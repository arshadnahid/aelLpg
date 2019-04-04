<?php
/**
 * Created by PhpStorm.
 * User: AEL-DEV
 * Date: 4/1/2019
 * Time: 12:15 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class PurchaseController extends CI_Controller
{


    private $timestamp;
    private $admin_id;
    public $dist_id;
    public $invoice_id;


    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Finane_Model');
        $this->load->model('Inventory_Model');
        $this->load->model('Sales_Model');
        //$this->load->model('Datatable');
        $this->timestamp = date('Y-m-d H:i:s');
        $this->admin_id = $this->session->userdata('admin_id');
        $this->dist_id = $this->session->userdata('dis_id');
        if (empty($this->admin_id) || empty($this->dist_id)) {
            redirect(site_url());
        }
        $this->invoice_type = 1;
    }

    public function purchases_add($confirId = null) {
        if (isPostBack()) {



//form validation rules
            $this->form_validation->set_rules('supplierID', 'Supplier ID', 'required');
            $this->form_validation->set_rules('voucherid', 'Voucher ID', 'required');
            $this->form_validation->set_rules('purchasesDate', 'Purchases Date', 'required');
            $this->form_validation->set_rules('paymentType', 'Payment Date', 'required');
            //$this->form_validation->set_rules('category_id[]', 'Product Category', 'required');
            //$this->form_validation->set_rules('product_id[]', 'Product Name', 'required');
            //$this->form_validation->set_rules('quantity[]', 'Product Quantigy', 'required');
            //$this->form_validation->set_rules('rate[]', 'Product Rate', 'required');
            //$this->form_validation->set_rules('price[]', 'Product Price', 'required');
            if ($this->form_validation->run() == FALSE) {
                exception("Required field can't be empty.");
                redirect(site_url('purchases_add'));
            } else {
                $paymentType = $this->input->post('paymentType');
                $accountCr = $this->input->post('accountCr');
                $arrayIndex = count($this->input->post('product_id'));
                $supplier_id = $this->input->post('supplierID');
                $this->db->trans_start();

                log_message('error','POST data'.print_r($_POST,true));



                $purchase_inv['invoice_no'] = $this->input->post('voucherid');
                $purchase_inv['supplier_invoice_no'] = $this->input->post('userInvoiceId');
                $purchase_inv['supplier_id'] = $this->input->post('supplierID');
                $purchase_inv['payment_type'] = $paymentType;
                $purchase_inv['invoice_amount'] = array_sum($this->input->post('price'));
                $purchase_inv['vat_amount'] = 0;
                $purchase_inv['discount_amount'] = $this->input->post('discount')!=''?$this->input->post('discount'):0;
                $purchase_inv['paid_amount'] = $this->input->post('thisAllotment')!=''?$this->input->post('thisAllotment'):0;

                $purchase_inv['tran_vehicle_id'] = $this->input->post('transportation')!=''?$this->input->post('transportation'):0;
                $purchase_inv['transport_charge'] = $this->input->post('transportationAmount')!=''?$this->input->post('transportationAmount'):0;
                $purchase_inv['loader_charge'] = $this->input->post('loaderAmount')!=''?$this->input->post('loaderAmount'):0;
                $purchase_inv['loader_emp_id'] = $this->input->post('loader')!=''?$this->input->post('loader'):0;
                $purchase_inv['refference_person_id'] = $this->input->post('reference');
                $purchase_inv['company_id'] = $this->dist_id;
                $purchase_inv['dist_id'] = $this->dist_id;
                $purchase_inv['branch_id'] = 0;
                $purchase_inv['due_date'] = date('Y-m-d', strtotime($this->input->post('dueDate')));
                $purchase_inv['invoice_date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
                $purchase_inv['insert_date'] = $this->timestamp;
                $purchase_inv['insert_by'] = $this->admin_id;
                $purchase_inv['is_active'] = 'Y';
                $purchase_inv['is_delete'] = 'N';
                $this->invoice_id = $this->Common_model->insert_data('purchase_invoice_info', $purchase_inv);








                $productCate = $this->input->post('category_id');
                $allStock = array();
                //echo "<pre>";
                //print_r($_POST['slNo']);exit;
                foreach ($_POST['slNo'] as $key => $value){
                    unset($stock);
                    $stock['purchase_invoice_id'] = $this->invoice_id;
                    $stock['product_id'] = $_POST['product_id_'.$value];
                    $stock['is_package '] = $_POST['is_package_'.$value];
                    $stock['quantity'] = $_POST['quantity_'.$value];
                    $stock['unit_price'] = $_POST['rate_'.$value];
                    $stock['insert_by'] = $this->admin_id;
                    $stock['insert_date'] = $this->timestamp;
                    log_message('error','Insert in stock table'.print_r($stock,true));
                    //$allStock[] = $stock;
                    $purchase_details_id=$this->Common_model->insert_data('purchase_details', $stock);


                    if(isset($_POST['returnproduct_'.$value])){
                        foreach ($_POST['returnproduct_'.$value] as $key1 => $value1){
                            unset($stock2);
                            $stock2['purchase_details_id'] = $purchase_details_id;
                            $stock2['product_id'] = $value1;
                            $stock2['returnable_quantity'] = $_POST['returnQuentity_'.$value][$key1];
                            $stock2['return_quantity'] = $_POST['returnQuentity_'.$value][$key1];
                            $stock2['insert_by'] = $this->admin_id;
                            $stock2['insert_date'] = $this->timestamp;
                            $allStock[] = $stock2;
                        }


                    }


                }
                $this->db->insert_batch('purchase_return_details', $allStock);
                //$this->Common_model->insert_batch('purchase_return_details', $allStock);
                log_message('error','Insert in stock details table'.print_r($allStock,true));





                if ($paymentType == 2) {
                    //if payment type credit than transaction here
                    $generals_id = $this->creditTransactionInsert();
                } elseif ($paymentType == 1) {
                    //if payment type Cash than transaction here
                    $generals_id = $this->cashTransactionInsert();
                } elseif ($paymentType == 4) {
                    //if payment type partial than calculate from here
                    $generals_id = $this->partialTransactionInsert();
                } else {
                    $generals_id = $this->chequeTransactionInsert();
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    notification("Your data can't be inserted.Somthing is wrong!!");
                    if (!empty($confirId)):
                        redirect(site_url('PurchaseDemoConfirm/' . $confirId));
                    else:
                        redirect(site_url('purchases_add'));
                    endif;
                } else {
                    if (!empty($confirId)):
                        message("Your posted ledger successfully inserted into database.");
                        $update['ConfirmStatus'] = 1;
                        $this->Common_model->update_data('purchase_demo', $update, 'purchase_demo_id', $confirId);
                        redirect(site_url('demolist'));
                    else:
                        message("Your data successfully inserted into database.");
                        redirect(site_url('viewPurchases/' . $generals_id));
                    endif;
                }
            }
        }
        $data['accountHeadList'] = $this->Common_model->getAccountHead();
        $condition = array(
            'dist_id' => $this->dist_id,
            'form_id' => 11,
        );
        $supID = $this->Common_model->getSupplierID($this->dist_id);
        $data['supplierID'] = $this->Common_model->checkDuplicateSupID($supID, $this->dist_id);
        $data['title'] = 'Purchases Add';
        $data['unitList'] = $this->Common_model->get_data_list_by_single_column('unit', 'dist_id', $this->dist_id);
        $costCondition = array(
            'dist_id' => $this->dist_id,
            'parentId' => 62,
        );
        $data['costList'] = $this->Common_model->get_data_list_by_many_columns('generaldata', $costCondition);
        $data['productCat'] = $this->Common_model->getPublicProductCat($this->dist_id);
        $data['productList'] = $this->Common_model->getPublicProductList($this->dist_id);
        $data['packageList'] = $this->Common_model->getPublicPackageList($this->dist_id);

        $data['cylinderProduct'] = $this->Common_model->getPublicProduct($this->dist_id, 1);
        //echo "<pre>";
        //print_r($data['cylinderProduct']);exit;
        $data['supplierList'] = $this->Common_model->getPublicSupplier($this->dist_id);

        $condition1 = array(
            'dist_id' => $this->dist_id,
            'isActive' => 'Y',
            'isDelete' => 'N',
        );
        $data['employeeList'] = $this->Common_model->get_data_list_by_many_columns('employee', $condition1);
        $data['vehicleList'] = $this->Common_model->get_data_list_by_many_columns('vehicle', $condition1);

        $totalPurchases = $this->Common_model->get_data_list_by_many_columns('generals', $condition);
        $data['voucherID'] = "PV" . date('y') . date('m') . str_pad(count($totalPurchases) + 1, 4, "0", STR_PAD_LEFT);
        $data['mainContent'] = $this->load->view('distributor/inventory/purchases/purchasesWithPos', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }
    function package_product_list(){
        $package_id = $this->input->post('package_id');



        $packageProductDetails = $this->Common_model->get_package_product($package_id);
        echo json_encode($packageProductDetails);
        //echo "<pre>";
        //print_r($productDetails);
       // if (!empty($productDetails)):
        //    echo $productDetails->purchases_price;
       // endif;
    }

    function creditTransactionInsert() {



        $data['supplier_id'] = $this->input->post('supplierID');
        $data['dist_id'] = $this->dist_id;
        $data['voucher_no'] = $this->input->post('voucherid');
        $data['reference'] = $this->input->post('reference');
        $data['dueDate'] = date('Y-m-d', strtotime($this->input->post('dueDate')));
        $data['date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
        $data['payType'] = 2;
        $data['debit'] = array_sum($this->input->post('price'));
        $data['narration'] = $this->input->post('narration');
        $data['mainInvoiceId'] = $this->input->post('userInvoiceId');
        $data['form_id'] = 11;
        $data['loader'] = $this->input->post('loader');
        $data['transportation'] = $this->input->post('transportation');
        $data['loaderAmount'] = $this->input->post('loaderAmount');
        $data['transportationAmount'] = $this->input->post('transportationAmount');
        $data['discount']=$this->input->post('discount');
        $data['updated_by'] = $this->admin_id;
        $data['created_at'] = $this->timestamp;
        $generals_id = $this->Common_model->insert_data('generals', $data);

//cylinder calculation start here....
        $addReturnAble = $this->input->post('add_returnAble');
        $newCylinderProductCost = 0;
        $otherProductCost = 0;
        $productCate = $this->input->post('category_id');
        $allStock = array();
        $allStock1 = array();
        foreach ($productCate as $key => $value):
            unset($stock);
            if ($value == 1) {
                $newCylinderProductCost += $this->input->post('price')[$key];
            } else {
                $otherProductCost += $this->input->post('price')[$key];
            }
            $stock['generals_id'] = $generals_id;
            $stock['category_id'] = $value;
            $stock['product_id'] = $this->input->post('product_id')[$key];
            $stock['quantity'] = $this->input->post('quantity')[$key];
            $stock['rate'] = $this->input->post('rate')[$key];
            $stock['price'] = $this->input->post('price')[$key];
            $stock['unit'] = getProductUnit($this->input->post('product_id')[$key]);
            $stock['date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
            $stock['form_id'] = 11;
            $stock['type'] = 'In';
            $stock['dist_id'] = $this->dist_id;
            $stock['updated_by'] = $this->admin_id;
            $stock['created_at'] = $this->timestamp;
            $allStock[] = $stock;
            $returnQty = $this->input->post('add_returnAble')[$key];

//If cylinder stock out than transaction store here.
            if (!empty($returnQty) && $returnQty > 0) {
                unset($stock1);
                /*
                 * EDIT By Nahid
                 *
                 * $stock1['generals_id'] = $cylinderId;
                 *                  */
                $stock1['generals_id'] = $generals_id;
                $stock1['category_id'] = $value;
                $stock1['product_id'] = $this->input->post('product_id')[$key];
                $stock1['unit'] = getProductUnit($this->input->post('product_id')[$key]);
                $stock1['quantity'] = $this->input->post('add_returnAble')[$key];
                $stock1['rate'] = $this->input->post('rate')[$key];
                $stock1['price'] = $this->input->post('price')[$key];
                $stock1['date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
                $stock1['form_id'] = 24;
                $stock1['type'] = 'Cin';
                $stock1['dist_id'] = $this->dist_id;
                $stock1['supplierId'] = $this->input->post('supplierID');
                $stock1['updated_by'] = $this->admin_id;
                $stock1['created_at'] = $this->timestamp;
                $allStock1[] = $stock1;
            }
        endforeach;
        $this->db->insert_batch('stock', $allStock);
        if (!empty($allStock1)):
            $this->db->insert_batch('stock', $allStock1);
        endif;

//insert in stock table
        $cylinderRecive = $this->input->post('category_id2');
        $cylinderAllStock = array();
        if (!empty($cylinderRecive) && $cylinderRecive > 0):

            foreach ($cylinderRecive as $key => $value) :
                unset($stockReceive);
                $stockReceive['category_id'] = $value;
                $stockReceive['product_id'] = $this->input->post('product_id2')[$key];
                $stockReceive['unit'] = getProductUnit($this->input->post('product_id2')[$key]);
                $stockReceive['quantity'] = $this->input->post('quantity2')[$key];
                $stockReceive['date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
                $stockReceive['form_id'] = 23;
                $stockReceive['generals_id'] = $generals_id;
                $stockReceive['type'] = 'Cout';
                $stockReceive['dist_id'] = $this->dist_id;
                $stockReceive['supplierId'] = $this->input->post('supplierID');
                $stockReceive['updated_by'] = $this->admin_id;
                $stockReceive['created_at'] = $this->timestamp;
                $cylinderAllStock[] = $stockReceive;
            endforeach;
//insert for culinder receive
            $this->db->insert_batch('stock', $cylinderAllStock);
        endif;

        $supp = array(
            'ledger_type' => 2,
            'trans_type' => 'purchase',
            'history_id' => $generals_id,
            'trans_type' => $this->input->post('voucherid'),
            'client_vendor_id' => $this->input->post('supplierID'),
            'updated_by' => $this->admin_id,
            'paymentType' => 'Purcahses Voucher',
            'dist_id' => $this->dist_id,
            'amount' => $this->input->post('netTotal'),
            'dr' => $this->input->post('netTotal'),
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
        );
        $this->db->insert('client_vendor_ledger', $supp);



//insert into client vendor ledger

//50 supplier Payable
        $gl_data = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'form_id' => '11',
            'dist_id' => $this->dist_id,
            'account' => 50,
            'credit' => $this->input->post('netTotal'),
            'memo' => 'purchases',
            'updated_by' => $this->admin_id,
            'created_at' => $this->timestamp
        );
        $this->db->insert('generalledger', $gl_data);

        if (!empty($newCylinderProductCost)):
            $gl_data = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
                'form_id' => '11',
                'dist_id' => $this->dist_id,
                'account' => 173,
                'debit' => $newCylinderProductCost,
                'memo' => 'purchases',
                'updated_by' => $this->admin_id,
                'created_at' => $this->timestamp
            );
            $this->db->insert('generalledger', $gl_data);
        endif;
//Others product inventory stock.
        if (!empty($otherProductCost)):
            $gl_data = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
                'form_id' => '11',
                'dist_id' => $this->dist_id,
                'account' => 52,
                'debit' => $otherProductCost,
                'memo' => 'purchases',
                'updated_by' => $this->admin_id,
                'created_at' => $this->timestamp
            );
            $this->db->insert('generalledger', $gl_data);
        endif;
//LOADING AND UNLOADING
        $gl_data = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'form_id' => '11',
            'dist_id' => $this->dist_id,
            'account' => 336,
            'debit' => $this->input->post('loaderAmount'),
            'memo' => 'Loading and wages',
            'updated_by' => $this->admin_id,
            'created_at' => $this->timestamp
        );
        $this->db->insert('generalledger', $gl_data);
//transportation
        $gl_data = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'form_id' => '11',
            'dist_id' => $this->dist_id,
            'account' => 339,
            'debit' => $this->input->post('transportationAmount'),
            'memo' => 'Transportation',
            'updated_by' => $this->admin_id,
            'created_at' => $this->timestamp
        );
        $this->db->insert('generalledger', $gl_data);

        if ($generals_id) {
            return $generals_id;
        }
    }

    function partialTransactionInsert() {
        $accountCr = $this->input->post('accountCrPartial');
        $thisAllotment = $this->input->post('thisAllotment');
        if (empty($accountCr) || empty($thisAllotment)) {
            exception("Required field can't be empty.");
            redirect(site_url('purchases_add'));
        }
        $add_returnAble = array_sum($this->input->post('add_returnAble'));
        $data['supplier_id'] = $this->input->post('supplierID');
        $data['dist_id'] = $this->dist_id;
        $data['voucher_no'] = $this->input->post('voucherid');
        $data['reference'] = $this->input->post('reference');
        $data['date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
        $data['payType'] = 4;
        $data['debit'] = array_sum($this->input->post('price'));
        $data['narration'] = $this->input->post('narration');
        $data['form_id'] = 11;
        $data['loader'] = $this->input->post('loader');
        $data['transportation'] = $this->input->post('transportation');
        $data['loaderAmount'] = $this->input->post('loaderAmount');
        $data['transportationAmount'] = $this->input->post('transportationAmount');
        $data['discount']=$this->input->post('discount');
        $data['updated_by'] = $this->admin_id;
        $data['created_at'] = $this->timestamp;
        $generals_id = $this->Common_model->insert_data('generals', $data);
//insert in generall table
//insert in returnAlbe

        $productCate = $this->input->post('category_id');
        $allStock = array();
        $allStockCylinder = array();
        $newCylinderProductCost = '';
        $otherProductCost = '';
        foreach ($productCate as $key => $value):
            unset($stock);
            if ($value == 1) {
                $newCylinderProductCost += $this->input->post('price')[$key];
            } else {
                $otherProductCost += $this->input->post('price')[$key];
            }
            $stock['generals_id'] = $generals_id;
            $stock['category_id'] = $value;
            $stock['product_id'] = $this->input->post('product_id')[$key];
            $stock['quantity'] = $this->input->post('quantity')[$key];
            $stock['rate'] = $this->input->post('rate')[$key];
            $stock['price'] = $this->input->post('price')[$key];
            $stock['unit'] = getProductUnit($this->input->post('product_id')[$key]);
            $stock['date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
            $stock['form_id'] = 11;
            $stock['type'] = 'In';
            $stock['dist_id'] = $this->dist_id;
            $stock['updated_by'] = $this->admin_id;
            $stock['created_at'] = $this->timestamp;
            $allStock[] = $stock;
            $returnQty = $this->input->post('add_returnAble')[$key];
//If cylinder stock out than transaction store here.
            if (!empty($returnQty) && $returnQty > 0) {
                unset($stock1);
                $stock1['generals_id'] = $generals_id;
                $stock1['category_id'] = $value;
                $stock1['product_id'] = $this->input->post('product_id')[$key];
                $stock1['unit'] = getProductUnit($this->input->post('product_id')[$key]);
                $stock1['quantity'] = $this->input->post('add_returnAble')[$key];
                $stock1['rate'] = $this->input->post('rate')[$key];
                $stock1['price'] = $this->input->post('price')[$key];
                $stock1['date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
                $stock1['form_id'] = 24;
                $stock1['type'] = 'Cin';
                $stock1['dist_id'] = $this->dist_id;
                $stock1['supplierId'] = $this->input->post('supplierID');
                $stock1['updated_by'] = $this->admin_id;
                $stock1['created_at'] = $this->timestamp;
                $allStock1[] = $stock1;
            }
        endforeach;
//data insert in stock table
        $this->db->insert_batch('stock', $allStock);

        if(!empty($allStock1)):
            $this->db->insert_batch('stock', $allStock1);
        endif;
//insert in stock table
//Cylinder Stock transaction here
        $cylinderRecive = $this->input->post('category_id2');
        $cylinderAllStock = array();
        if (!empty($cylinderRecive) && $cylinderRecive > 0):

            foreach ($cylinderRecive as $key => $value) :
                unset($stockReceive);
                $stockReceive['category_id'] = $value;
                $stockReceive['product_id'] = $this->input->post('product_id2')[$key];
                $stockReceive['unit'] = getProductUnit($this->input->post('product_id2')[$key]);
                $stockReceive['quantity'] = $this->input->post('quantity2')[$key];
                $stockReceive['date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
                $stockReceive['form_id'] = 23;
                $stockReceive['generals_id'] = $generals_id;
                $stockReceive['type'] = 'Cout';
                $stockReceive['dist_id'] = $this->dist_id;
                $stockReceive['supplierId'] = $this->input->post('supplierID');
                $stockReceive['updated_by'] = $this->admin_id;
                $stockReceive['created_at'] = $this->timestamp;
                $cylinderAllStock[] = $stockReceive;
            endforeach;
//insert for culinder receive
            $this->db->insert_batch('stock', $cylinderAllStock);
        endif;
        $supp = array(
            'ledger_type' => 2,
            'trans_type' => 'purchase',
            'history_id' => $generals_id,
            'trans_type' => $this->input->post('voucherid'),
            'client_vendor_id' => $this->input->post('supplierID'),
            'updated_by' => $this->admin_id,
            'dist_id' => $this->dist_id,
            'amount' => $this->input->post('netTotal'),
            'dr' => $this->input->post('netTotal'),
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'paymentType' => 'Purchase Voucher'
        );
        $this->db->insert('client_vendor_ledger', $supp);
//insert into client vendor ledger

//50 supplier Payable
        $gl_data = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'form_id' => '11',
            'dist_id' => $this->dist_id,
            'account' => 50,
            'credit' => $this->input->post('netTotal'),
            'memo' => 'purchases',
            'updated_by' => $this->admin_id,
            'created_at' => $this->timestamp
        );
        $this->db->insert('generalledger', $gl_data);

//new cylinder product stock
        if (!empty($newCylinderProductCost)):
            $gl_data = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
                'form_id' => '11',
                'dist_id' => $this->dist_id,
                'account' => 173,
                'debit' => $newCylinderProductCost,
                'memo' => 'purchases',
                'updated_by' => $this->admin_id,
                'created_at' => $this->timestamp
            );
            $this->db->insert('generalledger', $gl_data);
        endif;
//Others product inventory stock.
        if (!empty($otherProductCost)):
            $gl_data = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
                'form_id' => '11',
                'dist_id' => $this->dist_id,
                'account' => 52,
                'debit' => $otherProductCost,
                'memo' => 'purchases',
                'updated_by' => $this->admin_id,
                'created_at' => $this->timestamp
            );
            $this->db->insert('generalledger', $gl_data);
        endif;

        //LOADING AND UNLOADING
        $gl_data = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'form_id' => '11',
            'dist_id' => $this->dist_id,
            'account' => 336,
            'debit' => $this->input->post('loaderAmount'),
            'memo' => 'Loading and wages',
            'updated_by' => $this->admin_id,
            'created_at' => $this->timestamp
        );
        $this->db->insert('generalledger', $gl_data);
//transportation
        $gl_data = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'form_id' => '11',
            'dist_id' => $this->dist_id,
            'account' => 339,
            'debit' => $this->input->post('transportationAmount'),
            'memo' => 'Transportation',
            'updated_by' => $this->admin_id,
            'created_at' => $this->timestamp
        );
        $this->db->insert('generalledger', $gl_data);

//cash calculation here.
        $generals_data['supplier_id'] = $this->input->post('supplierID');
        $generals_data['dist_id'] = $this->dist_id;
        $generals_data['voucher_no'] = $this->input->post('voucherid');
        $generals_data['reference'] = $this->input->post('reference');
        $generals_data['date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
        $generals_data['payType'] = 1;
        $generals_data['credit'] = $this->input->post('thisAllotment');
        $generals_data['narration'] = $this->input->post('narration');
        $generals_data['form_id'] = 14;
        $generals_data['updated_by'] = $this->admin_id;
        $generals_data['mainInvoiceId'] = $generals_id;
        $generals_data['created_at'] = $this->timestamp;
        $paymentGeneralId = $this->Common_model->insert_data('generals', $generals_data);
        $supp1 = array(
            'ledger_type' => 2,
            'dist_id' => $this->dist_id,
            'trans_type' => $this->input->post('voucherid'),
            'client_vendor_id' => $this->input->post('supplierID'),
            'amount' => $this->input->post('thisAllotment'),
            'cr' => $this->input->post('thisAllotment'),
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'updated_by' => $this->admin_id,
            'history_id' => $paymentGeneralId,
            'paymentType' => 'Supplier Payment',
        );
        $this->db->insert('client_vendor_ledger', $supp1);
// generalledger: Pay From
        $cr_data = array(
            'form_id' => '14',
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'generals_id' => $paymentGeneralId,
            'dist_id' => $this->dist_id,
            'account' => $this->input->post('accountCrPartial'),
            'credit' => $this->input->post('thisAllotment'),
            'updated_by' => $this->admin_id,
            'created_at' => $this->timestamp
        );
        $this->db->insert('generalledger', $cr_data);
// generalledger: Account Payables
        $dr_data = array(
            'form_id' => '14',
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'generals_id' => $paymentGeneralId,
            'dist_id' => $this->dist_id,
            'account' => 50,
            'debit' => $this->input->post('thisAllotment'),
            'updated_by' => $this->admin_id,
            'created_at' => $this->timestamp
        );
        $this->db->insert('generalledger', $dr_data);
        $totalMoneyReceite = $this->Common_model->get_data_list_by_single_column('moneyreceit', 'dist_id', $this->dist_id);
        $mrid = "RID" . str_pad(count($totalMoneyReceite) + 1, 4, "0", STR_PAD_LEFT);
        $bankName = $this->input->post('bankName');
        $checkNo = $this->input->post('checkNo');
        $checkDate = $this->input->post('checkDate');
        $branchName = $this->input->post('branchName');
        $moneyReceit = array(
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'invoiceID' => $this->input->post('voucherid'),
            'totalPayment' => $this->input->post('thisAllotment'),
            'receitID' => $mrid,
            'mainInvoiceId' => $generals_id,
            'customerid' => $this->input->post('supplierID'),
            'narration' => $this->input->post('narration'),
            'updated_by' => $this->admin_id,
            'dist_id' => $this->dist_id,
            'paymentType' => 1,
            'receiveType' => 2,
            'bankName' => isset($bankName) ? $bankName : '0',
            'checkNo' => isset($checkNo) ? $checkNo : '0',
            'checkDate' => isset($checkDate) ? date('Y-m-d', strtotime($checkDate)) : '0',
            'branchName' => isset($branchName) ? $branchName : '0');
        $this->db->insert('moneyreceit', $moneyReceit);
        if ($generals_id) {
            return $generals_id;
        }
    }
    function chequeTransactionInsert() {
        $bankName = $this->input->post('bankName');
        $checkNo = $this->input->post('checkNo');
        if (empty($bankName) || empty($checkNo)) {
            exception("Required field can't be empty.");
            redirect(site_url('purchases_add'));
        }
//when bank transaction than start here.
        $data['supplier_id'] = $this->input->post('supplierID');
        $data['dist_id'] = $this->dist_id;
        $data['voucher_no'] = $this->input->post('voucherid');
        $data['reference'] = $this->input->post('reference');
        $data['date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
        $data['payType'] = 2;
        $data['debit'] = array_sum($this->input->post('price'));
        $data['narration'] = $this->input->post('narration');
        $data['form_id'] = 11;

        $data['loader'] = $this->input->post('loader');
        $data['transportation'] = $this->input->post('transportation');
        $data['loaderAmount'] = $this->input->post('loaderAmount');
        $data['transportationAmount'] = $this->input->post('transportationAmount');
        $data['discount']=$this->input->post('discount');
        $data['mainInvoiceId'] = $this->input->post('userInvoiceId');
        $data['updated_by'] = $this->admin_id;
        $data['created_at'] = $this->timestamp;
        $generals_id = $this->Common_model->insert_data('generals', $data);
//insert in generall table
        $returnQty = array_sum($this->input->post('add_returnAble'));

        $productCate = $this->input->post('category_id');
        $allStock = array();
        $allStock1 = array();
        $newCylinderProductCost = '';
        $otherProductCost = '';
        foreach ($productCate as $key => $value):
            unset($stock);
//dd
            if ($value == 1) {
                $newCylinderProductCost += $this->input->post('price')[$key];
            } else {
                $otherProductCost += $this->input->post('price')[$key];
            }
            $stock['generals_id'] = $generals_id;
            $stock['category_id'] = $value;
            $stock['product_id'] = $this->input->post('product_id')[$key];
            $stock['quantity'] = $this->input->post('quantity')[$key];
            $stock['rate'] = $this->input->post('rate')[$key];
            $stock['price'] = $this->input->post('price')[$key];
            $stock['unit'] = getProductUnit($this->input->post('product_id')[$key]);
            $stock['date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
            $stock['form_id'] = 11;
            $stock['type'] = 'In';
            $stock['dist_id'] = $this->dist_id;
            $stock['updated_by'] = $this->admin_id;
            $stock['created_at'] = $this->timestamp;
            $allStock[] = $stock;
            $returnQty = $this->input->post('add_returnAble')[$key];
//If cylinder stock out than transaction store here.
            if (!empty($returnQty)) {
                unset($stock1);
                $stock1['generals_id'] = $generals_id;
                $stock1['category_id'] = $value;
                $stock1['product_id'] = $this->input->post('product_id')[$key];
                $stock1['unit'] = getProductUnit($this->input->post('product_id')[$key]);
                $stock1['quantity'] = $this->input->post('add_returnAble')[$key];
                $stock1['rate'] = $this->input->post('rate')[$key];
                $stock1['price'] = $this->input->post('price')[$key];
                $stock1['date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
                $stock1['form_id'] = 24;
                $stock1['type'] = 'Cin';
                $stock1['dist_id'] = $this->dist_id;
                $stock1['supplierId'] = $this->input->post('supplierID');
                $stock1['updated_by'] = $this->admin_id;
                $stock1['created_at'] = $this->timestamp;
                $allStock1[] = $stock1;
            }
        endforeach;
        $this->db->insert_batch('stock', $allStock);
        if(!empty($allStock1)):
            $this->db->insert_batch('stock', $allStock1);
        endif;
//insert in stock table
        $cylinderRecive = $this->input->post('category_id2');
        $cylinderAllStock = array();
        if (!empty($cylinderRecive) && $cylinderRecive > 0):
            foreach ($cylinderRecive as $key => $value) :
                unset($stockReceive);
                $stockReceive['category_id'] = $value;
                $stockReceive['product_id'] = $this->input->post('product_id2')[$key];
                $stockReceive['unit'] = getProductUnit($this->input->post('product_id2')[$key]);
                $stockReceive['quantity'] = $this->input->post('quantity2')[$key];
                $stockReceive['date'] = date('Y-m-d', strtotime($this->input->post('purchasesDate')));
                $stockReceive['form_id'] = 23;
                $stockReceive['generals_id'] = $generals_id;
                $stockReceive['type'] = 'Cout';
                $stockReceive['dist_id'] = $this->dist_id;
                $stockReceive['supplierId'] = $this->input->post('supplierID');
                $stockReceive['updated_by'] = $this->admin_id;
                $stockReceive['created_at'] = $this->timestamp;
                $cylinderAllStock[] = $stockReceive;
            endforeach;
//insert for culinder receive
            $this->db->insert_batch('stock', $cylinderAllStock);
        endif;
        $supp = array(
            'ledger_type' => 2,
            'trans_type' => 'purchase',
            'history_id' => $generals_id,
            'trans_type' => $this->input->post('voucherid'),
            'client_vendor_id' => $this->input->post('supplierID'),
            'updated_by' => $this->admin_id,
            'dist_id' => $this->dist_id,
            'amount' => $this->input->post('netTotal'),
            'dr' => $this->input->post('netTotal'),
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'paymentType' => 'Purchase Voucher'
        );
        $this->db->insert('client_vendor_ledger', $supp);

//50 supplier Payable
        $gl_data = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'form_id' => '11',
            'dist_id' => $this->dist_id,
            'account' => 50,
            'credit' => $this->input->post('netTotal'),
            'memo' => 'purchases',
            'updated_by' => $this->admin_id,
            'created_at' => $this->timestamp
        );
        $this->db->insert('generalledger', $gl_data);

//new cylinder product stock
        if (!empty($newCylinderProductCost)):
            $gl_data = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
                'form_id' => '11',
                'dist_id' => $this->dist_id,
                'account' => 173,
                'debit' => $newCylinderProductCost,
                'memo' => 'purchases',
                'updated_by' => $this->admin_id,
                'created_at' => $this->timestamp
            );
            $this->db->insert('generalledger', $gl_data);
        endif;
//Others product inventory stock.
        if (!empty($otherProductCost)):
            $gl_data = array(
                'generals_id' => $generals_id,
                'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
                'form_id' => '11',
                'dist_id' => $this->dist_id,
                'account' => 52,
                'debit' => $otherProductCost,
                'memo' => 'purchases',
                'updated_by' => $this->admin_id,
                'created_at' => $this->timestamp
            );
            $this->db->insert('generalledger', $gl_data);
        endif;

        //LOADING AND UNLOADING
        $gl_data = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'form_id' => '11',
            'dist_id' => $this->dist_id,
            'account' => 336,
            'debit' => $this->input->post('loaderAmount'),
            'memo' => 'Loading and wages',
            'updated_by' => $this->admin_id,
            'created_at' => $this->timestamp
        );
        $this->db->insert('generalledger', $gl_data);
//transportation
        $gl_data = array(
            'generals_id' => $generals_id,
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'form_id' => '11',
            'dist_id' => $this->dist_id,
            'account' => 339,
            'debit' => $this->input->post('transportationAmount'),
            'memo' => 'Transportation',
            'updated_by' => $this->admin_id,
            'created_at' => $this->timestamp
        );
        $this->db->insert('generalledger', $gl_data);
        $mrCondition = array(
            'dist_id' => $this->dist_id,
            'receiveType' => 2,
        );
        $totalMoneyReceite = $this->Common_model->get_data_list_by_many_columns('moneyreceit', $mrCondition);
        $mrid = "RID" . date('y') . date('m') . str_pad(count($totalMoneyReceite) + 1, 4, "0", STR_PAD_LEFT);
        $bankName = $this->input->post('bankName');
        $checkNo = $this->input->post('checkNo');
        $checkDate = $this->input->post('checkDate');
        $branchName = $this->input->post('branchName');
        $moneyReceit = array(
            'date' => date('Y-m-d', strtotime($this->input->post('purchasesDate'))),
            'invoiceID' => $this->input->post('voucherid'),
            'totalPayment' => array_sum($this->input->post('price')),
            'receitID' => $mrid,
            'mainInvoiceId' => $generals_id,
            'customerid' => $this->input->post('supplierID'),
            'narration' => $this->input->post('narration'),
            'updated_by' => $this->admin_id,
            'dist_id' => $this->dist_id,
            'paymentType' => 2,
            'receiveType' => 2,
            'bankName' => isset($bankName) ? $bankName : '0',
            'checkNo' => isset($checkNo) ? $checkNo : '0',
            'checkDate' => isset($checkDate) ? date('Y-m-d', strtotime($checkDate)) : '0',
            'branchName' => isset($branchName) ? $branchName : '0');
        $this->db->insert('moneyreceit', $moneyReceit);
        if ($generals_id) {
            return $generals_id;
        }
    }
}