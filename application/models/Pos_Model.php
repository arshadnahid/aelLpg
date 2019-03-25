<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pos_Model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();













    }

    public function get_pos_data($pos_id = 36,$dist_id=15) {

        $this->db->select("g.dist_id,g.form_id,g.payType,g.voucher_no,g.customer_id,p.brand_id,g.reference,g.date,g.discount,g.vat,g.debit,g.credit,g.vatAmount,g.narration,c.customerName,s.generals_id,s.category_id,s.unit,s.product_id,s.type,s.quantity,s.rate,s.price,pc.title,p.productName,u.unitTtile,a.name as salesPerson,b.brandName");
        $this->db->from("generals g");
        $this->db->join('customer c', 'c.customer_id=g.customer_id');

        $this->db->join('admin a', 'a.admin_id=g.updated_by');
        $this->db->join('stock s', 'g.generals_id=s.generals_id');
        $this->db->join('productcategory pc', 'pc.category_id=s.category_id');
        $this->db->join('product p', 'p.product_id=s.product_id');
        $this->db->join('brand b', 'p.brand_id=b.brandId');
        $this->db->join('unit u', 'u.unit_id=s.unit','left');

        $this->db->where('g.generals_id', $pos_id);
        $this->db->where('g.form_id', 31);
        $this->db->where('g.dist_id', $dist_id);
        $this->db->where('a.distributor_id', $dist_id);

        $result = $this->db->get()->result();

        return $result;
    }

      public function getSalesPosVoucherList() {
        $this->db->select("form.name,generals.generals_id,generals.voucher_no,generals.narration,generals.date,generals.debit,customer.customerID,customer.customerName,customer.customer_id");
        $this->db->from("generals");
        $this->db->join('customer', 'customer.customer_id=generals.customer_id');
        $this->db->join('form', 'form.form_id=generals.form_id');
        $this->db->where('generals.dist_id', $this->dist_id);
        $this->db->where('generals.form_id', 31);
        $this->db->order_by('generals.date', 'desc');
        $result = $this->db->get()->result();
        return $result;
    }

}
