<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class VoucherController extends CI_Controller {

    private $timestamp;
    private $admin_id;
    public $dist_id;

    public function __construct() {
        parent::__construct();
        //$this->load->model('Common_model', 'Finane_Model', 'Inventory_Model', 'Sales_Model');
        $this->load->model('Common_model');
        $this->load->model('Finane_Model');
        $this->load->model('Inventory_Model');
        $this->load->model('Sales_Model');
        $this->timestamp = date('Y-m-d H:i:s');
        $this->admin_id = $this->session->userdata('admin_id');
        $this->dist_id = $this->session->userdata('dis_id');
    }

    public function paymentVoucherPosting($voucherId) {
        $data['accountHeadList'] = $this->Common_model->getAccountHead();
        //echo $this->db->last_query();die;
        $voucherCondition = array(
            'dist_id' => $this->dist_id,
            'form_id' => 2,
        );
        $data['paymentPosting'] = $this->Common_model->get_single_data_by_single_column('purchase_demo', 'purchase_demo_id', $voucherId);
        $totalPurchases = $this->Common_model->get_data_list_by_many_columns('generals', $voucherCondition);
        $data['voucherID'] = "DV" . date("y") . date("m") . str_pad(count($totalPurchases) + 1, 4, "0", STR_PAD_LEFT);
        $data['title'] = 'Payment Voucher';
        $data['mainContent'] = $this->load->view('distributor/finance/import/paymentVoucherPosting', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function journalVoucherPosting($postingId) {
        $data['accountHeadList'] = $this->Common_model->getAccountHead();
        $voucherCondition = array(
            'dist_id' => $this->dist_id,
            'form_id' => 1,
        );
        $data['journalPosting'] = $this->Common_model->get_single_data_by_single_column('purchase_demo', 'purchase_demo_id', $postingId);
        $totalPurchases = $this->Common_model->get_data_list_by_many_columns('generals', $voucherCondition);
        $data['voucherID'] = "JV" . date("y") . date("m") . str_pad(count($totalPurchases) + 1, 4, "0", STR_PAD_LEFT);
        $data['title'] = 'Journal Voucher Posting';
        $data['mainContent'] = $this->load->view('distributor/finance/import/journalVoucherPosting', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function receiveVoucherPosting($voucherId) {
        $data['accountHeadList'] = $this->Common_model->getAccountHead();
        //echo $this->db->last_query();die;
        $voucherCondition = array(
            'dist_id' => $this->dist_id,
            'form_id' => 3,
        );
        $data['receivePosting'] = $this->Common_model->get_single_data_by_single_column('purchase_demo', 'purchase_demo_id', $voucherId);
        $totalPurchases = $this->Common_model->get_data_list_by_many_columns('generals', $voucherCondition);
        $data['voucherID'] = "DV" . date("y") . date("m") . str_pad(count($totalPurchases) + 1, 4, "0", STR_PAD_LEFT);
        $data['title'] = 'Receive Voucher Posting';
        $data['mainContent'] = $this->load->view('distributor/finance/import/receiveVoucherPosting', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function financeImport() {
        $data['voucherList'] = $this->Common_model->getVoucherList($this->dist_id);
        $data['title'] = 'Finance Import';
        $data['mainContent'] = $this->load->view('distributor/finance/import/importVoucher', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function financeImportAdd() {
        if (isPostBack()) {
            if (!empty($_FILES['paymentVoucher']['name']))://supplier list import operation start this block
                //check file type only csv
                $allowed = array('csv');
                $filename = $_FILES['paymentVoucher']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    notification("Import file type should be csv format.");
                    redirect(site_url('financeImportAdd'));
                }
                $config['upload_path'] = './uploads/import/setup/';
                $config['allowed_types'] = 'csv';
                $config['file_name'] = date("Y-m-d");
                $this->load->library('upload');
                $this->upload->initialize($config);
                $upload = $this->upload->do_upload('paymentVoucher');
                $data = $this->upload->data();
                $this->load->helper('file');
                $file = $_FILES['paymentVoucher']['tmp_name'];
                $importFile = fopen($file, "r");
                $row = 0;

                $storeData = array();
                while (($readRowData = fgetcsv($importFile, 1000, ",")) !== false) {
                    if ($row != 0):
                        if (!empty($readRowData)):
                            unset($data); //empty array;
                            /* check customer or supplier or miselenius id  start */
                            // dumpVar($readRowData);
                            $data['payee'] = $readRowData[2];
                            if ($data['payee'] == 1) {
                                $data['supplierID'] = $readRowData[3];
                            } elseif ($data['payee'] == 2) {
                                $customerCon = array(
                                    'customerID' => $readRowData[3],
                                    'dist_id' => $this->dist_id,
                                );
                                $customerlist = $this->Common_model->get_single_data_by_many_columns('customer', $customerCon);
                                if (empty($customerlist)):
                                    notification("This ( <b>" . $readRowData[3] . " </b>) customer ID not exits by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                    redirect(site_url('financeImportAdd'));
                                else :
                                    $data['supplierID'] = $customerlist->customer_id;
                                endif;
                            }else {
                                $customerCon = array(
                                    'supID' => $readRowData[3],
                                    'dist_id' => $this->dist_id,
                                );
                                $supplierlist = $this->Common_model->get_single_data_by_many_columns('supplier', $customerCon);
                                if (empty($supplierlist)):
                                    notification("This ( <b>" . $readRowData[3] . " </b>) supplier ID not exits by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                    redirect(site_url('financeImportAdd'));
                                else :
                                    $data['supplierID'] = $supplierlist->sup_id;
                                endif;
                            }

                            /* check customer or supplier or miselenius id   start */

                            /* check voucher id  start */
                            $voucher = array(
                                'voucher_no' => $readRowData[1],
                                'form_id' => 2,
                                'dist_id' => $this->dist_id,
                            );
                            $voucherID = $this->Common_model->get_single_data_by_many_columns('generals', $voucher);
                            if (empty($voucherID)):
                                $data['voucherid'] = isset($readRowData[1]) ? $readRowData[1] : '';
                            else:
                                $voucherCondition = array(
                                    'dist_id' => $this->dist_id,
                                    'form_id' => 2,
                                );
                                $totalSales = $this->Common_model->get_data_list_by_many_columns('generals', $voucherCondition);
                                $finalAddVoucher = count($totalSales) + ($row);
                                $data['voucherid'] = "DV" . date("y") . date("m") . str_pad($finalAddVoucher, 4, "0", STR_PAD_LEFT);
                            endif;


                            /* check account credit head start */
                            $payFrom = array(
                                'code' => $readRowData[4],
                                'dist_id' => $this->dist_id
                            );
                            $payData = $this->Common_model->get_single_data_by_many_columns('generaldata', $payFrom);
                            if (empty($payData)):
                                notification("This ( <b>" . $readRowData[4] . " </b>) account code not exits in database, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                redirect(site_url('financeImportAdd'));
                            else :
                                $data['accountCr'] = $payData->chartId;
                            endif;
                            /* check account credit head start */

                            /* check account debit head start */
                            $accountDr = array();
                            $debitAccount = explode(',', $readRowData[5]);
                            foreach ($debitAccount as $key => $value) {
                                $debitAccount = array(
                                    'code' => $value,
                                    'dist_id' => $this->dist_id,
                                );
                                $accountInfo = $this->Common_model->get_single_data_by_many_columns('generaldata', $debitAccount);
                                if (!empty($accountInfo)):
                                    $accountDr[] = $accountInfo->chartId;
                                else:
                                    notification("This ( <b>" . $value . " </b>) account Id not exits in database, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                    redirect(site_url('financeImportAdd'));
                                endif;
                            }
                            /* check account debit head End */

                            /* check account amount  start */
                            $accountAmount = array();
                            $crDrAmount = explode(',', $readRowData[6]);
                            foreach ($crDrAmount as $key => $value) {
                                $accountAmount[] = $value;
                            }
                            /* check account amount  end */

                            /* check account amount  start */
                            $accountMemo = array();
                            $crDrMemo = explode(',', $readRowData[7]);
                            foreach ($crDrMemo as $key => $value) {
                                $accountMemo[] = $value;
                            }
                            /* check account amount  end */
                            $data['purchasesDate'] = isset($readRowData[0]) ? date('Y-m-d', strtotime($readRowData[0])) : '';
                            $data['narration'] = isset($readRowData[8]) ? $readRowData[8] : '';
                            $data['memo'] = implode(",", $accountMemo);
                            $data['accountDr'] = implode(",", $accountDr);
                            $data['price'] = implode(",", $accountAmount);
                            $data['type'] = '3'; //payment voucher
                            $data['dist_id'] = $this->dist_id;
                            $data['updated_by'] = $this->admin_id;
                            if (!empty($data['supplierID'])):
                                $storeData[] = $data; //store each single row;
                            endif;
                        endif;
                    endif;
                    $row++;
                }

                //dumpVar($storeData);

                if (!empty($storeData)):
                    $this->db->insert_batch('purchase_demo', $storeData);
                endif;
                if ($this->db->affected_rows() > 0):
                    message("Your csv file successfully inserted into database.");
                    redirect(site_url('financeImport'));
                else:
                    notification("Your csv file not inserted.please check csv file format properly.");
                    redirect(site_url('financeImportAdd'));
                endif;

            endif;

            //receive Voucher 


            if (!empty($_FILES['receiveVoucher']['name']))://supplier list import operation start this block
                //check file type only csv
                $allowed = array('csv');
                $filename = $_FILES['receiveVoucher']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    notification("Import file type should be csv format.");
                    redirect(site_url('financeImportAdd'));
                }
                $config['upload_path'] = './uploads/import/setup/';
                $config['allowed_types'] = 'csv';
                $config['file_name'] = date("Y-m-d");
                $this->load->library('upload');
                $this->upload->initialize($config);
                $upload = $this->upload->do_upload('receiveVoucher');
                $data = $this->upload->data();
                $this->load->helper('file');
                $file = $_FILES['receiveVoucher']['tmp_name'];
                $importFile = fopen($file, "r");
                $row = 0;

                $storeData = array();
                while (($readRowData = fgetcsv($importFile, 1000, ",")) !== false) {
                    if ($row != 0):
                        if (!empty($readRowData)):
                            unset($data); //empty array;
                            /* check customer or supplier or miselenius id  start */
                            //dumpVar($readRowData);
                            $data['payee'] = $readRowData[2];
                            if ($data['payee'] == 1) {
                                $data['supplierID'] = $readRowData[3];
                            } elseif ($data['payee'] == 2) {
                                $customerCon = array(
                                    'customerID' => $readRowData[3],
                                    'dist_id' => $this->dist_id,
                                );
                                $customerlist = $this->Common_model->get_single_data_by_many_columns('customer', $customerCon);
                                if (empty($customerlist)):
                                    notification("This ( <b>" . $readRowData[3] . " </b>) customer ID not exits by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                    redirect(site_url('financeImportAdd'));
                                else :
                                    $data['supplierID'] = $customerlist->customer_id;
                                endif;
                            }else {
                                $customerCon = array(
                                    'supID' => $readRowData[3],
                                    'dist_id' => $this->dist_id,
                                );
                                $supplierlist = $this->Common_model->get_single_data_by_many_columns('supplier', $customerCon);
                                if (empty($supplierlist)):
                                    notification("This ( <b>" . $readRowData[3] . " </b>) supplier ID not exits by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                    redirect(site_url('financeImportAdd'));
                                else :
                                    $data['supplierID'] = $supplierlist->sup_id;
                                endif;
                            }

                            /* check customer or supplier or miselenius id   start */

                            /* check voucher id  start */
                            $voucher = array(
                                'voucher_no' => $readRowData[1],
                                'form_id' => 3,
                                'dist_id' => $this->dist_id,
                            );
                            $voucherID = $this->Common_model->get_single_data_by_many_columns('generals', $voucher);
                            if (empty($voucherID)):
                                $data['voucherid'] = isset($readRowData[1]) ? $readRowData[1] : '';
                            else:
                                $voucherCondition = array(
                                    'dist_id' => $this->dist_id,
                                    'form_id' => 3,
                                );
                                $totalSales = $this->Common_model->get_data_list_by_many_columns('generals', $voucherCondition);
                                $finalAddVoucher = count($totalSales) + ($row);
                                $data['voucherid'] = "DV" . date("y") . date("m") . str_pad($finalAddVoucher, 4, "0", STR_PAD_LEFT);
                            endif;


                            /* check account credit head start */
                            $payFrom = array(
                                'code' => $readRowData[4],
                                'dist_id' => $this->dist_id
                            );
                            $payData = $this->Common_model->get_single_data_by_many_columns('generaldata', $payFrom);
                            if (empty($payData)):
                                notification("This ( <b>" . $readRowData[4] . " </b>) account code not exits in database, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                redirect(site_url('financeImportAdd'));
                            else :
                                $data['accountCr'] = $payData->chartId;
                            endif;
                            /* check account credit head start */

                            /* check account debit head start */
                            $accountDr = array();
                            $debitAccount = explode(',', $readRowData[5]);
                            foreach ($debitAccount as $key => $value) {
                                $debitAccount = array(
                                    'code' => $value,
                                    'dist_id' => $this->dist_id,
                                );
                                $accountInfo = $this->Common_model->get_single_data_by_many_columns('generaldata', $debitAccount);
                                if (!empty($accountInfo)):
                                    $accountDr[] = $accountInfo->chartId;
                                else:
                                    notification("This ( <b>" . $value . " </b>) account Id not exits in database, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                    redirect(site_url('financeImportAdd'));
                                endif;
                            }
                            /* check account debit head End */

                            /* check account amount  start */
                            $accountAmount = array();
                            $crDrAmount = explode(',', $readRowData[6]);
                            foreach ($crDrAmount as $key => $value) {
                                $accountAmount[] = $value;
                            }
                            /* check account amount  end */

                            /* check account amount  start */
                            $accountMemo = array();
                            $crDrMemo = explode(',', $readRowData[7]);
                            foreach ($crDrMemo as $key => $value) {
                                $accountMemo[] = $value;
                            }
                            /* check account amount  end */
                            $data['purchasesDate'] = isset($readRowData[0]) ? date('Y-m-d', strtotime($readRowData[0])) : '';
                            $data['narration'] = isset($readRowData[8]) ? $readRowData[8] : '';
                            $data['memo'] = implode(",", $accountMemo);
                            $data['accountDr'] = implode(",", $accountDr);
                            $data['price'] = implode(",", $accountAmount);
                            $data['type'] = '4'; //receive Voucher
                            $data['dist_id'] = $this->dist_id;
                            $data['updated_by'] = $this->admin_id;
                            if (!empty($data['supplierID'])):
                                $storeData[] = $data; //store each single row;
                            endif;
                        endif;
                    endif;
                    $row++;
                }

                //dumpVar($storeData);

                if (!empty($storeData)):
                    $this->db->insert_batch('purchase_demo', $storeData);
                endif;
                if ($this->db->affected_rows() > 0):
                    message("Your csv file successfully inserted into database.");
                    redirect(site_url('financeImport'));
                else:
                    notification("Your csv file not inserted.please check csv file format properly.");
                    redirect(site_url('financeImportAdd'));
                endif;
            else:
                exception("Receive Payment CSV file can not be empty.Please browse Sales CSV file.");
                redirect(site_url('financeImportAdd'));
            endif;
        }

        $data['title'] = 'Finance Import Add';
        $data['mainContent'] = $this->load->view('distributor/finance/import/importAdd', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    function jounalVoucherAdd() {
        if (isPostBack()) {
            if (!empty($_FILES['journalVoucher']['name']))://supplier list import operation start this block
                //check file type only csv
                $allowed = array('csv');
                $filename = $_FILES['journalVoucher']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    notification("Import file type should be csv format.");
                    redirect(site_url('journalVoucher'));
                }
                $config['upload_path'] = './uploads/import/setup/';
                $config['allowed_types'] = 'csv';
                $config['file_name'] = date("Y-m-d");
                $this->load->library('upload');
                $this->upload->initialize($config);
                $upload = $this->upload->do_upload('journalVoucher');
                $data = $this->upload->data();
                $this->load->helper('file');
                $file = $_FILES['journalVoucher']['tmp_name'];
                $importFile = fopen($file, "r");
                $row = 0;

                $storeData = array();
                while (($readRowData = fgetcsv($importFile, 1000, ",")) !== false) {
                    if ($row != 0):
                        if (!empty($readRowData)):
                            unset($data); //empty array;
                            //  dumpVar($readRowData);
                            /* check voucher id  start */
                            $voucher = array(
                                'voucher_no' => $readRowData[1],
                                'dist_id' => $this->dist_id,
                                'form_id' => 1,
                            );
                            $voucherID = $this->Common_model->get_single_data_by_many_columns('generals', $voucher);
                            if (empty($voucherID)):
                                $data['voucherid'] = isset($readRowData[1]) ? $readRowData[1] : '';
                            else:
                                $voucherCondition = array(
                                    'dist_id' => $this->dist_id,
                                    'form_id' => 1,
                                );
                                $totalPurchases = $this->Common_model->get_data_list_by_many_columns('generals', $voucherCondition);
                                $finalAddVoucher = count($totalPurchases) + ($row);
                                $data['voucherID'] = "JV" . date("y") . date("m") . str_pad(count($finalAddVoucher) + 1, 4, "0", STR_PAD_LEFT);
                            endif;




                            $accountDr = array();
                            $accountHd = explode(',', $readRowData[2]);
                            foreach ($accountHd as $key => $value) {
                                $debitAccount = array(
                                    'code' => $value,
                                    'dist_id' => $this->dist_id,
                                );
                                $accountInfo = $this->Common_model->get_single_data_by_many_columns('generaldata', $debitAccount);

                                if (!empty($accountInfo)):
                                    $accountDr[] = $accountInfo->chartId;
                                else:
                                    notification("This ( <b>" . $value . " </b>) account Id not exits in database, by this (<b> " . $readRowData[2] . " </b>) voucher ID");
                                    redirect(site_url('financeImportAdd'));
                                endif;
                            }


                            /* check account debit head start */
                            $accountCr = array();
                            $CRAccount = explode(',', $readRowData[3]);
                            foreach ($CRAccount as $key => $value) {
                                $debitAccount = array(
                                    'code' => $value,
                                    'dist_id' => $this->dist_id,
                                );
                                $accountInfo = $this->Common_model->get_single_data_by_many_columns('generaldata', $debitAccount);
                                if (!empty($accountInfo)):
                                    $accountCr[] = $accountInfo->chartId;
                                else:
                                    notification("This ( <b>" . $value . " </b>) account Id not exits in database, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                    redirect(site_url('financeImportAdd'));
                                endif;
                            }
                            /* check account debit head End */




                            /* check account amount  start */
                            $drAmount = array();
                            $DrAmount = explode(',', $readRowData[4]);
                            foreach ($DrAmount as $key => $value) {
                                $drAmount[] = $value;
                            }

                            $crAmount = array();
                            $CrAmount = explode(',', $readRowData[5]);
                            foreach ($CrAmount as $key => $value) {
                                $crAmount[] = $value;
                            }
                            /* check account amount  end */
                            $sumDrAmount = array_sum($drAmount);
                            $sumCrAmount = array_sum($crAmount);

                            if ($sumDrAmount != $sumCrAmount) {
                                notification("Debit Amount and Credit Amount must be equal. Your Debit Amount Is:  ( <b>" . $sumDrAmount . " </b>) Credit Amount Is (<b> " . $sumCrAmount . " </b>)");
                                redirect(site_url('financeImportAdd'));
                            }

                            /* check account amount  start */
                            $accountMemo = array();
                            $crDrMemo = explode(',', $readRowData[6]);
                            foreach ($crDrMemo as $key => $value) {
                                $accountMemo[] = $value;
                            }

                            /* check account amount  end */
                            $data['purchasesDate'] = isset($readRowData[0]) ? date('Y-m-d', strtotime($readRowData[0])) : '';
                            $data['narration'] = isset($readRowData[7]) ? $readRowData[7] : '';
                            $data['memo'] = implode(",", $accountMemo);
                            $data['accountDr'] = implode(",", $accountDr);
                            $data['accountCr'] = implode(",", $accountCr);
                            $data['drAmount'] = implode(",", $drAmount);
                            $data['crAmount'] = implode(",", $crAmount);
                            $data['type'] = '5'; //journal voaucher 
                            $data['dist_id'] = $this->dist_id;
                            $data['updated_by'] = $this->admin_id;
                            if (!empty($data['purchasesDate'])):
                                $storeData[] = $data; //store each single row;
                            endif;
                        endif;
                    endif;
                    $row++;
                }

                //dumpVar($storeData);

                if (!empty($storeData)):
                    $this->db->insert_batch('purchase_demo', $storeData);
                endif;
                if ($this->db->affected_rows() > 0):
                    message("Your csv file successfully inserted into database.");
                    redirect(site_url('financeImport'));
                else:
                    notification("Your csv file not inserted.please check csv file format properly.");
                    redirect(site_url('financeImportAdd'));
                endif;
            else:
                exception("Sales CSV file can not be empty.Please browse Sales CSV file.");
                redirect(site_url('financeImportAdd'));
            endif;
        }
    }

    public function salesImport() {
        $data['title'] = 'Sales Import';
        $data['salesImportList'] = $this->Common_model->get_data_list_by_single_column('purchase_demo', 'type', 2, 'purchase_demo_id', 'DESC');
        $data['mainContent'] = $this->load->view('distributor/sales/import/salesImportList', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function addSalesImport() {
        if (isPostBack()) {
            if (!empty($_FILES['salesImport']['name']))://supplier list import operation start this block
                //check file type only csv
                $allowed = array('csv');
                $filename = $_FILES['salesImport']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    notification("Import file type should be csv format.");
                    redirect(site_url('salesImport'));
                }
                $config['upload_path'] = './uploads/import/setup/';
                $config['allowed_types'] = 'csv';
                $config['file_name'] = date("Y-m-d");
                $this->load->library('upload');
                $this->upload->initialize($config);
                $upload = $this->upload->do_upload('salesImport');
                $data = $this->upload->data();
                $this->load->helper('file');
                $file = $_FILES['salesImport']['tmp_name'];
                $importFile = fopen($file, "r");
                $row = 0;

                $storeData = array();
                while (($readRowData = fgetcsv($importFile, 1000, ",")) !== false) {
                    if ($row != 0):
                        if (!empty($readRowData)):
                            unset($data); //empty array;
                            /* check customer id  start */
                            $customerCon = array(
                                'customerID' => $readRowData[0],
                                'dist_id' => $this->dist_id,
                            );
                            $customerlist = $this->Common_model->get_single_data_by_many_columns('customer', $customerCon);
                            if (empty($customerlist)):
                                notification("This ( <b>" . $readRowData[0] . " </b>) customer ID not exits by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                redirect(site_url('salesImport'));
                            else :
                                $data['supplierID'] = $customerlist->customer_id;
                            endif;
                            /* check supplier id  start */

                            /* check voucher id  start */
                            $voucher = array(
                                'voucher_no' => $readRowData[1],
                                'form_id' => 5,
                                'dist_id' => $this->dist_id,
                            );
                            $voucherID = $this->Common_model->get_single_data_by_many_columns('generals', $voucher);
                            if (empty($voucherID)):
                                $data['voucherid'] = isset($readRowData[1]) ? $readRowData[1] : '';
                            else:
                                $voucherCondition = array(
                                    'dist_id' => $this->dist_id,
                                    'form_id' => 5,
                                );
                                $totalSales = $this->Common_model->get_data_list_by_many_columns('generals', $voucherCondition);
                                $finalAddVoucher = count($totalSales) + ($row);
                                $data['voucherid'] = "SID" . str_pad($finalAddVoucher, 4, "0", STR_PAD_LEFT);
                            endif;
                            /* check voucher id  end */

                            /* check account head start */
//                            $payFrom = array(
//                                'title' => $readRowData[5],
//                                'dist_id' => $this->dist_id
//                            );
//                            $payData = $this->Common_model->get_single_data_by_many_columns('chartofaccount', $payFrom);
//
//                            if (empty($payData)):
//                                notification("This ( <b>" . $readRowData[5] . " </b>) account head not exits in database, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
//                                redirect(site_url('salesImport'));
//                            else :
//                                $data['accountCr'] = $payData->chart_id;
//                            endif;
                            /* check account head end */

                            /* check product id head start */
                            $productCat = array();
                            $productPro = array();
                            $product = explode(',', $readRowData[6]);
                            foreach ($product as $key => $value) {
                                $producCon = array(
                                    'product_code' => $value,
                                    'dist_id' => $this->dist_id,
                                );
                                $productResult = $this->Common_model->get_single_data_by_many_columns('product', $producCon);
                                if (!empty($productResult)):
                                    // $dataCat['category_id'] = $productResult->category_id;
                                    // $dataPro['product_id'] = $productResult->product_id;
                                    $productCat[] = $productResult->category_id;
                                    $productPro[] = $productResult->product_id;
                                else:
                                    notification("This ( <b>" . $value . " </b>) product code not exits in database, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                    redirect(site_url('salesImport'));
                                endif;
                            }
                            $ProCategory = implode(",", $productCat);
                            $productID = implode(",", $productPro);
                            /* check product id head end */

                            /* check product unit start */
                            $unit = explode(',', $readRowData[7]);
                            $productUnit = array();
                            foreach ($unit as $key => $val):
                                $unitCondition = array(
                                    'dist_id' => $this->dist_id,
                                    'code' => $val,
                                );
                                $unitResult = $this->Common_model->get_single_data_by_many_columns('unit', $unitCondition);
                                //echo $this->db->last_query();die;
                                if (!empty($unitResult)):
                                    $productUnit[] = $unitResult->unit_id;
                                else:
                                    notification("This ( <b>" . $val . " </b>) unit code not exits in database, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                    redirect(site_url('salesImport'));
                                endif;
                            endforeach;
                            $ProUnit = implode(",", (array) $productUnit);
                            $Qty = implode(",", (array) $readRowData[8]);
                            $totalAppendQty = count($readRowData[8]);
                            $totalAppendPrice = count($readRowData[9]);
                            $totalAppendTotalPrice = count($readRowData[10]);
                            //check qutantity and price figure as same
                            if ($totalAppendQty != $totalAppendPrice):
                                notification("This ( <b>" . $totalAppendPrice . " </b>) unit price not match by product quantity, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                redirect(site_url('salesImport'));
                            endif;
                            //check qutantity and tota price figure as same
                            if ($totalAppendQty != $totalAppendTotalPrice):
                                notification("This ( <b>" . $totalAppendTotalPrice . " </b>) total price not match by product quantity, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                redirect(site_url('salesImport'));
                            endif;
                            $UnitPrice = implode(",", (array) $readRowData[9]);
                            $TotalPrice = implode(",", (array) $readRowData[10]);
                            $data['reference'] = isset($readRowData[2]) ? $readRowData[2] : '';
                            $data['purchasesDate'] = date("Y-m-d", strtotime($readRowData[3]));
                            if ($readRowData[3] == 'Cash' || $readRowData[3] == 'credit'):
                                if ($readRowData[3] == 'Cash') {
                                    $data['paymentType'] = 1;
                                } elseif ($readRowData[3] == 'credit') {
                                    $data['paymentType'] = 2;
                                }
                            endif;
                            $data['category_product'] = $ProCategory;
                            $data['productID'] = $productID;
                            $data['productUnit'] = $ProUnit;
                            $data['quantity'] = $Qty;
                            $data['rate'] = $UnitPrice;
                            $data['price'] = $TotalPrice;
                            $data['subTotal'] = isset($readRowData[11]) ? $readRowData[11] : '';
                            $data['discount'] = isset($readRowData[12]) ? $readRowData[12] : '';
                            $data['grandTotal'] = isset($readRowData[13]) ? $readRowData[13] : '';
                            $data['vat'] = isset($readRowData[14]) ? $readRowData[14] : '';
                            $data['netTotal'] = isset($readRowData[15]) ? $readRowData[15] : '';
                            $data['narration'] = isset($readRowData[16]) ? $readRowData[16] : '';
                            $data['type'] = '2';
                            $data['dist_id'] = $this->dist_id;
                            $data['updated_by'] = $this->admin_id;
                            if (!empty($data['supplierID'])):
                                $storeData[] = $data; //store each single row;
                            endif;
                        endif;
                    endif;
                    $row++;
                }
                if (!empty($storeData)):
                    $this->db->insert_batch('purchase_demo', $storeData);
                endif;
                if ($this->db->affected_rows() > 0):
                    message("Your csv file successfully inserted into database.");
                    redirect(site_url('salesImport'));
                else:
                    notification("Your csv file not inserted.please check csv file format properly.");
                    redirect(site_url('salesImport'));
                endif;
            else:
                exception("Sales CSV file can not be empty.Please browse Sales CSV file.");
                redirect(site_url('salesImport'));
            endif;
        }
        $data['title'] = 'Add Sales Import';
        $data['mainContent'] = $this->load->view('distributor/sales/import/addSalesImport', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function salesImportConfirm($cinfirmId = null) {
        $condition = array(
            'dist_id' => $this->dist_id,
            'form_id' => 5,
        );
        $cusCondition = array(
            'dist_id' => $this->dist_id,
            'status' => 1,
        );
        $customerID = $this->Sales_Model->getCustomerID($this->dist_id);
        $data['customerID'] = $this->Sales_Model->checkDuplicateCusID($customerID, $this->dist_id);
        $data['referenceList'] = $this->Common_model->get_data_list_by_single_column('reference', 'dist_id', $this->dist_id);
        $data['configInfo'] = $this->Common_model->get_single_data_by_single_column('tbl_distributor', 'dist_id', $this->dist_id);
        $data['title'] = 'Sale Add';
        $data['productCat'] = $this->Common_model->get_data_list_by_single_column('productcategory', 'dist_id', $this->dist_id);
        $data['unitList'] = $this->Common_model->get_data_list_by_single_column('unit', 'dist_id', $this->dist_id);
        $data['customerList'] = $this->Common_model->get_data_list_by_many_columns('customer', $cusCondition);
        $data['salesImportList'] = $this->Common_model->get_single_data_by_single_column('purchase_demo', 'purchase_demo_id', $cinfirmId);
        $totalSale = $this->Common_model->get_data_list_by_many_columns('generals', $condition);
        $data['voucherID'] = "SID"  . str_pad(count($totalSale) + 1, 4, "0", STR_PAD_LEFT);
        $data['mainContent'] = $this->load->view('distributor/sales/saleInvoice/salesImport', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function demolist() {
        $data['title'] = 'Demo List';
        $data['PurchaseDemoList'] = $this->Common_model->get_data_list_by_single_column('purchase_demo', 'type', 1);
        $data['mainContent'] = $this->load->view('distributor/inventory/import/demolist', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function PurchaseDemoConfirm($id) {
        $condition = array(
            'dist_id' => $this->dist_id,
            'form_id' => 11,
        );
        $costCondition = array(
            'dist_id' => $this->dist_id,
            'parentId' => 62,
        );
        $supCondition = array(
            'dist_id' => $this->dist_id,
            'status' => 1,
        );
        $data['title'] = 'Purchase Demo Confirm';
        $supID = $this->Common_model->getSupplierID($this->dist_id);
        $data['supplierID'] = $this->Common_model->checkDuplicateSupID($supID, $this->dist_id);
        $data['configInfo'] = $this->Common_model->get_single_data_by_single_column('purchase_demo', 'purchase_demo_id', $id);
        $data['costList'] = $this->Common_model->get_data_list_by_many_columns('generaldata', $costCondition);
        $data['productCat'] = $this->Common_model->get_data_list_by_single_column('productcategory', 'dist_id', $this->dist_id);
        $data['unitList'] = $this->Common_model->get_data_list_by_single_column('unit', 'dist_id', $this->dist_id);
        $data['supplierList'] = $this->Common_model->get_data_list_by_many_columns('supplier', $supCondition);
        $totalPurchases = $this->Common_model->get_data_list_by_many_columns('generals', $condition);
        $data['voucherID'] = "PV" . date("y") . date("m") . str_pad(count($totalPurchases) + 1, 4, "0", STR_PAD_LEFT);
        $data['accountHeadList'] = $this->Common_model->getAccountHead();
        $data['mainContent'] = $this->load->view('distributor/inventory/import/PurchaseDemoConfirm', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function demoImport() {
        if (isPostBack()) {

            if (!empty($_FILES['PurchaseImport']['name']))://supplier list import operation start this block
                //check file type only csv
                $allowed = array('csv');
                $filename = $_FILES['PurchaseImport']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    notification("Import file type should be csv format.");
                    redirect(site_url('demoImport'));
                }
                $config['upload_path'] = './uploads/import/setup/';
                $config['allowed_types'] = 'csv';
                $config['file_name'] = date("Y-m-d");
                $this->load->library('upload');
                $this->upload->initialize($config);
                $upload = $this->upload->do_upload('PurchaseImport');
                $data = $this->upload->data();
                $this->load->helper('file');
                $file = $_FILES['PurchaseImport']['tmp_name'];
                $importFile = fopen($file, "r");
                $row = 0;

                $storeData = array();
                while (($readRowData = fgetcsv($importFile, 1000, ",")) !== false) {
                    if ($row != 0):
                        if (!empty($readRowData)):



                            unset($data); //empty array;
                            /* check supplier id  start */

                            $supplierCon = array(
                                'supID' => $readRowData[0],
                                'dist_id' => $this->dist_id,
                            );
                            $suplist = $this->Common_model->get_single_data_by_many_columns('supplier', $supplierCon);
                            if (empty($suplist)):
                                notification("This ( <b>" . $readRowData[0] . " </b>) supplier ID not exits by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                redirect(site_url('demoImport'));
                            else :
                                $data['supplierID'] = $suplist->sup_id;
                            endif;
                            /* check supplier id  start */


                            /* check voucher id  start */
                            $voucher = array(
                                'voucherid' => $readRowData[1],
                            );
                            $voucherID = $this->Common_model->get_single_data_by_many_columns('purchase_demo', $voucher);
                            if (empty($voucherID)):
                                $data['voucherid'] = isset($readRowData[1]) ? $readRowData[1] : '';
                            else:
                                $voucherCondition = array(
                                    'dist_id' => $this->dist_id,
                                    'form_id' => 11,
                                );
                                $totalPurchases = $this->Common_model->get_data_list_by_many_columns('generals', $voucherCondition);
                                $finalAddVoucher = count($totalPurchases) + ($row - 1);
                                $data['voucherid'] = "PV" . date("y") . date("m") . str_pad(count($finalAddVoucher), 4, "0", STR_PAD_LEFT);
                            endif;
                            /* check voucher id  end */

                            /* check account head start */
                            $payFrom = array(
                                'title' => $readRowData[5],
                                'dist_id' => $this->dist_id
                            );
                            $payData = $this->Common_model->get_single_data_by_many_columns('chartofaccount', $payFrom);

                            if (empty($payData)):
                                notification("This ( <b>" . $readRowData[5] . " </b>) account head not exits in database, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                redirect(site_url('demoImport'));
                            else :
                                $data['accountCr'] = $payData->chart_id;
                            endif;
                            /* check account head end */

                            /* check product id head start */

                            $product = explode(',', $readRowData[6]);
                            foreach ($product as $key => $value) {
                                $producCon = array(
                                    'product_code' => $value,
                                    'dist_id' => $this->dist_id,
                                );
                                $productResult = $this->Common_model->get_single_data_by_many_columns('product', $producCon);
                                if (!empty($productResult)):
                                    $dataCat['category_id'] = $productResult->category_id;
                                    $dataPro['product_id'] = $productResult->product_id;
                                    $productCat[] = $dataCat['category_id'];
                                    $productPro[] = $dataPro['product_id'];
                                else:
                                    notification("This ( <b>" . $value . " </b>) product code not exits in database, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                    redirect(site_url('demoImport'));
                                endif;
                            }
                            $ProCategory = implode(",", $productCat);
                            $productID = implode(",", $productPro);
                            /* check product id head end */
                            /* check product unit start */
                            $unit = explode(',', $readRowData[7]);
                            foreach ($unit as $key => $val):
                                $unitCondition = array(
                                    'dist_id' => $this->dist_id,
                                    'code' => $val,
                                );
                                $unitResult = $this->Common_model->get_single_data_by_many_columns('unit', $unitCondition);
                                //echo $this->db->last_query();die;
                                if (!empty($unitResult)):
                                    $productUnit[] = $unitResult->unit_id;
                                else:
                                    notification("This ( <b>" . $val . " </b>) unit code not exits in database, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                    redirect(site_url('demoImport'));
                                endif;
                            endforeach;
                            $ProUnit = implode(",", (array) $productUnit);
                            $Qty = implode(",", (array) $readRowData[8]);
                            $totalAppendQty = count($readRowData[8]);
                            $totalAppendPrice = count($readRowData[9]);
                            $totalAppendTotalPrice = count($readRowData[10]);
                            //check qutantity and price figure as same
                            if ($totalAppendQty != $totalAppendPrice):
                                notification("This ( <b>" . $totalAppendPrice . " </b>) unit price not match by product quantity, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                redirect(site_url('demoImport'));
                            endif;
                            //check qutantity and tota price figure as same
                            if ($totalAppendQty != $totalAppendTotalPrice):
                                notification("This ( <b>" . $totalAppendTotalPrice . " </b>) total price not match by product quantity, by this (<b> " . $readRowData[1] . " </b>) voucher ID");
                                redirect(site_url('demoImport'));
                            endif;
                            $UnitPrice = implode(",", (array) $readRowData[9]);
                            $TotalPrice = implode(",", (array) $readRowData[10]);
                            $data['reference'] = isset($readRowData[2]) ? $readRowData[2] : '';
                            $data['purchasesDate'] = date("Y-m-d", strtotime($readRowData[3]));
                            if ($readRowData[3] == 'Cash' || $readRowData[3] == 'credit'):
                                if ($readRowData[3] == 'Cash') {
                                    $data['paymentType'] = 1;
                                } elseif ($readRowData[3] == 'credit') {
                                    $data['paymentType'] = 2;
                                }
                            endif;
                            $data['category_product'] = $ProCategory;
                            $data['productID'] = $productID;
                            $data['productUnit'] = $ProUnit;
                            $data['quantity'] = $Qty;
                            $data['rate'] = $UnitPrice;
                            $data['price'] = $TotalPrice;
                            $data['type'] = 1;
                            $data['dist_id'] = $this->dist_id;
                            $data['updated_by'] = $this->admin_id;
                            if (!empty($data['supplierID'])):
                                $storeData[] = $data; //store each single row;
                            endif;
                        endif;
                    endif;
                    $row++;
                }
                if (!empty($storeData)):
                    $this->db->insert_batch('purchase_demo', $storeData);
                endif;
                if ($this->db->affected_rows() > 0):
                    message("Your csv file successfully inserted into database.");
                    redirect(site_url('demoImport'));
                else:
                    notification("Your csv file not inserted.please check csv file format properly.");
                    redirect(site_url('demoImport'));
                endif;

            else:
                exception("Purchases CSV file can not be empty.Please browse CSV file.");
                redirect(site_url('demoImport'));
            endif;
        }
        $data['title'] = 'Purchases import Voucher';
        $data['mainContent'] = $this->load->view('distributor/inventory/import/demoImport', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

}
