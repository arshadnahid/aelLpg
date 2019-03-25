<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SalesController extends CI_Controller {

    private $timestamp;
    private $admin_id;
    public $dist_id;

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Finane_Model');
        $this->load->model('Inventory_Model');
        $this->load->model('Sales_Model');
        $this->timestamp = date('Y-m-d H:i:s');
        $this->admin_id = $this->session->userdata('admin_id');
        $this->dist_id = $this->session->userdata('dis_id');
        if (empty($this->admin_id) || empty($this->dist_id)) {
            redirect(site_url());
        }
    }

    public function customerDashboard($customerId) {
        $data['customerDetails'] = $this->Common_model->get_single_data_by_single_column('customer', 'customer_id', $customerId);
        $salesCon = array(
            'customer_id' => $customerId,
            'form_id' => 5,
        );
        $data['salesList'] = $this->Common_model->get_data_list_by_many_columns('generals', $salesCon);
        //dumpVar($data['salesList']);
        $paymentCon = array(
            'customer_id' => $customerId,
            'form_id' => 7,
        );
        // $data['salesPayment'] = $this->Common_model->get_data_list_by_many_columns('generals', $paymentCon);
        $data['salesPayment'] = $this->Common_model->get_data_list_by_single_column('moneyreceit', 'customerid', $customerId);
        //dumpVar($data['salesPayment']);
        $salesOrderCon = array(
            'customer_id' => $customerId,
            'form_id' => 19,
        );
        $data['salesOrder'] = $this->Common_model->get_data_list_by_many_columns('generals', $salesOrderCon);
        // dumpVar($data['supplierPayment']);
        $data['title'] = 'Supplier Dashboard';
        $data['mainContent'] = $this->load->view('distributor/sales/customer/customerDashboard', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function getCustomerListByType() {
        $type = $this->input->post('type');
        $customer_id = $this->input->post('customer_id');
        $data['customerId'] = $customer_id;

        $cusCondition = array(
            'customerType' => $type,
            'dist_id' => $this->dist_id,
        );

        $data['customerList'] = $this->Common_model->get_data_list_by_many_columns('customer', $cusCondition);
        $this->load->view('distributor/ajax/customerList', $data);
    }

    public function customerSalesReport() {
        if (isPostBack()) {
            $customerId = $this->input->post('customer_id');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $data['type'] = $type = $this->input->post('cusType');
            $data['customerId'] = $customerId;
            if ($customerId == 'all'):
                $data['salesList'] = $this->Sales_Model->getCustomerSalesList($this->dist_id, $start_date, $end_date, '', $type);
            else:
                $data['salesList'] = $this->Sales_Model->getCustomerSalesList($this->dist_id, $start_date, $end_date, $customerId, $type);
            endif;
        }
        $data['customerType'] = $this->Common_model->get_data_list('customertype');
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['pageTitle'] = 'Customer Wise Sales Report';
        $data['customerList'] = $this->Common_model->get_data_list_by_single_column('customer', 'dist_id', $this->dist_id);
        $data['title'] = 'Customer Sales Report';
        $data['mainContent'] = $this->load->view('distributor/sales/report/customerSalesReport', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function customerSalesReport_export_excel() {
        $file = 'Customer Sales Report_' . date('d.m.Y') . '.xls';
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        header('Cache-Control: max-age=0');
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['customerList'] = $this->Common_model->get_data_list_by_single_column('customer', 'dist_id', $this->dist_id);
        $this->load->view('excel_report/sales/customerSalesReport_export_excel', $data);
        unset($_SESSION['full_array']);
    }

    public function salesReport() {
        $data['customerType'] = $this->Common_model->get_data_list('customertype');
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['pageTitle'] = 'Sales Report';
        $data['title'] = 'Sales || Report';
        $data['mainContent'] = $this->load->view('distributor/sales/report/salesReport', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function referenceSalesReport() {
        if (isPostBack()) {
            $referenceId = $this->input->post('referenceId');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $data['referenceId'] = $referenceId;
            if ($referenceId == 'all'):
                $data['refOpList'] = $this->Sales_Model->getReferenceSalesList($this->dist_id, $start_date, $end_date);
            else:
                $data['refOpList'] = $this->Sales_Model->getReferenceSalesListById($this->dist_id, $start_date, $end_date, $referenceId);
            endif;
        }
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['pageTitle'] = 'Reference Sales Report';
        $data['title'] = 'Reference Sales || Report';
        $data['referenceList'] = $this->Common_model->get_data_list_by_single_column('reference', 'dist_id', $this->dist_id);
        $data['mainContent'] = $this->load->view('distributor/sales/report/referenceSalesReport', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function topSaleProduct() {
        if (isPostBack()) {
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $data['topSaleProduct'] = $this->Sales_Model->getTopSaleProduct($start_date, $end_date, $this->dist_id);
        }
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['pageTitle'] = 'Reference Sales Report';
        $data['title'] = 'Reference Sales || Report';
        $data['referenceList'] = $this->Common_model->get_data_list_by_single_column('reference', 'dist_id', $this->dist_id);
        $data['mainContent'] = $this->load->view('distributor/sales/report/topSaleingProduct', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function salesReport_export_excel() {
        $file = 'Sales Report_' . date('d.m.Y') . '.xls';
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        header('Cache-Control: max-age=0');
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $this->load->view('excel_report/sales/salesReport_export_excel', $data);
        unset($_SESSION['full_array']);
    }

    public function salesOrder() {
        $condition = array(
            'dist_id' => $this->dist_id,
            'form_id' => 19,
            'orderStatus' => 1,
        );
        $data['title'] = 'Sale || Order';
        $data['referenceList'] = $this->Common_model->get_data_list_by_single_column('reference', 'dist_id', $this->dist_id);
        $data['saleslist'] = $this->Common_model->get_data_list_by_many_columns('generals', $condition);
        $data['mainContent'] = $this->load->view('distributor/sales/salesOrder/salesOrderList', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function cancelOrder() {
        $condition = array(
            'dist_id' => $this->dist_id,
            'form_id' => 19,
            'orderStatus' => 3,
        );
        $data['title'] = 'Cancel Order';
        $data['saleslist'] = $this->Common_model->get_data_list_by_many_columns('generals', $condition);
        $data['mainContent'] = $this->load->view('distributor/sales/salesOrder/cancelOrderList', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function salesOrderView($orderId) {
        $data['title'] = 'Sale || Order';
        $data['saleslist'] = $this->Common_model->get_single_data_by_single_column('generals', 'generals_id', $orderId);
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['customerInfo'] = $this->Common_model->get_single_data_by_single_column('customer', 'customer_id', $data['saleslist']->customer_id);
        $data['stockList'] = $this->Common_model->get_data_list_by_single_column('stock', 'generals_id', $orderId);
        $data['mainContent'] = $this->load->view('distributor/sales/salesOrder/salesOrderView', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function salesOrderCancel($orderId) {
        $data['orderStatus'] = 3;
        $this->Common_model->update_data('generals', $data, 'generals_id', $orderId);
        message("Your order successfully cancel from order list.");
        redirect(site_url('salesOrder'));
    }

    public function salesOrderConfirm($orderId) {
        if (isPostBack()) {
            // dumpVar($_POST);
            $productId = $this->input->post('product_id');
            $customerId = $this->input->post('customer_id');
            if (empty($productId)) {
                exception("Order item can't be empty.");
                redirect(site_url('salesOrderConfirm/' . $orderId));
            }
            if (empty($customerId)) {
                exception("Customer Id can't be empty.");
                redirect(site_url('salesOrderConfirm/' . $orderId));
            }
            $this->db->trans_start();
            $payType = $this->input->post('paymentType');
            $data['customer_id'] = $this->input->post('customer_id');
            $data['voucher_no'] = $this->input->post('voucherid');
            $data['reference'] = $this->input->post('reference');
            $data['payType'] = $this->input->post('paymentType');
            $data['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
            $data['discount'] = $this->input->post('discount');
            $data['vat'] = $this->input->post('vat');
            $data['narration'] = $this->input->post('narration');
            $data['shipAddress'] = $this->input->post('shippingAddress');
            $data['form_id'] = 5;
            $data['orderId'] = $orderId;
            $data['debit'] = $this->input->post('netTotal');
            $data['dist_id'] = $this->dist_id;
            $data['updated_by'] = $this->admin_id;
            $grandtotal = $this->input->post('grandtotal');
            $data['vatAmount'] = ($grandtotal / 100) * $data['vat'];
            $generals_id = $this->Common_model->insert_data('generals', $data);
            $cngStatus['orderStatus'] = 2;
            $this->Common_model->update_data('generals', $cngStatus, 'generals_id', $orderId);
            $category_cat = $this->input->post('category_id');
            $allStock = array();
            $totalProductCost = 0;
            foreach ($category_cat as $key => $value):
                unset($stock);
                $productCost = $this->Sales_Model->productCost($this->input->post('product_id')[$key], $this->dist_id);
                $totalProductCost += $this->input->post('quantity')[$key] * $productCost;
                $stock['generals_id'] = $generals_id;
                $stock['category_id'] = $value;
                $stock['product_id'] = $this->input->post('product_id')[$key];
                $stock['quantity'] = $this->input->post('quantity')[$key];
                $stock['rate'] = $this->input->post('rate')[$key];
                $stock['price'] = $this->input->post('price')[$key];
                $stock['date'] = $this->input->post('saleDate');
                $stock['form_id'] = 5;
                $stock['type'] = 'Out';
                $stock['dist_id'] = $this->dist_id;
                $stock['updated_by'] = $this->admin_id;
                $stock['created_at'] = $this->timestamp;
                $allStock[] = $stock;
            endforeach;
            $this->db->insert_batch('stock', $allStock);
            //insert in stock table
            $supp = array(
                'ledger_type' => 1,
                'trans_type' => 'Sales',
                'history_id' => $generals_id,
                'trans_type' => $this->input->post('voucherid'),
                'client_vendor_id' => $this->input->post('customer_id'),
                'updated_by' => $this->admin_id,
                'dist_id' => $this->dist_id,
                'amount' => $this->input->post('netTotal'),
                'dr' => $this->input->post('netTotal'),
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            );
            $this->db->insert('client_vendor_ledger', $supp);
            $totalMoneyReceite = $this->Common_model->get_data_list_by_single_column('generals', 'dist_id', $this->dist_id);
            $mrid = "RID" . date("y") . date("m") . str_pad(count($totalMoneyReceite), 4, "0", STR_PAD_LEFT);
            if ($payType == 1) {
                // when cash transction start from here
                //58 account receiable head debit
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '58',
                    'debit' => $this->input->post('netTotal'), //sales - discount= grand + vat =newNettotal
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
                //59  Prompt Given Discounts
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '59',
                    'debit' => $data['discount'],
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
                //49  Sales head credit
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '49',
                    'credit' => array_sum($this->input->post('price')),
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
                //60 Sales tax/vat head credit
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '60',
                    'credit' => $data['vatAmount'],
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
                //7501 Cost of Goods-Retail head debit
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '62',
                    'debit' => $totalProductCost,
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
                //52 account Inventory head credit
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '52',
                    'credit' => $totalProductCost,
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
                //1301 Cash in Hand  head debit
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '54',
                    'debit' => $this->input->post('netTotal'),
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
                //58 Account Receivable head credit
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '58',
                    'credit' => $this->input->post('netTotal'),
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
                //client vendor ledger
                $customerLedger = array(
                    'ledger_type' => 1,
                    'trans_type' => 'Sales Payment',
                    'history_id' => $generals_id,
                    'trans_type' => $this->input->post('voucherid'),
                    'client_vendor_id' => $this->input->post('customer_id'),
                    'dist_id' => $this->dist_id,
                    'amount' => $this->input->post('netTotal'),
                    'cr' => $this->input->post('netTotal'),
                    'date' => $this->input->post('saleDate')
                );
                $this->db->insert('client_vendor_ledger', $customerLedger);
                //money Receite General
                $moneyReceit = array(
                    'date' => $this->input->post('saleDate'),
                    'invoiceID' => json_encode($this->input->post('voucherid')),
                    'totalPayment' => $this->input->post('netTotal'),
                    'receitID' => $mrid,
                    'customerid' => $this->input->post('customer_id'),
                    'narration' => $this->input->post('narration'),
                    'updated_by' => $this->admin_id,
                    'dist_id' => $this->dist_id,
                    'paymentType' => 1
                );
                $this->db->insert('moneyreceit', $moneyReceit);
            } elseif ($payType == 2) {
                //when due transction start from here.
                //58 account receiable head debit
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '58',
                    'debit' => $this->input->post('netTotal'), //sales - discount= grand + vat =newNettotal
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
                //59  Prompt Given Discounts
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '59',
                    'debit' => $data['discount'],
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
                //49  Sales head credit
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '49',
                    'credit' => array_sum($this->input->post('price')),
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
                //60 Sales tax/vat head credit
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '60',
                    'credit' => $data['vatAmount'],
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
                //62 Cost of Goods-Retail head debit
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '62',
                    'debit' => $totalProductCost,
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
                //52 account Inventory head credit
                $singleLedger = array(
                    'generals_id' => $generals_id,
                    'date' => $this->input->post('saleDate'),
                    'form_id' => '5',
                    'dist_id' => $this->dist_id,
                    'account' => '52',
                    'credit' => $totalProductCost,
                    'updated_by' => $this->admin_id,
                );
                $this->db->insert('generalledger', $singleLedger);
            } else {
                $bankName = $this->input->post('bankName');
                $checkNo = $this->input->post('checkNo');
                $checkDate = $this->input->post('checkDate');
                $branchName = $this->input->post('branchName');
                $moneyReceit = array(
                    'date' => $this->input->post('saleDate'),
                    'invoiceID' => json_encode($this->input->post('voucherid')),
                    'totalPayment' => $this->input->post('netTotal'),
                    'receitID' => $mrid,
                    'customerid' => $this->input->post('customer_id'),
                    'narration' => $this->input->post('narration'),
                    'updated_by' => $this->admin_id,
                    'dist_id' => $this->dist_id,
                    'paymentType' => 2,
                    'bankName' => isset($bankName) ? $bankName : '0',
                    'checkNo' => isset($checkNo) ? $checkNo : '0',
                    'checkDate' => isset($checkDate) ? $checkDate : '0',
                    'branchName' => isset($branchName) ? $branchName : '0');
                $this->db->insert('moneyreceit', $moneyReceit);
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                notification("Your sales can't be inserted.Something is wrong.");
                redirect('salesInvoice_add', 'refresh');
            } else {
                message("Your data successfully inserted into database.");
                redirect('salesInvoice', 'refresh');
            }
        }
        $data['orderGeneral'] = $this->Common_model->get_single_data_by_single_column('generals', 'generals_id', $orderId);
        $data['orderStock'] = $this->Common_model->get_data_list_by_single_column('stock', 'generals_id', $orderId);
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
        $data['configInfo'] = $this->Common_model->get_single_data_by_single_column('tbl_distributor', 'dist_id', $this->dist_id);
        $data['referenceList'] = $this->Common_model->get_single_data_by_single_column('reference', 'reference_id', $this->dist_id);
        $data['title'] = 'Sale Order Confirm';
        $data['referenceList'] = $this->Common_model->get_data_list_by_single_column('reference', 'dist_id', $this->dist_id);
        $data['productCat'] = $this->Common_model->get_data_list_by_single_column('productcategory', 'dist_id', $this->dist_id);
        $data['unitList'] = $this->Common_model->get_data_list_by_single_column('unit', 'dist_id', $this->dist_id);
        $data['customerList'] = $this->Common_model->get_data_list_by_many_columns('customer', $cusCondition);
        $totalSale = $this->Common_model->get_data_list_by_many_columns('generals', $condition);
        $data['voucherID'] = "SV" . date("y") . date("m") . str_pad(count($totalSale) + 1, 4, "0", STR_PAD_LEFT);
        $data['mainContent'] = $this->load->view('distributor/sales/salesOrder/salesOrderConfirm', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function salesOrderAdd() {
        if (isPostBack()) {
            // dumpVar($_POST);
            $productId = $this->input->post('product_id');
            $customerId = $this->input->post('customer_id');
            if (empty($customerId)) {
                exception("Customer Id can't be empty.");
                redirect(site_url('salesOrderAdd'));
            }
            if (empty($productId)) {
                exception("Order item can't be empty.");
                redirect(site_url('salesOrderAdd'));
            }
            $this->db->trans_start();
            $payType = $this->input->post('paymentType');
            $data['customer_id'] = $this->input->post('customer_id');
            $data['voucher_no'] = $this->input->post('voucherid');
            $data['reference'] = $this->input->post('reference');
            $data['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
            $data['deliveryDate'] = date('Y-m-d', strtotime($this->input->post('deliveryDate')));
            $data['discount'] = $this->input->post('discount');
            $data['vat'] = $this->input->post('vat');
            $data['narration'] = $this->input->post('narration');
            $data['shipAddress'] = $this->input->post('shippingAddress');
            $data['form_id'] = 19;
            $data['debit'] = $this->input->post('netTotal');
            $data['dist_id'] = $this->dist_id;
            $data['updated_by'] = $this->admin_id;
            $grandtotal = $this->input->post('grandtotal');
            $data['vatAmount'] = ($grandtotal / 100) * $data['vat'];
            $generals_id = $this->Common_model->insert_data('generals', $data);
            $category_cat = $this->input->post('category_id');
            $allStock = array();
            $totalProductCost = 0;
            foreach ($category_cat as $key => $value):
                unset($stock);
                $productCost = $this->Sales_Model->productCost($this->input->post('product_id')[$key], $this->dist_id);
                $totalProductCost += $this->input->post('quantity')[$key] * $productCost;
                $stock['generals_id'] = $generals_id;
                $stock['category_id'] = $value;
                $stock['product_id'] = $this->input->post('product_id')[$key];
                $stock['quantity'] = $this->input->post('quantity')[$key];
                $stock['rate'] = $this->input->post('rate')[$key];
                $stock['price'] = $this->input->post('price')[$key];
                $stock['unit'] = getProductUnit($this->input->post('product_id')[$key]);
                $stock['date'] = $this->input->post('saleDate');
                $stock['form_id'] = 19;
                $stock['type'] = 'Order';
                $stock['dist_id'] = $this->dist_id;
                $stock['updated_by'] = $this->admin_id;
                $stock['created_at'] = $this->timestamp;
                $allStock[] = $stock;
            endforeach;
            $this->db->insert_batch('stock', $allStock);
            //insert in stock table
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                notification("Your sales can't be inserted.Something is wrong.");
                redirect('salesOrderAdd', 'refresh');
            } else {
                message("Your data successfully inserted into database.");
                redirect('salesOrder', 'refresh');
            }
        }
        $condition = array(
            'dist_id' => $this->dist_id,
            'form_id' => 19,
        );
        $cusCondition = array(
            'dist_id' => $this->dist_id,
            'status' => 1,
        );
        $customerID = $this->Sales_Model->getCustomerID($this->dist_id);
        $data['customerID'] = $this->Sales_Model->checkDuplicateCusID($customerID, $this->dist_id);
        $data['configInfo'] = $this->Common_model->get_single_data_by_single_column('tbl_distributor', 'dist_id', $this->dist_id);
        $data['title'] = 'Sale Order Add';
        $data['referenceList'] = $this->Common_model->get_data_list_by_single_column('reference', 'dist_id', $this->dist_id);
        $data['productCat'] = $this->Common_model->getPublicProductCat($this->dist_id);
        $data['unitList'] = $this->Common_model->get_data_list_by_single_column('unit', 'dist_id', $this->dist_id);
        $data['customerList'] = $this->Common_model->get_data_list_by_many_columns('customer', $cusCondition);
        $totalSale = $this->Common_model->get_data_list_by_many_columns('generals', $condition);
        $data['voucherID'] = "SOV" . date("y") . date("m") . str_pad(count($totalSale) + 1, 4, "0", STR_PAD_LEFT);
        $data['mainContent'] = $this->load->view('distributor/sales/salesOrder/salesOrderAdd', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function salesInvoice() {
        $data['title'] = 'Sale || Invoice';
        $data['mainContent'] = $this->load->view('distributor/sales/saleInvoice/saleList', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function customer_ajax() {
        $customer = $this->input->post('customer');
        $result = '<table class="table table-bordered table-hover">';
        $result .= '<thead><tr><td align="center"><strong>Voucher No.</strong></td><td align="center"><strong>Date</strong></td><td align="center"><strong>Type</strong></td><td align="center"><strong>Amount Due (In BDT.)</strong></td><td align="center"><strong>Allocation (In BDT.)</strong></td></tr></thead>';
        $result .= '<tbody>';
        $query = $this->Sales_Model->generals_customer($customer);
        foreach ($query as $key => $row):
            if ($this->Sales_Model->generals_voucher($row['voucher_no']) != 0):
                $result .= '<tr>';
                $result .= '<td><a href="' . site_url('salesInvoice_view/' . $row['generals_id']) . '">' . $row['voucher_no'] . '<input type="hidden" name="voucher[]" value="' . $row['voucher_no'] . '"></a></td>';
                $result .= '<td>' . date('d.m.Y', strtotime($row['date'])) . '</td>';
                $result .= '<td>' . $this->Common_model->tableRow('form', 'form_id', $row['form_id'])->name . '</td>';
                $result .= '<td align="right"><input type="hidden" value="' . $this->Sales_Model->generals_voucher($row['voucher_no']) . '" id="dueAmount_' . $key . '">' . number_format((float) $this->Sales_Model->generals_voucher($row['voucher_no']), 2, '.', ',') . '</td>';
                $result .= '<td><input id="paymentAmount_' . $key . '" type="text" onkeyup="checkOverAmount(' . $key . ')" class="form-control amount " name="amount[]"   placeholder="0.00"></td>';
                $result .= '</tr>';
            endif;
        endforeach;
        $result .= '<tr>';
        $result .= '<td align="right" colspan="4"><strong>Total (In BDT.)</strong></td>';
        $result .= '<td><input type="text" class="form-control ttl_amount required" name="ttl_amount" placeholder="0.00" readonly="readonly"></td>';
        $result .= '</tr>';
        $result .= '</tbody></table>';
        $result .= '<script type="text/javascript">';
        $result .= "$(document).ready(function(){ $('.amount').change(function(){ ttl_amount=0; $.each($('.amount'), function(){ aamount = $(this).val(); aamount=Number(aamount); ttl_amount+=aamount; }); $(this).val(parseFloat($(this).val()).toFixed(2)); $('.ttl_amount').val(parseFloat(ttl_amount).toFixed(2)); }); });";
        $result .= '</script>';
        echo $result;
    }

    public function customerPaymentAdd() {
        if (isPostBack()) {
            $this->form_validation->set_rules('customerid', 'Customer ID', 'required');
            $this->form_validation->set_rules('paymentDate', 'Payment Date', 'required');
            $this->form_validation->set_rules('receiptId', 'Money Receit ID', 'required');
            $this->form_validation->set_rules('payType', 'Payment Type', 'required');
            $this->form_validation->set_rules('ttl_amount', 'Total Payment Amount', 'required');
            if ($this->form_validation->run() == FALSE) {
                exception("Required field can't be empty.");
                redirect(site_url('customerPaymentAdd'));
            } else {
                $updated_by = $this->admin_id;
                $created_at = date('Y-m-d H:i:s');
                $voucher = $this->input->post('voucher');
                $paymentType = $this->input->post('payType');
                $accountDr = $this->input->post('accountDr');
                $this->db->trans_start();
                if (!empty($voucher)) {
                    $totalAmount = 0;
                    $allVoucher = array();
                    foreach ($voucher as $a => $b) {
                        $payment = $this->input->post('amount[' . $a . ']');
                        $voucherId = $this->input->post('voucher[' . $a . ']');
                        if (!empty($payment) && $payment > 1) {
                            /* get main invoice id for delete quewry. */
                            $condition = array(
                                'form_id' => 5,
                                'voucher_no' => $voucherId
                            );
                            $invoiceId = $this->Common_model->get_single_data_by_many_columns('generals', $condition)->generals_id;
                            $allVoucher[] = $voucherId . '_' . $payment;
                            $totalAmount += $payment;
                            if ($paymentType == 1 && !empty($accountDr)):
                                $custLedger = array(
                                    'ledger_type' => 1,
                                    'history_id' => $invoiceId,
                                    'paymentType' => 'Sales Payment',
                                    'trans_type' => $this->input->post('voucher[' . $a . ']'),
                                    'client_vendor_id' => $this->input->post('customerid'),
                                    'amount' => $this->input->post('amount[' . $a . ']'),
                                    'cr' => $this->input->post('amount[' . $a . ']'),
                                    'date' => date('Y-m-d', strtotime($this->input->post('paymentDate'))),
                                    'dist_id' => $this->dist_id,
                                );
                                $this->db->insert('client_vendor_ledger', $custLedger);
                                $generals_data = array(
                                    'form_id' => '7',
                                    'mainInvoiceId' => $invoiceId,
                                    'customer_id' => $this->input->post('customerid'),
                                    'dist_id' => $this->dist_id,
                                    'voucher_no' => $this->input->post('voucher[' . $a . ']'),
                                    'date' => date('Y-m-d', strtotime($this->input->post('paymentDate'))),
                                    'credit' => $this->input->post('amount[' . $a . ']'),
                                    'narration' => $this->input->post('narration'),
                                    'updated_by' => $updated_by,
                                    'created_at' => $created_at
                                );
                                $this->db->insert('generals', $generals_data);
                                $generals_id = $this->db->insert_id();
                                // Cash in hand debit
                                $cr_data = array(
                                    'form_id' => '7',
                                    'date' => date('Y-m-d', strtotime($this->input->post('paymentDate'))),
                                    'generals_id' => $generals_id,
                                    'dist_id' => $this->dist_id,
                                    'account' => $this->input->post('accountDr'),
                                    'debit' => $this->input->post('amount[' . $a . ']'),
                                    'updated_by' => $updated_by,
                                    'created_at' => $created_at
                                );
                                $this->db->insert('generalledger', $cr_data);
                                // account receiable credit
                                $dr_data = array(
                                    'form_id' => '7',
                                    'date' => date('Y-m-d', strtotime($this->input->post('paymentDate'))),
                                    'generals_id' => $generals_id,
                                    'dist_id' => $this->dist_id,
                                    'account' => '58',
                                    'credit' => $this->input->post('amount[' . $a . ']'),
                                    'updated_by' => $updated_by,
                                    'created_at' => $created_at
                                );
                                $this->db->insert('generalledger', $dr_data);
                            endif;
                        }
                    }
                    if (count($voucher) == 1) {
                        $mainInvoiceId = $invoiceId;
                    } else {
                        $mainInvoiceId = 0;
                    }
                    $bankName = $this->input->post('bankName');
                    $checkNo = $this->input->post('checkNo');
                    $checkDate = date('Y-m-d', strtotime($this->input->post('date')));
                    $branchName = $this->input->post('branchName');
                    $mreceit = array(
                        'date' => date('Y-m-d', strtotime($this->input->post('paymentDate'))),
                        'invoiceID' => json_encode($allVoucher),
                        'mainInvoiceId' => $mainInvoiceId,
                        'totalPayment' => $totalAmount,
                        'receitID' => $this->input->post('receiptId'),
                        'customerid' => $this->input->post('customerid'),
                        'narration' => $this->input->post('narration'),
                        'updated_by' => $this->admin_id,
                        'dist_id' => $this->dist_id,
                        'receiveType' => 1,
                        'paymentType' => $this->input->post('payType'),
                        'bankName' => isset($bankName) ? $bankName : '0',
                        'checkNo' => isset($checkNo) ? $checkNo : '0',
                        'checkDate' => isset($checkDate) ? date('Y-m-d', strtotime($checkDate)) : '0',
                        'branchName' => isset($branchName) ? $branchName : '0');
                    $this->db->insert('moneyreceit', $mreceit);
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    exception("Payment Could not Inserted.");
                    redirect('customerPayment', 'refresh');
                } else {
                    message("Your data successfully inserted into database.");
                    redirect('customerPayment', 'refresh');
                }
            }
        }
        $data['accountHeadList'] = $this->Common_model->getAccountHead();
        $moneyReceitNo = $this->db->where(array('dist_id' => $this->dist_id, 'receiveType' => 1))->count_all_results('moneyreceit') + 1;
        $data['moneyReceitVoucher'] = "CMR" . date("y") . date("m") . str_pad($moneyReceitNo, 4, "0", STR_PAD_LEFT);
        $condition = array(
            'dist_id' => $this->dist_id,
            'status' => 1,
        );
        $data['title'] = 'Customer Payment Receive';
        $data['customerList'] = $this->Inventory_Model->getPaymentDueSupplierCustomer($this->dist_id, 1);
        $data['mainContent'] = $this->load->view('distributor/sales/report/customerPayment', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function pendingCheck() {
        if (isPostBack()) {
            $this->form_validation->set_rules('accountDr', 'Account Head', 'required');
            $this->form_validation->set_rules('paymentDate', 'Payment Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                exception("Required field can't be empty.");
                redirect(site_url('pendingCheck'));
            } else {
                //dumpVar($_POST);
                $receiteID = $this->input->post('receiteID');
                $receiteInfo = $this->Common_model->tableRow('moneyreceit', 'moneyReceitid', $receiteID);
                $updated_by = $this->session->userdata('admin_id');
                $created_at = date('Y-m-d H:i:s');
                $voucher = json_decode($receiteInfo->invoiceID);
                $paymentType = $this->input->post('paymentType');
                $clientID = $this->input->post('clientID');
                $account = $this->input->post('accountDr');
                if (!empty($voucher)) {
                    if (count($voucher) == 1) {
                        $this->db->trans_start();
                        if (!empty($receiteInfo->totalPayment)) {
                            //$invoiceId = explode("_", $voucher[0]);
                            $voucherId = explode("_", $voucher[0]);
                            $customerData = array(
                                'ledger_type' => 1,
                                'trans_type' => $receiteInfo->receitID,
                                'history_id' => $receiteInfo->mainInvoiceId,
                                'paymentType' => 'Check Received',
                                'client_vendor_id' => $clientID,
                                'amount' => $receiteInfo->totalPayment,
                                'cr' => $receiteInfo->totalPayment,
                                'dist_id' => $this->dist_id,
                                'date' => date('Y-m-d', strtotime($this->input->post('paymentDate')))
                            );
                            $this->db->insert('client_vendor_ledger', $customerData);
                            $generals_data = array(
                                'form_id' => 7,
                                'customer_id' => $clientID,
                                'mainInvoiceId' => $receiteInfo->mainInvoiceId,
                                'dist_id' => $this->dist_id,
                                'voucher_no' => $voucherId[0],
                                'date' => date('Y-m-d', strtotime($this->input->post('paymentDate'))),
                                'credit' => $receiteInfo->totalPayment,
                                'narration' => $this->input->post('narration'),
                                'updated_by' => $updated_by,
                                'created_at' => $created_at
                            );
                            $this->db->insert('generals', $generals_data);
                            $generals_id = $this->db->insert_id();
                            // Cash in hand debit
                            $dr_data = array(
                                'form_id' => 7,
                                'date' => date('Y-m-d', strtotime($this->input->post('paymentDate'))),
                                'generals_id' => $generals_id,
                                'dist_id' => $this->dist_id,
                                'account' => $account,
                                'debit' => $receiteInfo->totalPayment,
                                'updated_by' => $updated_by,
                                'created_at' => $created_at
                            );
                            $this->db->insert('generalledger', $dr_data);
                            // account receiable credit
                            $cr_data = array(
                                'form_id' => 7,
                                'date' => date('Y-m-d', strtotime($this->input->post('paymentDate'))),
                                'generals_id' => $generals_id,
                                'dist_id' => $this->dist_id,
                                'account' => '58',
                                'credit' => $receiteInfo->totalPayment,
                                'updated_by' => $updated_by,
                                'created_at' => $created_at
                            );
                            $this->db->insert('generalledger', $cr_data);
                            $changeStatus['checkStatus'] = 2;
                            $changeStatus['received_date'] = date('Y-m-d');
                            $this->db->where('moneyReceitid', $receiteID);
                            $this->db->update('moneyreceit', $changeStatus);
                        }
                        $this->db->trans_complete();
                        if ($this->db->trans_status() === FALSE) {
                            exception("Data could not save.something is wrong");
                            redirect('pendingCheck', 'refresh');
                        } else {
                            message("Your data successfully inserted into database.");
                            redirect('viewMoneryReceipt/' . $receiteID, 'refresh');
                        }
                    } else {
                        //dumpVar($voucher);
                        $this->db->trans_start();
                        $totalAmount = 0;
                        $allVoucher = array();
                        foreach ($voucher as $a => $b) {
                            $moneyReceit = explode("_", $b);
                            $payment = $moneyReceit[1];
                            /* get main invoice id for delete quewry. */
                            $condition = array(
                                'form_id' => 5,
                                'voucher_no' => $moneyReceit[0]
                            );
                            $InvoiceDuePayment = $this->Sales_Model->checkVoucherPaymentAlreadyReceive($this->dist_id, $moneyReceit[0]);
//                            if (!empty($InvoiceDuePayment) && $InvoiceDuePayment > 0) {
//
//                            }
                            $invoiceId = $this->Common_model->get_single_data_by_many_columns('generals', $condition)->generals_id;
                            if (!empty($payment)) {
                                $allVoucher[] = $moneyReceit[0];
                                $totalAmount += $payment;
                                $customerData = array(
                                    'ledger_type' => 1,
                                    'history_id' => $invoiceId,
                                    'trans_type' => $moneyReceit[0],
                                    'paymentType' => 'Check Receive',
                                    'client_vendor_id' => $clientID,
                                    'amount' => $moneyReceit[1],
                                    'cr' => $moneyReceit[1],
                                    'dist_id' => $this->dist_id,
                                    'date' => date('Y-m-d', strtotime($this->input->post('paymentDate')))
                                );
                                $this->db->insert('client_vendor_ledger', $customerData);
                                $generals_data = array(
                                    'form_id' => 7,
                                    'customer_id' => $clientID,
                                    'mainInvoiceId' => $invoiceId,
                                    'dist_id' => $this->dist_id,
                                    'voucher_no' => $moneyReceit[0],
                                    'date' => date('Y-m-d', strtotime($this->input->post('paymentDate'))),
                                    'credit' => $moneyReceit[1],
                                    'narration' => $this->input->post('narration'),
                                    'updated_by' => $updated_by,
                                    'created_at' => $created_at
                                );
                                $this->db->insert('generals', $generals_data);
                                $generals_id = $this->db->insert_id();
                                // Cash in hand debit
                                $dr_data = array(
                                    'form_id' => 7,
                                    'date' => date('Y-m-d', strtotime($this->input->post('paymentDate'))),
                                    'generals_id' => $generals_id,
                                    'dist_id' => $this->dist_id,
                                    'account' => $account,
                                    'debit' => $moneyReceit[1],
                                    'updated_by' => $updated_by,
                                    'created_at' => $created_at
                                );
                                $this->db->insert('generalledger', $dr_data);
                                // account receiable credit
                                $cr_data = array(
                                    'form_id' => 7,
                                    'date' => date('Y-m-d', strtotime($this->input->post('paymentDate'))),
                                    'generals_id' => $generals_id,
                                    'dist_id' => $this->dist_id,
                                    'account' => '58',
                                    'credit' => $moneyReceit[1],
                                    'updated_by' => $updated_by,
                                    'created_at' => $created_at
                                );
                                $this->db->insert('generalledger', $cr_data);
                                $changeStatus['checkStatus'] = 2;
                                $changeStatus['received_date'] = date('Y-m-d');
                                $this->db->where('moneyReceitid', $receiteID);
                                $this->db->update('moneyreceit', $changeStatus);
                            }
                        }
                        $this->db->trans_complete();
                        if ($this->db->trans_status() === FALSE) {
                            exception("Data could not save.something is wrong");
                            redirect('pendingCheck', 'refresh');
                        } else {
                            message("Your data successfully inserted into database.");
                            redirect('viewMoneryReceipt/' . $receiteID, 'refresh');
                        }
                    }
                }
            }
        }
        // $data['accountHeadList'] = $assetsList;
        $data['accountHeadList'] = $this->Common_model->getAccountHead();
        $data['title'] = 'Customer Pending cheque';
        //money Recit condition
        $moneyReceitCond = array(
            'receiveType' => 1, //customer
            'paymentType' => 2, //cheque
            'checkStatus' => 1, //pending
            'dist_id' => $this->dist_id, //distributor id
        );
        $data['customerPendingCheque'] = $this->Common_model->get_data_list_by_many_columns('moneyreceit', $moneyReceitCond, 'moneyReceitid', 'DESC');
        $data['mainContent'] = $this->load->view('distributor/sales/report/pendingCheck', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    function dishonourCustomerChwque($chequeId) {
        $data['checkStatus'] = 3;
        $this->Common_model->update_data('moneyreceit', $data, 'moneyReceitid', $chequeId);
        message("Your data successfully inserted into dtabase.");
        redirect(site_url('dishonourCustomerChwqueList'));
    }

    function dishonourCustomerChwqueList() {
        $moneyReceitCond = array(
            'receiveType' => 1, //customer
            'paymentType' => 2, //cheque
            'checkStatus' => 3, //pending
            'dist_id' => $this->dist_id, //distributor id
        );
        $data['customerPendingCheque'] = $this->Common_model->get_data_list_by_many_columns('moneyreceit', $moneyReceitCond, 'moneyReceitid', 'DESC');
        $data['mainContent'] = $this->load->view('distributor/sales/report/dishourCheck', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function customerPayment() {
        $data['title'] = 'Customer Payment List';
        $data['mainContent'] = $this->load->view('distributor/sales/report/customerPaymentList', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function viewMoneryReceipt($receiptId, $voucherId = null) {
        $data['title'] = 'Money Receipt';
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['moneyReceitInfo'] = $this->Common_model->get_single_data_by_single_column('moneyreceit', 'moneyReceitid', $receiptId);
        $data['customerInfo'] = $this->Common_model->get_single_data_by_single_column('customer', 'customer_id', $data['moneyReceitInfo']->customerid);
        $data['mainContent'] = $this->load->view('distributor/sales/report/viewMoneyReceipt', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function salesInvoice_view($salesID) {
        if (is_numeric($salesID)) {
            //is invoice id is valid
            $validInvoiecId = $this->Sales_Model->checkInvoiceIdAndDistributor($this->dist_id, $salesID);
            if ($validInvoiecId === FALSE) {
                exception("Sorry invoice id is invalid!!");
                redirect(site_url('salesInvoice'));
            }
        } else {
            exception("Sorry invoice id is invalid!!");
            redirect(site_url('salesInvoice'));
        }
        $data['title'] = 'Sale || View';
        $data['saleslist'] = $this->Common_model->get_single_data_by_single_column('generals', 'generals_id', $salesID);
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['invoicePayment'] = $this->Sales_Model->getInvoicePayment($this->dist_id, $salesID);
        $data['customerInfo'] = $this->Common_model->get_single_data_by_single_column('customer', 'customer_id', $data['saleslist']->customer_id);
        $data['stockList'] = $this->Common_model->get_data_list_by_single_column('stock', 'generals_id', $salesID);
        $data['mainContent'] = $this->load->view('distributor/sales/saleInvoice/sales_view', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function salesInvoicViewWithCylinder($salesID) {
        if (is_numeric($salesID)) {
            //is invoice id is valid
            $validInvoiecId = $this->Sales_Model->checkInvoiceIdAndDistributor($this->dist_id, $salesID);
            if ($validInvoiecId === FALSE) {
                exception("Sorry invoice id is invalid!!");
                redirect(site_url('salesInvoice'));
            }
        } else {
            exception("Sorry invoice id is invalid!!");
            redirect(site_url('salesInvoice'));
        }
        $data['title'] = 'Sale || View';
        $data['saleslist'] = $this->Common_model->get_single_data_by_single_column('generals', 'generals_id', $salesID);
        $data['invoicePayment'] = $this->Sales_Model->getInvoicePayment($this->dist_id, $salesID);
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['customerInfo'] = $this->Common_model->get_single_data_by_single_column('customer', 'customer_id', $data['saleslist']->customer_id);
        $data['stockList'] = $this->Common_model->get_data_list_by_single_column('stock', 'generals_id', $salesID);
        $data['mainContent'] = $this->load->view('distributor/sales/saleInvoice/sales_viewWithCylinser', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    function productWiseSalesReport() {
        $data['title'] = 'Product Wise Sales Report';
        $data['productList'] = $this->Common_model->getPublicProductWithoutCat($this->dist_id);
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['mainContent'] = $this->load->view('distributor/sales/report/proudctWiseSalesReport', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    function cylinderReceiveView($generalId) {
        $data['title'] = 'Cylinder || View';
        $data['saleslist'] = $this->Common_model->get_single_data_by_single_column('generals', 'generals_id', $generalId);
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['customerInfo'] = $this->Common_model->get_single_data_by_single_column('customer', 'customer_id', $data['saleslist']->customer_id);
        $data['stockList'] = $this->Common_model->get_data_list_by_single_column('stock', 'generals_id', $generalId);
        $data['mainContent'] = $this->load->view('distributor/sales/cylinder/cylinderView', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function cylinderReceive() {
        $data['cylinderList'] = $this->Common_model->getCylinderList($this->dist_id);
        $data['title'] = 'Cylinder List';
        $data['mainContent'] = $this->load->view('distributor/sales/cylinder/cylinderList', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function cylinderReceiveAdd() {
        if (isPostBack()) {
            // dumpVar($_POST);
            $this->db->trans_start();
            $data['customer_id'] = $this->input->post('customer_id');
            $data['voucher_no'] = $this->input->post('voucherid');
            $data['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
            $data['narration'] = $this->input->post('narration');
            $data['form_id'] = 24;
            $data['dist_id'] = $this->dist_id;
            $data['updated_by'] = $this->admin_id;
            $generals_id = $this->Common_model->insert_data('generals', $data);
            $category_cat = $this->input->post('category_id');
            $allStock = array();
            $totalProductCost = 0;
            foreach ($category_cat as $key => $value):
                unset($stock);
                $productCost = $this->Sales_Model->productCost($this->input->post('product_id')[$key], $this->dist_id);
                $totalProductCost += $this->input->post('quantity')[$key] * $productCost;
                $stock['generals_id'] = $generals_id;
                $stock['category_id'] = $value;
                $stock['product_id'] = $this->input->post('product_id')[$key];
                $stock['unit'] = getProductUnit($this->input->post('product_id')[$key]);
                $stock['quantity'] = $this->input->post('quantity')[$key];
                $stock['rate'] = $this->input->post('rate')[$key];
                $stock['price'] = $this->input->post('price')[$key];
                $stock['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                $stock['form_id'] = 24;
                $stock['type'] = 'Cin';
                $stock['dist_id'] = $this->dist_id;
                $stock['customerId'] = $this->input->post('customer_id');
                $stock['updated_by'] = $this->admin_id;
                $stock['created_at'] = $this->timestamp;
                $allStock[] = $stock;
            endforeach;
            $this->db->insert_batch('stock', $allStock);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                notification("Your cylinder receive can't be inserted.Something is wrong.");
                redirect('cylinderReceiveAdd', 'refresh');
            } else {
                message("Your data successully inserted into database.");
                redirect('cylinderReceive', 'refresh');
            }
        }
        $cusCondition = array(
            'dist_id' => $this->dist_id,
            'status' => 1,
        );
        $condition = array(
            'form_id' => 24,
            'dist_id' => $this->dist_id,
        );
        $data['title'] = 'Sale Add';
        $data['productCat'] = $this->Common_model->getPublicProductCat($this->dist_id);
        $data['unitList'] = $this->Common_model->get_data_list_by_single_column('unit', 'dist_id', $this->dist_id);
        $data['customerList'] = $this->Common_model->get_data_list_by_many_columns('customer', $cusCondition);
        $totalReceive = $this->Common_model->get_data_list_by_many_columns('generals', $condition);
        $data['voucherID'] = "CRID" . date("y") . date("m") . str_pad(count($totalReceive) + 1, 4, "0", STR_PAD_LEFT);
        $data['mainContent'] = $this->load->view('distributor/sales/cylinder/cylinderAdd', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function salesInvoice_edit($invoiceId = null) {
        /* check Invoice id valid ? or not */
        if (is_numeric($invoiceId)) {
            //is invoice id is valid
            $validInvoiecId = $this->Sales_Model->checkInvoiceIdAndDistributor($this->dist_id, $invoiceId);
            if ($validInvoiecId === FALSE) {
                exception("Sorry invoice id is invalid!!");
                redirect(site_url('salesInvoice'));
            }
        } else {
            exception("Sorry invoice id is invalid!!");
            redirect(site_url('salesInvoice_edit/' . $invoiceId));
        }
        /* check Invoice id valid ? or not */
        if (isPostBack()) {
            // dumpVar($_POST);
            $this->form_validation->set_rules('netTotal', 'Net Total', 'required');
            $this->form_validation->set_rules('customer_id', 'Customer ID', 'required');
            $this->form_validation->set_rules('voucherid', 'Voucehr ID', 'required');
            $this->form_validation->set_rules('saleDate', 'Sales Date', 'required');
            $this->form_validation->set_rules('paymentType', 'Payment Type', 'required');
            $this->form_validation->set_rules('category_id[]', 'Category ID', 'required');
            $this->form_validation->set_rules('product_id[]', 'Product', 'required');
            $this->form_validation->set_rules('quantity[]', 'Product Quantity', 'required');
            $this->form_validation->set_rules('rate[]', 'Product Rate', 'required');
            $this->form_validation->set_rules('price[]', 'Product Price', 'required');
            $allData = $this->input->post();
            if ($this->form_validation->run() == FALSE) {
                exception("Required field can't be empty.");
                redirect(site_url('salesInvoice_add'));
            } else {

                $productId = $this->input->post('product_id');
                $pmtype = $this->input->post('paymentType');
                $ppAmount = $this->input->post('partialPayment');
                $this->db->trans_start();
                $payType = $this->input->post('paymentType');
                // echo $payType;die;
                $data['customer_id'] = $this->input->post('customer_id');
                $data['voucher_no'] = $this->input->post('voucherid');
                $data['reference'] = $this->input->post('reference');
                $data['payType'] = $this->input->post('paymentType');
                $data['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                $data['discount'] = $this->input->post('discount');
                $data['vat'] = $this->input->post('vat');
                $data['narration'] = $this->input->post('narration');
                $data['shipAddress'] = $this->input->post('shippingAddress');
                $data['loader'] = $this->input->post('loader');
                $data['loaderAmount'] = $this->input->post('loaderAmount');
                $data['transportation'] = $this->input->post('transportation');
                $data['transportationAmount'] = $this->input->post('transportationAmount');
                $data['form_id'] = 5;
                $data['debit'] = $this->input->post('netTotal');
                $data['dist_id'] = $this->dist_id;
                $data['updated_at'] = $this->timestamp;
                $data['updated_by'] = $this->admin_id;
                $data['mainInvoiceId'] = $this->input->post('userInvoiceId');
                $grandtotal = $this->input->post('grandtotal');
                $data['vatAmount'] = ($grandtotal / 100) * $data['vat'];
                $returnQty = array_sum($this->input->post('returnQuantity'));
                $this->Common_model->update_data('generals', $data, 'generals_id', $invoiceId);
                $generals_id = $invoiceId;
                /* Delete query fro this invoice id */
                //delete stock table
                $this->Common_model->delete_data('stock', 'generals_id', $invoiceId);
                $this->Common_model->delete_data('generalledger', 'generals_id', $invoiceId);
                $this->Common_model->delete_data('client_vendor_ledger', 'history_id', $invoiceId);
                $this->Common_model->delete_data('moneyreceit', 'mainInvoiceId', $invoiceId);
                $invoiceList = $this->Sales_Model->getInvoiceIdList($this->dist_id, $invoiceId);
                //delete general table
                if (!empty($invoiceList)) {
                    foreach ($invoiceList as $eachId):
                        $this->Common_model->delete_data('generals', 'generals_id', $eachId->generals_id);
                        $this->Common_model->delete_data('stock', 'generals_id', $eachId->generals_id);
                        $this->Common_model->delete_data('generalledger', 'generals_id', $eachId->generals_id);
                        $this->Common_model->delete_data('client_vendor_ledger', 'history_id', $eachId->generals_id);
                        $this->Common_model->delete_data('moneyreceit', 'mainInvoiceId', $eachId->generals_id);
                    endforeach;
                }
                if (!empty($returnQty)) {
                    /*
                     * Edit By Nahid
                     * or Stop Inserting data to general table
                     *
                     *
                     * $cylinder['customer_id'] = $this->input->post('customer_id');
                      $cylinder['voucher_no'] = $this->input->post('voucherid');
                      $cylinder['reference'] = $this->input->post('reference');
                      $cylinder['payType'] = $this->input->post('paymentType');
                      $cylinder['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                      $cylinder['discount'] = $this->input->post('discount');
                      $cylinder['vat'] = $this->input->post('vat');
                      $cylinder['narration'] = $this->input->post('narration');
                      $cylinder['shipAddress'] = $this->input->post('shippingAddress');
                      $cylinder['form_id'] = 23;
                      $cylinder['debit'] = $this->input->post('netTotal');
                      $cylinder['dist_id'] = $this->dist_id;
                      $cylinder['mainInvoiceId'] = $generals_id;
                      $cylinder['updated_by'] = $this->admin_id;
                      $cylinder['vatAmount'] = ($grandtotal / 100) * $data['vat'];
                      $cylinderId = $this->Common_model->insert_data('generals', $cylinder); */
                }
                $customerName = $this->Common_model->tableRow('customer', 'customer_id', $data['customer_id'])->customerName;
                $mobile = $this->Common_model->tableRow('customer', 'customer_id', $data['customer_id'])->customerPhone;
                $category_cat = $this->input->post('category_id');
                $allStock = array();
                $allStock1 = array();
                $totalProductCost = 0;
                $newCylinderProductCost = 0;
                $otherProductCost = 0;
                foreach ($category_cat as $key => $value):
                    unset($stock);
                    $productCost = $this->Sales_Model->productCost($this->input->post('product_id')[$key], $this->dist_id);
                    $totalProductCost += $this->input->post('quantity')[$key] * $productCost;
                    if ($value == 1) {
                        //get cylinder product cost
                        $newCylinderProductCost += $this->input->post('quantity')[$key] * $productCost;
                    } else {
                        //get without cylinder product cost
                        $otherProductCost += $this->input->post('quantity')[$key] * $productCost;
                    }
                    $stock['generals_id'] = $generals_id;
                    $stock['category_id'] = $value;
                    $stock['product_id'] = $this->input->post('product_id')[$key];
                    $stock['unit'] = getProductUnit($this->input->post('product_id')[$key]);
                    $stock['quantity'] = $this->input->post('quantity')[$key];
                    $stock['rate'] = $this->input->post('rate')[$key];
                    $stock['price'] = $this->input->post('price')[$key];
                    $stock['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                    $stock['form_id'] = 5;
                    $stock['type'] = 'Out';
                    $stock['dist_id'] = $this->dist_id;
                    $stock['updated_by'] = $this->admin_id;
                    $stock['created_at'] = $this->timestamp;
                    $allStock[] = $stock;
                    $returnQty = $this->input->post('returnQuantity')[$key];
                    //If cylinder stock out than transaction store here.
                    if (!empty($returnQty)) {
                        // $productCost = $this->Sales_Model->productCost($this->input->post('product_id')[$key], $this->dist_id);
                        //$stock1['generals_id'] = $cylinderId;
                        $stock1['generals_id'] = $generals_id;
                        $stock1['category_id'] = $value;
                        $stock1['product_id'] = $this->input->post('product_id')[$key];
                        $stock1['unit'] = getProductUnit($this->input->post('product_id')[$key]);
                        $stock1['quantity'] = $this->input->post('returnQuantity')[$key];
                        $stock1['rate'] = $this->input->post('rate')[$key];
                        $stock1['price'] = $this->input->post('price')[$key];
                        $stock1['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                        $stock1['form_id'] = 23;
                        $stock1['type'] = 'Cout';
                        $stock1['dist_id'] = $this->dist_id;
                        $stock1['customerId'] = $this->input->post('customer_id');
                        $stock1['updated_by'] = $this->admin_id;
                        $stock1['created_at'] = $this->timestamp;
                        $allStock1[] = $stock1;
                    }
                endforeach;
                $cylinderRecive = $this->input->post('category_id2');
                $cylinderAllStock = array();
                if (!empty($cylinderRecive)):
                    /*
                     * Edit By Nahid
                     * or Stop Inserting data to general table
                     *
                     *
                     * $cylinderData['customer_id'] = $this->input->post('customer_id');
                      $cylinderData['voucher_no'] = $this->input->post('voucherid');
                      $cylinderData['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                      $cylinderData['narration'] = $this->input->post('narration');
                      $cylinderData['form_id'] = 24;
                      $cylinderData['dist_id'] = $this->dist_id;
                      $cylinderData['mainInvoiceId'] = $generals_id;
                      $cylinderData['updated_by'] = $this->admin_id;
                      $CylinderReceive = $this->Common_model->insert_data('generals', $cylinderData); */
                    foreach ($cylinderRecive as $key => $value) :
                        //$stock1['generals_id'] = $cylinderId;
                        $stockReceive['generals_id'] = $generals_id;
                        //$stockReceive['generals_id'] = $CylinderReceive;
                        $stockReceive['category_id'] = $value;
                        $stockReceive['product_id'] = $this->input->post('product_id2')[$key];
                        $stockReceive['unit'] = getProductUnit($this->input->post('product_id2')[$key]);
                        $stockReceive['quantity'] = $this->input->post('quantity2')[$key];
                        $stockReceive['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                        $stockReceive['form_id'] = 24;
                        $stockReceive['type'] = 'Cin';
                        $stockReceive['dist_id'] = $this->dist_id;
                        $stockReceive['customerId'] = $this->input->post('customer_id');
                        $stockReceive['updated_by'] = $this->admin_id;
                        $stockReceive['created_at'] = $this->timestamp;
                        $cylinderAllStock[] = $stockReceive;
                    endforeach;
                    //insert for culinder receive
                    $this->db->insert_batch('stock', $cylinderAllStock);
                endif;
                //insert for quantity out stock
                $this->db->insert_batch('stock', $allStock);
                //insert for cylinder stock out
                $this->db->insert_batch('stock', $allStock1);
                //insert in stock table
                $customerLedger = array(
                    'ledger_type' => 1,
                    'trans_type' => 'Sales',
                    'history_id' => $generals_id,
                    'trans_type' => $this->input->post('voucherid'),
                    'client_vendor_id' => $this->input->post('customer_id'),
                    'updated_by' => $this->admin_id,
                    'dist_id' => $this->dist_id,
                    'amount' => $this->input->post('netTotal'),
                    'dr' => $this->input->post('netTotal'),
                    'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                );
                $this->db->insert('client_vendor_ledger', $customerLedger);
                $mrCondition = array(
                    'dist_id' => $this->dist_id,
                    'receiveType' => 1,
                );
                $totalMoneyReceite = $this->Common_model->get_data_list_by_many_columns('moneyreceit', $mrCondition);
                $mrid = "CMR" . date("y") . date("m") . str_pad(count($totalMoneyReceite) + 1, 4, "0", STR_PAD_LEFT);
                if ($payType == 1) {
                    //when payment type cash
                    $this->cashTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid);
                } elseif ($payType == 2) {
                    //when paymnet type credit
                    $this->creditTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid);
                } elseif ($payType == 3) {
                    //when payment type cheque
                    $this->chequeTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid);
                } else {
                    //when payment transaction is partial.but now it use as cash.
                    $this->partialTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid);
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    notification("Your sales can't be inserted.Something is wrong.");
                    redirect('salesInvoice_edit/' . $generals_id, 'refresh');
                } else {
                    message("Your data successfully inserted into database.");
                    redirect('salesInvoice_view/' . $generals_id, 'refresh');
                }
                /* Delete query fro this invoice id */
            }
        }
        $data['title'] = 'Sale Invoice Edit';
        $data['editInvoice'] = $this->Common_model->get_single_data_by_single_column('generals', 'generals_id', $invoiceId);
        $data['bank_check_details'] = array();
        if ($data['editInvoice']->payType == 3) {
            $data['bank_check_details'] = $this->Common_model->get_single_data_by_single_column('moneyreceit', 'mainInvoiceId', $data['editInvoice']->generals_id);
        }
        $data['editStock'] = $this->Common_model->get_data_list_by_single_column('stock', 'generals_id', $invoiceId);
        $data['configInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['accountHeadList'] = $this->Common_model->getAccountHead();
        //get only cylinder product
        $data['productList'] = $this->Common_model->getPublicProductList($this->dist_id);
        // dumpVar($data['accountHeadList']);
        $data['cylinderProduct'] = $this->Common_model->getPublicProduct($this->dist_id, 2);
        $data['productCat'] = $this->Common_model->getPublicProductCat($this->dist_id);
        $data['unitList'] = $this->Common_model->getPublicUnit($this->dist_id);
        $data['referenceList'] = $this->Sales_Model->getReferenceList($this->dist_id);
        $data['customerList'] = $this->Sales_Model->getCustomerList($this->dist_id);
        $data['cylinserOut'] = $this->Sales_Model->getCylinderInOutResult($this->dist_id, $invoiceId, 23);
        $data['cylinderReceive'] = $this->Sales_Model->getCylinderInOutResult2($this->dist_id, $invoiceId, 24);
        //echo $this->db->last_query();exit;
        $data['creditAmount'] = $paymentInfo = $this->Sales_Model->getCreditAmount($invoiceId);
        $condition = array(
            'dist_id' => $this->dist_id,
            'isActive' => 'Y',
            'isDelete' => 'N',
        );
        $data['employeeList'] = $this->Common_model->get_data_list_by_many_columns('employee', $condition);
        $data['vehicleList'] = $this->Common_model->get_data_list_by_many_columns('vehicle', $condition);
        $data['accountId'] = $this->Sales_Model->getAccountId($paymentInfo->generals_id);
        // echo $this->db->last_query();die;
        $data['mainContent'] = $this->load->view('distributor/sales/saleInvoice/editInvoice', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function salesInvoice_add($confirmId = null) {
        if (isPostBack()) {
            // dumpVar($_POST);
            $this->form_validation->set_rules('netTotal', 'Net Total', 'required');
            $this->form_validation->set_rules('customer_id', 'Customer ID', 'required');
            $this->form_validation->set_rules('voucherid', 'Voucehr ID', 'required');
            $this->form_validation->set_rules('saleDate', 'Sales Date', 'required');
            $this->form_validation->set_rules('paymentType', 'Payment Type', 'required');
            $this->form_validation->set_rules('category_id[]', 'Category ID', 'required');
            $this->form_validation->set_rules('product_id[]', 'Product', 'required');
            $this->form_validation->set_rules('quantity[]', 'Product Quantity', 'required');
            $this->form_validation->set_rules('rate[]', 'Product Rate', 'required');
            $this->form_validation->set_rules('price[]', 'Product Price', 'required');
            $allData = $this->input->post();
            if ($this->form_validation->run() == FALSE) {
                exception("Required field can't be empty.");
                redirect(site_url('salesInvoice_add'));
            } else {
                $customerId = $this->input->post('customer_id');
                $productId = $this->input->post('product_id');
                $pmtype = $this->input->post('paymentType');
                $ppAmount = $this->input->post('partialPayment');
                $this->db->trans_start();
                $payType = $this->input->post('paymentType');
                // echo $payType;die;
                $data['customer_id'] = $this->input->post('customer_id');
                $data['voucher_no'] = $this->input->post('voucherid');
                $data['reference'] = $this->input->post('reference');
                $data['payType'] = $this->input->post('paymentType');
                $data['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                $data['discount'] = $this->input->post('discount');
                $data['vat'] = $this->input->post('vat');
                $data['narration'] = $this->input->post('narration');
                $data['shipAddress'] = $this->input->post('shippingAddress');
                $data['mainInvoiceId'] = $this->input->post('userInvoiceId');
                $data['loader'] = $this->input->post('loader');
                $data['loaderAmount'] = $this->input->post('loaderAmount');
                $data['transportation'] = $this->input->post('transportation');
                $data['transportationAmount'] = $this->input->post('transportationAmount');
                $data['form_id'] = 5;
                $data['debit'] = $this->input->post('netTotal');
                $data['dist_id'] = $this->dist_id;
                $data['updated_by'] = $this->admin_id;
                $grandtotal = $this->input->post('grandtotal');
                $data['vatAmount'] = ($grandtotal / 100) * $data['vat'];
                $generals_id = $this->Common_model->insert_data('generals', $data);
                $returnQty = array_sum($this->input->post('returnQuantity'));
                //cylinder calculation start here....

                $customerName = $this->Common_model->tableRow('customer', 'customer_id', $data['customer_id'])->customerName;
                $mobile = $this->Common_model->tableRow('customer', 'customer_id', $data['customer_id'])->customerPhone;
                $category_cat = $this->input->post('category_id');
                $allStock = array();
                $allStock1 = array();
                $totalProductCost = 0;
                $newCylinderProductCost = 0;
                $otherProductCost = 0;
                foreach ($category_cat as $key => $value):
                    unset($stock);
                    $productCost = $this->Sales_Model->productCost($this->input->post('product_id')[$key], $this->dist_id);
                    $totalProductCost += $this->input->post('quantity')[$key] * $productCost;
                    if ($value == 1) {
                        //get cylinder product cost
                        $newCylinderProductCost += $this->input->post('quantity')[$key] * $productCost;
                    } else {
                        //get without cylinder product cost
                        $otherProductCost += $this->input->post('quantity')[$key] * $productCost;
                    }
                    $stock['generals_id'] = $generals_id;
                    $stock['category_id'] = $value;
                    $stock['product_id'] = $this->input->post('product_id')[$key];
                    $stock['unit'] = getProductUnit($this->input->post('product_id')[$key]);
                    $stock['quantity'] = $this->input->post('quantity')[$key];
                    $stock['rate'] = $this->input->post('rate')[$key];
                    $stock['price'] = $this->input->post('price')[$key];
                    $stock['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                    $stock['form_id'] = 5;
                    $stock['type'] = 'Out';
                    $stock['dist_id'] = $this->dist_id;
                    $stock['updated_by'] = $this->admin_id;
                    $stock['created_at'] = $this->timestamp;
                    $allStock[] = $stock;
                    $returnQty = $this->input->post('returnQuantity')[$key];
                    //If cylinder stock out than transaction store here.
                    if (!empty($returnQty)) {
                        // $productCost = $this->Sales_Model->productCost($this->input->post('product_id')[$key], $this->dist_id);
                        $stock1['generals_id'] = $generals_id;
                        //$stock1['generals_id'] = $cylinderId;
                        $stock1['category_id'] = $value;
                        $stock1['product_id'] = $this->input->post('product_id')[$key];
                        $stock1['unit'] = getProductUnit($this->input->post('product_id')[$key]);
                        $stock1['quantity'] = $this->input->post('returnQuantity')[$key];
                        $stock1['rate'] = $this->input->post('rate')[$key];
                        $stock1['price'] = $this->input->post('price')[$key];
                        $stock1['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                        $stock1['form_id'] = 23;
                        $stock1['type'] = 'Cout';
                        $stock1['dist_id'] = $this->dist_id;
                        $stock1['customerId'] = $this->input->post('customer_id');
                        $stock1['updated_by'] = $this->admin_id;
                        $stock1['created_at'] = $this->timestamp;
                        $allStock1[] = $stock1;
                    }
                endforeach;
                $cylinderRecive = $this->input->post('category_id2');
                $cylinderAllStock = array();
                if (!empty($cylinderRecive)):

                    foreach ($cylinderRecive as $key => $value) :
                        //$stock1['generals_id'] = $cylinderId;
                        //$stockReceive['generals_id'] = $CylinderReceive;
                        $stockReceive['generals_id'] = $generals_id;
                        $stockReceive['category_id'] = $value;
                        $stockReceive['product_id'] = $this->input->post('product_id2')[$key];
                        $stockReceive['unit'] = getProductUnit($this->input->post('product_id2')[$key]);
                        $stockReceive['quantity'] = $this->input->post('quantity2')[$key];
                        $stockReceive['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                        $stockReceive['form_id'] = 24;
                        $stockReceive['type'] = 'Cin';
                        $stockReceive['dist_id'] = $this->dist_id;
                        $stockReceive['customerId'] = $this->input->post('customer_id');
                        $stockReceive['updated_by'] = $this->admin_id;
                        $stockReceive['created_at'] = $this->timestamp;
                        $cylinderAllStock[] = $stockReceive;
                    endforeach;
                    //insert for culinder receive
                    $this->db->insert_batch('stock', $cylinderAllStock);
                endif;
                //insert for quantity out stock
                $this->db->insert_batch('stock', $allStock);
                //insert for cylinder stock out
                $this->db->insert_batch('stock', $allStock1);
                //insert in stock table
                $customerLedger = array(
                    'ledger_type' => 1,
                    'trans_type' => 'Sales',
                    'history_id' => $generals_id,
                    'trans_type' => $this->input->post('voucherid'),
                    'client_vendor_id' => $this->input->post('customer_id'),
                    'updated_by' => $this->admin_id,
                    'dist_id' => $this->dist_id,
                    'amount' => $this->input->post('netTotal'),
                    'dr' => $this->input->post('netTotal'),
                    'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                );
                $this->db->insert('client_vendor_ledger', $customerLedger);
                $mrCondition = array(
                    'dist_id' => $this->dist_id,
                    'receiveType' => 1,
                );
                $totalMoneyReceite = $this->Common_model->get_data_list_by_many_columns('moneyreceit', $mrCondition);
                $mrid = "CMR" . date("y") . date("m") . str_pad(count($totalMoneyReceite) + 1, 4, "0", STR_PAD_LEFT);
                if ($payType == 1) {
                    //when payment type cash
                    $this->cashTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid);
                } elseif ($payType == 2) {
                    //when payment type credit
                    $this->creditTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid);
                } elseif ($payType == 3) {
                    //when payment type cheque.
                    $this->chequeTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid);
                } elseif ($payType == 4) {
                    //when partial paymet start from here.
                    $this->partialTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid);
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    notification("Your sales can't be inserted.Something is wrong.");
                    if (!empty($confirmId)) {
                        redirect('salesImportConfirm/' . $confirmId, 'refresh');
                    } else {
                        redirect('salesInvoice_add/', 'refresh');
                    }
                } else {
                    message("Your data successfully inserted into database.");
                    if (!empty($confirmId)) {
                        $updateStata['ConfirmStatus'] = 1;
                        $this->Common_model->update_data('purchase_demo', $updateStata, 'purchase_demo_id', $confirmId);
                        redirect('salesImport', 'refresh');
                    } else {
                        redirect('salesInvoice_view/' . $generals_id, 'refresh');
                    }
                }
            }
        }
        $salesCondition = array(
            'dist_id' => $this->dist_id,
            'form_id' => 5,
        );
        $cusCondition = array(
            'dist_id' => $this->dist_id,
            'status' => 1,
        );
        $data['title'] = 'Sale Add';
        $customerID = $this->Sales_Model->getCustomerID($this->dist_id);
        $data['customerID'] = $this->Sales_Model->checkDuplicateCusID($customerID, $this->dist_id);
        $data['referenceList'] = $this->Common_model->get_data_list_by_single_column('reference', 'dist_id', $this->dist_id);
        $data['configInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['accountHeadList'] = $this->Common_model->getAccountHead();
        $data['productList'] = $this->Common_model->getPublicProductList($this->dist_id);
        $data['cylinderProduct'] = $this->Common_model->getPublicProduct($this->dist_id, 2);
        $data['productCat'] = $this->Common_model->getPublicProductCat($this->dist_id);
        $data['unitList'] = $this->Common_model->getPublicUnit($this->dist_id);
        $data['customerList'] = $this->Sales_Model->getCustomerList($this->dist_id);
        $totalSale = $this->Common_model->get_data_list_by_many_columns('generals', $salesCondition);

        $condition = array(
            'dist_id' => $this->dist_id,
            'isActive' => 'Y',
            'isDelete' => 'N',
        );
        $data['employeeList'] = $this->Common_model->get_data_list_by_many_columns('employee', $condition);
        $data['vehicleList'] = $this->Common_model->get_data_list_by_many_columns('vehicle', $condition);

        $data['voucherID'] = "SID" . date("y") . date("m") . str_pad(count($totalSale) + 1, 4, "0", STR_PAD_LEFT);
        $data['mainContent'] = $this->load->view('distributor/sales/saleInvoice/sale_add', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    function cashTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid) {
        // when cash transction start from here
        //58 account receiable head debit

        $singleLedger = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'form_id' => '5',
            'dist_id' => $this->dist_id,
            'account' => '58',
            'debit' => $this->input->post('netTotal'), //sales - discount= grand + vat =newNettotal
            'updated_by' => $this->admin_id,
        );
        $this->db->insert('generalledger', $singleLedger);
        //59  Prompt Given Discounts
        if (!empty($data['discount'])) :
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '59',
                'debit' => $data['discount'],
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //49  Sales head credit
        $singleLedger = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'form_id' => '5',
            'dist_id' => $this->dist_id,
            'account' => '49',
            'credit' => array_sum($this->input->post('price')),
            'updated_by' => $this->admin_id,
        );
        $this->db->insert('generalledger', $singleLedger);
        //60 Sales tax/vat head credit
        if (!empty($data['vatAmount'])):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '60',
                'credit' => $data['vatAmount'],
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //7501 Cost of Goods-Retail head debit
        if (!empty($totalProductCost)):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '62',
                'debit' => $totalProductCost,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //52 account Inventory head credit
        if (!empty($otherProductCost)):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '52',
                'credit' => $otherProductCost,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //cylinder product stock.
        if (!empty($newCylinderProductCost)) {
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '173',
                'credit' => $newCylinderProductCost,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        }

        //loader account head credit
        //transportation account head credit
        //loader and transportation account receiaveable head debit against credit
        $loaderAmount = $this->input->post('loaderAmount');
        $transportationAmount = $this->input->post('transportationAmount');
        if (!empty($loaderAmount)) {
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '391',
                'credit' => $loaderAmount,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        }
        if (!empty($transportationAmount)) {
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '392',
                'credit' => $transportationAmount,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        }


        //customer payment ledger
        $generals_data = array(
            'form_id' => '7',
            'customer_id' => $this->input->post('customer_id'),
            'dist_id' => $this->dist_id,
            'mainInvoiceId' => $generals_id,
            'voucher_no' => $this->input->post('voucherid'),
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'credit' => $this->input->post('netTotal'),
            'narration' => $this->input->post('narration'),
            'updated_by' => $this->admin_id,
            'created_at' => $this->timestamp
        );
        $generalPaymentId = $this->Common_model->insert_data('generals', $generals_data);
        //1301 Cash in Hand  head debit
        $singleLedger = array(
            'generals_id' => $generalPaymentId,
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'form_id' => '5',
            'dist_id' => $this->dist_id,
            'account' => '54',
            'debit' => $this->input->post('netTotal'),
            'updated_by' => $this->admin_id,
        );
        $this->db->insert('generalledger', $singleLedger);
        //58 Account Receivable head credit
        $singleLedger = array(
            'generals_id' => $generalPaymentId,
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'form_id' => '5',
            'dist_id' => $this->dist_id,
            'account' => '58',
            'credit' => $this->input->post('netTotal'),
            'updated_by' => $this->admin_id,
        );
        $this->db->insert('generalledger', $singleLedger);
        //client vendor ledger
        $customerLedger1 = array(
            'ledger_type' => 1,
            'trans_type' => 'Sales Payment',
            'history_id' => $generalPaymentId,
            'trans_type' => $this->input->post('voucherid'),
            'client_vendor_id' => $this->input->post('customer_id'),
            'dist_id' => $this->dist_id,
            'updated_by' => $this->admin_id,
            'amount' => $this->input->post('netTotal'),
            'cr' => $this->input->post('netTotal'),
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate')))
        );
        $this->db->insert('client_vendor_ledger', $customerLedger1);
        //money Receite General
        $moneyReceit = array(
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'invoiceID' => json_encode($this->input->post('voucherid')),
            'totalPayment' => $this->input->post('netTotal'),
            'receitID' => $mrid,
            'mainInvoiceId' => $generals_id,
            'dist_id' => $this->dist_id,
            'customerid' => $this->input->post('customer_id'),
            'narration' => $this->input->post('narration'),
            'updated_by' => $this->admin_id,
            'paymentType' => 1
        );
        $this->db->insert('moneyreceit', $moneyReceit);
    }

    function partialTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid) {
        $this->form_validation->set_rules('partialPayment', 'Partial Payment', 'required');
        $this->form_validation->set_rules('accountCrPartial', 'Account Head', 'required');
        if ($this->form_validation->run() == FALSE) {
            exception("Required field can't be empty.");
            redirect(site_url('salesInvoice_add'));
        }

        $singleLedger = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'form_id' => '5',
            'dist_id' => $this->dist_id,
            'account' => '58',
            'debit' => $this->input->post('netTotal'), //sales - discount= grand + vat =newNettotal
            'updated_by' => $this->admin_id,
        );
        $this->db->insert('generalledger', $singleLedger);
        //59  Prompt Given Discounts
        if (!empty($data['discount'])):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '59',
                'debit' => $data['discount'],
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
//49  Sales head credit
        $singleLedger = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'form_id' => '5',
            'dist_id' => $this->dist_id,
            'account' => '49',
            'credit' => array_sum($this->input->post('price')),
            'updated_by' => $this->admin_id,
        );
        $this->db->insert('generalledger', $singleLedger);
        //60 Sales tax/vat head credit
        if (!empty($data['vatAmount'])):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '60',
                'credit' => $data['vatAmount'],
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //7501 Cost of Goods-Retail head debit
        if (!empty($totalProductCost)):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '62',
                'debit' => $totalProductCost,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //52 account Inventory head credit
        if (!empty($otherProductCost)):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '52',
                'credit' => $otherProductCost,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //cylinder product stock.
        if (!empty($newCylinderProductCost)) {
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '173',
                'credit' => $newCylinderProductCost,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        }


        //loader account head credit
        //transportation account head credit
        //loader and transportation account receiaveable head debit against credit
        $loaderAmount = $this->input->post('loaderAmount');
        $transportationAmount = $this->input->post('transportationAmount');
        if (!empty($loaderAmount)) {
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '391',
                'credit' => $loaderAmount,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        }
        if (!empty($transportationAmount)) {
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '392',
                'credit' => $transportationAmount,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        }



        //cash or partial payment start here.
        $generals_data = array(
            'form_id' => '7',
            'customer_id' => $this->input->post('customer_id'),
            'dist_id' => $this->dist_id,
            'mainInvoiceId' => $generals_id,
            'voucher_no' => $this->input->post('voucherid'),
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'credit' => $this->input->post('partialPayment'),
            'narration' => $this->input->post('narration'),
            'updated_by' => $this->admin_id,
            'created_at' => $this->timestamp
        );
        $generalPaymentId = $this->Common_model->insert_data('generals', $generals_data);
        //1301 Cash in Hand  head debit
        $singleLedger = array(
            'generals_id' => $generalPaymentId,
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'form_id' => '7',
            'dist_id' => $this->dist_id,
            'account' => $this->input->post('accountCrPartial'),
            'debit' => $this->input->post('partialPayment'),
            'updated_by' => $this->admin_id,
        );
        $this->db->insert('generalledger', $singleLedger);
        //58 Account Receivable head credit
        $singleLedger = array(
            'generals_id' => $generalPaymentId,
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'form_id' => '7',
            'dist_id' => $this->dist_id,
            'account' => '58',
            'credit' => $this->input->post('partialPayment'),
            'updated_by' => $this->admin_id,
        );
        $this->db->insert('generalledger', $singleLedger);
        //client vendor ledger
        $customerLedger = array(
            'ledger_type' => 1,
            'trans_type' => 'Sales Payment',
            'history_id' => $generalPaymentId,
            'trans_type' => $this->input->post('voucherid'),
            'client_vendor_id' => $this->input->post('customer_id'),
            'dist_id' => $this->dist_id,
            'amount' => $this->input->post('partialPayment'),
            'cr' => $this->input->post('partialPayment'),
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate')))
        );
        $this->db->insert('client_vendor_ledger', $customerLedger);
        //money Receite General
        $moneyReceit = array(
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'invoiceID' => json_encode($this->input->post('voucherid')),
            'totalPayment' => $this->input->post('partialPayment'),
            'receitID' => $mrid,
            'customerid' => $this->input->post('customer_id'),
            'narration' => $this->input->post('narration'),
            'updated_by' => $this->admin_id,
            'dist_id' => $this->dist_id,
            'paymentType' => 1,
            'mainInvoiceId' => $generalPaymentId
        );
        $this->db->insert('moneyreceit', $moneyReceit);
        //partial payment stop here.
    }

    function chequeTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid) {



        $singleLedger = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'form_id' => '5',
            'dist_id' => $this->dist_id,
            'account' => '58',
            'debit' => $this->input->post('netTotal'), //sales - discount= grand + vat =newNettotal
            'updated_by' => $this->admin_id,
        );
        $this->db->insert('generalledger', $singleLedger);




        //59  Prompt Given Discounts
        if (!empty($data['discount'])):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '59',
                'debit' => $data['discount'],
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //49  Sales head credit
        $singleLedger = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'form_id' => '5',
            'dist_id' => $this->dist_id,
            'account' => '49',
            'credit' => array_sum($this->input->post('price')),
            'updated_by' => $this->admin_id,
        );
        $this->db->insert('generalledger', $singleLedger);
        //60 Sales tax/vat head credit
        if (!empty($data['vatAmount'])):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '60',
                'credit' => $data['vatAmount'],
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //62 Cost of Goods-Retail head debit
        if (!empty($totalProductCost)):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '62',
                'debit' => $totalProductCost,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //52 account Inventory head credit
        if (!empty($otherProductCost)):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '52',
                'credit' => $otherProductCost,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //cylinder product stock.
        if (!empty($newCylinderProductCost)) {
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '173',
                'credit' => $newCylinderProductCost,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        }

        //loader account head credit
        //transportation account head credit
        //loader and transportation account receiaveable head debit against credit
        $loaderAmount = $this->input->post('loaderAmount');
        $transportationAmount = $this->input->post('transportationAmount');
        if (!empty($loaderAmount)) {
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '391',
                'credit' => $loaderAmount,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        }
        if (!empty($transportationAmount)) {
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '392',
                'credit' => $transportationAmount,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        }



        $bankName = $this->input->post('bankName');
        $checkNo = $this->input->post('checkNo');
        $checkDate = $this->input->post('checkDate');
        $branchName = $this->input->post('branchName');
        $moneyReceit = array(
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'invoiceID' => json_encode($this->input->post('voucherid')),
            //'totalPayment' => $this->input->post('netTotal'),
            'totalPayment' => $this->input->post('chaque_amount'),
            'receitID' => $mrid,
            'customerid' => $this->input->post('customer_id'),
            'narration' => $this->input->post('narration'),
            'updated_by' => $this->admin_id,
            'dist_id' => $this->dist_id,
            'mainInvoiceId' => $generals_id,
            'paymentType' => 2,
            'bankName' => isset($bankName) ? $bankName : '0',
            'checkNo' => isset($checkNo) ? $checkNo : '0',
            'checkDate' => isset($checkDate) ? date('Y-m-d', strtotime($checkDate)) : '0',
            'branchName' => isset($branchName) ? $branchName : '0');
        $this->db->insert('moneyreceit', $moneyReceit);
    }

    function creditTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost) {
        //when due transction start from here.
        //58 account receiable head debit

        $singleLedger = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'form_id' => '5',
            'dist_id' => $this->dist_id,
            'account' => '58',
            'debit' => $this->input->post('netTotal'), //sales - discount= grand + vat =newNettotal
            'updated_by' => $this->admin_id,
        );
        $this->db->insert('generalledger', $singleLedger);



        //59  Prompt Given Discounts
        if (!empty($data['discount'])):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '59',
                'debit' => $data['discount'],
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //49  Sales head credit
        $singleLedger = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
            'form_id' => '5',
            'dist_id' => $this->dist_id,
            'account' => '49',
            'credit' => array_sum($this->input->post('price')),
            'updated_by' => $this->admin_id,
        );
        $this->db->insert('generalledger', $singleLedger);
        //60 Sales tax/vat head credit
        if (!empty($data['vatAmount'])):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '60',
                'credit' => $data['vatAmount'],
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //62 Cost of Goods-Retail head debit
        if (!empty($totalProductCost)):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '62',
                'debit' => $totalProductCost,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //52 account Inventory head credit
        if (!empty($otherProductCost)):
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '52',
                'credit' => $otherProductCost,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        endif;
        //cylinder product stock.
        if (!empty($newCylinderProductCost)) {
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '173',
                'credit' => $newCylinderProductCost,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        }
        //loader account head credit
        //transportation account head credit
        //loader and transportation account receiaveable head debit against credit

        $loaderAmount = $this->input->post('loaderAmount');
        $transportationAmount = $this->input->post('transportationAmount');
        if (!empty($loaderAmount)) {
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '391',
                'credit' => $loaderAmount,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        }
        if (!empty($transportationAmount)) {
            $singleLedger = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                'form_id' => '5',
                'dist_id' => $this->dist_id,
                'account' => '392',
                'credit' => $transportationAmount,
                'updated_by' => $this->admin_id,
            );
            $this->db->insert('generalledger', $singleLedger);
        }
    }

    function customerList() {
        $data['title'] = 'Setup || Customer';
        $data['mainContent'] = $this->load->view('distributor/sales/customer/customerList', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    function saveNewCustomer() {
        $data = array();
        $data['customerID'] = $this->input->post('customerID');
        $data['customerName'] = $this->input->post('customerName');
        $data['customerPhone'] = $this->input->post('customerPhone');
        $data['customerEmail'] = $this->input->post('customerEmail');
        $data['customerAddress'] = $this->input->post('customerAddress');
        $data['customerType'] = $this->input->post('customerType');
        $data['dist_id'] = $this->dist_id;
        $data['updated_by'] = $this->admin_id;
        $insertID = $this->Common_model->insert_data('customer', $data);

        $customerType = $this->Common_model->tableRow('customertype', 'type_id', $data['customerType'])->typeTitle;

        if (!empty($insertID)):
            echo '<option value="' . $insertID . '" selected="selected">' . $customerType . ' - ' . $data['customerID'] . ' [ ' . $data['customerName'] . ' ] ' . '</option>';
        endif;
    }

    function addCustomer() {
        if (isPostBack()) {
            //dumpVar($_POST);
            $this->form_validation->set_rules('customerID', 'Product Code', 'required');
            $this->form_validation->set_rules('customerName', 'Product Category', 'required');
            //$this->form_validation->set_rules('customerPhone', 'Product Branch', 'required');
            //$this->form_validation->set_rules('customerAddress', 'Product Name', 'required');
            if ($this->form_validation->run() == FALSE) {
                exception("Required field can't be empty.");
                redirect(site_url('addCustomer'));
            } else {
                $data = array();
                $data['customerID'] = $this->input->post('customerID');
                $data['customerType'] = $this->input->post('customerType');
                $data['customerName'] = $this->input->post('customerName');
                $data['customerPhone'] = $this->input->post('customerPhone');
                $data['customerEmail'] = $this->input->post('customerEmail');
                $data['customerAddress'] = $this->input->post('customerAddress');
                $data['dist_id'] = $this->dist_id;
                $data['updated_by'] = $this->admin_id;
                $insertID = $this->Common_model->insert_data('customer', $data);
                if (!empty($insertID)) {
                    unset($_POST);
                    message("New Customer created successfully.");
                    redirect(site_url('customerList'));
                }
            }
        }
        $data['title'] = 'Setup || Customer';
        $customerID = $this->Sales_Model->getCustomerID($this->dist_id);
        $data['customerType'] = $this->Common_model->get_data_list('customertype');
        $data['customerID'] = $this->Sales_Model->checkDuplicateCusID($customerID, $this->dist_id);
        $data['mainContent'] = $this->load->view('distributor/sales/customer/addCustomer', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    function editCustomer($customerid) {
        if (isPostBack()) {
            $this->form_validation->set_rules('customerID', 'Product Code', 'required');
            $this->form_validation->set_rules('customerName', 'Customer Name', 'required');
            //$this->form_validation->set_rules('customerPhone', 'Product Branch', 'required');
            //$this->form_validation->set_rules('customerAddress', 'Customer Address', 'required');
            if ($this->form_validation->run() == FALSE) {
                exception("Required field can't be empty.");
                redirect(site_url('editCustomer/' . $customerid));
            } else {
                $data = array();
                $data['customerID'] = $this->input->post('customerID');
                $data['customerName'] = $this->input->post('customerName');
                $data['customerType'] = $this->input->post('customerType');
                $data['customerPhone'] = $this->input->post('customerPhone');
                $data['customerEmail'] = $this->input->post('customerEmail');
                $data['customerAddress'] = $this->input->post('customerAddress');
                $data['dist_id'] = $this->dist_id;
                $data['updated_by'] = $this->admin_id;
                $this->Common_model->update_data('customer', $data, 'customer_id', $customerid);
                message("Customer Information update successfully.");
                redirect(site_url('customerList'));
            }
        }
        $data['title'] = 'Customer Update';
        $data['customerType'] = $this->Common_model->get_data_list('customertype');
        $data['customerEdit'] = $this->Common_model->get_single_data_by_single_column('customer', 'customer_id', $customerid);
        $data['mainContent'] = $this->load->view('distributor/sales/customer/editCustomer', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    function deleteReference($deleteId) {
        $saleCondition = array(
            'dist_id' => $this->dist_id,
            'reference' => $deleteId,
        );
        $exits = $this->Common_model->get_data_list_by_many_columns('generals', $saleCondition);
        if (empty($exits)) {
            $condition = array(
                'dist_id' => $this->dist_id,
                'reference_id' => $deleteId
            );
            $this->Common_model->delete_data_with_condition('reference', $condition);
            message("Your data successully deleted from database.");
            redirect(site_url('reference'));
        } else {
            exception("This Reference can't be deleted.already have a transaction by this Reference!");
            redirect(site_url('reference'));
        }
    }

    function reference() {
        $data['referenceList'] = $this->Common_model->get_data_list_by_single_column('reference', 'dist_id', $this->dist_id);
        $data['title'] = 'Reference List';
        $data['mainContent'] = $this->load->view('distributor/sales/reference/reference', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    function referenceAdd() {
        if (isPostBack()) {
            $this->form_validation->set_rules('refCode', 'Product Code', 'required');
            $this->form_validation->set_rules('referenceName', 'Reference Name', 'required');
            //$this->form_validation->set_rules('customerPhone', 'Product Branch', 'required');
            // $this->form_validation->set_rules('customerAddress', 'Product Name', 'required');
            if ($this->form_validation->run() == FALSE) {
                exception("Required field can't be empty.");
                redirect(site_url('referenceAdd'));
            } else {
                $data['refCode'] = $this->input->post('refCode');
                $data['referenceName'] = $this->input->post('referenceName');
                $data['referencePhone'] = $this->input->post('referencePhone');
                $data['referenceEmail'] = $this->input->post('referenceEmail');
                $data['referenceAddress'] = $this->input->post('referenceAddress');
                $data['dist_id'] = $this->dist_id;
                $data['updated_by'] = $this->admin_id;
                $this->Common_model->insert_data('reference', $data);
                message("Your data successfully stored into database.");
                redirect(site_url('reference'));
            }
        }
        $totalReferece = $this->Common_model->get_data_list_by_single_column('reference', 'dist_id', $this->dist_id);
        $data['refCode'] = "RID" . date("y") . date("m") . str_pad(count($totalReferece) + 1, 4, "0", STR_PAD_LEFT);
        $data['title'] = 'Reference Add';
        $data['mainContent'] = $this->load->view('distributor/sales/reference/referenceAdd', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    function editReference($editId) {
        if (isPostBack()) {
            //$this->form_validation->set_rules('refCode', 'Product Code', 'required');
            $this->form_validation->set_rules('referenceName', 'Reference Name', 'required');
            //$this->form_validation->set_rules('customerPhone', 'Product Branch', 'required');
            // $this->form_validation->set_rules('customerAddress', 'Product Name', 'required');
            if ($this->form_validation->run() == FALSE) {
                exception("Required field can't be empty.");
                redirect(site_url('editReference/' . $editId));
            } else {
                $data['refCode'] = $this->input->post('refCode');
                $data['referenceName'] = $this->input->post('referenceName');
                $data['referencePhone'] = $this->input->post('referencePhone');
                $data['referenceEmail'] = $this->input->post('referenceEmail');
                $data['referenceAddress'] = $this->input->post('referenceAddress');
                $data['dist_id'] = $this->dist_id;
                $data['updated_by'] = $this->admin_id;
                $this->Common_model->update_data('reference', $data, 'reference_id', $editId);
                message("Your data successfully update into database.");
                redirect(site_url('reference'));
            }
        }
        $data['referenceList'] = $this->Common_model->get_single_data_by_single_column('reference', 'reference_id', $editId);
        $data['title'] = 'Reference Edit';
        $data['mainContent'] = $this->load->view('distributor/sales/reference/referenceEdit', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    function checkDuplicatePhone() {
        $phone = $this->input->post('phone');
        if (!empty($phone)):
            $condition = array(
                'dist_id' => $this->dist_id,
                'customerPhone' => $phone
            );
            $exits = $this->Common_model->get_single_data_by_many_columns('customer', $condition);
            if (!empty($exits)):
                echo 1;
            else:
                echo 2;
            endif;
        endif;
    }

    function checkDuplicatePhoneForUpdate() {
        $phone = $this->input->post('phone');
        $customer_id = $this->input->post('customer_id');
        $condition = array(
            'dist_id' => $this->dist_id,
            'customerPhone' => $phone,
            'customer_id !=' => $customer_id,
        );
        $exits = $this->Common_model->get_single_data_by_many_columns('customer', $condition);
        if (!empty($exits)):
            echo 1;
        else:
            echo 2;
        endif;
    }

    function supplierUpdate($updateid = null) {
        if (isPostBack()) {
            $data['supID'] = $this->input->post('supplierId');
            $data['supName'] = $this->input->post('supName');
            $data['supEmail'] = $this->input->post('supEmail');
            $data['supPhone'] = $this->input->post('supPhone');
            $data['supAddress'] = $this->input->post('supAddress');
            $data['colorCode'] = $this->input->post('colorCode');
            if (!empty($this->input->post('image')[0])) {
                $data['supLogo'] = $this->input->post('image')[0];
            }
            $data['dist_id'] = $this->dist_id;
            $data['updated_by'] = $this->admin_id;
            $insertID = $this->Common_model->insert_data('supplier', $data);
            if (!empty($insertID)) {
                unset($_POST);
                message(" Supplier updated successfully.");
                redirect(site_url('supplierList'));
            }
        }
        $data['title'] = 'Supplier || Edit';
        $data['supplierEdit'] = $this->Common_model->get_single_data_by_single_column('supplier', 'sup_id', $updateid);
        $data['mainContent'] = $this->load->view('distributor/setup/supplier/supplierEdit', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    function suplierStatusChange() {
        $supid = $this->input->post('supID');
        $data['status'] = $this->input->post('status');
        $this->Common_model->update_data('supplier', $data, 'sup_id', $supid);
        message("Supplier status successfully Change.");
        return 1;
    }

    function deletedata() {
        $table = $this->input->post('table');
        $column = $this->input->post('column');
        $id = $this->input->post('id');
        $this->Common_model->delete_data($table, $column, $id);
        message("Your data successfully deleted from database.");
        echo 1;
    }

    function getCustomerEditInvoiceBalance() {
        $customerId = $this->input->post('customerId');
        $invoiceId = $this->input->post('invoiceId');
        $amount = $this->Sales_Model->getCustomerInvoiceAmount($customerId, $invoiceId);
        if (!empty($amount)) {
            echo $amount;
        }
    }

    function getCustomerCurrentBalance($customerId = null) {
        if (!empty($customerId)):
            $customerId = $customerId;
        else:
            $customerId = $this->input->post('customerId');
        endif;
        $presentBalance = $this->Sales_Model->getCustomerBalance($this->dist_id, $customerId);
        echo $presentBalance;
    }

    public function salesPosAdd() {
        if (isPostBack()) {
            // dumpVar($_POST);
            $this->form_validation->set_rules('netTotal', 'Net Total', 'required');
            $this->form_validation->set_rules('customer_id', 'Customer ID', 'required');
            $this->form_validation->set_rules('voucherid', 'Voucehr ID', 'required');
            $this->form_validation->set_rules('saleDate', 'Sales Date', 'required');
            $this->form_validation->set_rules('paymentType', 'Payment Type', 'required');
            $this->form_validation->set_rules('category_id[]', 'Category ID', 'required');
            $this->form_validation->set_rules('product_id[]', 'Product', 'required');
            $this->form_validation->set_rules('unit_id[]', 'Product Unit', 'required');
            $this->form_validation->set_rules('quantity[]', 'Product Quantity', 'required');
            $this->form_validation->set_rules('rate[]', 'Product Rate', 'required');
            $this->form_validation->set_rules('price[]', 'Product Price', 'required');
            $allData = $this->input->post();
//            echo '<pre>';
//             //print_r($_POST);
//             print_r( validation_errors());
//             exit;
            if ($this->form_validation->run() == FALSE) {
                exception("Required field can't be empty.");
                redirect(site_url('salesPos'));
            } else {
                $customerId = $this->input->post('customer_id');
                $productId = $this->input->post('product_id');
                $pmtype = $this->input->post('paymentType');
                $ppAmount = $this->input->post('partialPayment');
                $this->db->trans_start();
                $payType = $this->input->post('paymentType');
                // echo $payType;die;
                $data['customer_id'] = $this->input->post('customer_id');
                $data['voucher_no'] = $this->input->post('voucherid');
                $data['reference'] = $this->input->post('reference');
                $data['payType'] = $this->input->post('paymentType');
                $data['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                $data['discount'] = $this->input->post('discount');
                $data['vat'] = $this->input->post('vat');
                $data['narration'] = $this->input->post('narration');
                $data['shipAddress'] = $this->input->post('shippingAddress');
                $data['mainInvoiceId'] = $this->input->post('userInvoiceId');
                $data['form_id'] = 31;
                $data['debit'] = $this->input->post('netTotal');
                $data['dist_id'] = $this->dist_id;
                $data['updated_by'] = $this->admin_id;
                $grandtotal = $this->input->post('grandtotal');
                $data['vatAmount'] = ($grandtotal / 100) * $data['vat'];
                $generals_id = $this->Common_model->insert_data('generals', $data);
                $returnQty = array_sum($this->input->post('returnQuantity'));
                //cylinder calculation start here....
                if (!empty($returnQty)) {
                    $cylinder['customer_id'] = $this->input->post('customer_id');
                    $cylinder['voucher_no'] = $this->input->post('voucherid');
                    $cylinder['reference'] = $this->input->post('reference');
                    $cylinder['payType'] = $this->input->post('paymentType');
                    $cylinder['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                    $cylinder['discount'] = $this->input->post('discount');
                    $cylinder['vat'] = $this->input->post('vat');
                    $cylinder['narration'] = $this->input->post('narration');
                    $cylinder['shipAddress'] = $this->input->post('shippingAddress');
                    $cylinder['form_id'] = 23;
                    $cylinder['debit'] = $this->input->post('netTotal');
                    $cylinder['dist_id'] = $this->dist_id;
                    $cylinder['mainInvoiceId'] = $generals_id;
                    $cylinder['updated_by'] = $this->admin_id;
                    $cylinder['vatAmount'] = ($grandtotal / 100) * $data['vat'];
                    $cylinderId = $this->Common_model->insert_data('generals', $cylinder);
                }
                $customerName = $this->Common_model->tableRow('customer', 'customer_id', $data['customer_id'])->customerName;
                $mobile = $this->Common_model->tableRow('customer', 'customer_id', $data['customer_id'])->customerPhone;
                $category_cat = $this->input->post('category_id');
                $allStock = array();
                $allStock1 = array();
                $totalProductCost = 0;
                $newCylinderProductCost = 0;
                $otherProductCost = 0;
                foreach ($category_cat as $key => $value):
                    unset($stock);
                    $productCost = $this->Sales_Model->productCost($this->input->post('product_id')[$key], $this->dist_id);
                    $totalProductCost += $this->input->post('quantity')[$key] * $productCost;
                    if ($value == 1) {
                        //get cylinder product cost
                        $newCylinderProductCost += $this->input->post('quantity')[$key] * $productCost;
                    } else {
                        //get without cylinder product cost
                        $otherProductCost += $this->input->post('quantity')[$key] * $productCost;
                    }
                    $stock['generals_id'] = $generals_id;
                    $stock['category_id'] = $value;
                    $stock['product_id'] = $this->input->post('product_id')[$key];
                    $stock['unit'] = getProductUnit($this->input->post('product_id')[$key]);
                    $stock['quantity'] = $this->input->post('quantity')[$key];
                    $stock['rate'] = $this->input->post('rate')[$key];
                    $stock['price'] = $this->input->post('price')[$key];
                    $stock['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                    $stock['form_id'] = 31;
                    $stock['type'] = 'Out';
                    $stock['dist_id'] = $this->dist_id;
                    $stock['updated_by'] = $this->admin_id;
                    $stock['created_at'] = $this->timestamp;
                    $allStock[] = $stock;
                    $returnQty = $this->input->post('returnQuantity')[$key];
                    //If cylinder stock out than transaction store here.
                    if (!empty($returnQty)) {
                        // $productCost = $this->Sales_Model->productCost($this->input->post('product_id')[$key], $this->dist_id);
                        $stock1['generals_id'] = $cylinderId;
                        $stock1['category_id'] = $value;
                        $stock1['product_id'] = $this->input->post('product_id')[$key];
                        $stock1['unit'] = getProductUnit($this->input->post('product_id')[$key]);
                        $stock1['quantity'] = $this->input->post('returnQuantity')[$key];
                        $stock1['rate'] = $this->input->post('rate')[$key];
                        $stock1['price'] = $this->input->post('price')[$key];
                        $stock1['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                        $stock1['form_id'] = 23;
                        $stock1['type'] = 'Cout';
                        $stock1['dist_id'] = $this->dist_id;
                        $stock1['customerId'] = $this->input->post('customer_id');
                        $stock1['updated_by'] = $this->admin_id;
                        $stock1['created_at'] = $this->timestamp;
                        $allStock1[] = $stock1;
                    }
                endforeach;
                $cylinderRecive = $this->input->post('category_id2');
                $cylinderAllStock = array();
                if (!empty($cylinderRecive)):
                    $cylinderData['customer_id'] = $this->input->post('customer_id');
                    $cylinderData['voucher_no'] = $this->input->post('voucherid');
                    $cylinderData['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                    $cylinderData['narration'] = $this->input->post('narration');
                    $cylinderData['form_id'] = 24;
                    $cylinderData['dist_id'] = $this->dist_id;
                    $cylinderData['mainInvoiceId'] = $generals_id;
                    $cylinderData['updated_by'] = $this->admin_id;
                    $CylinderReceive = $this->Common_model->insert_data('generals', $cylinderData);
                    foreach ($cylinderRecive as $key => $value) :
                        //$stock1['generals_id'] = $cylinderId;
                        $stockReceive['generals_id'] = $CylinderReceive;
                        $stockReceive['category_id'] = $value;
                        $stockReceive['product_id'] = $this->input->post('product_id2')[$key];
                        $stockReceive['unit'] = getProductUnit($this->input->post('product_id2')[$key]);
                        $stockReceive['quantity'] = $this->input->post('quantity2')[$key];
                        $stockReceive['date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                        $stockReceive['form_id'] = 24;
                        $stockReceive['type'] = 'Cin';
                        $stockReceive['dist_id'] = $this->dist_id;
                        $stockReceive['customerId'] = $this->input->post('customer_id');
                        $stockReceive['updated_by'] = $this->admin_id;
                        $stockReceive['created_at'] = $this->timestamp;
                        $cylinderAllStock[] = $stockReceive;
                    endforeach;
                    //insert for culinder receive
                    $this->db->insert_batch('stock', $cylinderAllStock);
                endif;
                //insert for quantity out stock
                $this->db->insert_batch('stock', $allStock);
                //insert for cylinder stock out
                $this->db->insert_batch('stock', $allStock1);
                //insert in stock table
                $customerLedger = array(
                    'ledger_type' => 1,
                    'trans_type' => 'Sales',
                    'history_id' => $generals_id,
                    'trans_type' => $this->input->post('voucherid'),
                    'client_vendor_id' => $this->input->post('customer_id'),
                    'updated_by' => $this->admin_id,
                    'dist_id' => $this->dist_id,
                    'amount' => $this->input->post('netTotal'),
                    'dr' => $this->input->post('netTotal'),
                    'date' => date('Y-m-d', strtotime($this->input->post('saleDate'))),
                );
                $this->db->insert('client_vendor_ledger', $customerLedger);
                $mrCondition = array(
                    'dist_id' => $this->dist_id,
                    'receiveType' => 1,
                );
                $totalMoneyReceite = $this->Common_model->get_data_list_by_many_columns('moneyreceit', $mrCondition);
                $mrid = "CMR" . date("y") . date("m") . str_pad(count($totalMoneyReceite) + 1, 4, "0", STR_PAD_LEFT);
                if ($payType == 1) {
                    //when payment type cash
                    $this->cashTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid);
                } elseif ($payType == 2) {
                    //when payment type credit
                    $this->creditTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid);
                } elseif ($payType == 3) {
                    //when payment type cheque.
                    $this->chequeTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid);
                } elseif ($payType == 4) {
                    //when partial paymet start from here.
                    $this->partialTransactionInsert($generals_id, $data, $totalProductCost, $otherProductCost, $newCylinderProductCost, $mrid);
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    notification("Your sales can't be inserted.Something is wrong.");
                    if (!empty($confirmId)) {
                        redirect('salesImportConfirm/' . $confirmId, 'refresh');
                    } else {
                        redirect('salesInvoice_add/', 'refresh');
                    }
                } else {
                    message("Your data successfully inserted into database.");
                    if (!empty($confirmId)) {
                        $updateStata['ConfirmStatus'] = 1;
                        $this->Common_model->update_data('purchase_demo', $updateStata, 'purchase_demo_id', $confirmId);
                        redirect('salesImport', 'refresh');
                    } else {
                        redirect('salesInvoice_view/' . $generals_id, 'refresh');
                    }
                }
            }
        }
        $salesCondition = array(
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
        $data['configInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['title'] = 'Sale POS';
        $data['accountHeadList'] = $this->Common_model->getAccountHead();
        // dumpVar($data['accountHeadList']);
        $data['productList'] = $this->Common_model->getPublicProduct($this->dist_id, 2);
        $data['productCat'] = $this->Common_model->getPublicProductCat($this->dist_id);
        $data['unitList'] = $this->Common_model->getPublicUnit($this->dist_id);
        $data['customerList'] = $this->Common_model->get_data_list_by_many_columns('customer', $cusCondition);
        $totalSale = $this->Common_model->get_data_list_by_many_columns('generals', $salesCondition);
        $data['voucherID'] = "SID" . date("y") . date("m") . str_pad(count($totalSale) + 1, 4, "0", STR_PAD_LEFT);
        $data['pageName'] = 'salePosAdd';
        $data['mainContent'] = $this->load->view('distributor/sales/salesPos/salePosAdd', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function salesPosList() {
        $data['title'] = 'Sale || Invoice';
        $data['saleslist'] = $this->Sales_Model->getSalesPosVoucherList();
        $data['mainContent'] = $this->load->view('distributor/sales/salesPos/salePosList', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function get_product_list_by_dist_id() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            if (isset($_GET['receiveStatus'])) {
                $status = strtolower($_GET['receiveStatus']);
            } else {
                $status = 0;
            }
            echo json_encode($this->Common_model->get_product_list_by_dist_id($this->dist_id, $q, $status));
        }
    }

}