<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends CI_Controller {

    private $timestamp;
    public $admin_id;
    public $dist_id;

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Finane_Model');
        $this->load->model('Inventory_Model');
        $this->load->model('Sales_Model');
        $this->load->model('Dashboard_Model');
        $thisdis = $this->session->userdata('dis_id');
        $admin_id = $this->session->userdata('admin_id');
        if (empty($thisdis) || empty($admin_id)) {
            redirect(site_url('DistributorDashboard'));
        }
        $this->timestamp = date('Y-m-d H:i:s');
        $this->admin_id = $this->session->userdata('admin_id');
        $this->dist_id = $this->session->userdata('dis_id');
    }

    public function productType() {
        if (isPostBack()) {
            //validation rules
            $this->form_validation->set_rules('product_type_name', 'Product Type Name', 'required');
            if ($this->form_validation->run() == FALSE) {
                exception("Required field can't be empty.");
                redirect(site_url('addproductType'));
            } else {
                $data['product_type_name'] = $this->input->post('product_type_name');
                $data['description'] = $this->input->post('description');
                $data['is_active'] = $this->input->post('is_active');

                $data['dist_id'] = $this->dist_id;
                $data['insert_by'] = $this->admin_id;
                $data['insert_date'] = $this->timestamp;
                $data['company_id'] = 0;
                $data['branch_id'] = 0;
                $insertid = $this->Common_model->insert_data('product_type', $data);
                if (!empty($insertid)):
                    message("New product inserted successfully.");
                    redirect(site_url('productType'));
                else:
                    message("Product Can't inserted.");
                    redirect(site_url('addproductType'));
                endif;
            }
        }
        $data['pageName'] = 'addProductType';
        $data['mainContent'] = $this->load->view('distributor/inventory/product/addProductType', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    public function productTypeList() {
        $data['pageName'] = 'productTypeList';
        $data['mainContent'] = $this->load->view('distributor/inventory/product/productTypeList', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }

    function checkDuplicateProductType() {
        $product_type_name = $this->input->post('product_type_name');
        $product_type_id = $this->input->post('product_type_id');
        if (!empty($product_type_id)):
            $productTypeExits = $this->Common_model->checkDuplicateProductType($this->dist_id, $product_type_name, $product_type_id);
        else:
            $productTypeExits = $this->Common_model->checkDuplicateProductType($this->dist_id, $product_type_name);
        endif;
        if (!empty($productTypeExits)) {
            echo 1;
        }
    }

    function productTypeStatusChange() {
        $product_type_id = $this->input->post('product_type_id');
        $data['is_active'] = $this->input->post('status') == 1 ? 'Y' : 'N';
        $data['update_by'] = $this->admin_id;
        $data['update_date'] = $this->timestamp;
        $this->Common_model->update_data('product_type', $data, 'product_type_id', $product_type_id);
        message("Product Status successfully change.");
        echo 1;
    }

    function deleteProductType($product_type_id) {
        $inventoryCondition = array(
            'dist_id' => $this->dist_id,
            'product_type_id' => $deletedId,
        );
        $data['is_active'] = 'N';
        $data['is_delete'] = 'Y';
        $data['update_by'] = $this->admin_id;
        $data['update_date'] = $this->timestamp;
        $result = $this->Common_model->update_data_by_dist_id('product_type', $data, 'product_type_id', $product_type_id, $this->dist_id);
        if ($result != 0) {
            message("Your data successully deleted from database.");
        } else {
            exception("This Product Type can't be deleted.already have a transaction!");
        }
        redirect(site_url('productType'));
    }

    public function editProductType($product_type_id) {
        if (isPostBack()) {
            $this->form_validation->set_rules('product_type_name', 'Product Type Name', 'required');
            $this->form_validation->set_rules('product_type_id', 'Product Type Name', 'required');
            if ($this->form_validation->run() == FALSE) {
                exception("Required field can't be empty.");
                redirect(site_url('editProductType'));
            } else {
                $data['product_type_name'] = $this->input->post('product_type_name');
                $data['description'] = $this->input->post('description');
                $data['is_active'] = $this->input->post('is_active');
                $data['dist_id'] = $this->dist_id;
                $data['insert_by'] = $this->admin_id;
                $data['insert_date'] = $this->timestamp;
                $data['company_id'] = 0;
                $data['branch_id'] = 0;
                $insertid = $this->Common_model->update_data('product_type', $data, 'product_type_id', $product_type_id);

                if ($insertid > 0):
                    message("Product Type Update successfully.");
                    redirect(site_url('productType'));
                else:
                    message("Product Type Can't Update.");
                    redirect(site_url('productType'));
                endif;
            }
        }
        $data['product_type'] = $this->Common_model->get_single_data_by_single_column('product_type', 'product_type_id', $product_type_id);
        $data['pageName'] = 'editProductType';
        $data['mainContent'] = $this->load->view('distributor/inventory/product/editProductType', $data, true);
        $this->load->view('distributor/masterDashboard', $data);
    }
    

}
