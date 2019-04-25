<?php
/**
 * Created by PhpStorm.
 * User: Nahid
 * Date: 4/6/2019
 * Time: 10:53 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class SalesController extends CI_Controller
{

    private $timestamp;
    private $admin_id;
    public $dist_id;

    public function __construct()
    {
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
    public function salesInvoice_add($confirmId = null) {
        if (isPostBack()) {
            // dumpVar($_POST);
            $this->form_validation->set_rules('netTotal', 'Net Total', 'required');
            $this->form_validation->set_rules('customer_id', 'Customer ID', 'required');
            $this->form_validation->set_rules('voucherid', 'Voucehr ID', 'required');
            $this->form_validation->set_rules('saleDate', 'Sales Date', 'required');
            $this->form_validation->set_rules('paymentType', 'Payment Type', 'required');
            //$this->form_validation->set_rules('category_id[]', 'Category ID', 'required');
            //$this->form_validation->set_rules('product_id[]', 'Product', 'required');
            //$this->form_validation->set_rules('quantity[]', 'Product Quantity', 'required');
            //$this->form_validation->set_rules('rate[]', 'Product Rate', 'required');
            $this->form_validation->set_rules('price[]', 'Product Price', 'required');
            //echo '<pre>';
            //print_r($_POST);
            //exit;
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



                $sales_inv['invoice_no'] = $this->input->post('voucherid');
                $sales_inv['customer_invoice_no'] = $this->input->post('userInvoiceId');
                $sales_inv['customer_id'] = $this->input->post('customer_id');
                $sales_inv['payment_type'] = $payType;
                $sales_inv['invoice_amount'] = array_sum($this->input->post('price'));
                $sales_inv['vat_amount'] = 0;
                $sales_inv['discount_amount'] = $this->input->post('discount')!=''?$this->input->post('discount'):0;
                $sales_inv['paid_amount'] = $this->input->post('thisAllotment')!=''?$this->input->post('thisAllotment'):0;

                $sales_inv['tran_vehicle_id'] = $this->input->post('transportation')!=''?$this->input->post('transportation'):0;
                $sales_inv['transport_charge'] = $this->input->post('transportationAmount')!=''?$this->input->post('transportationAmount'):0;
                $sales_inv['loader_charge'] = $this->input->post('loaderAmount')!=''?$this->input->post('loaderAmount'):0;
                $sales_inv['loader_emp_id'] = $this->input->post('loader')!=''?$this->input->post('loader'):0;
                $sales_inv['refference_person_id'] = $this->input->post('reference');
                $sales_inv['company_id'] = $this->dist_id;
                $sales_inv['dist_id'] = $this->dist_id;
                $sales_inv['branch_id'] = 0;
                $sales_inv['due_date'] = date('Y-m-d', strtotime($this->input->post('dueDate')));
                $sales_inv['invoice_date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                $sales_inv['insert_date'] = $this->timestamp;
                $sales_inv['insert_by'] = $this->admin_id;
                $sales_inv['is_active'] = 'Y';
                $sales_inv['is_delete'] = 'N';

                $this->invoice_id = $this->Common_model->insert_data('sales_invoice_info', $sales_inv);




                $allStock = array();
                //echo "<pre>";
                //print_r($_POST);//exit;
                foreach ($_POST['slNo'] as $key => $value){
                    $returnable_quantity=$_POST['returnQuantity'][$value] !=''?$_POST['returnQuantity'][$value] :0;
                    $return_quentity=empty($_POST['returnQuentity_'.$value])?0:array_sum($_POST['returnQuentity_'.$value]);
                    $supplier_advance=0;
                    $supplier_due=0;
                    unset($stock);
                    $stock['sales_invoice_id'] = $this->invoice_id;

                    $stock['product_id'] = $_POST['product_id_'.$value];
                    $stock['is_package '] = $_POST['is_package_'.$value];
                    $stock['returnable_quantity '] = $returnable_quantity;
                    $stock['return_quentity '] = $return_quentity;
                    if($return_quentity<$returnable_quantity){
                        $supplier_advance=$returnable_quantity-$return_quentity;
                    }else{
                        $supplier_due=$return_quentity-$returnable_quantity;
                    }
                    $stock['customer_due'] = $supplier_due;
                    $stock['customer_advance'] = $supplier_advance;
                    $stock['quantity'] = $_POST['quantity_'.$value];
                    $stock['unit_price'] = $_POST['rate_'.$value];

                    $stock['insert_by'] = $this->admin_id;
                    $stock['insert_date'] = $this->timestamp;
                    log_message('error','Insert in stock table'.print_r($stock,true));
                    //$allStock[] = $stock;
                    //$purchase_details_id=1;
                    $sales_details_id=$this->Common_model->insert_data('sales_details', $stock);
                    //Cost of Goods Product 62
                    $totalProductCost += ($_POST['quantity_'.$value]*$_POST['rate_'.$value]);
                    if ($_POST['product_id_'.$value] == 1 || $_POST['product_id_'.$value]==2) {
                        //get cylinder product cost
                        
                        $newCylinderProductCost=$newCylinderProductCost+($_POST['quantity_'.$value]*$_POST['rate_'.$value]);
                       // $newCylinderProductCost += $this->input->post('quantity')[$key] * $productCost;
                    } else {
                        //get without cylinder product cost
                        
                        $otherProductCost += ($_POST['quantity_'.$value]*$_POST['rate_'.$value]);
                    }




                    if(isset($_POST['returnproduct_'.$value])){
                        foreach ($_POST['returnproduct_'.$value] as $key1 => $value1){
                            unset($stock2);
                            $stock2['sales_details_id'] = $sales_details_id;
                            $stock2['product_id'] = $value1;
                            $stock2['returnable_quantity'] = $_POST['returnQuentity_'.$value][$key1];
                            $stock2['return_quantity'] = $_POST['returnQuentity_'.$value][$key1];
                            $stock2['insert_by'] = $this->admin_id;
                            $stock2['insert_date'] = $this->timestamp;
                            $allStock[] = $stock2;
                        }
                    }
                }
                //echo '<pre>';
                //print_r($stock);
                //exit;



                $this->db->insert_batch('sales_return_details', $allStock);

                log_message('error','Insert in stock details table'.print_r($allStock,true));































               /* foreach ($category_cat as $key => $value):
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


                */
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
        //echo '<pre>';
        //echo $this->db->last_query();
        //print_r($data['productList']);exit;



        $data['cylinderProduct'] = $this->Common_model->getPublicProduct($this->dist_id, 1);
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



    public function salesInvoice_view($salesID) {
        /*if (is_numeric($salesID)) {
            //is invoice id is valid
            $validInvoiecId = $this->Sales_Model->checkInvoiceIdAndDistributor($this->dist_id, $salesID);
            if ($validInvoiecId === FALSE) {
                exception("Sorry invoice id is invalid!!");
                redirect(site_url('salesInvoice'));
            }
        } else {
            exception("Sorry invoice id is invalid!!");
            redirect(site_url('salesInvoice'));
        }*/
        $data['title'] = 'Sale || View';
        //$data['saleslist'] = $this->Common_model->get_single_data_by_single_column('generals', 'generals_id', $salesID);
        $data['saleslist'] = $this->Common_model->get_single_data_by_single_column('sales_invoice_info', 'sales_invoice_id', $salesID);

        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['invoicePayment'] = $this->Sales_Model->getInvoicePayment($this->dist_id, $salesID);
        $data['customerInfo'] = $this->Common_model->get_single_data_by_single_column('customer', 'customer_id', $data['saleslist']->customer_id);
        $stockList = $this->Common_model->get_sales_product_detaild2($salesID);


        foreach ($stockList  as $ind => $element) {
            $result[$element->sales_invoice_id][$element->sales_details_id]['sales_invoice_id'] = $element->sales_invoice_id;
            $result[$element->sales_invoice_id][$element->sales_details_id]['sales_details_id'] = $element->sales_details_id;
            $result[$element->sales_invoice_id][$element->sales_details_id]['is_package'] = $element->is_package;
            $result[$element->sales_invoice_id][$element->sales_details_id]['product_id'] = $element->product_id;
            $result[$element->sales_invoice_id][$element->sales_details_id]['productName'] = $element->productName;
            $result[$element->sales_invoice_id][$element->sales_details_id]['product_code'] = $element->product_code;
            $result[$element->sales_invoice_id][$element->sales_details_id]['title'] = $element->title;
            $result[$element->sales_invoice_id][$element->sales_details_id]['unitTtile'] = $element->unitTtile;
            $result[$element->sales_invoice_id][$element->sales_details_id]['brandName'] = $element->brandName;
            $result[$element->sales_invoice_id][$element->sales_details_id]['quantity'] = $element->quantity;
            $result[$element->sales_invoice_id][$element->sales_details_id]['unit_price'] = $element->unit_price;
            //$result[$element->sales_invoice_id][$element->sales_details_id]['unit_price'] = $element->unit_price;
            if($element->returnable_quantity >0 ){
                $result[$element->sales_invoice_id][$element->sales_details_id]['return'][$element->sales_details_id][] = array('return_product_name'=>$element->return_product_name,
                    'return_product_id'=>$element->return_product_id,
                    'return_product_cat'=>$element->return_product_cat,
                    'return_product_name'=>$element->return_product_name,
                    'return_product_unit'=>$element->return_product_unit,
                    'return_product_brand'=>$element->return_product_brand,
                    'returnable_quantity'=>$element->returnable_quantity,
                );
            }else{
                $result[$element->sales_invoice_id][$element->sales_details_id]['return'][$element->sales_details_id]='';
            }

        }

        $data['stockList']=$result;


       /* echo  $this->db->last_query();
        echo "<pre>";
        print_r($data['stockList']);
        print_r($result);
        print_r($stockList);

        print_r(count($result[12][18]['return'][18]));
        var_dump(empty($result[12][18]['return']));
        exit;*/
        $data['mainContent'] = $this->load->view('distributor/sales/saleInvoice/sales_view', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function  cylinder_sales_report(){


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


            $stockList = $this->Common_model->cylinder_sales_report($customerId,$start_date,$end_date);
            //echo'<pre>';
            //echo $this->db->last_query();
            //print_r($stockList);exit;


            foreach ($stockList  as $ind => $element) {
                $customer= $element->customerName .' ['.$element->customerID.']';
                $result[$element->sales_invoice_id]['invoice_no']=$element->invoice_no ;
                $result[$element->sales_invoice_id]['invoice_date']=$element->invoice_date ;
                $result[$element->sales_invoice_id]['customer']=$customer ;
                $result[$element->sales_invoice_id]['customer_id']=$customer ;
                $result[$element->sales_invoice_id]['payment_type']=$element->payment_type ;
                $result[$element->sales_invoice_id]['sales_producr'][$element->sales_details_id]['sales_invoice_id'] = $element->sales_invoice_id;
                $result[$element->sales_invoice_id]['sales_producr'][$element->sales_details_id]['sales_details_id'] = $element->sales_details_id;
                $result[$element->sales_invoice_id]['sales_producr'][$element->sales_details_id]['is_package'] = $element->is_package;
                $result[$element->sales_invoice_id]['sales_producr'][$element->sales_details_id]['product_id'] = $element->product_id;
                $result[$element->sales_invoice_id]['sales_producr'][$element->sales_details_id]['productName'] = $element->productName;
                $result[$element->sales_invoice_id]['sales_producr'][$element->sales_details_id]['product_code'] = $element->product_code;
                $result[$element->sales_invoice_id]['sales_producr'][$element->sales_details_id]['title'] = $element->title;
                $result[$element->sales_invoice_id]['sales_producr'][$element->sales_details_id]['unitTtile'] = $element->unitTtile;
                $result[$element->sales_invoice_id]['sales_producr'][$element->sales_details_id]['brandName'] = $element->brandName;
                $result[$element->sales_invoice_id]['sales_producr'][$element->sales_details_id]['quantity'] = $element->quantity;
                $result[$element->sales_invoice_id]['sales_producr'][$element->sales_details_id]['unit_price'] = $element->unit_price;
                //$result[$element->sales_invoice_id][$element->sales_details_id]['unit_price'] = $element->unit_price;
                if($element->returnable_quantity >0 ){
                    $result[$element->sales_invoice_id]['sales_producr'][$element->sales_details_id]['return'][$element->sales_details_id][] = array('return_product_name'=>$element->return_product_name,
                        'return_product_id'=>$element->return_product_id,
                        'return_product_cat'=>$element->return_product_cat,
                        'return_product_name'=>$element->return_product_name,
                        'return_product_unit'=>$element->return_product_unit,
                        'return_product_brand'=>$element->return_product_brand,
                        'returnable_quantity'=>$element->returnable_quantity,
                        'return_quantity'=>$element->return_quantity,
                    );
                }else{
                    $result[$element->sales_invoice_id]['sales_producr'][$element->sales_details_id]['return'][$element->sales_details_id][]=array('return_product_name'=>'',
                        'return_product_id'=>'',
                        'return_product_cat'=>'',
                        'return_product_name'=>'',
                        'return_product_unit'=>'',
                        'return_product_brand'=>'',
                        'returnable_quantity'=>'',
                        'return_quantity'=>'',
                    );
                }

            }



            $data['salesList'] = $result;
        }

        $data['customerType'] = $this->Common_model->get_data_list('customertype');
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['pageTitle'] = 'Customer Wise Sales Report';
        $data['customerList'] = $this->Common_model->get_data_list_by_single_column('customer', 'dist_id', $this->dist_id);
        $data['title'] = 'Cylinder Sales Report';
        $data['mainContent'] = $this->load->view('distributor/sales/report/cylinder_sales_report', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }
    public function  sales_report_brand_wise(){


        if (isPostBack()) {
            $brandId = $this->input->post('brandId');
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
            $data['allStock'] = $this->Inventory_Model->sales_report_brand_wise($start_date, $end_date,  $brandId);
            //echo $this->db->last_query();
            //echo '<pre>';
            //print_r($data['allStock']);
            //exit;


            $product=array();
            foreach ($data['allStock']  as $ind => $element) {
                if($element->p_name!='' ){
                    array_push($product,$element->p_name);
                }
                $result[$element->brandId]['brand_name']=$element->brandName;
                $result[$element->brandId][$element->p_name.'_package']=$element->sales_package_qty;
                $result[$element->brandId][$element->p_name.'_empty']=$element->sales_empty_qty;
                $result[$element->brandId][$element->p_name.'_refial']=$element->sales_refill_qty;
            }
            $product=array_unique($product);
            $data['product']=$product;
            $data['sales_list']=$result;
            //echo '<pre>';

            //$product=sort($product);
            //print_r($result);
            //print_r($data['product']);
            //exit;


        }
        $data['brandList'] = $this->Common_model->getPublicBrand($this->dist_id);
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['pageTitle'] = 'Customer Wise Sales Report';
        $data['title'] = 'Sales Rreport Brand Wise';
        $data['mainContent'] = $this->load->view('distributor/sales/report/sales_report_brand_wise', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function  daily_sales_statement($start_date='', $end_date=''){
        $start_date=$_GET['start_date'];
        $end_date=$_GET['end_date'];
        if($start_date!='' && $end_date!=''){
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
            $data['daily_sales_statement'] = $this->Sales_Model->daily_sales_statement($start_date, $end_date,  $this->dist_id);
            //echo  $this->db->last_query();
        }

        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['pageTitle'] = 'Customer Wise Sales Report';
        $data['title'] = 'Sales Rreport Brand Wise';
        $data['mainContent'] = $this->load->view('distributor/sales/report/daily_sales_statement', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }
    public function  date_wise_product_sales($start_date='', $end_date=''){
        $start_date=$_GET['start_date'];
        $end_date=$_GET['end_date'];
        if($start_date!='' && $end_date!=''){
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
            $data['daily_sales_statement'] = $this->Sales_Model->date_wise_product_sales($start_date, $end_date,  $this->dist_id);
            echo $this->db->last_query();
            echo '<pre>';
            print_r($data['daily_sales_statement']);
            exit;

        }

        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['pageTitle'] = 'Customer Wise Sales Report';
        $data['title'] = 'Sales Rreport Brand Wise';
        $data['mainContent'] = $this->load->view('distributor/sales/report/date_wise_product_sales', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }
    public function  date_wise_product_sales_by_date($start_date='', $end_date=''){
        $start_date=$_GET['start_date'];
        $end_date=$_GET['end_date'];
        if($start_date!='' && $end_date!=''){
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
            $data['daily_sales_statement'] = $this->Sales_Model->date_wise_product_sales_by_date($start_date, $end_date,  $this->dist_id);
            echo $this->db->last_query();
            echo '<pre>';
            print_r($data['daily_sales_statement']);
            exit;

        }

        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['pageTitle'] = 'Customer Wise Sales Report';
        $data['title'] = 'Sales Rreport Brand Wise';
        $data['mainContent'] = $this->load->view('distributor/sales/report/date_wise_product_sales_by_date', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }
 public function  customer_due($start_date='', $end_date=''){
        $start_date=isset($_GET['start_date'])?$_GET['start_date']:'';
        $customer_id=isset($_GET['start_date'])?$_GET['customer_id']:'All';
        $end_date=isset($_GET['end_date'])?$_GET['end_date']:'';
        if($start_date!='' && $end_date!=''){
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));
            $data['customer_due'] = $this->Sales_Model->customer_due($customer_id,$start_date, $end_date,  $this->dist_id);
            echo $this->db->last_query();
            echo '<pre>';
            print_r($data['customer_due']);
            exit;

        }
        $customerList=array();
        $data['companyInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $cus_list = $this->Sales_Model->customer_list($this->dist_id);




     $cus_items_array[] = array(
         'label' => "All",
         'value' => 'All'
     );
         foreach ($cus_list as $key => $value) {
             $cus_items_array[] = array(
                 'label' => $value->customerName,
                 'value' => $value->customer_id,
                 'have_invoice' => $value->customer_id,
             );
         };
     $data['pageName'] = 'salePosAdd';
       $data['customer_info'] = json_encode($cus_items_array);
         //echo '<pre>';
         //print_r($page_data['customer_info']);exit;
        $data['pageTitle'] = 'Customer Wise Sales Report';
        $data['title'] = 'Sales Rreport Brand Wise';
        $data['mainContent'] = $this->load->view('distributor/sales/report/customer_due', $data, true);
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
            //$this->form_validation->set_rules('product_id[]', 'Product', 'required');
            //$this->form_validation->set_rules('quantity[]', 'Product Quantity', 'required');
            //$this->form_validation->set_rules('rate[]', 'Product Rate', 'required');
            //$this->form_validation->set_rules('price[]', 'Product Price', 'required');
            $allData = $this->input->post();
            if ($this->form_validation->run() == FALSE) {
                exception("Required field can't be empty.");
                redirect(site_url('salesInvoice_add'));
            } else {
                $payType = $this->input->post('paymentType');
                $sales_inv['invoice_no'] = $this->input->post('voucherid');
                $sales_inv['sales_invoice_id'] = $this->input->post('sales_invoice_id');
                $sales_inv['customer_invoice_no'] = $this->input->post('userInvoiceId');
                $sales_inv['customer_id'] = $this->input->post('customer_id');
                $sales_inv['payment_type'] = $payType;
                $sales_inv['invoice_amount'] = array_sum($this->input->post('price'));
                $sales_inv['vat_amount'] = $this->input->post('vat');
                $sales_inv['discount_amount'] = $this->input->post('discount')!=''?$this->input->post('discount'):0;
                $sales_inv['paid_amount'] = $this->input->post('partialPayment')!=''?$this->input->post('partialPayment'):0;
                $sales_inv['tran_vehicle_id'] = $this->input->post('transportation')!=''?$this->input->post('transportation'):0;
                $sales_inv['transport_charge'] = $this->input->post('transportationAmount')!=''?$this->input->post('transportationAmount'):0;
                $sales_inv['loader_charge'] = $this->input->post('loaderAmount')!=''?$this->input->post('loaderAmount'):0;
                $sales_inv['loader_emp_id'] = $this->input->post('loader')!=''?$this->input->post('loader'):0;
                $sales_inv['refference_person_id'] = $this->input->post('reference');
                $sales_inv['company_id'] = $this->dist_id;
                $sales_inv['dist_id'] = $this->dist_id;
                $sales_inv['branch_id'] = 0;
                $sales_inv['due_date'] = date('Y-m-d', strtotime($this->input->post('dueDate')));
                $sales_inv['invoice_date'] = date('Y-m-d', strtotime($this->input->post('saleDate')));
                $sales_inv['insert_date'] = $this->timestamp;
                $sales_inv['insert_by'] = $this->admin_id;
                $sales_inv['is_active'] = 'Y';
                $sales_inv['is_delete'] = 'N';








                $this->invoice_id = $this->input->post('sales_invoice_id');
                $this->Common_model->update_data('sales_invoice_info', $sales_inv, 'sales_invoice_id', $this->invoice_id);
                $allStock = array();
                $stockUpdate = array();

                foreach ($_POST['sales_details_id'] as $key => $value){
                    $returnable_quantity=$_POST['returnAbleQuantity_'.$value] !=''?$_POST['returnAbleQuantity_'.$value] :0;
                    $return_quentity=empty($_POST['returnQuentity_'.$value])?0:array_sum($_POST['returnQuentity_'.$value]);
                    $supplier_advance=0;
                    $supplier_due=0;
                    unset($stock);
                    $stock['sales_invoice_id'] = $this->invoice_id;
                    $stock['sales_details_id'] =$value;
                    $stock['product_id'] = $_POST['product_id_'.$value];
                    $stock['is_package '] = $_POST['is_package_'.$value];
                    $stock['returnable_quantity '] = $returnable_quantity;
                    $stock['return_quentity '] = $return_quentity;
                    if($return_quentity<$returnable_quantity){
                        $supplier_advance=$returnable_quantity-$return_quentity;
                    }else{
                        $supplier_due=$return_quentity-$returnable_quantity;
                    }
                    $stock['customer_due'] = $supplier_due;
                    $stock['customer_advance'] = $supplier_advance;
                    $stock['quantity'] = $_POST['quantity_'.$value];
                    $stock['unit_price'] = $_POST['unit_price_'.$value];
                    $stock['update_by'] = $this->admin_id;
                    $stock['update_date'] = $this->timestamp;
                    $stock['is_active'] = 'Y';
                    $stock['is_delete'] = 'N';
                    $stockUpdate[]=$stock;

                    if(isset($_POST['returnproductEdit_'.$value])){
                        foreach ($_POST['returnproductEdit_'.$value] as $key1 => $value1){
                            unset($stock2);
                            $stock2['sales_details_id'] = $value1;
                            //$stock2['product_id'] = $value1;
                            $stock2['returnable_quantity'] = $_POST['returnQuentityEdit_'.$value][$key1];
                            $stock2['return_quantity'] = $_POST['returnQuentityEdit_'.$value][$key1];
                            $stock2['update_by'] = $this->admin_id;
                            $stock2['update_date'] = $this->timestamp;
                            $allEditStock[] = $stock2;
                        }
                    }
                    if(isset($_POST['returnproductAdd_'.$value])){
                        foreach ($_POST['returnproductAdd_'.$value] as $key1 => $value1){
                            unset($stock2);
                            $stock2['sales_details_id'] = $value;
                            $stock2['product_id'] = $value1;
                            $stock2['returnable_quantity'] = $_POST['returnQuentityAdd_'.$value][$key1];
                            $stock2['return_quantity'] = $_POST['returnQuentityAdd_'.$value][$key1];
                            $stock2['update_by'] = $this->admin_id;
                            $stock2['update_date'] = $this->timestamp;
                            $alladdStock[] = $stock2;
                        }
                    }
                }


                echo  '<pre>';
                print_r($_POST);
                print_r($stockUpdate);
                print_r($allEditStock);
                print_r($alladdStock);
                exit;

















                $productId = $this->input->post('product_id');
                $pmtype = $this->input->post('paymentType');
                $ppAmount = $this->input->post('partialPayment');
                $this->db->trans_start();

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
        $data['editInvoice'] = $this->Common_model->get_single_data_by_single_column('sales_invoice_info', 'sales_invoice_id', $invoiceId);

        $data['bank_check_details'] = array();
        if ($data['editInvoice']->payment_type == 3) {
            $data['bank_check_details'] = $this->Common_model->get_single_data_by_single_column('moneyreceit', 'mainInvoiceId', $data['editInvoice']->sales_invoice_id);
        }


        //$data['editStock'] = $this->Common_model->get_data_list_by_single_column('stock', 'generals_id', $invoiceId);

        $stockList = $this->Common_model->get_sales_product_detaild2($invoiceId);


        foreach ($stockList  as $ind => $element) {
            $result[$element->sales_invoice_id][$element->sales_details_id]['sales_invoice_id'] = $element->sales_invoice_id;
            $result[$element->sales_invoice_id][$element->sales_details_id]['sales_details_id'] = $element->sales_details_id;
            $result[$element->sales_invoice_id][$element->sales_details_id]['is_package'] = $element->is_package;
            $result[$element->sales_invoice_id][$element->sales_details_id]['category_id'] = $element->category_id;
            $result[$element->sales_invoice_id][$element->sales_details_id]['product_id'] = $element->product_id;
            $result[$element->sales_invoice_id][$element->sales_details_id]['productName'] = $element->productName;
            $result[$element->sales_invoice_id][$element->sales_details_id]['product_code'] = $element->product_code;
            $result[$element->sales_invoice_id][$element->sales_details_id]['title'] = $element->title;
            $result[$element->sales_invoice_id][$element->sales_details_id]['unitTtile'] = $element->unitTtile;
            $result[$element->sales_invoice_id][$element->sales_details_id]['brandName'] = $element->brandName;
            $result[$element->sales_invoice_id][$element->sales_details_id]['quantity'] = $element->quantity;
            $result[$element->sales_invoice_id][$element->sales_details_id]['unit_price'] = $element->unit_price;
            //$result[$element->sales_invoice_id][$element->sales_details_id]['unit_price'] = $element->unit_price;
            if($element->returnable_quantity >0 ){
                $result[$element->sales_invoice_id][$element->sales_details_id]['return'][$element->sales_details_id][] = array('return_product_name'=>$element->return_product_name,
                    'return_product_id'=>$element->return_product_id,
                    'sales_return_id'=>$element->sales_return_id,
                    'return_product_cat'=>$element->return_product_cat,
                    'return_product_name'=>$element->return_product_name,
                    'return_product_unit'=>$element->return_product_unit,
                    'return_product_brand'=>$element->return_product_brand,
                    'returnable_quantity'=>$element->returnable_quantity,
                );
            }else{
                $result[$element->sales_invoice_id][$element->sales_details_id]['return'][$element->sales_details_id]='';
            }

        }

        $data['editStock']=$result;

        //echo '<pre>';
        //print_r($stockList);exit;



        $data['configInfo'] = $this->Common_model->get_single_data_by_single_column('system_config', 'dist_id', $this->dist_id);
        $data['accountHeadList'] = $this->Common_model->getAccountHead();
        //get only cylinder product
        $data['productList'] = $this->Common_model->getPublicProductList($this->dist_id);
        // dumpVar($data['accountHeadList']);
        $data['cylinderProduct'] = $this->Common_model->getPublicProduct($this->dist_id, 1);
        //echo '<pre>';
        //print_r($data['cylinderProduct']);exit;
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

}