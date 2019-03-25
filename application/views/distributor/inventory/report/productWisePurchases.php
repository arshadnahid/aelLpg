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
                    <a href="<?php echo site_url('DistributorDashboard/3'); ?>">Inventory</a>
                </li>
                <li class="active">Product Wise Purchases Report</li>
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
            <div class="row  noPrint">
                <div class="col-md-12">
                    <form id="publicForm" action=""  method="post" class="form-horizontal">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="table-header">
                                Product wise Purchases Report
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
                                            ?>" data-date-format='dd-mm-yyyy' placeholder="End Date:dd-mm-yyyy"/>
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

                $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
                $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));

                $productId = $this->input->post('productId');

                if ($productId != 'all'):
                    ?>
                    <div class="row">
                        <div class="col-xs-10 col-xs-offset-1">

                            <div class="table-header">
                                Product Wise Purchases Report <span style="color:greenyellow;">From <?php echo $start_date; ?> To <?php echo $end_date; ?></span>
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
                            <table class="table table-striped table-bordered table-hover table-responsive">
                                <thead>
                                    <tr>   
                                        <td align="center"><strong>SL</strong></td>
                                        <td align="center"><strong>Date</strong></td>
                                        <td align="center"><strong>Voucher</strong></td>
                                        <td align="center"><strong>Supplier</strong></td>
                                        <td align="center"><strong>Qty</strong></td>
                                        <td align="center"><strong>Unit Price(BDT)</strong></td>
                                        <td align="center"><strong>Total Price(BDT)</strong></td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qty = 0;
                                    $priice = 0;




                                    $productWiseSales = $this->Inventory_Model->getProductWiseSalesReport($this->dist_id, $productId, $start_date, $end_date);
                                    //echo $this->db->last_query();die;
                                    foreach ($productWiseSales as $key => $each_product):
                                        ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td><?php
                                                $voucherId = $this->Inventory_Model->getVoucherIdByGeneralId($each_product->generals_id);
                                                echo date('M d, Y', strtotime($each_product->date));
                                                ?></td>

                                            <td><a class="blue" href="<?php echo site_url('viewPurchases/' . $voucherId); ?>"><?php echo $voucherId; ?></a></td>
                                            <td><?php echo $this->Inventory_Model->getCustomerOrSupplierIdByGeneralId($each_product->generals_id); ?></td>
                                            <td align="right"><?php
                                                echo $each_product->quantity;
                                                $qty += $each_product->quantity;
                                                ?></td>
                                            <td align="right"><?php echo number_format($each_product->rate); ?></td>
                                            <td align="right"><?php
                                                echo number_format($each_product->quantity * $each_product->rate);
                                                $priice += $each_product->quantity * $each_product->rate;
                                                ?></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                </tbody>
                                <tfoot>                             
                                    <tr>
                                        <td align="right" colspan="4"><strong>Total</strong></td>
                                        <td align='right'><strong><?php echo $qty; ?></strong></td>
                                        <td></td>
                                        <td align='right'><strong><?php echo number_format($priice); ?></strong></td>
                                    </tr>
                                </tfoot>    

                            </table> 
                        </div>
                    </div>

                <?php else: ?>
                    <div class="row">
                        <div class="col-xs-10 col-xs-offset-1">

                            <div class="table-header">
                                Product Wise Purchases Report <span style="color:greenyellow;">From <?php echo $start_date; ?> To <?php echo $end_date; ?></span>
                            </div>


                            <table class="table table-responsive">
                                <tr>
                                    <td style="text-align:center;">
                                        <h3><?php echo $companyInfo->companyName; ?>.</h3>
                                        <p><?php echo $companyInfo->dist_address; ?>
                                        </p>

                                        <strong>Phone : </strong><?php echo $companyInfo->dist_phone; ?><br>
                                        <strong>Email : </strong><?php echo $companyInfo->dist_email; ?><br>
                                        <strong>Website : </strong><?php echo $companyInfo->dis_website; ?><br>
                                        <strong><?php echo "All Product Purchases Report"; ?></strong>
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-striped table-bordered table-hover table-responsive">
                                <thead>
                                    <tr>   
                                        <td align="center"><strong>SL</strong></td>
                                        <td align="center"><strong>Product</strong></td>
                                        <td align="center"><strong>Qty</strong></td>
                                        <td align="center"><strong>Unit Price(BDT)</strong></td>
                                        <td align="center"><strong>Total Price(BDT)</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qty = 0;
                                    $priice = 0;
                                    $sl = 1;


                                    foreach ($productList as $productSerial => $eachInfo):

                                        $productWisePurcahses = $this->Inventory_Model->getProductSummationReport($this->dist_id, $eachInfo->product_id, $start_date, $end_date);
                                        //echo $this->db->last_query();die;
                                        if (!empty($productWisePurcahses->totalQty)):
                                            ?>
                                            <tr>
                                                <td><?php echo $sl++; ?></td>
                                                <td><?php echo $productWisePurcahses->productName . ' [ ' . $productWisePurcahses->brandName . ' ] '; ?></td>
                                                <td align="right"><?php
                                                    echo $productWisePurcahses->totalQty;
                                                    $qty += $productWisePurcahses->totalQty;
                                                    ?></td>
                                                <td align="right"><?php echo number_format($productWisePurcahses->totalAvgRate); ?></td>
                                                <td align="right"><?php
                                                    echo number_format($productWisePurcahses->totalQty * $productWisePurcahses->totalAvgRate);
                                                    $priice += $productWisePurcahses->totalQty * $productWisePurcahses->totalAvgRate;
                                                    ?></td>
                                            </tr>
                                            <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </tbody>
                                <tfoot>                             
                                    <tr>
                                        <td align="right" colspan="2"><strong>Total</strong></td>
                                        <td align='right'><strong><?php echo $qty; ?></strong></td>
                                        <td></td>
                                        <td align='right'><strong><?php echo number_format($priice); ?></strong></td>
                                    </tr>
                                </tfoot>    

                            </table> 
                        </div>
                    </div>


                <?php endif; ?>

            <?php endif; ?>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker.min.js"></script>
