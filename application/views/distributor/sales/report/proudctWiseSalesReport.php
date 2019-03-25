<?php
if (isset($_POST['start_date'])):
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $productId = $this->input->post('productId');
endif;
?>
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state noPrint" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                   <a href="<?php echo site_url('DistributorDashboard/2');?>">Sales</a>
                </li>
                <li class="active">Product Wise Sales Report</li>
            </ul>
            <ul class="breadcrumb pull-right">
                <li>
                    <a href="<?php echo site_url('DistributorDashboard/2'); ?>">
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
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="table-header">
                                Product wise sales Report
                            </div>
                            <br>
                            <div style="background-color: grey!important;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Product</label>
                                        <div class="col-sm-9">
                                            <select  name="productId" class="chosen-select form-control supplierid" id="form-field-select-3" data-placeholder="Search by Product">
                                                <option <?php
                                                if ($productId == 'all') {
                                                    echo "selected";
                                                }
                                                ?> value="all">All</option>
                                                    <?php
                                                    foreach ($productList as $eachInfo):
                                                        $brandInfo = $this->Common_model->tableRow('brand', 'brandId', $eachInfo->brand_id)->brandName;
                                                        ?>
                                                    <option <?php
                                                    if (!empty($productId) && $productId == $eachInfo->product_id) {
                                                        echo "selected";
                                                    }
                                                    ?> value="<?php echo $eachInfo->product_id; ?>"><?php echo $eachInfo->productName . ' [ ' . $brandInfo . ' ] '; ?></option>
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
                                                echo date('Y-m-d');
                                            }
                                            ?>" data-date-format='yyyy-mm-dd' placeholder="Start Date: yyyy-mm-dd"/>
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
                                                echo date('Y-m-d');
                                            }
                                            ?>" data-date-format='yyyy-mm-dd' placeholder="End Date: yyyy-mm-dd"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <!--<label class="col-sm-2 control-label no-padding-right" for="form-field-1"></label>-->
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
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div><!-- /.col -->
            <?php
            if (isset($_POST['start_date'])):
                $start_date = $this->input->post('start_date');
                $end_date = $this->input->post('end_date');
                $productId = $this->input->post('productId');
                ?>
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1">
                        <div class="table-header">
                            Stock Report <span style="color:greenyellow;">From <?php echo $start_date; ?> To <?php echo $end_date; ?></span>
                        </div>
                        <table class="table table-responsive">
                            <tr>
                                <td style="text-align:center;">
                                    <h3><?php echo $companyInfo->companyName; ?>.</h3>
                                    <span><?php echo $companyInfo->address; ?></span><br>
                                    <strong>Phone : </strong><?php echo $companyInfo->phone; ?><br>
                                    <strong>Email : </strong><?php echo $companyInfo->email; ?><br>
                                    <strong>Website : </strong><?php echo $companyInfo->website; ?><br>
                                    <strong><?php echo $pageTitle; ?></strong>
                                </td>
                            </tr>
                        </table>
                        <?php if ($productId == 'all'): ?>
                            <table class="table table-striped table-bordered table-hover table-responsive">
                                <thead>
                                    <tr>
                                        <td align="center">SL</td>
                                        <td align="center">Product</td>
                                        <td align="center">Qty</td>
                                        <td align="center">Total Sales Price(BDT)</td>
                                        <td align="center">GP Profit</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $open_qty = 0;
                                    $purchases_qty = 0;
                                    $sale_qty = 0;
                                    $closing_qty = 0;
                                    $closing_value = 0;
                                    $sl = 1;
                                    $qty = 0;
                                    $price = 0;
                                    $gpPrice = 0;
                                    foreach ($productList as $key => $eachProduct):
                                        $productWiseSales = $this->Sales_Model->getProductWiseSalesReportAll($this->dist_id, $eachProduct->product_id, $start_date, $end_date);
                                        $averagePurchasesPrice = $this->Sales_Model->getAveragePurchasesPriceAll($this->dist_id, $eachProduct->product_id);
                                        if (!empty($productWiseSales->totalSalesQty) || !empty($productWiseSales->totalAvgSalesPrice)):
                                            ?>
                                            <tr>
                                                <td><?php echo $sl++; ?></td>
                                                <td>
                                                    <?php
                                                    $brandInfo = $this->Common_model->tableRow('brand', 'brandId', $eachProduct->brand_id)->brandName;
                                                    echo $eachProduct->productName . ' [ ' . $brandInfo . ' ] ';
                                                    ?>
                                                </td>
                                                <td align='right'>
                                                    <?php
                                                    echo $productWiseSales->totalSalesQty;
                                                    $qty += $productWiseSales->totalSalesQty;
                                                    ?>
                                                </td>
                                                <td align='right'>
                                                    <?php
                                                    echo number_format((float) $productWiseSales->totalSalesQty * $productWiseSales->totalAvgSalesPrice, 2, '.', ',');
                                                    $price += $productWiseSales->totalSalesQty * $productWiseSales->totalAvgSalesPrice;
                                                    ?>
                                                </td>
                                                <td align='right'>
                                                    <?php
                                                    $gpPrice += ($productWiseSales->totalSalesQty * $productWiseSales->totalAvgSalesPrice) - ($productWiseSales->totalSalesQty * $averagePurchasesPrice);
                                                    echo number_format(($productWiseSales->totalSalesQty * $productWiseSales->totalAvgSalesPrice) - ($productWiseSales->totalSalesQty * $averagePurchasesPrice));
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td align='right' colspan="3"><strong>Total</strong></td>
                                        <td align='right' >
                                            <strong>
                                                <?php
                                                echo number_format((float) $price, 2, '.', ',');
                                                ?>
                                            </strong>
                                        </td>
                                        <td align='right'>
                                            <strong>
                                                <?php
                                                echo number_format((float) $gpPrice, 2, '.', ',');
                                                ?>
                                            </strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php else: ?>
                            <table class="table table-striped table-bordered table-hover table-responsive">
                                <thead>
                                    <tr>
                                        <td align="center">SL</td>
                                        <td align="center">Date</td>
                                        <td align="center">Voucher</td>
                                        <td align="center">Customer</td>
                                        <td align="center">Qty</td>
                                        <td align="center">Sales Price(BDT)</td>
                                        <td align="center">Gross Profit</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $open_qty = 0;
                                    $purchases_qty = 0;
                                    $sale_qty = 0;
                                    $closing_qty = 0;
                                    $closing_value = 0;
                                    $tsalesPrice = 0;
                                    $tGpPrice = 0;
                                    $productWiseSales = $this->Sales_Model->getProductWiseSalesReport($this->dist_id, $productId, $start_date, $end_date);
                                    $averagePurchasesPrice = $this->Sales_Model->getAveragePurchasesPrice($this->dist_id, $productId);
                                    foreach ($productWiseSales as $key => $each_product):
                                        ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td><?php echo $each_product->date; ?></td>
                                            <td><a title="view invoice" href="<?php echo site_url('salesInvoice_view/' . $each_product->generals_id); ?>"><?php echo $each_product->voucher_no; ?></a></td>
                                            <td>
                                                <a href="<?php echo site_url('customerDashboard/' . $each_product->customer_id); ?>"><?php
                                                    echo $each_product->customerID . ' [ ' . $each_product->customerName . ' ] ';
                                                    ?>
                                                </a>
                                            </td>
                                            <td align='right'><?php echo $each_product->quantity; ?></td>
                                            <td align='right'>
                                                <?php
                                                $tsalesPrice += $each_product->quantity * $each_product->rate;
                                                echo number_format((float) $each_product->quantity * $each_product->rate, 2, '.', ',');
                                                ?>
                                            </td>
                                            <td align='right'>
                                                <?php
                                                $tGpPrice += ($each_product->quantity * $each_product->rate) - ($each_product->quantity * $averagePurchasesPrice);
                                                echo number_format((float) ($each_product->quantity * $each_product->rate) - ($each_product->quantity * $averagePurchasesPrice), 2, '.', ',');
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td align='right' colspan="5"><strong>Total</strong></td>
                                        <td align='right'>
                                            <?php
                                            echo number_format((float) $tsalesPrice, 2, '.', ',');
                                            ?>
                                        </td>
                                        <td align='right'>
                                            <?php
                                            echo number_format((float) $tGpPrice, 2, '.', ',');
                                            ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker.min.js"></script>
