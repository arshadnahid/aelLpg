<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function checkMenuAccessValid($menu, $adminId) {
        $menuId = $this->tableRow('navigation', 'url', $menu)->navigation_id;
        if (!empty($menuId)):
            // echo $menuId;die("test");
            $condition = array(
                'admin_id' => $adminId,
                'navigation_id' => $menuId
            );
            $accessValid = $this->get_single_data_by_many_columns('admin_role', $condition);
            if (empty($accessValid)) {
                return FALSE;
            } else {
                return TRUE;
            }
        else:
            return TRUE;
        endif;
    }

    function getCylinderList($dist_id) {
        $condition = array(23, 24);
        $this->db->select("*");
        $this->db->from("generals");
        $this->db->where_in('form_id', $condition);
        $this->db->where('dist_id', $this->dist_id);
        $this->db->order_by('generals_id', 'DESC');
        $result = $this->db->get()->result();
        return $result;
    }

    function getDailySalesAmount($date, $dist_id) {
        $this->db->select('sum(price) as totalSales,date');
        $this->db->from("stock");
        $this->db->where('dist_id', $dist_id);
        $this->db->where('type', 'Out');
        $this->db->where('date', $date);
        $this->db->group_by('date');
        $this->db->order_by('date', 'asc');
        $result = $this->db->get()->row();
        return $result->totalSales;
    }

    function getDailyPurchasesAmount($date, $dist_id) {
        $this->db->select('sum(price) as totalSales,date');
        $this->db->from("stock");
        $this->db->where('dist_id', $dist_id);
        $this->db->where('type', 'In');
        $this->db->where('date', $date);
        $this->db->group_by('date');
        $this->db->order_by('date', 'asc');
        $result = $this->db->get()->row();
        return $result->totalSales;
    }

    function SendSMS($URL) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 0);
        try {
            $output = $content = curl_exec($ch);
            print_r($output);
        } catch (Exception $ex) {
            $output = "-100";
        }
        return $output;
    }

    function getVoucherList($distId) {
        $conditionId = array(3, 4, 5);
        $this->db->select("*");
        $this->db->from("purchase_demo");
        $this->db->where_in('type', $conditionId);
        $this->db->where('dist_id', $distId);
        $this->db->order_by('ConfirmStatus', 'asc');
        $allVoucherList = $this->db->get()->result();
        return $allVoucherList;
    }

    function getChartListByID($parentID) {
        $this->db->select("*");
        $this->db->from("chartofaccount");
        $this->db->where('status', 1);
        $this->db->where('parentId', $parentID);
        $this->db->group_start();
        $this->db->where('dist_id', $this->dist_id);
        $this->db->or_where('common', 1);
        $this->db->group_end();
        $getChildList = $this->db->get()->result();
        return $getChildList;
    }

    function getParentChartList() {
        $this->db->select("*");
        $this->db->from("chartofaccount");
        $this->db->where('status', 1);
        $this->db->where_in('parentId', array('1', '2', '3', '4'));
        $this->db->group_start();
        $this->db->where('dist_id', $this->dist_id);
        $this->db->or_where('common', 1);
        $this->db->group_end();
        $getParentList = $this->db->get()->result();
        return $getParentList;
    }

    public function getProductLowAndHighReport($distId, $catId, $quantity, $order) {
        if ($catId == 'All' && $order == 1):
            //upper query
            $storeResult = array();
            $store1 = array();
            $allProduct = $this->getPublicProductWithoutCat($distId);
            foreach ($allProduct as $key => $eachProduct) {
                $this->db->select('stock.category_id,stock.product_id,sum(stock.quantity) as totalQuantityIn,stock.dist_id,productcategory.title,product.productName,product.brand_id');
                $this->db->from('stock');
                $this->db->join('productcategory', 'productcategory.category_id=stock.category_id');
                $this->db->join('product', 'product.product_id=stock.product_id');
                //$this->db->join('brand', 'brand.brandId=product.brand_id');
                $this->db->where('stock.dist_id', $distId);
                $this->db->where('stock.type', 'In');
                $this->db->where('stock.product_id', $eachProduct->product_id);
                $resultIn = $this->db->get()->row();
                if (!empty($resultIn)) {
                    $this->db->select('stock.category_id,stock.product_id,sum(stock.quantity) as totalQuantityOut,stock.dist_id,productcategory.title,product.productName');
                    $this->db->from('product');
                    $this->db->join('productcategory', 'productcategory.category_id=product.category_id');
                    $this->db->join('stock', 'product.product_id=stock.product_id');
                    $this->db->where('product.dist_id', $distId);
                    $this->db->where('stock.type', 'Out');
                    $this->db->where('product.product_id', $eachProduct->product_id);
                    $resultOut = $this->db->get()->row();
                    $quantityBla = $resultIn->totalQuantityIn - $resultOut->totalQuantityOut;
                    if ($quantityBla > $quantity) {
                        $store1['productDetails'] = $resultIn;
                        $store1['quantity'] = $quantityBla;
                        $storeResult[] = $store1;
                    }
                }
            }
            return $storeResult; elseif ($catId == 'All' && $order == 2):
            //upper query
            $storeResult = array();
            $store1 = array();
            $allProduct = $this->getPublicProductWithoutCat($distId);
            foreach ($allProduct as $key => $eachProduct) {
                $this->db->select('stock.category_id,stock.product_id,sum(stock.quantity) as totalQuantityIn,stock.dist_id,productcategory.title,product.productName,product.brand_id');
                $this->db->from('stock');
                $this->db->join('productcategory', 'productcategory.category_id=stock.category_id');
                $this->db->join('product', 'product.product_id=stock.product_id');
                //$this->db->join('brand', 'brand.brandId=product.brand_id');
                $this->db->where('stock.dist_id', $distId);
                $this->db->where('stock.type', 'In');
                $this->db->where('stock.product_id', $eachProduct->product_id);
                $resultIn = $this->db->get()->row();
                if (!empty($resultIn)) {
                    $this->db->select('stock.category_id,stock.product_id,sum(stock.quantity) as totalQuantityOut,stock.dist_id,productcategory.title,product.productName');
                    $this->db->from('product');
                    $this->db->join('productcategory', 'productcategory.category_id=product.category_id');
                    $this->db->join('stock', 'product.product_id=stock.product_id');
                    $this->db->where('product.dist_id', $distId);
                    $this->db->where('stock.type', 'Out');
                    $this->db->where('product.product_id', $eachProduct->product_id);
                    $resultOut = $this->db->get()->row();
                    $quantityBla = $resultIn->totalQuantityIn - $resultOut->totalQuantityOut;
                    if ($quantityBla < $quantity) {
                        $store1['productDetails'] = $resultIn;
                        $store1['quantity'] = $quantityBla;
                        $storeResult[] = $store1;
                    }
                } else {
                    $store1['productDetails'] = $resultIn;
                    $store1['quantity'] = 0;
                    $storeResult[] = $store1;
                }
            }
            return $storeResult; elseif ($catId != 'All' && $order == 1):
//lower
            //upper query
            $storeResult = array();
            $store1 = array();
            $allProduct = $this->getPublicProduct($distId, $catId);
            foreach ($allProduct as $key => $eachProduct) {
                $this->db->select('stock.category_id,stock.product_id,sum(stock.quantity) as totalQuantityIn,stock.dist_id,productcategory.title,product.productName,product.brand_id');
                $this->db->from('stock');
                $this->db->join('productcategory', 'productcategory.category_id=stock.category_id');
                $this->db->join('product', 'product.product_id=stock.product_id');
                //$this->db->join('brand', 'brand.brandId=product.brand_id');
                $this->db->where('stock.dist_id', $distId);
                $this->db->where('stock.type', 'In');
                $this->db->where('stock.product_id', $eachProduct->product_id);
                $resultIn = $this->db->get()->row();
                if (!empty($resultIn)) {
                    $this->db->select('stock.category_id,stock.product_id,sum(stock.quantity) as totalQuantityOut,stock.dist_id,productcategory.title,product.productName');
                    $this->db->from('product');
                    $this->db->join('productcategory', 'productcategory.category_id=product.category_id');
                    $this->db->join('stock', 'product.product_id=stock.product_id');
                    $this->db->where('product.dist_id', $distId);
                    $this->db->where('stock.type', 'Out');
                    $this->db->where('product.product_id', $eachProduct->product_id);
                    $resultOut = $this->db->get()->row();
                    $quantityBla = $resultIn->totalQuantityIn - $resultOut->totalQuantityOut;
                    if ($quantityBla > $quantity) {
                        $store1['productDetails'] = $resultIn;
                        $store1['quantity'] = $quantityBla;
                        $storeResult[] = $store1;
                    }
                }
            }
            return $storeResult;
        else:
            //upper query
            $storeResult = array();
            $store1 = array();
            $allProduct = $this->getPublicProduct($distId, $catId);
            foreach ($allProduct as $key => $eachProduct) {
                $this->db->select('stock.category_id,stock.product_id,sum(stock.quantity) as totalQuantityIn,stock.dist_id,productcategory.title,product.productName,product.brand_id');
                $this->db->from('stock');
                $this->db->join('productcategory', 'productcategory.category_id=stock.category_id');
                $this->db->join('product', 'product.product_id=stock.product_id');
                //$this->db->join('brand', 'brand.brandId=product.brand_id');
                $this->db->where('stock.dist_id', $distId);
                $this->db->where('stock.type', 'In');
                $this->db->where('stock.product_id', $eachProduct->product_id);
                $resultIn = $this->db->get()->row();
                if (!empty($resultIn)) {
                    $this->db->select('stock.category_id,stock.product_id,sum(stock.quantity) as totalQuantityOut,stock.dist_id,productcategory.title,product.productName');
                    $this->db->from('product');
                    $this->db->join('productcategory', 'productcategory.category_id=product.category_id');
                    $this->db->join('stock', 'product.product_id=stock.product_id');
                    $this->db->where('product.dist_id', $distId);
                    $this->db->where('stock.type', 'Out');
                    $this->db->where('product.product_id', $eachProduct->product_id);
                    $resultOut = $this->db->get()->row();
                    $quantityBla = $resultIn->totalQuantityIn - $resultOut->totalQuantityOut;
                    if ($quantityBla < $quantity) {
                        $store1['productDetails'] = $resultIn;
                        $store1['quantity'] = $quantityBla;
                        $storeResult[] = $store1;
                    }
                } else {
                    $store1['productDetails'] = $resultIn;
                    $store1['quantity'] = 0;
                    $storeResult[] = $store1;
                }
            }
            return $storeResult;
        endif;
    }

    public function getPublicProduct($distId, $catid) {
        $this->db->select('product.product_id,productcategory.title as productCat,product.brand_id,product.category_id,product.productName,product.dist_id,product.status,brand.brandName,unit.unitTtile');
        $this->db->from('product');
        $this->db->join('brand', 'brand.brandId = product.brand_id', 'left');
        $this->db->join('unit', 'unit.unit_id = product.unit_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = product.category_id', 'left');
        $this->db->group_start();
        $this->db->where('product.dist_id', $distId);
        $this->db->or_where('product.dist_id', 1);
        $this->db->group_end();
        $this->db->where('product.status', 1);
        $this->db->where('product.category_id', $catid);
        $this->db->order_by('product.productName', 'ASE');
        $getProductList = $this->db->get()->result();
        return $getProductList;
    }

    public function getProductInfo($productId) {
        $this->db->select('product.product_id,product.product_code,productcategory.title as productCat,product.brand_id,product.category_id,product.productName,product.dist_id,product.status,brand.brandName');
        $this->db->from('product');
        $this->db->join('brand', 'brand.brandId = product.brand_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = product.category_id', 'left');
        $this->db->where('product.product_id', $productId);
        $productInfo = $this->db->get()->row();
        return $productInfo;
    }

    public function getPublicProductList($distId) {
        $allList = array();
        $this->db->select('category_id,title');
        $this->db->from('productcategory');
        $this->db->where('dist_id', '1');
        $this->db->or_where('dist_id', $distId);
        $result = $this->db->get()->result();
        foreach ($result as $key => $eachCategory) {
            unset($list);
            $list['categoryName'] = $eachCategory->title;
            $list['categoryId'] = $eachCategory->category_id;
            $list['productInfo'] = $this->getProductListByCategory($eachCategory->category_id, $distId);
            $allList[] = $list;
        }
        $allList['packageList']=$this->getPublicPackageList($distId);
        return $allList;
    }
    public function getPublicPackageList($distId) {
        $allList = array();
        $this->db->select('package.package_name,package.package_id,package.package_code,product.product_id,product.category_id');
        $this->db->from('package');
        $this->db->join('package_products', 'package_products.package_id = package.package_id', 'left');
        $this->db->join('product', 'product.product_id = package_products.product_id', 'left');

        $this->db->where('product.category_id', '2');
        $this->db->group_start();
        $this->db->where('package.dist_id', '1');
        $this->db->or_where('package.dist_id', $distId);
        $this->db->group_end();
        $result = $this->db->get()->result();

        return $result;
    }

    public function getProductListByCategory($category, $distId) {
        $this->db->select('product.product_id,productcategory.title as productCat,product.brand_id,product.category_id,product.productName,product.dist_id,product.status,brand.brandName,unit.unitTtile');
        $this->db->from('product');
        $this->db->join('brand', 'brand.brandId = product.brand_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = product.category_id', 'left');
        $this->db->join('unit', 'unit.unit_id = product.unit_id', 'left');
        $this->db->group_start();
        $this->db->where('product.dist_id', $distId);
        $this->db->or_where('product.dist_id', 1);
        $this->db->group_end();
        $this->db->where('product.status', 1);
        $this->db->where('product.category_id', $category);
        $this->db->order_by('product.productName', 'ASE');
        $getProductList = $this->db->get()->result();
        return $getProductList;
    }

    public function get_product_list_by_dist_id($distId, $q = '', $status = NULL) {
        $this->db->select('product.product_id,product.productName,product.brand_id,product.category_id,productcategory.title as productCatName,unit.unitTtile,product.unit_id,product.product_code,brand.brandName');
        $this->db->from('product');
        $this->db->join('brand', 'brand.brandId = product.brand_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = product.category_id', 'left');
        $this->db->join('unit', 'unit.unit_id = product.unit_id', 'left');
        $this->db->group_start();
        $this->db->where('product.dist_id', $distId);
        $this->db->or_where('product.dist_id', 1);
        $this->db->group_end();
        $this->db->where('product.status', 1);
        $this->db->group_start();
        $this->db->like('product.productName', $q);
        $this->db->or_like('product.product_code', $q);
        $this->db->or_like('brand.brandName', $q);
        $this->db->group_end();
        if (!empty($status)) {
            $this->db->where('product.category_id', 2);
        }
        $this->db->limit("30");
        $this->db->order_by("product.product_id", "ASC");
        $result = $this->db->get()->result_array();
        if (count($result) > 0) {
            $data = array();
            foreach ($result as $key => $value) {
                $data[$key]['id'] = $result[$key]['product_id'];
                $data[$key]['productName'] = $result[$key]['productName'];
                $data[$key]['brandName'] = $result[$key]['brandName'];
                $data[$key]['category_id'] = $result[$key]['category_id'];
                $data[$key]['productCatName'] = $result[$key]['productCatName'];
                $data[$key]['unitTtile'] = $result[$key]['unitTtile'];
                $data[$key]['unit_id'] = $result[$key]['unit_id'];
                $data[$key]['brandName'] = $result[$key]['brandName'];
                $data[$key]['brand_id'] = $result[$key]['brand_id'];
                //$data[$key]['label'] = $result[$key]['brand_id'];
                //$data[$key]['productWholeSalePrice'] = $result[$key]['productWholeSalePrice'];
                $data[$key]['value'] = $result[$key]['productCatName'] . ' - ' . $result[$key]['productName'] . ' [ ' . $result[$key]['brandName'] . ' ]';
                //$data[$key]['productModel'] = ($result[$key]['productModel']!='')? $result[$key]['productModel']:'' ;
            }
            return $data;
        }
        // return $getProductList;
    }

    public function get_purchases_product_list_by_dist_id($distId, $q = '', $status = NULL) {
        $this->db->select('product.product_id,product.productName,product.brand_id,product.category_id,productcategory.title as productCatName,unit.unitTtile,product.unit_id,product.product_code,brand.brandName');
        $this->db->from('product');
        $this->db->join('brand', 'brand.brandId = product.brand_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = product.category_id', 'left');
        $this->db->join('unit', 'unit.unit_id = product.unit_id', 'left');
        $this->db->group_start();
        $this->db->where('product.dist_id', $distId);
        $this->db->or_where('product.dist_id', 1);
        $this->db->group_end();
        $this->db->where('product.status', 1);
        $this->db->group_start();
        $this->db->like('product.productName', $q);
        $this->db->or_like('product.product_code', $q);
        $this->db->or_like('brand.brandName', $q);
        $this->db->group_end();
        if (!empty($status)) {
            $this->db->where('product.category_id', 2);
        }
        $this->db->limit("30");
        $this->db->order_by("product.product_id", "ASC");
        $result = $this->db->get()->result_array();
        if (count($result) > 0) {
            $data = array();
            foreach ($result as $key => $value) {
                $data[$key]['id'] = $result[$key]['product_id'];
                $data[$key]['productName'] = $result[$key]['productName'];
                $data[$key]['brandName'] = $result[$key]['brandName'];
                $data[$key]['category_id'] = $result[$key]['category_id'];
                $data[$key]['productCatName'] = $result[$key]['productCatName'];
                $data[$key]['unitTtile'] = $result[$key]['unitTtile'];
                $data[$key]['unit_id'] = $result[$key]['unit_id'];
                $data[$key]['brandName'] = $result[$key]['brandName'];
                $data[$key]['brand_id'] = $result[$key]['brand_id'];
                $data[$key]['value'] = $result[$key]['productCatName'] . ' - ' . $result[$key]['productName'] . ' [ ' . $result[$key]['brandName'] . ' ]';
            }
            return $data;
        }
        // return $getProductList;
    }

    public function checkPublicProductCat($catName, $distId) {
        $this->db->select("category_id,dist_id,title");
        $this->db->from("productcategory");
        $this->db->group_start();
        $this->db->where('dist_id', $distId);
        $this->db->or_where('dist_id', 1);
        $this->db->group_end();
        $this->db->where('title', $catName);
        $getProductList = $this->db->get()->result();
        return $getProductList;
    }

    public function checkDuplicateModel($distId, $productName, $productCat, $brandId, $productId = null) {
        $this->db->select("product.product_id");
        $this->db->from("product");
        $this->db->group_start();
        $this->db->where('product.dist_id', $distId);
        $this->db->or_where('product.dist_id', 1);
        $this->db->group_end();
        $this->db->where('category_id', $productCat);
        $this->db->where('brand_id', $brandId);
        if (!empty($productId)):
            $this->db->where('product.product_id !=', $productId);
        endif;
        $this->db->where('product.productName', $productName);
        $getProductList = $this->db->get()->row();
        return $getProductList;
    }

    public function getPublicProductWithoutCat($distId) {
        $this->db->select("brand.brandName,productcategory.title as productCat,product.product_id,product.brand_id,product.category_id,product.productName,product.product_code,product.purchases_price,product.salesPrice,product.retailPrice,product.status,product.dist_id");
        $this->db->from("product");
        $this->db->join('brand', 'brand.brandId = product.brand_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = product.category_id', 'left');
        $this->db->group_start();
        $this->db->where('product.dist_id', $distId);
        $this->db->or_where('product.dist_id', 1);
        $this->db->group_end();
        $this->db->where('product.status', 1);
        $this->db->order_by('productcategory.title', 'ASC');
        $getProductList = $this->db->get()->result();
        return $getProductList;
    }

    public function getImportProduct($distId) {
        $this->db->select("brand.brandName,productcategory.title as productCat,productcategory.category_id,product.product_id,product.brand_id,product.category_id,product.productName,product.product_code,product.purchases_price,product.salesPrice,product.retailPrice,product.status,product.dist_id");
        $this->db->from("product");
        $this->db->join('brand', 'brand.brandId = product.brand_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = product.category_id', 'left');
        $this->db->group_start();
        $this->db->where('product.dist_id', $distId);
        $this->db->or_where('product.dist_id', 1);
        $this->db->group_end();
        $this->db->where('product.status', 1);
        $this->db->order_by('productcategory.category_id', 'asc');
        $getProductList = $this->db->get()->result();
        $list = array();
        foreach ($getProductList as $key => $eachProduct):
            $product = array();
            $product['sl'] = $key + 1;
            $product['category_id'] = $eachProduct->category_id;
            $product['product_id'] = $eachProduct->product_id;
            $product['product_code'] = $eachProduct->product_code;
            $product['productCat'] = $eachProduct->productCat;
            $product['productName'] = $eachProduct->productName . '[ ' . $eachProduct->brandName . ' ]';
            $product['quantity'] = '';
            $product['unitPrice'] = '';
            $product['totalPrice'] = '';
            $list[] = $product;
        endforeach;
        return $list;
    }

    public function getImportProductList($distId) {
        $this->db->select("productcategory.title as productCat,product.product_id,product.brand_id,product.category_id,product.productName,product.product_code,product.purchases_price,product.salesPrice,product.retailPrice,product.status,product.dist_id");
        $this->db->from("product");
        $this->db->join('brand', 'brand.brandId = product.brand_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = product.category_id', 'left');
        $this->db->group_start();
        $this->db->where('product.dist_id', $distId);
        $this->db->or_where('product.dist_id', 1);
        $this->db->group_end();
        $this->db->where('product.status', 1);
        $this->db->order_by('product.product_id', 'DESC');
        $getProductList = $this->db->get()->result();
        return $getProductList;
    }

    public function getPublicProductWithoutStatus($distId) {
        $this->db->select("brand.brandName,productcategory.title,product.product_id,product.brand_id,product.category_id,product.productName,product.product_code,product.purchases_price,product.salesPrice,product.retailPrice,product.status,product.dist_id");
        $this->db->from("product");
        $this->db->join('brand', 'brand.brandId = product.brand_id', 'left');
        $this->db->join('productcategory', 'productcategory.category_id = product.category_id', 'left');
        $this->db->group_start();
        $this->db->where('product.dist_id', $distId);
        $this->db->or_where('product.dist_id', 1);
        $this->db->group_end();
        $this->db->order_by('product.product_id', 'DESC');
        $getProductList = $this->db->get()->result();
        return $getProductList;
    }

    public function getPublicUnit($distId) {
        $this->db->select("dist_id,unitTtile,unit_id,code");
        $this->db->from("unit");
        $this->db->group_start();
        $this->db->where('dist_id', $distId);
        $this->db->or_where('dist_id', 1);
        $this->db->group_end();
        $this->db->order_by('unit_id', 'ASE');
        $getUnitList = $this->db->get()->result();
        return $getUnitList;
    }

    public function cehckDuplicateUnit($name, $distId) {
        $this->db->select("dist_id,unitTtile,unit_id");
        $this->db->from("unit");
        $this->db->group_start();
        $this->db->where('dist_id', $distId);
        $this->db->or_where('dist_id', 1);
        $this->db->group_end();
        $this->db->where('unitTtile', $name);
        $getUnitList = $this->db->get()->result();
        return $getUnitList;
    }

    public function getPublicProductWithoutCatCylin($distId, $cyCat) {
        $this->db->select("*");
        $this->db->from("product");
        $this->db->group_start();
        $this->db->where('dist_id', $distId);
        $this->db->or_where('dist_id', 1);
        $this->db->group_end();
        if ($cyCat == 2) {
            $this->db->where('category_id !=', 1);
        } else {
            $this->db->where('category_id', 1);
        }
        $this->db->where('status', 1);
        $this->db->order_by('productName', 'ASE');
        $getProductList = $this->db->get()->result();
        return $getProductList;
    }

    public function getPublicProductCat($distId) {
        $this->db->select("category_id,dist_id,title");
        $this->db->from("productcategory");
        $this->db->group_start();
        $this->db->where('dist_id', $distId);
        $this->db->or_where('dist_id', 1);
        $this->db->group_end();
        $this->db->order_by('dist_id', 'ASE');
        $getProductList = $this->db->get()->result();
        return $getProductList;
    }

    public function getPublicProductCatbyCilinder($distId, $type) {
        $this->db->select("*");
        $this->db->from("productcategory");
        $this->db->group_start();
        $this->db->where('dist_id', $distId);
        $this->db->or_where('dist_id', 1);
        $this->db->group_end();
        if ($type == 1) {
            $this->db->where('category_id', 1);
        } else {
            $this->db->where('category_id !=', 1);
        }
        $this->db->order_by('dist_id', 'ASE');
        $getProductList = $this->db->get()->result();
        return $getProductList;
    }

    public function getPublicBrand($distId) {
        $this->db->select("*");
        $this->db->from("brand");
        $this->db->group_start();
        $this->db->where('dist_id', $distId);
        $this->db->or_where('dist_id', 1);
        $this->db->group_end();
        $this->db->order_by('brandName', 'ASE');
        $getProductList = $this->db->get()->result();
        return $getProductList;
    }

    public function getPublicSupplier($distId) {
        $this->db->select("*");
        $this->db->from("supplier");
        $this->db->group_start();
        $this->db->where('dist_id', $distId);
        $this->db->or_where('dist_id', 1);
        $this->db->group_end();
        $this->db->where('status', 1);
        $this->db->order_by('supName', 'ASE');
        $getParentList = $this->db->get()->result();
        return $getParentList;
    }

    public function getPublicSupplierForList($distId) {
        $this->db->select("sup_id,supID,supName,supEmail,supPhone,supAddress,status");
//        $this->db->select("*");
        $this->db->from("supplier");
        $this->db->group_start();
        $this->db->where('dist_id', $distId);
        $this->db->or_where('dist_id', 1);
        $this->db->group_end();
        $this->db->order_by('supName', 'ASE');
        $getParentList = $this->db->get()->result();
        return $getParentList;
    }

    function makeGeneralLedger($distributorid = Null) {
        if (!empty($distributorid)) {
            $this->dist_id = $distributorid;
        }
        $condition = array(
            'dist_id' => $this->dist_id,
            'status' => 1,
        );
        // $this->db->where_in('parentId', array('4'));
        //$getParentList = $this->get_data_list_by_many_columns('chartofaccount', $condition);
        //step num 2// get parent menu lsit
        $getParentList = $this->getParentChartList();
        //echo $this->db->last_query();die;
        $assetsList = array();
        foreach ($getParentList as $key => $eachValue):
            $getChildList = $this->getChartListByID($eachValue->chart_id);
            //  $getChildList = $this->get_data_list_by_many_columns('chartofaccount', $childCon);
            //setp num 3 get child menu list
            if (!empty($getChildList)):
                foreach ($getChildList as $key => $childValue):
                    $headList = $this->getChartListByID($childValue->chart_id);
                    // $headList = $this->get_data_list_by_many_columns('chartofaccount', $headCon);
                    if (!empty($headList)):
                        foreach ($headList as $key => $value):
                            $assetsList[] = $value;
                        endforeach;
                    else:
                        $assetsList[] = $childValue;
                    endif;
                endforeach;
            endif;
        endforeach;
        // dumpVar($assetsList);
        $this->delete_data("generaldata", "dist_id", $this->dist_id);
        foreach ($assetsList as $value) {
            unset($data1);
            $data1['rootId'] = $value->rootId;
            $data1['parentId'] = $value->parentId;
            $data1['code'] = $value->accountCode;
            $data1['title'] = $value->title;
            $data1['chartId'] = $value->chart_id;
            $data1['dist_id'] = $this->dist_id;
            $batch[] = $data1;
        }
        $this->db->insert_batch('generaldata', $batch);
    }

    public function compare_decision_info($dist_id) {
        $sql = 'SELECT * FROM tbl_decision WHERE
            ( SELECT MAX(per_month_interest_amount+per_month_profit_amount) AS per_tk FROM tbl_decision
            ORDER BY (per_month_profit_amount+per_month_interest_amount) DESC)
            AND (SELECT MIN(amount_of_saving+invest_amount) AS tk FROM tbl_decision
            ORDER BY (amount_of_saving+invest_amount) DESC)
            ORDER BY (per_month_profit_amount+per_month_interest_amount) DESC limit 5';
        $data = $this->db->query($sql)->result();
        return $data;
    }

    function getAccountHead() {
        $this->db->select('parentId');
        $this->db->from("generaldata");
        $this->db->group_by('parentId');
        $this->db->order_by('rootId', 'ASC');
        $result = $this->db->get()->result();
        foreach ($result as $key => $eachID) {
            $condition = array(
                'dist_id' => $this->dist_id,
                'parentId' => $eachID->parentId,
            );
            $data[$eachID->parentId]['parentName'] = $this->get_single_data_by_single_column('chartofaccount', 'chart_id', $eachID->parentId)->title;
            $data[$eachID->parentId]['Accountledger'] = $this->get_data_list_by_many_columns('generaldata', $condition);
        }
        return $data;
    }

    function getAccountHeadCashAndBank() {
        $this->db->select('parentId,chartId');
        $this->db->from("generaldata");
        $this->db->group_by('parentId');
        $this->db->order_by('rootId', 'ASC');
        $result = $this->db->get()->result();
        $array = array('42', '55');
        foreach ($result as $key => $eachID) {
            if (in_array($eachID->parentId, $array)) {
                $condition = array(
                    'dist_id' => $this->dist_id,
                    'parentId' => $eachID->parentId,
                );
                if (($eachID->chartId == '54' && $eachID->parentId == '42') || $eachID->parentId == '55'):
                    $data[$eachID->parentId]['parentName'] = $this->get_single_data_by_single_column('chartofaccount', 'chart_id', $eachID->parentId)->title;
                    $data[$eachID->parentId]['Accountledger'] = $this->get_data_list_by_many_columns('generaldata', $condition);
                endif;
            }
        }
        return $data;
    }

    function getAccountListByRoodId($rootId) {
        $this->db->select('parentId');
        $this->db->where('rootId', $rootId);
        $this->db->where('dist_id', $this->dist_id);
        $this->db->group_by('parentId');
        $this->db->order_by('rootId', 'ASC');
        $result = $this->db->get('generaldata')->result();
        foreach ($result as $key => $eachID) {
            $condition = array(
                'dist_id' => $this->dist_id,
                'parentId' => $eachID->parentId,
            );
            $data[$eachID->parentId]['parentName'] = $this->get_single_data_by_single_column('chartofaccount', 'chart_id', $eachID->parentId)->title . '-' . $eachID->parentId;
            $data[$eachID->parentId]['Accountledger'] = $this->get_data_list_by_many_columns('generaldata', $condition);
        }
        return $data;
    }

    function getAccountLedger() {
        $condition = array(
            'dist_id' => $this->dist_id,
            'status' => 1,
        );
        //$this->db->where_in('parentId', array('1'));
        $this->db->where_in('parentId', array('1', '2', '3', '4'));
        $getParentList = $this->Common_model->get_data_list_by_many_columns('chartofaccount', $condition);
        foreach ($getParentList as $key => $eachAccount):
            // dumpVar($eachAccount);
            $thirdAccountList = $this->Common_model->get_data_list_by_single_column('chartofaccount', 'parentId', $eachAccount->chart_id);
            foreach ($thirdAccountList as $ky => $forthAccount) {
                $getAccountList = $this->Common_model->get_data_list_by_single_column('chartofaccount', 'parentId', $forthAccount->chart_id);
                $getArrayData = $this->Common_model->get_data_list_by_single_column('chartofaccount', 'chart_id', $forthAccount->chart_id);
                //dumpVar($data['accountList'][$forthAccount->chart_id]);
                if (!empty($getAccountList)) {
                    // unset($data['accountList']);
                    $finalArray[][$forthAccount->chart_id] = $data['accountList'][$forthAccount->chart_id] = $getAccountList;
                } else {
                    $finalArray[][$forthAccount->parentId] = $data['accountList'][$forthAccount->parentId] = $getArrayData;
                    //$finalArray[]=$data['accountList'][$forthAccount->parentId];
                }
            }
        endforeach;
        return $finalArray;
    }

    function rowResult($table, $condition, $dist_id) {
        $this->db->select("*");
        $this->db->from($table);
        $this->db->group_start();
        $this->db->where('dist_id', $dist_id);
        $this->db->or_where('dist_id', 1);
        $this->db->group_end();
        $this->db->where($condition);
        $row = $this->db->get()->row();
        return $row;
    }

    function getSupplierIDAdmin($distributorid) {
        $supOriId = $this->db->where('dist_id', $distributorid)->count_all_results('supplier') + 1;
        $supplierGeneratedID = "ASID" . str_pad($supOriId, 4, "0", STR_PAD_LEFT);
        return $supplierGeneratedID;
    }

    function getSupplierID($distributorid) {
        $supOriId = $this->db->where('dist_id', $distributorid)->count_all_results('supplier') + 1;
        $supplierGeneratedID = "SID" . date("y") . date("m") . str_pad($supOriId, 4, "0", STR_PAD_LEFT);
        return $supplierGeneratedID;
    }

    function getCustomerID($distributorid) {
        $supOriId = $this->db->where('dist_id', $distributorid)->count_all_results('customer') + 1;
        $supplierGeneratedID = "CID" . date("y") . date("m") . str_pad($supOriId, 4, "0", STR_PAD_LEFT);
        return $supplierGeneratedID;
    }

    function getProID($distributorid) {
        $supOriId = $this->db->where('dist_id', $distributorid)->count_all_results('product') + 1;
        $supplierGeneratedID = "PID" . date("y") . date("m") . str_pad($supOriId, 4, "0", STR_PAD_LEFT);
        return $supplierGeneratedID;
    }

    public function checkDuplicateSupID($supplierGeneratedID, $distributorid) {
        $checkExits = $this->db->get_where('supplier', array('dist_id' => $distributorid, 'supID' => $supplierGeneratedID))->row();
        if (!empty($checkExits)) {
            $supOriId = $this->db->where('dist_id', $distributorid)->count_all_results('supplier') + 1;
            return $newID = "SID" . date("y") . date("m") . str_pad($supOriId + 1, 4, "0", STR_PAD_LEFT);
        } else {
            if (!empty($supplierGeneratedID)) {
                return $supplierGeneratedID;
            }
        }
    }

    public function checkDuplicateSupIDAdmin($supplierGeneratedID, $distributorid) {
        $checkExits = $this->db->get_where('supplier', array('dist_id' => $distributorid, 'supID' => $supplierGeneratedID))->row();
        if (!empty($checkExits)) {
            $supOriId = $this->db->where('dist_id', $distributorid)->count_all_results('supplier') + 1;
            return $newID = "ASID" . str_pad($supOriId + 1, 4, "0", STR_PAD_LEFT);
        } else {
            if (!empty($supplierGeneratedID)) {
                return $supplierGeneratedID;
            }
        }
    }

    public function checkDuplicatePurchaseVoucherID($supplierGeneratedID, $distributorid) {
        $checkExits = $this->db->get_where('supplier', array('dist_id' => $distributorid, 'supID' => $supplierGeneratedID))->row();
        if (!empty($checkExits)) {
            $supOriId = $this->db->where('dist_id', $distributorid)->count_all_results('supplier') + 1;
            return $newID = "SID" . date("y") . date("m") . str_pad($supOriId + 1, 4, "0", STR_PAD_LEFT);
        } else {
            if (!empty($supplierGeneratedID)) {
                return $supplierGeneratedID;
            }
        }
    }

    function getDynamicId($tableName, $arrayCondition, $getColumn, $orderBy, $removeVlaue, $addValue, $addPrefix) {
        $this->db->select($getColumn);
        $this->db->from($tableName);
        $this->db->where($arrayCondition);
        $this->db->order_by($orderBy, 'DESC');
        $getId = $this->db->get()->row();
        $id = $getId->$getColumn;
        $oldSerial = substr($id, $removeVlaue);
        $newSerial = $addPrefix . date('y') . date('m') . str_pad($oldSerial + $addValue, 4, "0", STR_PAD_LEFT);
        return $newSerial;
    }

    public function checkDuplicateCstID($supplierGeneratedID, $distributorid) {
        $checkExits = $this->db->get_where('customer', array('dist_id' => $distributorid, 'customer_id' => $supplierGeneratedID))->row();
        if (!empty($checkExits)) {
            $supOriId = $this->db->where('dist_id', $distributorid)->count_all_results('customer') + 1;
            return $newID = "CID" . date("y") . date("m") . str_pad($supOriId + 1, 4, "0", STR_PAD_LEFT);
        } else {
            if (!empty($supplierGeneratedID)) {
                return $supplierGeneratedID;
            }
        }
    }

    public function checkDuplicateProID($supplierGeneratedID, $distributorid) {
        $checkExits = $this->db->get_where('product', array('dist_id' => $distributorid, 'product_code' => $supplierGeneratedID))->row();
        if (!empty($checkExits)) {
            $supOriId = $this->db->where('dist_id', $distributorid)->count_all_results('product') + 1;
            return $newID = "PID" . date("y") . date("m") . str_pad($supOriId + 1, 4, "0", STR_PAD_LEFT);
        } else {
            if (!empty($supplierGeneratedID)) {
                return $supplierGeneratedID;
            }
        }
    }

    function get_bd_amount_in_text($amount) {
        $output_string = '';
        $tokens = explode('.', $amount);
        $current_amount = $tokens[0];
        $fraction = '';
        if (count($tokens) > 1) {
            $fraction = (double) ('0.' . $tokens[1]);
            $fraction = $fraction * 100;
            $fraction = round($fraction, 0);
            $fraction = (int) $fraction;
            $fraction = $this->translate_to_words($fraction) . ' Poisa';
            $fraction = ' Taka & ' . $fraction;
        }
        $crore = 0;
        if ($current_amount >= pow(10, 7)) {
            $crore = (int) floor($current_amount / pow(10, 7));
            $output_string .= $this->translate_to_words($crore) . ' crore ';
            $current_amount = $current_amount - $crore * pow(10, 7);
        }
        $lakh = 0;
        if ($current_amount >= pow(10, 5)) {
            $lakh = (int) floor($current_amount / pow(10, 5));
            $output_string .= $this->translate_to_words($lakh) . ' lakh ';
            $current_amount = $current_amount - $lakh * pow(10, 5);
        }
        $current_amount = (int) $current_amount;
        $output_string .= $this->translate_to_words($current_amount);
        $output_string = $output_string . $fraction . ' only';
        $output_string = ucwords($output_string);
        return $output_string;
    }

    function translate_to_words($number) {
        /*         * ***
         * A recursive function to turn digits into words
         * Numbers must be integers from -999,999,999,999 to 999,999,999,999 inclussive.
         */
        // zero is a special case, it cause problems even with typecasting if we don't deal with it here
        $max_size = pow(10, 18);
        if (!$number)
            return "zero";
        if (is_int($number) && $number < abs($max_size)) {
            $prefix = '';
            $suffix = '';
            switch ($number) {
                // setup up some rules for converting digits to words
                case $number < 0:
                    $prefix = "negative";
                    $suffix = $this->translate_to_words(-1 * $number);
                    $string = $prefix . " " . $suffix;
                    break;
                case 1:
                    $string = "one";
                    break;
                case 2:
                    $string = "two";
                    break;
                case 3:
                    $string = "three";
                    break;
                case 4:
                    $string = "four";
                    break;
                case 5:
                    $string = "five";
                    break;
                case 6:
                    $string = "six";
                    break;
                case 7:
                    $string = "seven";
                    break;
                case 8:
                    $string = "eight";
                    break;
                case 9:
                    $string = "nine";
                    break;
                case 10:
                    $string = "ten";
                    break;
                case 11:
                    $string = "eleven";
                    break;
                case 12:
                    $string = "twelve";
                    break;
                case 13:
                    $string = "thirteen";
                    break;
                // fourteen handled later
                case 15:
                    $string = "fifteen";
                    break;
                case $number < 20:
                    $string = $this->translate_to_words($number % 10);
                    // eighteen only has one "t"
                    if ($number == 18) {
                        $suffix = "een";
                    } else {
                        $suffix = "teen";
                    }
                    $string .= $suffix;
                    break;
                case 20:
                    $string = "twenty";
                    break;
                case 30:
                    $string = "thirty";
                    break;
                case 40:
                    $string = "forty";
                    break;
                case 50:
                    $string = "fifty";
                    break;
                case 60:
                    $string = "sixty";
                    break;
                case 70:
                    $string = "seventy";
                    break;
                case 80:
                    $string = "eighty";
                    break;
                case 90:
                    $string = "ninety";
                    break;
                case $number < 100:
                    $prefix = $this->translate_to_words($number - $number % 10);
                    $suffix = $this->translate_to_words($number % 10);
                    //$string = $prefix . "-" . $suffix;
                    $string = $prefix . " " . $suffix;
                    break;
                // handles all number 100 to 999
                case $number < pow(10, 3):
                    // floor return a float not an integer
                    $prefix = $this->translate_to_words(intval(floor($number / pow(10, 2)))) . " hundred";
                    if ($number % pow(10, 2))
                        $suffix = " and " . $this->translate_to_words($number % pow(10, 2));
                    $string = $prefix . $suffix;
                    break;
                case $number < pow(10, 6):
                    // floor return a float not an integer
                    $prefix = $this->translate_to_words(intval(floor($number / pow(10, 3)))) . " thousand";
                    if ($number % pow(10, 3))
                        $suffix = $this->translate_to_words($number % pow(10, 3));
                    $string = $prefix . " " . $suffix;
                    break;
            }
        } else {
            echo "ERROR with - $number Number must be an integer between -" . number_format($max_size, 0, ".", ",") . " and " . number_format($max_size, 0, ".", ",") . " exclussive.";
        }
        return $string;
    }

    function tableRow($table, $column, $columnValue) {
        return $this->db->get_where($table, array($column => $columnValue))->row();
    }

//    function get_data_list_by_main_menu_id($parent_id, $admin_id) {
//        //$this->db->where('parent_id', $parent_id);
//        $this->db->where('admin_id', $admin_id);
//        $result = $this->db->get("admin_role")->result_array();
//        $addedMenu1 = json_decode($result[0]['test']);
//
//        dumpVar($addedMenu1);
//        $accessMenu = array();
//        foreach ($addedMenu1 as $key => $value) :
//            if ($parent_id == $value->navigation_id) {
//                $accessMenu[] = $value;
//            }
//        endforeach;
//
//        dumpVar($accessMenu);
//
//        if ($accessMenu) {
//            dumpVar($accessMenu);
//        }
//        return $accessMenu;
//    }
    function get_data_list_by_main_menu_id($parent_id, $admin_id) {
        $this->db->where('parent_id', $parent_id);
        $this->db->where('admin_id', $admin_id);
        return $this->db->get("admin_role")->result_array();
    }

    function get_data_list_by_sub_menu_id($navigation_id, $admin_id) {
        $this->db->where('navigation_id', $navigation_id);
        $this->db->where('user_id', $admin_id);
        return $this->db->get("access_setting")->result_array();
    }

// add new data into a database table
    function insert_data($table_name, $data) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

// update data by id of a database table
    function update_data($table_name, $data, $column_name, $column_value) {
        $this->db->where($column_name, $column_value);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

// delete data by id of a database table
    function delete_data($table_name, $column_name, $column_value) {
        $this->db->where($column_name, $column_value);
        $this->db->delete($table_name);
        return $this->db->affected_rows();
    }

//delete data by multiple condition
    function delete_data_with_condition($table_name, $array) {
        $this->db->where($array);
        $this->db->delete($table_name);
        return $this->db->affected_rows();
    }

// get data list by single column of a database table
    function get_data_list_by_single_column($table_name, $column_name, $column_value, $order_column_name = NULL, $order = NULL, $start_limit = NULL, $per_page = NULL) {
        if (isset($order_column_name) && isset($order))
            $this->db->order_by($order_column_name, $order);
        if (isset($start_limit))
            $this->db->limit($per_page, $start_limit);
        $this->db->where($column_name, $column_value);
        return $this->db->get($table_name)->result();
    }

// get all data list of a database table
    function get_data_list($table_name, $order_column_name = NULL, $order = NULL, $start_limit = NULL, $per_page = NULL) {
        if (isset($order_column_name) && isset($order))
            $this->db->order_by($order_column_name, $order);
        if (isset($start_limit))
            $this->db->limit($per_page, $start_limit);
        return $this->db->get($table_name)->result();
    }

// get single data by single column of a database table
    function get_single_data_by_single_column($table_name, $column_name, $column_value) {
        $this->db->where($column_name, $column_value);
        return $this->db->get($table_name)->row();
    }

// get single data by many columns of a database table
    function get_data_list_by_many_columns($table_name, $column_array, $order_column_name = NULL, $order = NULL, $start_limit = NULL, $per_page = NULL) {
        $this->db->where($column_array);
        if (isset($order_column_name) && isset($order))
            $this->db->order_by($order_column_name, $order);
        if (isset($start_limit))
            $this->db->limit($per_page, $start_limit);
        return $this->db->get($table_name)->result();
    }

// get single data by many columns of a database table
    function get_single_data_by_many_columns($table_name, $column_array, $order_column_name = null, $order = null) {
        $this->db->where($column_array);
        if (isset($order_column_name) && isset($order))
            $this->db->order_by($order_column_name, $order);
        $result = $this->db->get($table_name)->row();
        return $result;
    }

// get number of rows of a database table
    function count_all_data($table_name) {
        if (isset($column_array)) {
            return $this->db->count_all($table_name)->where($column_array);
        } else {
            return $this->db->count_all($table_name);
        }
    }

    function get_purchase_list($dist_id) {
        $this->db->select('*');
        $this->db->from('generals');
        $this->db->where('dist_id', $dist_id);
        $this->db->where('form_id', 11);
        $this->db->order_by("generals_id", "desc");
        $this->db->limit('5');
        return $this->db->get()->result();
    }

    function get_sales_list($dist_id) {
        $this->db->select('*');
        $this->db->from('generals');
        $this->db->where('dist_id', $dist_id);
        $this->db->where('form_id', 5);
        $this->db->order_by("generals_id", "desc");
        $this->db->limit('5');
        return $this->db->get()->result();
    }

    function get_payment_list($dist_id) {
        $this->db->select('*');
        $this->db->from('generals');
        $this->db->where('dist_id', $dist_id);
        $this->db->where('form_id', 2);
        $this->db->order_by("generals_id", "desc");
        $this->db->limit('5');
        return $this->db->get()->result();
    }

    function get_receive_list($dist_id) {
        $this->db->select('*');
        $this->db->from('generals');
        $this->db->where('dist_id', $dist_id);
        $this->db->where('form_id', 3);
        $this->db->order_by("generals_id", "desc");
        $this->db->limit('5');
        return $this->db->get()->result();
    }

    function get_journal_list($dist_id) {
        $this->db->select('*');
        $this->db->from('generals');
        $this->db->where('dist_id', $dist_id);
        $this->db->where('form_id', 1);
        $this->db->order_by("generals_id", "desc");
        $this->db->limit('5');
        return $this->db->get()->result();
    }
    //    $joins[0]['table'] = 'reference';
//    $joins[0]['conditionition'] = 'reference.reference_id=customer.reference_id';
//    $joins[0]['jointype'] = 'left';
//
//    $condition['customer.customer_id'] = $customerid;
//    $condition['customer.dist_id'] = $this->dist_id;
//    $select_fields = 'customer.customerPhone,customer.customerAddress,customer.division,customer.thanna,customer.district,reference.reference_id,reference.refCode,reference.referenceName,reference.referencePhone';
//
//
//    $customer_info = $this->Common_model->join_select_one_row_array('customer', $select_fields, $joins, $condition);

//    // result_array() - ALL as array
    public function join_select_all_row_obj($table, $select_fields, $joins = array(), $condition = array(),$optional=null, $group_by = "", $order_by = array(), $limit = '') {
        $this->db->select($select_fields);
        $this->db->from($table);
        if (!empty($joins)) {
            foreach ($joins as $k => $v) {
                $this->db->join($v['table'], $v['conditionition'], $v['jointype']);
            }
        }
        if (!empty($group_by)) {
            $this->db->group_by($group_by);
        }

        if (!empty($order_by)) {
            $this->db->order_by($table . '.' . $order_by['field'], $order_by['type']);
        }
        if ($limit)
            $this->db->limit($limit);
        if (!empty($condition)) {
            $this->db->where($condition);
        }
        //if($optional=='Y'){
          //  $this->db->or_where($table.'.dist_id', 1);
        //}

        $sql = $this->db->get();
        // echo $this->db->last_query(); exit;
        return $sql->result();
    }
    
    public function checkDuplicateProductType($distId, $product_type_name,$product_type_id = null) {
        $this->db->select("product_type.product_type_id");
        $this->db->from("product_type");
        $this->db->group_start();
        $this->db->where('product_type.dist_id', $distId);
        $this->db->or_where('product_type.dist_id', 1);
        $this->db->group_end();
        
        if (!empty($product_type_id)):
            $this->db->where('product_type.product_type_id !=', $product_type_id);
        endif;
        $this->db->where('product_type.product_type_name', $product_type_name);
        $getProductList = $this->db->get()->row();
        return $getProductList;
    }public function checkDuplicateProductPackage($distId, $package_name,$package_id = null) {
        $this->db->select("package.package_id");
        $this->db->from("package");
        $this->db->group_start();
        $this->db->where('package.dist_id', $distId);
        $this->db->or_where('package.dist_id', 1);
        $this->db->group_end();

        if (!empty($package_id)):
            $this->db->where('package.package_id !=', $package_id);
        endif;
        $this->db->where('package.package_name', $package_name);
        $getProductList = $this->db->get()->row();
        return $getProductList;
    }
    
     function update_data_by_dist_id($table_name, $data, $column_name, $column_value,$dist_id ) {
        $this->db->where($column_name, $column_value);
        $this->db->where('dist_id' , $dist_id);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }
    public function getProductType($distId) {
        $this->db->select("product_type_id,product_type_name");
        $this->db->from("product_type");
        $this->db->group_start();
        $this->db->where('dist_id', $distId);
        $this->db->or_where('dist_id', 1);
        $this->db->group_end();
        $this->db->where('is_active', 'Y');
        $this->db->where('is_delete', 'N');
        $this->db->order_by('product_type_id', 'ASE');
        $getUnitList = $this->db->get()->result();
        return $getUnitList;
    }
    public function  get_package_product($package_id){
        $this->db->select('package.package_id,package.package_name,package.package_code,package_products.product_id,productcategory.category_id,productcategory.title,product.productName,unit.unitTtile,brand.brandId,brand.brandName');
        $this->db->from('package');
        $this->db->join('package_products', 'package_products.package_id=package.package_id','left');
        $this->db->join('product', 'product.product_id=package_products.product_id','left');
        $this->db->join('productcategory', 'productcategory.category_id=product.category_id','left');
        $this->db->join('unit', 'unit.unit_id=product.unit_id','left');
        $this->db->join('brand', 'brand.brandId=product.brand_id','left');
        $this->db->where('package.package_id='.$package_id);
        $this->db->where('package_products.is_active="Y"');
        $this->db->where('package_products.is_delete="N"');
        $sql = $this->db->get();
        return $sql->result();
    }
    public function  get_purchase_product_detaild($package_id){
        $this->db->select('purchase_details.product_id,purchase_details.is_package,purchase_details.quantity,purchase_details.unit_price,
        product.productName,product.product_code,
        productcategory.category_id,productcategory.title,unit.unitTtile,brand.brandId,brand.brandName');
        $this->db->from('purchase_details');

        $this->db->join('product', 'product.product_id=purchase_details.product_id','left');
        $this->db->join('productcategory', 'productcategory.category_id=product.category_id','left');
        $this->db->join('unit', 'unit.unit_id=product.unit_id','left');
        $this->db->join('brand', 'brand.brandId=product.brand_id','left');
        $this->db->where('purchase_details.purchase_invoice_id='.$package_id);
        $sql = $this->db->get();
        return $sql->result();
    }

    public function  get_purchase_product_detaild3($package_id){
        $this->db->select('purchase_details.product_id,purchase_details.is_package,purchase_details.quantity,purchase_details.unit_price,
        product.productName,product.product_code,
        productcategory.category_id,productcategory.title,
        unit.unitTtile,
        brand.brandId,brand.brandName ,
        product.productName as return_productName,product.product_code as return_product_code,
        productcategory.category_id as return_category_id,productcategory.title as return_title,
        unit.unitTtile as return_unitTtile,
        brand.brandId as return_brandId,brand.brandName as return_brandName
        ');
        $this->db->from('purchase_details');
        $this->db->join('purchase_return_details', 'purchase_return_details.purchase_details_id=purchase_details.purchase_details_id','left');
        $this->db->join('product', 'product.product_id=purchase_details.product_id','left');
        $this->db->join('productcategory', 'productcategory.category_id=product.category_id','left');
        $this->db->join('unit', 'unit.unit_id=product.unit_id','left');
        $this->db->join('brand', 'brand.brandId=product.brand_id','left');

        $this->db->join('product as product_r', 'product_r.product_id=purchase_return_details.product_id','left');
        $this->db->join('productcategory as productcategory_r', 'productcategory_r.category_id=product_r.category_id','left');
        $this->db->join('unit as unit_r', 'unit_r.unit_id=product_r.unit_id','left');
        $this->db->join('brand as brand_r', 'brand_r.brandId=product_r.brand_id','left');
        $this->db->where('purchase_details.purchase_invoice_id='.$package_id);
        $sql = $this->db->get();
        return $sql->result();
    }


    public function  get_purchase_product_detaild2($package_id){
        $query="SELECT
                    purchase_details.purchase_details_id,
                    purchase_details.purchase_invoice_id,
                    purchase_details.is_package,
                    purchase_details.product_id,
                    product.productName,
                    product.product_code,
                    productcategory.title,
                    product.category_id,
                    unit.unitTtile,
                    brand.brandName,
                    product2.productName AS return_product_name,
                    product2.product_code AS return_product_code,
                    productcategory2.title AS return_product_cat,
                    unit2.unitTtile AS return_product_unit,
                    brand2.brandName AS return_product_brand,
                    purchase_details.quantity,
                    purchase_details.unit_price,
                    purchase_return_details.product_id AS return_product_id,
                    purchase_return_details.returnable_quantity,
                    purchase_return_details.return_quantity
                FROM
                    purchase_details
                LEFT JOIN purchase_return_details ON purchase_return_details.purchase_details_id = purchase_details.purchase_details_id
                AND purchase_return_details.is_active = 'Y'
                AND purchase_return_details.is_delete = 'N'
                LEFT JOIN product ON product.product_id = purchase_details.product_id
                LEFT JOIN productcategory ON productcategory.category_id = product.category_id
                LEFT JOIN unit ON unit.unit_id = product.unit_id
                LEFT JOIN brand ON brand.brandId = product.brand_id
                LEFT JOIN product AS product2 ON product2.product_id = purchase_return_details.product_id
                LEFT JOIN productcategory AS productcategory2 ON productcategory2.category_id = product2.category_id
                LEFT JOIN unit AS unit2 ON unit2.unit_id = product2.unit_id
                LEFT JOIN brand AS brand2 ON brand2.brandId = product2.brand_id
                WHERE
                    purchase_details.is_active = 'Y'
                AND purchase_details.is_delete = 'N'
                AND purchase_details.purchase_invoice_id =".$package_id;
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }
    public function  get_sales_product_detaild2($sales_invoice_id){
        $query="SELECT
                    sales_details.sales_details_id,
                    sales_details.sales_invoice_id,
                    sales_details.is_package,
                    sales_details.product_id,
                    product.productName,
                    product.category_id,
                    product.product_code,
                    productcategory.title,
                    unit.unitTtile,
                    brand.brandName,
                    product2.productName AS return_product_name,
                    product2.product_code AS return_product_code,
                    productcategory2.title AS return_product_cat,
                    unit2.unitTtile AS return_product_unit,
                    brand2.brandName AS return_product_brand,
                    sales_details.quantity,
                    sales_details.unit_price,
                    sales_return_details.product_id AS return_product_id,
                    sales_return_details.returnable_quantity,
                    sales_return_details.sales_return_id,
                    sales_return_details.return_quantity
                FROM
                    sales_details
                LEFT JOIN sales_return_details ON sales_return_details.sales_details_id = sales_details.sales_details_id
                AND sales_return_details.is_active = 'Y'
                AND sales_return_details.is_delete = 'N'
                LEFT JOIN product ON product.product_id = sales_details.product_id
                LEFT JOIN productcategory ON productcategory.category_id = product.category_id
                LEFT JOIN unit ON unit.unit_id = product.unit_id
                LEFT JOIN brand ON brand.brandId = product.brand_id
                LEFT JOIN product AS product2 ON product2.product_id = sales_return_details.product_id
                LEFT JOIN productcategory AS productcategory2 ON productcategory2.category_id = product2.category_id
                LEFT JOIN unit AS unit2 ON unit2.unit_id = product2.unit_id
                LEFT JOIN brand AS brand2 ON brand2.brandId = product2.brand_id
                WHERE
                    sales_details.is_active = 'Y'
                AND sales_details.is_delete = 'N'
                AND sales_details.sales_invoice_id =".$sales_invoice_id;
        $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }


    public function  cylinder_sales_report($customerId,$start_date,$end_date){
        $query="SELECT
                    sales_invoice_info.sales_invoice_id,
                    sales_invoice_info.invoice_no,
                    sales_invoice_info.customer_invoice_no,
                    sales_invoice_info.invoice_date,
                    sales_invoice_info.payment_type,
                    sales_invoice_info.customer_id,
                    customer.customerID,
                    customer.customerType,
                    customer.customerName,
                    sales_details.sales_details_id,
                    sales_details.sales_invoice_id,
                    sales_details.is_package,
                    sales_details.product_id,
                    product.productName,
                    product.product_code,
                    productcategory.title,
                    unit.unitTtile,
                    brand.brandName,
                    product2.productName AS return_product_name,
                    product2.product_code AS return_product_code,
                    productcategory2.title AS return_product_cat,
                    unit2.unitTtile AS return_product_unit,
                    brand2.brandName AS return_product_brand,
                    sales_details.quantity,
                    sales_details.unit_price,
                    sales_return_details.product_id AS return_product_id,
                    sales_return_details.returnable_quantity,
                    sales_return_details.return_quantity
                FROM
                    sales_invoice_info
                LEFT JOIN customer ON customer.customer_id = sales_invoice_info.customer_id
                LEFT JOIN sales_details ON sales_details.sales_invoice_id = sales_invoice_info.sales_invoice_id
                LEFT JOIN sales_return_details ON sales_return_details.sales_details_id = sales_details.sales_details_id 
                AND sales_return_details.is_active = 'Y' 
                AND sales_return_details.is_delete = 'N'
                LEFT JOIN product ON product.product_id = sales_details.product_id
                LEFT JOIN productcategory ON productcategory.category_id = product.category_id
                LEFT JOIN unit ON unit.unit_id = product.unit_id
                LEFT JOIN brand ON brand.brandId = product.brand_id
                LEFT JOIN product AS product2
                ON
                    product2.product_id = sales_return_details.product_id
                LEFT JOIN productcategory AS productcategory2
                ON
                    productcategory2.category_id = product2.category_id
                LEFT JOIN unit AS unit2
                ON
                    unit2.unit_id = product2.unit_id
                LEFT JOIN brand AS brand2
                ON
                    brand2.brandId = product2.brand_id
                WHERE
                    sales_invoice_info.is_active = 'Y' 
                    AND sales_invoice_info.is_delete = 'N' 
                    AND sales_details.is_active = 'Y' 
                    AND sales_details.is_delete = 'N'";
        if($customerId!="all"){
            $query.="AND sales_invoice_info.customer_id =".$customerId;
        }



                $query = $this->db->query($query);
        $result = $query->result();
        return $result;
    }






    

}

?>