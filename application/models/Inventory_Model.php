<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inventory_Model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function getImportProduct($distId = null) {
        $this->db->select('*');
        $this->db->from('productimport');
        $this->db->where('productimport.dist_id', $distId);
        $this->db->group_start();
        $this->db->where_in('catId', 0);
        $this->db->or_where_in('brandId', 0);
        $this->db->or_where_in('unitId', 0);
        $this->db->group_end();
        $result = $this->db->get()->result();
        return $result;
    }

    public function getStock($distId, $fromDate, $todate, $catId, $brandId, $stockType) {
        $sql = '';
        if ($catId != 'All' && $brandId == 'All'):
            if ($stockType == 1) :
                $sql = 'WHERE  p.category_id =1 AND   AND p.category_id=' . $catId;
            else:
                $sql = 'WHERE  p.category_id !=1 AND p.category_id=' . $catId;
            endif; //inner if end
        elseif ($catId == 'All' && $brandId != 'All'):
            if ($stockType == 1):
                $sql = 'WHERE p.category_id =1 AND p.brand_id=' . $brandId;
            else:
                $sql = 'WHERE p.category_id !=1 AND p.brand_id=' . $brandId;
            endif; //inner if end
        elseif ($catId != 'All' && $brandId != 'All'):
            if ($stockType == 1):
                $sql = 'WHERE  p.category_id =1 AND p.brand_id= ' . $brandId . ' AND p.category_id=' . $catId;
            else:
                $sql = 'WHERE  p.category_id !=1 AND p.brand_id= ' . $brandId . ' AND p.category_id=' . $catId;
            endif; //inner if end
        else:
            if ($stockType == 1):
                $sql = 'WHERE p.category_id =1';
            else:
                $sql = 'WHERE p.category_id !=1';
            endif; //inner if end
        endif;
        $query = "SELECT c.title as pCateogry,p.product_id,p.productName,p.product_code,b.brandName,tab1.product_id,
tab1.opStockIn,
tab2.opStockOut ,
tab3.opStockIn as currentStockIn,
tab4.opStockOut as currentStockOut ,
tab5.avgPurPrice,
tab6.avgSalePrice
FROM product p
LEFT JOIN
brand b ON b.brandId=p.brand_id
LEFT JOIN
productcategory c ON c.category_id=p.category_id
left JOIN
	(SELECT SUM(s.quantity) as opStockIn,s.product_id ,s.type
	 FROM stock s
	WHERE s.date < '$fromDate'
	AND s.type='In'
        AND s.dist_id='$distId'
	GROUP BY s.product_id ) tab1
ON tab1.product_id=p.product_id
left JOIN
	(SELECT SUM(s1.quantity) as opStockOut,s1.product_id
	 FROM stock s1
	WHERE s1.date < '$fromDate'
	AND s1.type='Out'
        AND s1.dist_id='$distId'
	GROUP BY s1.product_id )
tab2
ON tab2.product_id=p.product_id
LEFT JOIN
(SELECT SUM(s.quantity) as opStockIn,s.product_id ,s.type
	 FROM stock s
	WHERE s.date >='$fromDate'  AND s.date <='$todate'
	AND s.type='In'
        AND s.dist_id='$distId'
	GROUP BY s.product_id ) tab3
ON tab3.product_id=p.product_id
LEFT JOIN
	(SELECT SUM(s1.quantity) as opStockOut,s1.product_id
	 FROM stock s1
	WHERE s1.date >='$fromDate'  AND s1.date <='$todate'
	AND s1.type='Out'
        AND s1.dist_id='$distId'
	GROUP BY s1.product_id )
tab4
ON tab4.product_id=p.product_id
LEFT JOIN
	(SELECT SUM(s1.price)/SUM(s1.quantity) as avgPurPrice,s1.product_id
	 FROM stock s1
	WHERE s1.type='In'
        AND  s1.dist_id='$distId'
	GROUP BY s1.product_id )
tab5
ON tab5.product_id=p.product_id
LEFT JOIN
	(SELECT SUM(s1.price)/SUM(s1.quantity) as avgSalePrice,s1.product_id
	 FROM stock s1
	WHERE s1.type='Out'
        AND  s1.dist_id='$distId'
	GROUP BY s1.product_id )
tab6
ON tab6.product_id=p.product_id
        $sql  GROUP BY p.product_id";
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }

    public function getCusSupProductSummary($type, $cusSumId, $productId, $fromDate, $todate, $distId) {
        if ($productId == 'all') {
            $pSql = 'GROUP BY p.product_id';
        } else {
            $pSql = 'WHERE  p.product_id=' . $productId;
        }
        if ($type == 2) {
            if ($productId == 'all') {
                $sql = 'AND  s.dist_id=' . $distId . ' AND s.customerId=' . $cusSumId . ' GROUP BY s.product_id';
            } else {
                $sql = 'AND  s.dist_id=' . $distId . ' AND s.customerId=' . $cusSumId . ' AND s.product_id=' . $productId;
            }
        } else {
            if ($productId == 'all') {
                $sql = 'AND  s.dist_id=' . $distId . ' AND s.supplierId=' . $cusSumId . ' GROUP BY s.product_id';
            } else {
                $sql = 'AND  s.dist_id=' . $distId . ' AND s.supplierId=' . $cusSumId . ' AND s.product_id=' . $productId;
            }
        }
        $query = "SELECT p.product_id,p.productName,p.product_code,b.brandName,tab1.product_id,
tab1.opStockIn,
tab2.opStockOut,
tab3.currentStockIn,
tab4.currentStockOut
FROM product p
LEFT JOIN
brand b ON b.brandId=p.brand_id
left JOIN
	(SELECT SUM(s.quantity) as opStockIn,s.product_id ,s.type
	 FROM stock s
	 WHERE s.date < '$fromDate'
	AND s.type='Cin'
        $sql) tab1
ON tab1.product_id=p.product_id
left JOIN
	(SELECT SUM(s.quantity) as opStockOut,s.product_id ,s.type
	 FROM stock s
	 WHERE s.date < '$fromDate'
	AND s.type='Cout'
        $sql)
tab2
ON tab2.product_id=p.product_id
LEFT JOIN
(SELECT SUM(s.quantity) as currentStockIn,s.product_id ,s.type
	 FROM stock s
	 WHERE s.date >= '$fromDate'
	 AND s.date <= '$todate'
	AND s.type='Cin'
        $sql)
tab3
ON tab3.product_id=p.product_id
LEFT JOIN
	(SELECT SUM(s.quantity) as currentStockOut,s.product_id ,s.type
	 FROM stock s
	 WHERE s.date >= '$fromDate'
	 AND s.date <= '$todate'
	AND s.type='Cout'
       $sql)
tab4
ON tab4.product_id=p.product_id
         $pSql";
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }
    public function cylinder_stock_report($start_date, $end_date,  $brandId){
        $query="SELECT
                brand.brandId,
                brand.brandName,
                IFNULL(purchase_refill_qty_table.purchase_refill_qty,0) as purchase_refill_qty,
                IFNULL(purchase_empty_qty_table.purchase_empty_qty,0) as purchase_empty_qty,
                IFNULL(purchase_refill_qty_table.purchase_returnable_quantity,0) as purchase_returnable_quantity,
                IFNULL(purchase_refill_qty_table.purchase_return_quentity,0) as purchase_return_quentity,
                IFNULL(purchase_refill_qty_table.purchase_supplier_due,0) as purchase_supplier_due,
                IFNULL(purchase_refill_qty_table.purchase_supplier_advance,0) as purchase_supplier_advance,
                IFNULL(sales_refill_qty_table.sales_refill_qty,0) as sales_refill_qty,
                IFNULL(sales_empty_qty_table.sales_empty_qty,0) as sales_empty_qty,
                IFNULL(sales_refill_qty_table.sales_returnable_quantity,0) as sales_returnable_quantity,
                IFNULL(sales_refill_qty_table.sales_return_quentity,0) as sales_return_quentity,
                IFNULL(sales_refill_qty_table.sales_customer_due,0) as sales_customer_due,
                IFNULL(sales_refill_qty_table.sales_customer_advance,0) as sales_customer_advance
            FROM
                brand
            LEFT JOIN(
                SELECT
                    product.product_id,
                    product.brand_id,
                    SUM(IFNULL(purchase_details.quantity,0)) AS purchase_refill_qty,
                    SUM(IFNULL(purchase_details.returnable_quantity,0))AS purchase_returnable_quantity,
                    SUM(IFNULL(purchase_details.return_quentity,0))AS purchase_return_quentity,
                    SUM(IFNULL(purchase_details.supplier_due,0))AS purchase_supplier_due,
                    SUM(IFNULL(purchase_details.supplier_advance,0))AS purchase_supplier_advance,
                    product.category_id
                FROM
                    product
                LEFT JOIN purchase_details ON purchase_details.product_id = product.product_id
                WHERE
                    product.category_id = 2
                GROUP BY
                    product.brand_id
            )AS purchase_refill_qty_table ON purchase_refill_qty_table.brand_id =brand.brandId
            AND purchase_refill_qty_table.category_id = 2
            LEFT JOIN(
                SELECT
                    product.brand_id,
                    product.category_id,
                    (SUM(IFNULL(purchase_details.quantity,0))- IFNULL(SUM(purchase_return_details.return_quantity),0))AS purchase_empty_qty
                FROM
                    product
                LEFT JOIN purchase_details ON purchase_details.product_id = product.product_id
                AND purchase_details.is_package = 0
                LEFT JOIN purchase_return_details ON purchase_return_details.product_id = product.product_id
                WHERE
                    product.category_id = 1
                GROUP BY
                    product.brand_id
            )AS purchase_empty_qty_table ON purchase_empty_qty_table.brand_id = brand.brandId
            AND purchase_empty_qty_table.category_id = 1
            LEFT JOIN(
                SELECT
                    product.product_id,
                    product.brand_id,
                    SUM(IFNULL(sales_details.quantity,0)) AS sales_refill_qty,
                    SUM(IFNULL(sales_details.returnable_quantity,0))AS sales_returnable_quantity,
                    SUM(IFNULL(sales_details.return_quentity,0))AS sales_return_quentity,
                    SUM(IFNULL(sales_details.customer_due,0))AS sales_customer_due,
                    SUM(IFNULL(sales_details.customer_advance,0))AS sales_customer_advance,
                    product.category_id
                FROM
                    product
                LEFT JOIN sales_details ON sales_details.product_id = product.product_id
                WHERE
                    product.category_id = 2
                GROUP BY
                    product.brand_id
            )AS sales_refill_qty_table ON sales_refill_qty_table.brand_id =brand.brandId
            AND sales_refill_qty_table.category_id = 2
            LEFT JOIN(
                SELECT
                    product.brand_id,
                    product.category_id,
                    (SUM(IFNULL(sales_details.quantity,0))- IFNULL(SUM(sales_return_details.return_quantity),0))AS sales_empty_qty
                FROM
                    product
                LEFT JOIN sales_details ON sales_details.product_id = product.product_id
                AND sales_details.is_package = 0
                LEFT JOIN sales_return_details ON sales_return_details.product_id = product.product_id
                WHERE
                    product.category_id = 1
                GROUP BY
                    product.brand_id
            )AS sales_empty_qty_table ON sales_empty_qty_table.brand_id = brand.brandId
            AND sales_empty_qty_table.category_id = 1";
        if($brandId !='0'){
            $query.=" WHERE brand.brandId=".$brandId;
        }

        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }
    public function cylinder_stock_group_report($start_date, $end_date,  $brandId){
        $query="SELECT
                brand.brandId,
                brand.brandName,
                product.productName,
                unit.unitTtile,
                IFNULL(purchase_refill_qty_table.purchase_refill_qty,0)AS purchase_refill_qty,
                IFNULL(purchase_refill_qty_table.purchase_returnable_quantity,0)AS purchase_returnable_quantity,
                IFNULL(purchase_refill_qty_table.purchase_return_quentity,0)AS purchase_return_quentity,
                IFNULL(purchase_refill_qty_table.purchase_supplier_due,0)AS purchase_supplier_due,
                IFNULL(purchase_refill_qty_table.purchase_supplier_advance,	0)AS purchase_supplier_advance,
              IFNULL(purchase_empty_qty_table.purchase_empty_qty,0)AS purchase_empty_qty,
              IFNULL(sales_refill_qty_table.sales_refill_qty,	0	)AS sales_refill_qty,
                IFNULL(sales_empty_qty_table.sales_empty_qty,0)AS sales_empty_qty,
                IFNULL(sales_refill_qty_table.sales_returnable_quantity,0	)AS sales_returnable_quantity,
                IFNULL(sales_refill_qty_table.sales_return_quentity,0	)AS sales_return_quentity,
                IFNULL(sales_refill_qty_table.sales_customer_due,0	)AS sales_customer_due,
                IFNULL(sales_refill_qty_table.sales_customer_advance,	0	)AS sales_customer_advance
            FROM
                brand
            LEFT JOIN product ON product.brand_id = brand.brandId
            LEFT JOIN unit ON unit.unit_id=product.unit_id
            LEFT JOIN(
                SELECT
                    product.product_id,
                    product.brand_id,
                    product.productName,
                    SUM(IFNULL(	purchase_details.quantity,0))AS purchase_refill_qty,
                    SUM(IFNULL(purchase_details.returnable_quantity,0))AS purchase_returnable_quantity,
                    SUM(IFNULL(purchase_details.return_quentity,0))AS purchase_return_quentity,
                    SUM(IFNULL(purchase_details.supplier_due,0))AS purchase_supplier_due,
                    SUM(IFNULL(purchase_details.supplier_advance,0))AS purchase_supplier_advance,
                    product.category_id
                FROM
                    product
                LEFT JOIN purchase_details ON purchase_details.product_id = product.product_id
                WHERE
                    product.category_id = 2
                GROUP BY
                    product.brand_id,
                    product.productName
            )AS purchase_refill_qty_table ON purchase_refill_qty_table.brand_id = brand.brandId
            AND purchase_refill_qty_table.productName = product.productName
            AND purchase_refill_qty_table.category_id = 2
            LEFT JOIN(SELECT
                    product.brand_id,
                    product.category_id,
                product.productName,
                    (SUM(IFNULL(purchase_details.quantity,0))- IFNULL(SUM(purchase_return_details.return_quantity),0))AS purchase_empty_qty
                FROM
                    product
                LEFT JOIN purchase_details ON purchase_details.product_id = product.product_id
                AND purchase_details.is_package = 0
                LEFT JOIN purchase_return_details ON purchase_return_details.product_id = product.product_id
                WHERE
                    product.category_id = 1
                GROUP BY
                    product.brand_id,
                    product.productName
            )AS purchase_empty_qty_table ON purchase_empty_qty_table.brand_id = brand.brandId
            AND purchase_empty_qty_table.productName = product.productName
            AND purchase_empty_qty_table.category_id = 1
            LEFT JOIN(
            SELECT
                    product.product_id,
                    product.brand_id,
                product.productName,
                    SUM(IFNULL(sales_details.quantity, 0))AS sales_refill_qty,
                    SUM(IFNULL(sales_details.returnable_quantity,0))AS sales_returnable_quantity,
                    SUM(IFNULL(sales_details.return_quentity,	0))AS sales_return_quentity,
                    SUM(IFNULL(sales_details.customer_due,0))AS sales_customer_due,
                    SUM(IFNULL(sales_details.customer_advance,0))AS sales_customer_advance,
                    product.category_id
                FROM
                    product
                LEFT JOIN sales_details ON sales_details.product_id = product.product_id
                WHERE
                    product.category_id = 2
                GROUP BY
                    product.brand_id,
                    product.productName
            
            )AS sales_refill_qty_table ON sales_refill_qty_table.brand_id = brand.brandId
            AND sales_refill_qty_table.productName = product.productName
            AND sales_refill_qty_table.category_id = 2
            LEFT JOIN(
                SELECT
                    product.brand_id,
                    product.category_id,
                product.productName,
                    (SUM(IFNULL(sales_details.quantity, 0))- IFNULL(SUM(sales_return_details.return_quantity),0))AS sales_empty_qty
                FROM
                    product
                LEFT JOIN sales_details ON sales_details.product_id = product.product_id
                AND sales_details.is_package = 0
                LEFT JOIN sales_return_details ON sales_return_details.product_id = product.product_id
                WHERE
                    product.category_id = 1
                GROUP BY
                    product.brand_id,
                    product.productName
            )AS sales_empty_qty_table ON sales_empty_qty_table.brand_id = brand.brandId
            AND sales_empty_qty_table.productName = product.productName
            AND sales_empty_qty_table.category_id = 1
            WHERE
                brand.dist_id = 1
            GROUP BY
                product.brand_id,
                product.productName
            ORDER BY brand.brandId,product.productName";
        if($brandId !='0'){
            $query.=" WHERE brand.brandId=".$brandId;
        }
        //log_message('error','cylinder_stock_report query'.print_r($query,true));
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }
    public function checkOpenigValid($distId) {
        $this->db->select("sum(credit) as totalAmount");
        $this->db->from("opening_balance");
        $this->db->where('dist_id', $distId);
        $result = $this->db->get()->row();
        if (!empty($result->totalAmount)):
            return $result->totalAmount;
        else:
            return 0;
        endif;
    }

    public function getProductLedger($fromDate, $toDate, $productId, $distId) {
        $this->db->select("generals.voucher_no,stock.type,brand.brandName,productcategory.title,product.productName,product.product_code,stock.quantity,stock.date,customer.customerName,supplier.supName");
        $this->db->from("stock");
        $this->db->join('generals', 'generals.generals_id=stock.generals_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id=stock.category_id', 'left');
        $this->db->join('product', 'product.product_id=stock.product_id', 'left');
        $this->db->join('supplier', 'supplier.sup_id=generals.supplier_id', 'left');
        $this->db->join('customer', 'customer.customer_id=generals.customer_id', 'left');
        $this->db->join('brand', 'brand.brandId=product.brand_id', 'left');
        $this->db->where('stock.dist_id', $distId);
        if (!empty($productId) && $productId != 'all') {
            $this->db->where('stock.product_id', $productId);
        }
        $this->db->where('stock.date >=', $fromDate);
        $this->db->where('stock.date <=', $toDate);
        $this->db->where('stock.form_id !=', 10);
        $this->db->order_by('stock.date', 'asc');
        $this->db->where_in('stock.type', array('In', 'Out'));
        $ledgerReport = $this->db->get()->result();
        return $ledgerReport;
    }

    public function getProductLedgerOpening($fromDate, $toDate, $productId, $distId) {
        $this->db->select("sum(stock.quantity) as totalIn");
        $this->db->from("stock");
        $this->db->where('stock.dist_id', $distId);
        if (!empty($productId) && $productId != 'all') {
            $this->db->where('stock.product_id', $productId);
        }
        $this->db->where('stock.date <', $fromDate);
        $this->db->where('stock.form_id !=', 10);
        $this->db->where('stock.type', 'In');
        $ledgerIn = $this->db->get()->row();

        $this->db->select("sum(stock.quantity) as totalOut");
        $this->db->from("stock");
        $this->db->where('stock.dist_id', $distId);
        if (!empty($productId) && $productId != 'all') {
            $this->db->where('stock.product_id', $productId);
        }
        $this->db->where('stock.date <', $fromDate);
        $this->db->where('stock.form_id !=', 10);
        $this->db->where('stock.type', 'Out');
        $ledgerOut = $this->db->get()->row();
        return $ledgerIn->totalIn - $ledgerOut->totalOut;
    }

    public function checkProductFormate($productFormate, $disttId) {
        $this->db->select("*");
        $this->db->from("product");
        $this->db->where('category_id', $productFormate[1]);
        $this->db->where('product_id', $productFormate[2]);
        $this->db->group_start();
        $this->db->where('dist_id', $disttId);
        $this->db->or_where('dist_id', 1);
        $this->db->group_end();
        $exits = $this->db->get()->row();
        if (!empty($exits)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getPaymentDueSupplierCustomer($distId, $supCus) {
        if ($supCus == 1) {
            $this->db->select("sum(dr - cr) as totalDue,customer.customer_id,customer.customerID,customer.customerName");
            $this->db->from("client_vendor_ledger");
            $this->db->join('customer', 'customer.customer_id=client_vendor_ledger.client_vendor_id', 'left');
            $this->db->where('client_vendor_ledger.dist_id', $distId);
            $this->db->where('client_vendor_ledger.ledger_type', $supCus);
            $this->db->group_by('customer.customer_id');
            $this->db->having('sum(dr - cr) > ', 0);
            $ledgerReport = $this->db->get()->result();
            return $ledgerReport;
        } else {
            $this->db->select("sum(dr - cr) as totalDue,supplier.sup_id,supplier.supID,supplier.supName");
            $this->db->from("client_vendor_ledger");
            $this->db->join('supplier', 'supplier.sup_id=client_vendor_ledger.client_vendor_id', 'left');
            $this->db->where('client_vendor_ledger.dist_id', $distId);
            $this->db->where('client_vendor_ledger.ledger_type', $supCus);
            $this->db->group_by('supplier.sup_id');
            $this->db->having('sum(dr - cr) > ', 0);
            $ledgerReport = $this->db->get()->result();
            return $ledgerReport;
        }
    }

    function getCylinderLedger($distId, $fromDate, $toDate) {
        $this->db->select("generals.voucher_no,stock.type,brand.brandName,productcategory.title,product.productName,product.product_code,stock.quantity,stock.date,customer.customerName,supplier.supName");
        $this->db->from("stock");
        $this->db->join('generals', 'generals.generals_id=stock.generals_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id=stock.category_id', 'left');
        $this->db->join('product', 'product.product_id=stock.product_id', 'left');
        $this->db->join('supplier', 'supplier.sup_id=generals.supplier_id', 'left');
        $this->db->join('customer', 'customer.customer_id=generals.customer_id', 'left');
        $this->db->join('brand', 'brand.brandId=product.brand_id', 'left');
        $this->db->where('stock.dist_id', $distId);
        $this->db->where('stock.date >=', $fromDate);
        $this->db->where('stock.date <=', $toDate);
        $this->db->where('stock.form_id !=', 10);
        $this->db->order_by('stock.date', 'asc');
        $this->db->where_in('stock.type', array('Cin', 'Cout'));
        $ledgerReport = $this->db->get()->result();
        return $ledgerReport;
    }

    function getSupplierClosingBalance($distId, $supplierId) {
        $this->db->select("sum(dr) - sum(cr) as totalCurrentBalance");
        $this->db->from("client_vendor_ledger");
        $this->db->where('dist_id', $distId);
        $this->db->where('ledger_type', 2);
        $this->db->where('client_vendor_id', $supplierId);
        $result = $this->db->get()->row();
        return $result->totalCurrentBalance;
    }

    function getPurchasesList() {
        $this->db->select("form.name,generals.generals_id,generals.voucher_no,generals.narration,generals.date,generals.debit,supplier.supID,supplier.supName,supplier.sup_id,supplier.sup_id");
        $this->db->from("generals");
        $this->db->join('supplier', 'supplier.sup_id=generals.supplier_id');
        $this->db->join('form', 'form.form_id=generals.form_id');
        $this->db->where('generals.dist_id', $this->dist_id);
        $this->db->where('generals.form_id', 11);
        $this->db->order_by('generals.date', 'desc');
        $result = $this->db->get()->result();
        return $result;
    }

    function getCreditAmount($invoiceId) {
        $this->db->select("credit,generals_id,");
        $this->db->from("generals");
        $this->db->where("mainInvoiceId", $invoiceId);
        $this->db->where("form_id", 14);
        $this->db->where('dist_id', $this->dist_id);
        $creditAmount = $this->db->get()->row();
        if (!empty($creditAmount)) {
            return $creditAmount;
        }
    }

    function getPurchasesAccountId($invoiceId) {
        $this->db->select("account");
        $this->db->from("generalledger");
        $this->db->where("generals_id", $invoiceId);
        $this->db->where("form_id", 14);
        $this->db->where("credit >=", '1');
        $this->db->where('dist_id', $this->dist_id);
        $this->db->order_by('generalledger_id', 'ASC');
        $creditAccount = $this->db->get()->row();

        if (!empty($creditAccount->account)) {
            return $creditAccount->account;
        }
    }

    function getReturnAbleCylinder($distId, $invoiceId, $productId) {
        $this->db->select("generals_id");
        $this->db->from("generals");
        $this->db->where("dist_id", $distId);
        //form Id 24 means cylinder receive,form Id 23 means cylinder out
        $this->db->where("form_id", 24);
        $this->db->where("mainInvoiceId", $invoiceId);
        $generalId = $this->db->get()->row();
        if (!empty($generalId)) {
            $this->db->select('stock.quantity');
            $this->db->from('stock');
            $this->db->join('productcategory', 'stock.category_id = productcategory.category_id');
            $this->db->join('product', 'stock.product_id = product.product_id');
            $this->db->join('unit', 'stock.unit = unit.unit_id');
            $this->db->join('brand', 'product.brand_id = brand.brandId');
            $this->db->where('stock.dist_id', $distId);
            $this->db->where('stock.type', 'Cin');
            $this->db->where('stock.product_id', $productId);
            //type 24 means cylinder receive,type 23 means cylinder out
            $this->db->where('stock.form_id', 24);
            $this->db->where('stock.generals_id', $generalId->generals_id);
            $cylinderInOutResult = $this->db->get()->row();
            return $cylinderInOutResult;
        }
    }

    function getReturnAbleCylinder2($distId, $invoiceId, $productId) {
        $this->db->select("quantity");
        $this->db->from("stock");
        $this->db->where("dist_id", $distId);
        //form Id 24 means cylinder receive,form Id 23 means cylinder out
        $this->db->where("form_id", 24);
        $this->db->where("product_id", $productId);
        $this->db->where("generals_id", $invoiceId);
        $generalId = $this->db->get()->row();
        return $generalId;
//        if (!empty($generalId)) {
//            $this->db->select('stock.quantity');
//            $this->db->from('stock');
//            $this->db->join('productcategory', 'stock.category_id = productcategory.category_id');
//            $this->db->join('product', 'stock.product_id = product.product_id');
//            $this->db->join('unit', 'stock.unit = unit.unit_id');
//            $this->db->join('brand', 'product.brand_id = brand.brandId');
//            $this->db->where('stock.dist_id', $distId);
//            $this->db->where('stock.type', 'Cin');
//            $this->db->where('stock.product_id', $productId);
//            //type 24 means cylinder receive,type 23 means cylinder out
//            $this->db->where('stock.form_id', 24);
//            $this->db->where('stock.generals_id', $generalId->generals_id);
//            $cylinderInOutResult = $this->db->get()->row();
//            return $cylinderInOutResult;
//        }
    }

    function getVoucherIdByGeneralId($generalId) {
        $voucehrInfo = $this->db->get_where('generals', array('generals_id' => $generalId))->row();
        if (!empty($voucehrInfo)) {
            return $voucehrInfo->voucher_no;
        } else {
            return 0;
        }
    }

    function getCustomerOrSupplierIdByGeneralId($generalId) {
        $voucherInfo = $this->db->get_where('generals', array('generals_id' => $generalId))->row();
        if (!empty($voucherInfo->customer_id)) {
            $customerInfo = $this->db->get_where('customer', array('customer_id' => $voucherInfo->customer_id))->row();
            if (!empty($customerInfo)) {
                return $customerInfo->customerID . ' [ ' . $customerInfo->customerName . ' ] ';
            } else {
                return 0;
            }
        } elseif (!empty($voucherInfo->supplier_id)) {
            $supplierInfo = $this->db->get_where('supplier', array('sup_id' => $voucherInfo->supplier_id))->row();
            if (!empty($supplierInfo)) {
                return $supplierInfo->supID . ' [ ' . $supplierInfo->supName . ' ] ';
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function getProductSummationReport($dist_id, $productid, $startDate, $endDate) {
        $this->db->select("sum(stock.quantity) as totalQty,avg(stock.rate) as totalAvgRate,product.productName,brand.brandName");
        $this->db->from("stock");
        $this->db->join('product', 'product.product_id=stock.product_id');
        $this->db->join('brand', 'brand.brandId=product.brand_id');
        //$this->db->join('supplier', 'supplier.sup_id=generals.supplier_id');
        $this->db->where("stock.product_id", $productid);
        $this->db->where("stock.type", "In");
        $this->db->where('stock.date >=', $startDate);
        $this->db->where('stock.date <=', $endDate);
        $this->db->where("stock.dist_id", $dist_id);
        $totalStockIn = $this->db->get()->row();
        return $totalStockIn;
    }

    function getProductWiseSalesReport($dist_id, $productid, $startDate, $endDate) {
        $this->db->select("*");
        $this->db->from("stock");
        //$this->db->join('generals', 'generals.generals_id=stock.generals_id');
        //$this->db->join('supplier', 'supplier.sup_id=generals.supplier_id');
        $this->db->where("stock.product_id", $productid);
        $this->db->where("stock.type", "In");
        $this->db->where('stock.date >=', $startDate);
        $this->db->where('stock.date <=', $endDate);
        $this->db->where("stock.dist_id", $dist_id);
        $totalStockIn = $this->db->get()->result();
        return $totalStockIn;
    }

    function generals_supplier($supplier_id) {
        $query = $this->db->get_where('generals', array('form_id' => 11, 'supplier_id' => $supplier_id));
        return $query->result_array();
    }

    function generals_voucher($voucher_no) {
        $dr = '';
        $cr = '';
        $query = $this->db->get_where('generals', array('voucher_no' => $voucher_no, 'dist_id' => $this->dist_id))->result_array();
        foreach ($query as $row) {
            $dr += $row['debit'];
            $cr += $row['credit'];
        }
        $bal = $dr - $cr;
        return $bal;
    }

    public function getStockReport($startDate, $endDate, $productid, $brandId, $distributor = null) {
        if (!empty($distributor)):
            $distID = $distributor;
        else:
            $distID = $this->dist_id;
        endif;
        //openingStock
        $this->db->select('avg(stock.rate) totalAvgSalesPrice');
        $this->db->from('stock');
        $this->db->join('product', 'stock.product_id = product.product_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = stock.category_id', 'left');
        $this->db->where('stock.type', 'Out');
        $this->db->where('stock.dist_id', $distID);
        if ($brandId != 'All') {
            $this->db->where('product.brand_id', $brandId);
        }
        $this->db->where('stock.product_id', $productid);
        $this->db->order_by('stock.category_id', 'ASC');
        $openingAvgSalesPrice = $this->db->get()->row_array();
        $data['totalAvgSalesPrice'] = $openingAvgSalesPrice['totalAvgSalesPrice'];
        $this->db->select('avg(stock.rate) totalAvgPusPrice');
        $this->db->from('stock');
        $this->db->join('product', 'stock.product_id = product.product_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = stock.category_id', 'left');
        $this->db->where('stock.type', 'In');
        if ($brandId != 'All') {
            $this->db->where('product.brand_id', $brandId);
        }
        $this->db->where('stock.dist_id', $distID);
        $this->db->where('stock.product_id', $productid);
        $this->db->order_by('stock.category_id', 'ASC');
        $openingAvgPurcPrice = $this->db->get()->row_array();
        $data['totalAvgPurcPrice'] = $openingAvgPurcPrice['totalAvgPusPrice'];
        $this->db->select('product.product_id,product.category_id,product.productName,product.product_code,productcategory.title as catName,sum(stock.quantity) as totalOpeQty,avg(stock.rate) totalAvgOpePusPrice,');
        $this->db->from('stock');
        $this->db->join('product', 'stock.product_id = product.product_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = stock.category_id', 'left');
        $this->db->where('stock.type', 'In');
        if ($brandId != 'All') {
            $this->db->where('product.brand_id', $brandId);
        }
        $this->db->where('stock.openingStatus', 1);
        $this->db->where('stock.dist_id', $distID);
        $this->db->where('stock.product_id', $productid);
        $this->db->order_by('stock.category_id', 'ASC');
        $data['mainOpeningStock'] = $this->db->get()->row_array();
        $this->db->select('product.product_id,product.category_id,product.productName,product.product_code,productcategory.title as catName,sum(stock.quantity) as totalOpeQty,avg(stock.rate) totalAvgOpePusPrice,');
        $this->db->from('stock');
        $this->db->join('product', 'stock.product_id = product.product_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = stock.category_id', 'left');
        $this->db->where('date <', $startDate);
        if ($brandId != 'All') {
            $this->db->where('product.brand_id', $brandId);
        }
        $this->db->where('stock.type', 'In');
        $this->db->where('stock.openingStatus !=', 1);
        $this->db->where('stock.dist_id', $distID);
        $this->db->where('stock.product_id', $productid);
        $this->db->order_by('stock.category_id', 'ASC');
        $data['openingStock'] = $this->db->get()->row_array();
        $this->db->select('avg(stock.rate) as averagePurchasesPrice,product.product_id,product.category_id,product.productName,product.product_code,productcategory.title as catName,sum(stock.quantity) as totalOpeQty,avg(stock.rate) totalAvgOpePusPrice,');
        $this->db->from('stock');
        $this->db->join('product', 'stock.product_id = product.product_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = stock.category_id', 'left');
        $this->db->where('date <', $startDate);
        if ($brandId != 'All') {
            $this->db->where('product.brand_id', $brandId);
        }
        $this->db->where('stock.type', 'Out');
        $this->db->where('stock.dist_id', $distID);
        $this->db->where('stock.product_id', $productid);
        $this->db->order_by('stock.category_id', 'ASC');
        $data['openingOut'] = $this->db->get()->row_array();
        //purchases stock
        $this->db->select('product.product_id,product.category_id,product.productName,product.product_code,productcategory.title as catName,sum(stock.quantity) as totalPurcQty,avg(stock.rate) totalAvgPusPrice,');
        $this->db->from('stock');
        $this->db->join('product', 'stock.product_id = product.product_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = stock.category_id', 'left');
        $this->db->where('date >=', $startDate);
        $this->db->where('date <=', $endDate);
        if ($brandId != 'All') {
            $this->db->where('product.brand_id', $brandId);
        }
        $this->db->where('stock.type', 'In');
        $this->db->where('stock.openingStatus !=', 1);
        $this->db->where('stock.dist_id', $distID);
        $this->db->where('stock.product_id', $productid);
        $this->db->order_by('stock.category_id', 'ASC');
        $data['purchasesStock'] = $this->db->get()->row_array();
        //Sale Out
        $this->db->select('product.product_id,product.category_id,product.productName,product.product_code,productcategory.title as catName,sum(stock.quantity) as totalSaleQty,avg(stock.rate) totalAvgSalePusPrice,');
        $this->db->from('stock');
        $this->db->join('product', 'stock.product_id = product.product_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = stock.category_id', 'left');
        $this->db->where('date >=', $startDate);
        $this->db->where('date <=', $endDate);
        if ($brandId != 'All') {
            $this->db->where('product.brand_id', $brandId);
        }
        $this->db->where('stock.type', 'Out');
        $this->db->where('stock.dist_id', $distID);
        $this->db->where('stock.product_id', $productid);
        $this->db->order_by('stock.category_id', 'ASC');
        $data['saleStock'] = $this->db->get()->row_array();
        return $data;
    }
    //$type_id, $balance_type, $sub_cus_id, $from_date, $to_date, $this->dist_id
    function getCusSupProductdetails($type_id, $balance_type, $sub_cus_id, $fromDate, $to_date, $distId) {
        $sql = "";
        if ($type_id == 2) {
            //customer
            if ($sub_cus_id != 'all') {
                $sql = "AND subCusTable.customer_id = " . $sub_cus_id;
            }


            $query = "SELECT
                        subCusTable.customer_id,
                        subCusTable.customerID AS subCusId,
                        subCusTable.customerName AS subCusName,
                        s.product_id,
                        s.type,
                        s.quantity,
                        InTable.StockIn,
                        OutTable.StockOut,
                        (
                            InTable.StockIn - OutTable.StockOut
                        ) AS balance,
                        InTable.product_id,
                        productTable.productName,
                        productTable.product_code,
                        productTable.brandName
                    FROM
                        customer subCusTable
                    LEFT JOIN stock s ON
                        s.customerId = subCusTable.customer_id
                                        LEFT JOIN(
                    SELECT p.product_id,
                        p.brand_id,
                        p.category_id,
                        p.productName,
                        p.product_code,
                        b.brandName,
                        pc.title
                    FROM
                        product p
                    LEFT JOIN productcategory pc ON
                        pc.category_id = p.category_id
                    LEFT JOIN brand b ON
                        b.brandId = p.brand_id
                ) AS productTable
                ON
                    productTable.product_id = s.product_id
                    LEFT JOIN(
                        SELECT
                            SUM(s.quantity) AS StockIn,
                            s.product_id,
                            s.type,
                            s.customerId
                        FROM
                            stock s
                        WHERE
                            s.type = 'Cin' AND s.dist_id = " . $distId . "
                        GROUP BY
                            s.product_id,
                            s.customerId
                    ) AS InTable
                    ON
                        InTable.customerId = s.customerId AND InTable.product_id = s.product_id
                    LEFT JOIN(
                        SELECT
                            SUM(s.quantity) AS StockOut,
                            s.product_id,
                            s.type,
                            s.customerId
                        FROM
                            stock s
                        WHERE
                            s.type = 'Cout' AND s.dist_id = " . $distId . "
                        GROUP BY
                            s.product_id,
                            s.customerId
                    ) AS OutTable
                    ON
                        OutTable.customerId = s.customerId AND OutTable.product_id = s.product_id
                    WHERE
                        subCusTable.dist_id = " . $distId . "  " . $sql . " AND  s.date >= '$fromDate' AND s.date <= '$to_date'
                    GROUP BY
                        s.product_id,
                        s.customerId  order  BY subCusTable.customer_id ASC   ";
        }else
         {

            //customer
            if ($sub_cus_id != 'all') {
                $sql = "AND subCusTable.sup_id = " . $sub_cus_id;
            }


            $query = "SELECT
                        subCusTable.sup_id,
                        subCusTable.supID AS subCusId,
                        subCusTable.supName AS subCusName,
                        s.product_id,
                        s.type,
                        s.quantity,
                        InTable.StockIn,
                        OutTable.StockOut,
                        (
                            InTable.StockIn - OutTable.StockOut
                        ) AS balance,
                        InTable.product_id,
                        productTable.productName,
                        productTable.product_code,
                        productTable.brandName
                    FROM
                        supplier subCusTable
                    LEFT JOIN stock s ON
                        s.supplierId = subCusTable.sup_id
                                        LEFT JOIN(
                    SELECT p.product_id,
                        p.brand_id,
                        p.category_id,
                        p.productName,
                        p.product_code,
                        b.brandName,
                        pc.title
                    FROM
                        product p
                    LEFT JOIN productcategory pc ON
                        pc.category_id = p.category_id
                    LEFT JOIN brand b ON
                        b.brandId = p.brand_id
                ) AS productTable
                ON
                    productTable.product_id = s.product_id
                    LEFT JOIN(
                        SELECT
                            SUM(s.quantity) AS StockIn,
                            s.product_id,
                            s.type,
                            s.supplierId
                        FROM
                            stock s
                        WHERE
                            s.type = 'Cin' AND s.dist_id = " . $distId . "
                        GROUP BY
                            s.product_id,
                            s.supplierId
                    ) AS InTable
                    ON
                        InTable.supplierId = s.supplierId AND InTable.product_id = s.product_id
                    LEFT JOIN(
                        SELECT
                            SUM(s.quantity) AS StockOut,
                            s.product_id,
                            s.type,
                            s.supplierId
                        FROM
                            stock s
                        WHERE
                            s.type = 'Cout' AND s.dist_id = " . $distId . "
                        GROUP BY
                            s.product_id,
                            s.supplierId
                    ) AS OutTable
                    ON
                        OutTable.supplierId = s.supplierId AND OutTable.product_id = s.product_id
                    WHERE
                        subCusTable.dist_id = " . $distId . "  " . $sql . " AND  s.date >= '$fromDate' AND s.date <= '$to_date'
                    GROUP BY
                        s.product_id,
                        s.customerId  order  BY subCusTable.sup_id ASC   ";
        }
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }
    function sales_report_brand_wise($start_date, $end_date,  $brandId) {


                                    $query = "SELECT
                            brand.brandId,
                            brand.brandName,
                            product.productName,
                           CAST(product.productName AS UNSIGNED) as p_name,
                          unit.unitTtile,
                          IFNULL(sales_package_qty_table.sales_package_qty,	0	)AS sales_package_qty,
                          IFNULL(sales_refill_qty_table.sales_refill_qty,	0	)AS sales_refill_qty,
                            IFNULL(sales_empty_qty_table.sales_empty_qty,0)AS sales_empty_qty,
                            IFNULL(sales_refill_qty_table.sales_returnable_quantity,0	)AS sales_returnable_quantity,
                            IFNULL(sales_refill_qty_table.sales_return_quentity,0	)AS sales_return_quentity,
                            IFNULL(sales_refill_qty_table.sales_customer_due,0	)AS sales_customer_due,
                            IFNULL(sales_refill_qty_table.sales_customer_advance,	0	)AS sales_customer_advance
                        FROM
                            brand
                        LEFT JOIN product ON product.brand_id = brand.brandId
                        LEFT JOIN unit ON unit.unit_id=product.unit_id
                        LEFT JOIN(
                        SELECT
                                product.product_id,
                                product.brand_id,
                                product.productName, 
                                sales_details.insert_date,
                                SUM(IFNULL(sales_details.quantity, 0))AS sales_package_qty,
                                SUM(IFNULL(sales_details.returnable_quantity,0))AS sales_returnable_quantity,
                                SUM(IFNULL(sales_details.return_quentity,	0))AS sales_return_quentity,
                                SUM(IFNULL(sales_details.customer_due,0))AS sales_customer_due,
                                SUM(IFNULL(sales_details.customer_advance,0))AS sales_customer_advance,
                                product.category_id
                            FROM
                                product
                            LEFT JOIN sales_details ON sales_details.product_id = product.product_id
                            LEFT JOIN sales_invoice_info on sales_invoice_info.sales_invoice_id=sales_details.sales_invoice_id
                        
                            WHERE
                                product.category_id = 2
                        AND sales_details.is_package = 1
                        AND sales_invoice_info.invoice_date > '" . $start_date . "'
                        AND sales_invoice_info.invoice_date < '" . $end_date . "'
                            GROUP BY
                                product.brand_id,
                                product.productName
                        
                        )AS sales_package_qty_table ON sales_package_qty_table.brand_id = brand.brandId
                        AND sales_package_qty_table.productName = product.productName
                        AND sales_package_qty_table.category_id = 2
                        LEFT JOIN(
                        SELECT
                                product.product_id,
                                product.brand_id,
                            product.productName,
                                SUM(IFNULL(sales_details.quantity, 0))AS sales_refill_qty,
                                SUM(IFNULL(sales_details.returnable_quantity,0))AS sales_returnable_quantity,
                                SUM(IFNULL(sales_details.return_quentity,	0))AS sales_return_quentity,
                                SUM(IFNULL(sales_details.customer_due,0))AS sales_customer_due,
                                SUM(IFNULL(sales_details.customer_advance,0))AS sales_customer_advance,
                                product.category_id
                            FROM
                                product
                            LEFT JOIN sales_details ON sales_details.product_id = product.product_id
                            LEFT JOIN sales_invoice_info on sales_invoice_info.sales_invoice_id=sales_details.sales_invoice_id
                        
                            WHERE
                                product.category_id = 2
                        AND sales_details.is_package = 0
                         AND sales_invoice_info.invoice_date > '" . $start_date . "'
                        AND sales_invoice_info.invoice_date < '" . $end_date . "'
                            GROUP BY
                                product.brand_id,
                                product.productName
                        
                        )AS sales_refill_qty_table ON sales_refill_qty_table.brand_id = brand.brandId
                        AND sales_refill_qty_table.productName = product.productName
                        AND sales_refill_qty_table.category_id = 2
                        LEFT JOIN(
                            SELECT
                                product.brand_id,
                                product.category_id,
                            product.productName,
                                (SUM(IFNULL(sales_details.quantity, 0))- IFNULL(SUM(sales_return_details.return_quantity),0))AS sales_empty_qty
                            FROM
                                product
                            LEFT JOIN sales_details ON sales_details.product_id = product.product_id
                            AND sales_details.is_package = 0
                            LEFT JOIN sales_return_details ON sales_return_details.product_id = product.product_id
                            LEFT JOIN sales_invoice_info on sales_invoice_info.sales_invoice_id=sales_details.sales_invoice_id
                            WHERE
                                product.category_id = 1
                                 AND sales_invoice_info.invoice_date > '" . $start_date . "'
                        AND sales_invoice_info.invoice_date < '" . $end_date . "'
                            GROUP BY
                                product.brand_id,
                                product.productName
                        )AS sales_empty_qty_table ON sales_empty_qty_table.brand_id = brand.brandId
                        AND sales_empty_qty_table.productName = product.productName
                        AND sales_empty_qty_table.category_id = 1
                        WHERE
                            brand.dist_id = 1
                        
                        GROUP BY
                            product.brand_id,
                            product.productName
                        ORDER BY brand.brandId,product.productName";


        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }


    public function  current_stock($distId){
        $query="SELECT
CONCAT(productcategory.title,' ',product.productName,' [ ',	brand.brandName,' ]')AS productName,
product.product_id,
/*	product.productName,
	product.product_code,
	product.category_id,
	product.unit_id,
	product.brand_id,
	productcategory.title AS product_category,
	unit.unitTtile AS product_unit,
	brand.brandName,*/
  IFNULL(product_purchase.product_purchase_qty,0) as product_purchase_qty,
  IFNULL(product_purchase.purchase_price,0) AS purchase_price,
  
  IFNULL(product_purchase_return.product_pur_return_quantity,0) as product_pur_return_quantity,

  IFNULL(product_sales.product_sales_qty,0) as product_sales_qty,
  IFNULL(product_sales.sales_price,0) AS sales_price,
IFNULL(product_sales_return.product_sales_return_quantity,0) as product_sales_return_quantity
  

FROM
	product
LEFT JOIN productcategory ON productcategory.category_id = product.category_id
LEFT JOIN unit ON unit.unit_id = product.unit_id
LEFT JOIN brand ON brand.brandId = product.brand_id
LEFT JOIN (/*get all product purchase quentity sum  and average price by product id*/
   SELECT
    purchase_details.product_id,
		SUM(purchase_details.quantity) AS product_purchase_qty,
		AVG(purchase_details.unit_price)AS purchase_price
		FROM
			purchase_details
		WHERE
			purchase_details.is_active = 'Y'
		AND purchase_details.is_delete = 'N'
		GROUP BY  purchase_details.product_id) AS product_purchase 
ON product_purchase.product_id=product.product_id
LEFT JOIN (/*get all product purchase RETURN quentity sum by product id*/
		SELECT
			purchase_return_details.product_id,
			SUM(purchase_return_details.return_quantity	)AS product_pur_return_quantity
		FROM
			purchase_return_details
		WHERE
			purchase_return_details.is_active = 'Y'
		AND purchase_return_details.is_delete = 'N'
		GROUP BY
			purchase_return_details.product_id
) AS product_purchase_return
ON product_purchase_return.product_id=product.product_id
LEFT JOIN(/*get all product sales quentity sum  and average sales price by product id*/
		SELECT
      sales_details.product_id,
			SUM(sales_details.quantity) AS product_sales_qty,
		AVG(sales_details.unit_price)AS sales_price
		FROM
			sales_details
		WHERE
			sales_details.is_active = 'Y'
		AND sales_details.is_delete = 'N'
		GROUP BY  sales_details.product_id

) AS product_sales 
ON product_sales.product_id=product.product_id

LEFT JOIN (/*get all product purchase RETURN quentity sum by product id*/
		SELECT
			sales_return_details.product_id,
			SUM(sales_return_details.return_quantity	)AS product_sales_return_quantity
		FROM
			sales_return_details
		WHERE
			sales_return_details.is_active = 'Y'
		AND sales_return_details.is_delete = 'N'
		GROUP BY
			sales_return_details.product_id
) AS product_sales_return
ON product_sales_return.product_id=product.product_id
WHERE
	1 = 1";
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }

}

?>