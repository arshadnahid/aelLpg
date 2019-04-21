<?php
/**
 * Created by PhpStorm.
 * User: AEL-DEV
 * Date: 4/17/2019
 * Time: 12:12 PM
 */
?>
<?php
/**
 * Created by PhpStorm.
 * User: AEL-DEV
 * Date: 4/17/2019
 * Time: 12:17 PM
 */
?>

<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state  noPrint" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/3'); ?>">Inventory</a>
                </li>
                <li class="active">Current Stock</li>
            </ul>

        </div>
        <br>
        <div class="page-content">
            <div class="row  noPrint">
                <div class="col-md-12">
                    <form id="publicForm" action=""  method="post" class="form-horizontal">
                        <div class="col-md-12">
                            <div class="table-header">
                                Current Stock  Report
                            </div>
                            <br>


                            <div class="col-md-5">



                                <div class="col-md-4">
                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-info btn-sm"  onclick="window.print();" style="cursor:pointer;">

                                            Print
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div><!-- /.col -->
            <?php
            if (!empty($allStock)):

                $from_date = date('Y-m-d', strtotime($this->input->post('start_date')));
                $to_date = date('Y-m-d', strtotime(date()));

                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="table-header">
                            Current Stock  Report <span style="color:greenyellow;" To <?php echo $to_date; ?></span>
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
                        <table class="table table-bordered" id="ALLPRODUCT">
                            <?php
                            //all supplier all customer

                            $topening = 0;
                            $tstockIn = 0;
                            $tstockOut = 0;
                            ?>
                            <thead>
                            <tr>

                                <td align="center"><strong>Product Name</strong></td>
                                <td align="center"><strong>Received Qty</strong></td>
                                <td align="center"><strong>Sales Qty</strong></td>


                                <td align="center"><strong>Balance</strong></td>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $j = 1;
                            foreach ($allStock as $key => $eachResult):

                                ?>

                                <?php


                                    ?>
                                    <tr>
                                        <td><?php echo $eachResult->productName; ?></td>
                                        <td><?php echo $purchase_qty=$eachResult->product_purchase_qty-$eachResult->product_pur_return_quantity ?></td>
                                        <td align="right"> <?php echo $sales_qty=$eachResult->product_sales_qty-$eachResult->product_sales_return_quantity;?> </td>

                                        <td align="right"><?php echo $purchase_qty-$sales_qty; ?></td>


                                    </tr>
                                    <?php

                            endforeach;
                            ?>






                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>

