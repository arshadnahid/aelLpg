<?php
if (isset($_POST['start_date'])):
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $categoryId = $this->input->post('categoryId');
    $brandId = $this->input->post('brandId');

//dumpVar($_POST);

endif;
?>
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state noPrint" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/3'); ?>">Inventory</a>
                </li>
                <li class="active">Stock Report</li>
            </ul>

            <ul class="breadcrumb pull-right">

                <li>
                    <a href="<?php echo site_url('DistributorDashboard/3'); ?>">
                        <i class="ace-icon fa fa-list"></i>
                        List
                    </a>
                </li>


            </ul>



        </div>
        <br>
        <div class="page-content">
            <div class="row noPrint">
                <div class="col-md-12">
                    <form id="publicForm" action=""  method="post" class="form-horizontal">

                        <div class="table-header">
                            Stock Report
                        </div>
                        <br>
                        <div style="background-color: grey!important;">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Category</label>
                                    <div class="col-sm-8">
                                        <select  name="categoryId" class="chosen-select form-control supplierid" id="form-field-select-3" data-placeholder="Search by Category">
                                            <option <?php
if (!empty($categoryId) && $categoryId == 'All') {
    echo "selected";
}
?> value="All">All</option>
                                                <?php foreach ($categoryList as $eachInfo): ?>
                                                <option <?php
                                                if (!empty($categoryId) && $categoryId == $eachInfo->category_id) {
                                                    echo "selected";
                                                }
                                                    ?> value="<?php echo $eachInfo->category_id; ?>"><?php echo $eachInfo->title; ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Brand</label>
                                    <div class="col-sm-8">
                                        <select  name="brandId" class="chosen-select form-control supplierid" id="form-field-select-3" data-placeholder="Search by Category">
                                            <option <?php
                                                if (!empty($brandId) && $brandId == 'All') {
                                                    echo "selected";
                                                }
                                                ?> value="All">All</option>
                                                <?php foreach ($brandList as $eachInfo): ?>
                                                <option <?php
                                                if (!empty($brandId) && $brandId == $eachInfo->brandId) {
                                                    echo "selected";
                                                }
                                                    ?> value="<?php echo $eachInfo->brandId; ?>"><?php echo $eachInfo->brandName; ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> From Date</label>
                                    <div class="col-sm-8">
                                        <input type="text"class="date-picker" id="start_date" name="start_date" value="<?php
                                                if (!empty($start_date)) {
                                                    echo $start_date;
                                                } else {
                                                    echo date('d-m-Y');
                                                }
                                                ?>" data-date-format='dd-mm-yyyy' placeholder="Start Date: dd-mm-yyyy"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> To Date</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="date-picker" id="end_date" name="end_date" value="<?php
                                               if (!empty($end_date)) {
                                                   echo $end_date;
                                               } else {
                                                   echo date('d-m-Y');
                                               }
                                                ?>" data-date-format='dd-mm-yyyy' placeholder="End Date: dd-mm-yyyy"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">


                                
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Search
                                    </button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-info btn-sm"  onclick="window.print();" style="cursor:pointer;">
                                        <i class="ace-icon fa fa-print  align-top bigger-125 icon-on-right"></i>
                                        Print
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </form>
                </div>
            </div><!-- /.col -->
            <?php
            if (isset($_POST['start_date'])):
                $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
                $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
                $categoryId = $this->input->post('categoryId');
                $brandId = $this->input->post('brandId');


                unset($_SESSION["categoryId"]);
                unset($_SESSION["start_date"]);
                unset($_SESSION["end_date"]);


                $_SESSION["categoryId"] = $categoryId;
                $_SESSION["start_date"] = $start_date;
                $_SESSION["end_date"] = $end_date;
                $dist_id = $this->dist_id;

                $dr = 0;
                $cr = 0;
                ?>
                <div class="row">
                    <div class="col-xs-12">

                        <div class="table-header">
                            Stock Report <span style="color:greenyellow;">From <?php echo $start_date; ?> To <?php echo $end_date; ?></span>
                        </div>
                        <div class="noPrint">
    <!--                        <a style="border-radius:100px 0 100px 0;" href="<?php echo site_url('InventoryController/stockReport_export_excel/') ?>" class="btn btn-success pull-right noPrint">
                            <i class="ace-icon fa fa-download"></i>
                            Excel 
                        </a>-->
                        </div>

                        <table class="table table-responsive">
                            <tr>
                                <td style="text-align:center;">
                                    <h3><?php echo $companyInfo->companyName; ?>.</h3>

                                    <span><?php echo rtrim($companyInfo->address); ?></span><br>
                                    <strong>Phone : </strong><?php echo $companyInfo->phone; ?><br>
                                    <strong>Email : </strong><?php echo $companyInfo->email; ?><br>
                                    <strong>Website : </strong><?php echo $companyInfo->website; ?><br>

                                    <strong><?php echo $pageTitle; ?></strong>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                                <tr>

                                    <td rowspan="2" style="text-align:center;"><strong>Category</strong></td>
                                    <td rowspan="2"  style="text-align:center;"><strong>Products</strong></td>
                                    <td rowspan="2"  style="text-align:center;"><strong>Products Code</strong></td>
                                    <td colspan="3"  style="text-align:center;"><strong>Opening Stock as on </strong></td>
                                    <td colspan="3"  style="text-align:center;"><strong>Purchase</strong></td>
                                    <td colspan="3"  style="text-align:center;"><strong>Sales</strong></td>
                                    <td colspan="3"  style="text-align:center;"><strong>Closing stock as on </strong>
                                    </td>

                                </tr>
                                <tr>   
                                    <td align="center">Qty</td>
                                    <td align="center"> Rate</td>
                                    <td align="center">TK</td>
                                    <td align="center">Qty</td>
                                    <td align="center"> Rate</td>
                                    <td align="center">TK</td>
                                    <td align="center">Qty</td>
                                    <td align="center"> Rate</td>
                                    <td align="center">TK</td>
                                    <td align="center">Qty</td>
                                    <td align="center">Rate</td>
                                    <td align="center">TK</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $open_qty = 0;
                                $opening_value = 0;
                                $purchases_qty = 0;
                                $purchases_value = 0;
                                $sale_qty = 0;
                                $sales_value = 0;
                                $closing_qty = 0;
                                $closing_value = 0;

                                if (!empty($categoryId) && $categoryId == 'All'):
                                    $productList = $this->Common_model->getPublicProductWithoutCatCylin($this->dist_id, 2);
                                elseif (!empty($categoryId) && $categoryId != 'All'):
                                    $productList = $this->Common_model->getPublicProduct($this->dist_id, $categoryId);
                                else:
                                    $productList = $this->Common_model->getPublicProductWithoutCat($this->dist_id);
                                endif;
                                foreach ($productList as $key => $each_product):
                                    $reportStock = $this->Inventory_Model->getStockReport($start_date, $end_date, $each_product->product_id, $brandId);
                                    //  dumpVar($reportStock);
                                    $mainOpeningStock = $reportStock['mainOpeningStock']['totalOpeQty'];
                                    $openingStock = $reportStock['openingStock']['totalOpeQty'] - $reportStock['openingOut']['totalOpeQty'];
                                    $open_qty += $openingStock = $mainOpeningStock + $openingStock;
                                    $openingAvgPrice = $reportStock['totalAvgPurcPrice'];
                                    $purchases_qty += $purchasesStock = $reportStock['purchasesStock']['totalPurcQty'];
                                    $purchasesAvgPrice = $reportStock['totalAvgPurcPrice'];
                                    $sale_qty += $saleStock = $reportStock['saleStock']['totalSaleQty'];
                                    $saleAvgPrice = $reportStock['totalAvgSalesPrice'];
                                    $closing = (($openingStock + $purchasesStock) - $saleStock);
                                    $closing_qty += $closing;
                                    $closing_value += $closing * $purchasesAvgPrice;
                                    $opening_value+=$openingStock * $purchasesAvgPrice;
                                    $purchases_value+=$purchasesStock * $purchasesAvgPrice;
                                    $sales_value+=$saleStock * $purchasesAvgPrice;
//                                    

                                    if (!empty($reportStock['mainOpeningStock']['totalOpeQty']) || !empty($reportStock['openingStock']['totalOpeQty']) || !empty($reportStock['purchasesStock']['totalPurcQty']) || !empty($reportStock['saleStock']['totalSaleQty'])):
                                        $productCat = $this->Common_model->tableRow('product', 'product_id', $each_product->product_id)->category_id;
                                        ?>
                                        <tr>

                                            <td><?php echo $this->Common_model->tableRow('productcategory', 'category_id', $productCat)->title; ?></td>
                                            <td><?php
                            $productInfo = $this->Common_model->tableRow('product', 'product_id', $each_product->product_id);
                            echo $productInfo->productName;
                            echo ' [ ' . $this->Common_model->tableRow('brand', 'brandId', $productInfo->brand_id)->brandName . ' ] ';
                                        ?></td>
                                            <td><?php echo $this->Common_model->tableRow('product', 'product_id', $each_product->product_id)->product_code; ?></td>
                                            <td  align="right"><?php
                                    if (!empty($openingStock)):
                                        echo $openingStock;
                                    endif;
                                        ?></td>
                                            <td align="right"><?php
                                    if (!empty($openingStock)):

                                        echo number_format((float) abs($purchasesAvgPrice), 2, '.', ',');
                                    endif;
                                        ?></td>
                                            <td align="right"><?php
                                    if (!empty($openingStock)):

                                        echo number_format((float) abs($openingStock * $purchasesAvgPrice), 2, '.', ',');
                                    endif;
                                        ?></td>
                                            <td align="right"><?php
                                    if (!empty($purchasesStock)):

                                        echo $purchasesStock;
                                    endif;
                                        ?></td>
                                            <td align="right"><?php
                                    if (!empty($purchasesStock)):
                                        echo number_format((float) abs($purchasesAvgPrice), 2, '.', ',');
                                    endif;
                                        ?></td>
                                            <td align="right"><?php
                                    if (!empty($purchasesStock)):

                                        echo number_format((float) abs($purchasesStock * $purchasesAvgPrice), 2, '.', ',');
                                    endif;
                                        ?></td>
                                            <td align="right"><?php
                                    if (!empty($saleStock)) {
                                        echo $saleStock;
                                    }
                                        ?></td>
                                            <td align="right"><?php
                                    if (!empty($saleStock)):

                                        echo number_format((float) abs($saleAvgPrice), 2, '.', ',');
                                    endif;
                                        ?></td>
                                            <td  align="right"><?php
                                    if (!empty($saleStock)):
                                        echo number_format((float) abs($saleStock * $saleAvgPrice), 2, '.', ',');
                                    endif;
                                        ?></td>
                                            <td align="right"><?php echo $closing; ?></td>
                                            <td align="right"><?php echo number_format((float) abs($purchasesAvgPrice), 2, '.', ','); ?></td>
                                            <td align="right"><?php echo number_format((float) abs($closing * $purchasesAvgPrice), 2, '.', ','); ?></td>
                                        </tr>
                                        <?php
                                    endif;
                                endforeach;
                                ?>
                            </tbody>
                            <tfoot>                             
                                <tr>
                                    <td colspan="3" align="right"><strong>Total (BDT) </strong></td>

                                    <td align="right" colspan="3"><strong><?php echo number_format((float) $opening_value, 2, '.', ','); ?></strong></td>
                                    <td align="right" colspan="3"><strong><?php echo number_format((float) $purchases_value, 2, '.', ','); ?></strong></td>
                                    <td align="right" colspan="3"><strong> <?php echo number_format((float) $sales_value, 2, '.', ','); ?></strong></td>
                                    <td align="right" colspan="3"><strong> <?php echo number_format((float) $closing_value, 2, '.', ','); ?></strong></td>
                                </tr>
                            </tfoot>    

                        </table> 
                    </div>
                </div>
            <?php endif; ?>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>

