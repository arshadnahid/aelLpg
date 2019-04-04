<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ServerFilterModel extends CI_Model {

    public $table;
    public $column_order; //set column field database for datatable orderable
    public $column_search; //set column field database for datatable searchable
    public $order; // default order
    public $join1; // default order
    public $join2; // default order
    public $dist_id;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function filterData($table, $column_order, $coumn_search, $order, $distId) {
        $this->table = $table;
        $this->column_order = $column_order;
        $this->column_search = $coumn_search;
        $this->order = $order;
        $this->dist_id = $distId;
    }

    private function _get_datatables_query() {
        $this->db->from($this->table);
        $this->db->where('dist_id', $this->dist_id);
        $this->db->or_where('dist_id', 1);
        $i = 0;

        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    private function _get_productCat_datatables_query() {
        $this->db->from($this->table);
        $this->db->where('dist_id', $this->dist_id);
        $this->db->or_where('dist_id', 1);
        $i = 0;

        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    private function _get_datatables_unit_query() {
        $this->db->from($this->table);
        $this->db->where('dist_id', $this->dist_id);
        $this->db->or_where('dist_id', 1);
        $i = 0;

        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    private function _get_product_datatables_query() {
        $this->db->select("productcategory.title,brand.brandName,product.product_code,product.productName,product.purchases_price,product.salesPrice,product.retailPrice,product.status,product.dist_id,product.product_id,unit.unitTtile");
        $this->db->from($this->table);
        $this->db->join('brand', 'brand.brandId = product.brand_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = product.category_id', 'left');
        $this->db->join('unit', 'unit.unit_id = product.unit_id', 'left');
        $this->db->group_start();
        $this->db->where('product.dist_id', $this->dist_id);
        $this->db->or_where('product.dist_id', 1);
        $this->db->group_end();
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            //$order = $this->order;
            $this->db->order_by('product.product_id', 'desc');
        }
    }

    private function _get_sales_datatables_query() {
        $this->db->select("form.name,generals.generals_id,generals.voucher_no,generals.narration,generals.date,generals.debit,customer.customerID,customer.customerName,customer.customer_id");
        $this->db->from("generals");
        $this->db->join('customer', 'customer.customer_id=generals.customer_id');
        $this->db->join('form', 'form.form_id=generals.form_id');
        $this->db->where('generals.dist_id', $this->dist_id);
        $this->db->where('generals.form_id', 5);
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            //$order = $this->order;
            $this->db->order_by('generals.date', 'desc');
        }
    }

    private function _get_purchases_datatables_query() {

        $this->db->select("form.name,generals.generals_id,generals.voucher_no,generals.narration,generals.date,generals.debit,supplier.supID,supplier.supName,supplier.sup_id,supplier.sup_id");
        $this->db->from("generals");
        $this->db->join('supplier', 'supplier.sup_id=generals.supplier_id');
        $this->db->join('form', 'form.form_id=generals.form_id');
        $this->db->where('generals.dist_id', $this->dist_id);
        $this->db->where('generals.form_id', 11);
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            //$order = $this->order;
            $this->db->order_by('generals.date', 'desc');
        }
    }
    private function _get_payment_datatables_query() {

        $this->db->select("miscellaneous,generals.customer_id,generals.supplier_id,form.name,generals.generals_id,generals.voucher_no,generals.narration,generals.date,generals.debit,supplier.supID,supplier.supName,customer.customerID,customer.customerName");
        $this->db->from("generals");
        $this->db->join('supplier', 'supplier.sup_id=generals.supplier_id','left');
        $this->db->join('customer', 'customer.customer_id=generals.customer_id','left');
        $this->db->join('form', 'form.form_id=generals.form_id');
        $this->db->where('generals.dist_id', $this->dist_id);
        $this->db->where('generals.form_id', 2);
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            //$order = $this->order;
            $this->db->order_by('generals.date', 'desc');
        }
    }
    private function _get_receive_datatables_query() {

        $this->db->select("miscellaneous,generals.customer_id,generals.supplier_id,form.name,generals.generals_id,generals.voucher_no,generals.narration,generals.date,generals.debit,supplier.supID,supplier.supName,customer.customerID,customer.customerName");
        $this->db->from("generals");
        $this->db->join('supplier', 'supplier.sup_id=generals.supplier_id','left');
        $this->db->join('customer', 'customer.customer_id=generals.customer_id','left');
        $this->db->join('form', 'form.form_id=generals.form_id');
        $this->db->where('generals.dist_id', $this->dist_id);
        $this->db->where('generals.form_id', 3);
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            //$order = $this->order;
            $this->db->order_by('generals.date', 'desc');
        }
    }
    private function _get_journal_datatables_query() {

        $this->db->select("miscellaneous,form.name,generals.generals_id,generals.voucher_no,generals.narration,generals.date,generals.debit");
        $this->db->from("generals");
        $this->db->join('form', 'form.form_id=generals.form_id');
        $this->db->where('generals.dist_id', $this->dist_id);
        $this->db->where('generals.form_id', 1);
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            //$order = $this->order;
            $this->db->order_by('generals.date', 'desc');
        }
    }
    
    private function _get_cusPay_datatables_query() {

        //'moneyreceit.date', 'moneyreceit.receitID', 'moneyreceit.moneyReceitid','moneyreceit.totalPayment','moneyreceit.checkStatus','moneyreceit.paymentType', 'customer.customerID', 'customer.customerName'
        $this->db->select("moneyreceit.date,moneyreceit.receitID,moneyreceit.moneyReceitid,moneyreceit.totalPayment,moneyreceit.checkStatus,moneyreceit.paymentType,customer.customerID,customer.customer_id,customer.customerName");
        $this->db->from("moneyreceit");
        $this->db->join('customer', 'customer.customer_id=moneyreceit.customerid');
        $this->db->where('moneyreceit.dist_id', $this->dist_id);
        $this->db->where('moneyreceit.receiveType', 1);
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            //$order = $this->order;
            $this->db->order_by('moneyreceit.date', 'desc');
        }
    }
    private function _get_supPay_datatables_query() {

        //'moneyreceit.date', 'moneyreceit.receitID', 'moneyreceit.moneyReceitid','moneyreceit.totalPayment','moneyreceit.checkStatus','moneyreceit.paymentType', 'customer.customerID', 'customer.customerName'
        $this->db->select("supplier.sup_id,moneyreceit.date,moneyreceit.receitID,moneyreceit.moneyReceitid,moneyreceit.totalPayment,moneyreceit.checkStatus,moneyreceit.paymentType,supplier.supID,supplier.supName");
        $this->db->from("moneyreceit");
        $this->db->join('supplier', 'supplier.sup_id=moneyreceit.customerid','left');
        $this->db->where('moneyreceit.dist_id', $this->dist_id);
        $this->db->where('moneyreceit.receiveType', 2);
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            //$order = $this->order;
            $this->db->order_by('moneyreceit.date', 'desc');
        }
    }
    private function _get_cus_datatables_query() {

        //'moneyreceit.date', 'moneyreceit.receitID', 'moneyreceit.moneyReceitid','moneyreceit.totalPayment','moneyreceit.checkStatus','moneyreceit.paymentType', 'customer.customerID', 'customer.customerName'
        $this->db->select("*");
        $this->db->from("customer");
        $this->db->where('dist_id', $this->dist_id);
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            //$order = $this->order;
            $this->db->order_by('customer.customer_id', 'desc');
        }
    }
    private function _get_sup_datatables_query() {

        //'moneyreceit.date', 'moneyreceit.receitID', 'moneyreceit.moneyReceitid','moneyreceit.totalPayment','moneyreceit.checkStatus','moneyreceit.paymentType', 'customer.customerID', 'customer.customerName'
        $this->db->select("*");
        $this->db->from("supplier");
        $this->db->where('dist_id', $this->dist_id);
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            //$order = $this->order;
            $this->db->order_by('supplier.sup_id', 'desc');
        }
    }

    
    private function _get_bill_datatables_query() {

        $this->db->select("miscellaneous,generals.customer_id,generals.supplier_id,form.name,generals.generals_id,generals.voucher_no,generals.narration,generals.date,generals.debit,supplier.supID,supplier.supName,customer.customerID,customer.customerName");
        $this->db->from("generals");
        $this->db->join('supplier', 'supplier.sup_id=generals.supplier_id','left');
        $this->db->join('customer', 'customer.customer_id=generals.customer_id','left');
        $this->db->join('form', 'form.form_id=generals.form_id');
        $this->db->where('generals.dist_id', $this->dist_id);
        $this->db->where('generals.form_id', 29);
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            //$order = $this->order;
            $this->db->order_by('generals.date', 'desc');
        }
    }
    
    function get_datatables() {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function get_productCat_datatables() {
        $this->_get_productCat_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function get_datatables_unit() {
        $this->_get_datatables_unit_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function get_product_datatables() {
        $this->_get_product_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function get_sales_datatables() {
        $this->_get_sales_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function get_purchases_datatables() {
        $this->_get_purchases_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function get_payment_datatables() {
        $this->_get_payment_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function get_receive_datatables() {
        $this->_get_receive_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function get_journal_datatables() {
        $this->_get_journal_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function get_bill_datatables() {
        $this->_get_bill_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function get_cusPay_datatables() {
        $this->_get_cusPay_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function get_supPay_datatables() {
        $this->_get_supPay_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function get_cus_datatables() {
        $this->_get_cus_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function get_sup_datatables() {
        $this->_get_sup_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_filtered_productCat() {
        $this->_get_productCat_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_filtered_unit() {
        $this->_get_datatables_unit_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_filtered_product() {
        $this->_get_product_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    

    function count_filtered_sales() {
        $this->_get_sales_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_filtered_purchases() {
        $this->_get_purchases_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_filtered_payment() {
        $this->_get_payment_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_filtered_receive() {
        $this->_get_receive_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_filtered_journal() {
        $this->_get_journal_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_filtered_bill() {
        $this->_get_bill_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_filtered_cusPay() {
        $this->_get_cusPay_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_filtered_supPay() {
        $this->_get_supPay_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_filtered_cus() {
        $this->_get_cus_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_filtered_sup() {
        $this->_get_sup_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function count_all_unit() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function count_all_productCat() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function count_all_product() {
        $this->db->from($this->table);
        $this->db->group_start();
        $this->db->where('product.dist_id', $this->dist_id);
        $this->db->or_where('product.dist_id', 1);
        $this->db->group_end();

        return $this->db->count_all_results();
    }

    public function count_all_sales() {
        $this->db->from($this->table);
        $this->db->where('dist_id', $this->dist_id);
        $this->db->where('form_id', 5);
        return $this->db->count_all_results();
    }

    public function count_all_purchases() {
        $this->db->from($this->table);
        $this->db->where('dist_id', $this->dist_id);
        $this->db->where('form_id', 11);
        return $this->db->count_all_results();
    }
    public function count_all_payment() {
        $this->db->from($this->table);
        $this->db->where('dist_id', $this->dist_id);
        $this->db->where('form_id', 2);
        return $this->db->count_all_results();
    }
    public function count_all_receive() {
        $this->db->from($this->table);
        $this->db->where('dist_id', $this->dist_id);
        $this->db->where('form_id', 3);
        return $this->db->count_all_results();
    }
    public function count_all_journal() {
        $this->db->from($this->table);
        $this->db->where('dist_id', $this->dist_id);
        $this->db->where('form_id', 1);
        return $this->db->count_all_results();
    }
    public function count_all_bill() {
        $this->db->from($this->table);
        $this->db->where('dist_id', $this->dist_id);
        $this->db->where('form_id', 29);
        return $this->db->count_all_results();
    }
    public function count_all_cusPay() {
        $this->db->from($this->table);
        $this->db->where('dist_id', $this->dist_id);
        $this->db->where('receiveType', 1);
        return $this->db->count_all_results();
    }
    public function count_all_supPay() {
        $this->db->from($this->table);
        $this->db->where('dist_id', $this->dist_id);
        $this->db->where('receiveType', 2);
        return $this->db->count_all_results();
    }
    public function count_all_cus() {
        $this->db->from($this->table);
        $this->db->where('dist_id', $this->dist_id);
        return $this->db->count_all_results();
    }
    public function count_all_sup() {
        $this->db->from($this->table);
        $this->db->where('dist_id', $this->dist_id);
        return $this->db->count_all_results();
    }
    function get_product_type_datatables() {
        $this->_get_product_type_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered_product_type() {
        $this->_get_product_type_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_productType() {
        $this->db->from($this->table);
        $this->db->group_start();
        $this->db->where('product_type.dist_id', $this->dist_id);
        $this->db->or_where('product_type.dist_id', 1);
        $this->db->group_end();
        
        $this->db->where('product_type.is_delete', 'N');

        return $this->db->count_all_results();
    }
    private function _get_product_type_datatables_query() {
        $this->db->select("product_type.product_type_name,product_type.product_type_id,product_type.is_active");
        $this->db->from($this->table);
       
        $this->db->group_start();
        $this->db->where('product_type.dist_id', $this->dist_id);
        $this->db->or_where('product_type.dist_id', 1);
        $this->db->group_end();
        
        $this->db->where('product_type.is_delete', 'N');
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            //$order = $this->order;
            $this->db->order_by('product_type.product_type_id', 'desc');
        }
    }
    function get_product_package_datatables() {
        $this->_get_product_package_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered_product_package() {
        $this->_get_product_package_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_product_package_datatables_query() {
        $this->db->select("package.package_id,package.package_name,package.is_active");
        $this->db->from($this->table);

        $this->db->group_start();
        $this->db->where('package.dist_id', $this->dist_id);
        $this->db->or_where('package.dist_id', 1);
        $this->db->group_end();

        $this->db->where('package.is_delete', 'N');
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            //$order = $this->order;
            $this->db->order_by('package.package_id', 'desc');
        }
    }
    public function count_all_productPackage() {
        $this->db->from($this->table);
        $this->db->group_start();
        $this->db->where('package.dist_id', $this->dist_id);
        $this->db->or_where('package.dist_id', 1);
        $this->db->group_end();

        $this->db->where('package.is_delete', 'N');

        return $this->db->count_all_results();
    }

}

?>