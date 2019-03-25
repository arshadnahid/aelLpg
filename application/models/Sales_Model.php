<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales_Model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function getCustomerList2() {

        $this->db->select();
        $this->db->where('dist_id', '1');
    }

    function getInvoicePayment($distId, $invoiceId) {
        $voaucherNo = $this->db->get_where('generals', array('generals_id' => $invoiceId, 'dist_id' => $distId))->row()->voucher_no;
        $this->db->select("sum(generals.credit) as totalAmount");
        $this->db->from("generals");
        $this->db->where('dist_id', $distId);
        $this->db->where('form_id', 7);
        $this->db->where('voucher_no', $voaucherNo);
        return $this->db->get()->row()->totalAmount;
    }

    function getTopSaleProduct($fromDate, $toDate, $distId) {
        $this->db->select("SUM(stock.quantity) as totalSale,brand.brandName,productcategory.title,product.productName,product.product_code");
        $this->db->from("stock");
        $this->db->join('productcategory', 'productcategory.category_id=product.category_id', 'left');
        $this->db->join('product', 'product.product_id=stock.product_id', 'left');
        $this->db->join('brand', 'brand.brandId=product.brand_id', 'left');
        $this->db->where('stock.dist_id', $distId);
        $this->db->where('stock.date >=', date('Y-m-d', strtotime($fromDate)));
        $this->db->where('stock.date <=', date('Y-m-d', strtotime($toDate)));
        $this->db->where('stock.type', 'Out');
        $this->db->group_by('stock.product_id');
        $this->db->order_by('SUM(stock.quantity)', 'DESC');
        $ledgerReport = $this->db->get()->result();
        return $ledgerReport;
    }

    public function getSalesVoucherList() {
        $this->db->select("form.name,generals.generals_id,generals.voucher_no,generals.narration,generals.date,generals.debit,customer.customerID,customer.customerName,customer.customer_id");
        $this->db->from("generals");
        $this->db->join('customer', 'customer.customer_id=generals.customer_id');
        $this->db->join('form', 'form.form_id=generals.form_id');
        $this->db->where('generals.dist_id', $this->dist_id);
        $this->db->where('generals.form_id', 5);
        $this->db->order_by('generals.date', 'desc');
        $result = $this->db->get()->result();
        return $result;
    }

    function getCustomerSalesList($distId, $fromDate, $endDate, $cusId = null, $type = null) {


        if (!empty($cusId)) {
            if (!empty($type) && $type != 'all'):
                $conCurrent = "AND c.customer_id='$cusId' AND c.customerType ='$type' AND g.dist_id ='$distId' AND g.date >='$fromDate' AND g.date <='$endDate'";
                $conOp = "AND c.customer_id='$cusId' AND g.dist_id ='$distId' AND g.date < '$fromDate'";
            else:
                $conCurrent = "AND c.customer_id='$cusId' AND g.dist_id ='$distId' AND g.date >='$fromDate' AND g.date <='$endDate'";
                $conOp = "AND c.customer_id='$cusId' AND g.dist_id ='$distId' AND g.date < '$fromDate'";
            endif;
        } else {
            if (!empty($type) && $type != 'all'):
                $conCurrent = "AND  c.customerType ='$type' AND g.date >='$fromDate' AND g.date <='$endDate'";
                $conOp = "AND c.customerType ='$type' AND g.dist_id ='$distId' AND g.date < '$fromDate'";

            else:
                $conCurrent = "AND g.date >='$fromDate' AND g.date <='$endDate'";
                $conOp = " AND g.dist_id ='$distId' AND g.date < '$fromDate'";
            endif;
        }

        $query = "SELECT tab1.date,tab1.voucher_no,tab1.narration as memo,tab1.payType,tab1.customerName,tab1.customerID,tab1.individualAmount,tab2.totalOpening from
            (SELECT c.customerName,c.customerID,c.customer_id,g.date,g.voucher_no,g.payType,g.narration,g.debit as individualAmount,c.customerType
            FROM generals g
            LEFT JOIN customer c
            ON c.customer_id=g.customer_id
            WHERE g.form_id =5 $conCurrent ORDER BY g.date ASC
            ) tab1
LEFT JOIN
(SELECT  SUM(g.debit) as totalOpening,c.customer_id
FROM customer c
LEFT JOIN generals g
on g.customer_id=c.customer_id
WHERE g.form_id =5 $conOp) tab2
on tab1.customer_id=tab2.customer_id ORDER BY tab2.totalOpening DESC";
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }

    function getReferenceSalesListById($distId, $fromDate, $endDate, $refId) {
        $query = "SELECT tab1.date,tab1.voucher_no,tab1.narration as memo,tab1.payType,tab1.referenceName,tab1.refCode,tab1.individualAmount,tab2.totalOpening from
            (SELECT r.referenceName,r.refCode,r.reference_id,g.date,g.voucher_no,g.payType,g.narration,g.debit as individualAmount
            FROM generals g
            LEFT JOIN reference r
            ON r.reference_id=g.reference
            WHERE g.form_id =5 AND r.reference_id='$refId' AND g.dist_id ='$distId' AND g.date >='$fromDate' AND g.date <='$endDate' ORDER BY g.date ASC
            ) tab1
LEFT JOIN
(SELECT  SUM(g.debit) as totalOpening,r.reference_id
FROM reference r
LEFT JOIN generals g
on g.reference=r.reference_id
WHERE g.form_id =5 AND r.reference_id='$refId' AND g.dist_id ='$distId' AND g.date < '$fromDate') tab2
on tab1.reference_id=tab2.reference_id ORDER BY tab2.totalOpening DESC";
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }

    function getReferenceSalesList($distId, $fromDate, $endDate) {
        $query = "SELECT tab1.referenceName,tab1.refCode,tab1.individualAmount,tab2.totalOpening from
            (SELECT r.referenceName,r.refCode,r.reference_id,sum(g.debit) as individualAmount
            FROM generals g
            LEFT JOIN reference r
            ON r.reference_id=g.reference
            WHERE g.form_id =5 AND g.dist_id ='$distId' AND g.date >='$fromDate' AND g.date <='$endDate'
            GROUP BY r.reference_id) tab1
LEFT JOIN
(SELECT  SUM(g.debit) as totalOpening,r.reference_id
FROM reference r
LEFT JOIN generals g
on g.reference=r.reference_id
WHERE g.form_id =5 AND g.dist_id ='$distId' AND g.date < '$fromDate') tab2
on tab1.reference_id=tab2.reference_id ORDER BY tab2.totalOpening DESC";
        $query = $this->db->query($query);
        $result = $query->result();
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

    function checkInvoiceIdAndDistributor($distId, $invoiceId) {
        $this->db->select("*");
        $this->db->from("generals");
        $this->db->where("dist_id", $distId);
        $this->db->where("generals_id", $invoiceId);
        $dataExits = $this->db->get()->row();
        if (!empty($dataExits)) {
            return true;
        }
    }

    function checkVoucherPaymentAlreadyReceive($distId, $voucher) {
        $this->db->select('sum(debit - credit) as totalPayment');
        $this->db->from('generals');
        $this->db->where('voucher_no', $voucher);
        $this->db->where('dist_id', $distId);
        $result = $this->db->get()->row();
        return $result->totalPayment;
    }

    function getReturnAbleCylinder($distId, $invoiceId, $productId) {
        $this->db->select("generals_id");
        $this->db->from("generals");
        $this->db->where("dist_id", $distId);
        //form Id 24 means cylinder receive,form Id 23 means cylinder out
        $this->db->where("form_id", 23);
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
            $this->db->where('stock.product_id', $productId);
            $this->db->where('stock.type', 'Cout');
            //type 24 means cylinder receive,type 23 means cylinder out
            $this->db->where('stock.form_id', 23);
            $this->db->where('stock.generals_id', $generalId->generals_id);
            $cylinderInOutResult = $this->db->get()->row();
            return $cylinderInOutResult;
        }
    }

    function getCylinderInOutResult($distId, $invoiceId, $formId) {
        $this->db->select("generals_id");
        $this->db->from("generals");
        $this->db->where("dist_id", $distId);
        //form Id 24 means cylinder receive,form Id 23 means cylinder out
        $this->db->where("form_id", $formId);
        $this->db->where("mainInvoiceId", $invoiceId);
        $generalId = $this->db->get()->row();
        if (!empty($generalId)) {
            $this->db->select('product.productName,brand.brandName,unit.unitTtile,productcategory.title,stock.quantity,stock.category_id,stock.product_id,stock.unit');
            $this->db->from('stock');
            $this->db->join('productcategory', 'stock.category_id = productcategory.category_id');
            $this->db->join('product', 'stock.product_id = product.product_id');
            $this->db->join('unit', 'stock.unit = unit.unit_id');
            $this->db->join('brand', 'product.brand_id = brand.brandId');
            $this->db->where('stock.dist_id', $distId);
            //type 24 means cylinder receive,type 23 means cylinder out
            $this->db->where('stock.form_id', $formId);
            $this->db->where('stock.generals_id', $generalId->generals_id);
            $cylinderInOutResult = $this->db->get()->result();
            return $cylinderInOutResult;
        }
    }

    function getInvoiceIdList($distId, $invoiceId) {
        $this->db->select("generals_id");
        $this->db->from("generals");
        $this->db->where("dist_id", $distId);
        $this->db->where("mainInvoiceId", $invoiceId);
        return $this->db->get()->result();
    }

    function getCustomerInvoiceAmount($customerId, $invoiceId) {
        $this->db->select("sum(dr - cr) as totalBalance");
        $this->db->from("client_vendor_ledger");
        $this->db->where("dist_id", $this->dist_id);
        $this->db->where("ledger_type", 1);
        $this->db->where("history_id", $invoiceId);
        $this->db->where("client_vendor_id", $customerId);
        $result = $this->db->get()->row();
        return $result->totalBalance;
    }

    function getCustomerBalance($distId, $customerId) {
        $this->db->select("sum(dr) - sum(cr) as totalCurrentBalance");
        $this->db->from("client_vendor_ledger");
        $this->db->where('dist_id', $distId);
        $this->db->where('ledger_type', 1);
        $this->db->where('client_vendor_id', $customerId);
        $result = $this->db->get()->row();
        return $result->totalCurrentBalance;
    }

    function getCreditAmount($invoiceId) {
        $this->db->select("credit,generals_id,");
        $this->db->from("generals");
        $this->db->where("mainInvoiceId", $invoiceId);
        $this->db->where("form_id", 7);
        $this->db->where('dist_id', $this->dist_id);
        $creditAmount = $this->db->get()->row();
        if (!empty($creditAmount)) {
            return $creditAmount;
        }
    }

    function getAccountId($invoiceId) {
        $this->db->select("account");
        $this->db->from("generalledger");
        $this->db->where("generals_id", $invoiceId);
        $this->db->where("form_id", 7);
        $this->db->where("debit >=", '1');
        $this->db->where('dist_id', $this->dist_id);
        $this->db->order_by('generalledger_id', 'ASC');
        $creditAccount = $this->db->get()->row();
        if (!empty($creditAccount->account)) {
            return $creditAccount->account;
        }
    }

    function cashSalesInsertLedger($distId, $generalId, $allData) {

    }

    function getGpAmountByInvoiceId($distId, $invoiceId) {
        $stock = $this->db->get_where('stock', array('generals_id' => $invoiceId, 'type' => 'Out'))->result();
        $purchasesPrice = 0;
        $salesPrice = 0;
        foreach ($stock as $eachInfo) {
            $purchasesAvg = $this->getAveragePurchasesPrice($distId, $eachInfo->product_id);
            $invoiceSales = $eachInfo->rate;
            $purchasesPrice+=$purchasesAvg * $eachInfo->quantity;
            $salesPrice+=$eachInfo->rate * $eachInfo->quantity;
        }
        $gpAmount = $salesPrice - $purchasesPrice;
        if (!empty($gpAmount)) {
            return $gpAmount;
        } else {
            return '0.00';
        }
    }

    function getCustomerList($distID) {
        $this->db->select('customer_id,customerID,customerName,customer.dist_id,typeTitle');
        $this->db->from('customer');
        $this->db->join('customertype', 'customertype.type_id =customer.customertype');
        $this->db->where('customer.dist_id', $distID);
        $this->db->order_by('customerName', 'ASC');
        return $this->db->get()->result();
    }

    function getReferenceList($distID) {
        $this->db->select('reference_id,refCode,referenceName,dist_id');
        $this->db->from('reference');
        $this->db->where('dist_id', $distID);
        $this->db->order_by('referenceName', 'ASC');
        return $this->db->get()->result();
    }

    function getAveragePurchasesPrice($distID, $productid) {
        $this->db->select('SUM(stock.price)/SUM(stock.quantity) as totalAvgPurchasesPrice');
        $this->db->from('stock');
        $this->db->join('product', 'stock.product_id = product.product_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = stock.category_id', 'left');
        $this->db->where('stock.type', 'In');
        $this->db->where('stock.dist_id', $distID);
        $this->db->where('stock.product_id', $productid);
        $this->db->order_by('stock.category_id', 'ASC');
        $totalAvgPurchasesPrice = $this->db->get()->row();
        return $totalAvgPurchasesPrice->totalAvgPurchasesPrice;
    }

    function getAveragePurchasesPriceAll($distID, $productid) {
        $this->db->select('SUM(stock.price)/SUM(stock.quantity) AS totalAvgSalesPrice');
        $this->db->from('stock');
        $this->db->where('stock.type', 'In');
        $this->db->where('stock.dist_id', $distID);
        $this->db->where('stock.product_id', $productid);
        $this->db->order_by('stock.category_id', 'ASC');
        $openingAvgSalesPrice = $this->db->get()->row();
        return $openingAvgSalesPrice->totalAvgSalesPrice;
    }

    function getProductWiseSalesReport($dist_id, $productid, $startDate, $endDate) {
        $this->db->select("*");
        $this->db->from("stock");
        $this->db->join('generals', 'generals.generals_id=stock.generals_id');
        $this->db->join('customer', 'customer.customer_id=generals.customer_id');
        $this->db->where("stock.product_id", $productid);
        $this->db->where("stock.type", "Out");
        $this->db->where('stock.date >=', $startDate);
        $this->db->where('stock.date <=', $endDate);
        $this->db->where("stock.dist_id", $dist_id);
        $totalStockIn = $this->db->get()->result();
        return $totalStockIn;
    }

    function getProductWiseSalesReportAll($dist_id, $productid, $startDate, $endDate) {
        $this->db->select("SUM(stock.price)/SUM(stock.quantity) as totalAvgSalesPrice,sum(quantity) as totalSalesQty");
        $this->db->from("stock");
        $this->db->where("stock.product_id", $productid);
        $this->db->where("stock.type", "Out");
        $this->db->where('stock.date >=', $startDate);
        $this->db->where('stock.date <=', $endDate);
        $this->db->where("stock.dist_id", $dist_id);
        $totalStockIn = $this->db->get()->row();
        return $totalStockIn;
    }

    function getProductWisePurchasesReport($dist_id, $productid) {
        $this->db->select("");
        $this->db->from("stock");
        $this->db->where("stock.product_id", $productId);
        $this->db->where("stock.type", "In");
        $this->db->where("stock.dist_id", $this->dist_id);
        $totalStockIn = $this->db->get()->result();
    }

    function getProductStock($productId) {
        $this->db->select("sum(stock.quantity) as totalStockIn");
        $this->db->from("stock");
        $this->db->where("stock.product_id", $productId);
        $this->db->where("stock.type", "In");
        $this->db->where("stock.dist_id", $this->dist_id);
        $totalStockIn = $this->db->get()->row();
        $this->db->select("sum(stock.quantity) as totalStockOut");
        $this->db->from("stock");
        $this->db->where("stock.product_id", $productId);
        $this->db->where("stock.type", "Out");
        $this->db->where("stock.dist_id", $this->dist_id);
        $totalStockOut = $this->db->get()->row();
        return $totalStockIn->totalStockIn - $totalStockOut->totalStockOut;
    }

    function generals_customer($customer_id) {
        $query = $this->db->get_where('generals', array('form_id' => 5, 'customer_id' => $customer_id));
        return $query->result_array();
    }

    function generals_voucher($voucher_no) {
        $dr = '';
        $cr = '';
        $query = $this->db->get_where('generals', array('voucher_no' => $voucher_no))->result_array();
        foreach ($query as $row) {
            $dr += $row['debit'];
            $cr += $row['credit'];
        }
        $bal = $dr - $cr;
        return $bal;
    }

    function productCost($productId, $dist_id) {
        $this->db->select('SUM(stock.price)/SUM(stock.quantity) as totalAvgPurchasesPrice');
        $this->db->from('stock');
        $this->db->where('stock.product_id', $productId);
        $this->db->where('stock.dist_id', $dist_id);
        $this->db->where('stock.type', 'In');
        $results = $this->db->get()->row_array();
        return $results['totalAvgPurchasesPrice'];
    }

    function getCustomerID($distributorid) {
        $cusOrgId = $this->db->where('dist_id', $distributorid)->count_all_results('customer') + 1;
        $CustomerGeneratedID = "CID" . date("y") . date("m") . str_pad($cusOrgId, 4, "0", STR_PAD_LEFT);
        return $CustomerGeneratedID;
    }

    public function checkDuplicateCusID($customerGeneratedID, $distributorid) {
        $checkExits = $this->db->get_where('customer', array('dist_id' => $distributorid, 'customerID' => $customerGeneratedID))->row();
        if (!empty($checkExits)) {
            $supOriId = $this->db->where('dist_id', $distributorid)->count_all_results('customer') + 2;
            return $newID = "CID" . date("y") . date("m") . str_pad($supOriId, 4, "0", STR_PAD_LEFT);
        } else {
            if (!empty($customerGeneratedID)) {
                return $customerGeneratedID;
            }
        }
    }

    function getReturnAbleCylinder2($distId, $invoiceId, $productId, $qty = null) {
        $this->db->select("quantity");
        $this->db->from("stock");
        $this->db->where("dist_id", $distId);
        //form Id 24 means cylinder receive,form Id 23 means cylinder out
        $this->db->where("form_id", 23);
        if(!empty($qty)):
             $this->db->where("quantity", $qty);
        endif;
        $this->db->where("product_id", $productId);
        $this->db->where("generals_id", $invoiceId);
        $generalId = $this->db->get()->row();
        return $generalId;
    }

    function getCylinderInOutResult2($distId, $invoiceId, $formId) {
        $this->db->select('product.productName,brand.brandName,unit.unitTtile,productcategory.title,stock.quantity,stock.category_id,stock.product_id,stock.unit');
        $this->db->from('stock');
        $this->db->join('productcategory', 'stock.category_id = productcategory.category_id');
        $this->db->join('product', 'stock.product_id = product.product_id');
        $this->db->join('unit', 'stock.unit = unit.unit_id');
        $this->db->join('brand', 'product.brand_id = brand.brandId');
        $this->db->where('stock.dist_id', $distId);
        //type 24 means cylinder receive,type 23 means cylinder out
        $this->db->where('stock.form_id', $formId);
        $this->db->where('stock.generals_id', $invoiceId);
        $cylinderInOutResult = $this->db->get()->result();
        return $cylinderInOutResult;
    }

}

?>