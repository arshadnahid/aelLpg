 
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state noPrint" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/3'); ?>">Inventory</a>
                </li>
                <li class="active">Cylinder Exchange View</li>
            </ul>
            
            <ul class="breadcrumb pull-right">
                
                <li>
                    <a href="<?php echo site_url('cylinderInOutJournal'); ?>">
                        <i class="ace-icon fa fa-list"></i>
                        List
                    </a>
                </li>
                
            </ul>
            
            
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-large">
                            <h3 class="widget-title grey lighter">
                                <i class="ace-icon fa fa-leaf green"></i>
                                Cylinder Exchange Voucher
                            </h3>

                            <div class="widget-toolbar no-border invoice-info">
                                <span class="invoice-info-label">Voucher ID:</span>
                                <span class="red"><?php echo $inOutView->voucher_no; ?></span>

                                <br />
                                <span class="invoice-info-label"> Date:</span>
                                <span class="red"><?php echo $inOutView->date; ?></span>
                            </div>

                            <div class="widget-toolbar hidden-480"  class="hidden-xs">
                                <a  onclick="window.print();" style="cursor:pointer;">
                                    <i class="ace-icon fa fa-print"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main padding-24">
                                <div class="row"  >
                                    <div class="col-xs-6">
                                        <div class="row">
                                            <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                                Company Info
                                            </div>
                                        </div>

                                        <div>
                                            <ul class="list-unstyled spaced">
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i><?php echo $companyInfo->companyName; ?>
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i><?php echo $companyInfo->email; ?>
                                                </li>

                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i><?php echo $companyInfo->phone; ?>
                                                </li>
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i><?php echo $companyInfo->address; ?>
                                                </li>

                                            </ul>
                                        </div>
                                    </div><!-- /.col -->


                                    <?php if (!empty($inOutView->supplier_id)): ?>

                                        <div class="col-xs-6">
                                            <div class="row">
                                                <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
                                                    Supplier Info
                                                </div>
                                            </div>

                                            <div>
                                                <ul class="list-unstyled  spaced">
                                                    <li>
                                                        <i class="ace-icon fa fa-caret-right green"></i><?php echo $supplierInfo->supID . '[' . $supplierInfo->supName . ']' ?>
                                                    </li>

                                                    <li>
                                                        <i class="ace-icon fa fa-caret-right green"></i><?php echo $supplierInfo->supEmail; ?>
                                                    </li>

                                                    <li>
                                                        <i class="ace-icon fa fa-caret-right green"></i><?php echo $supplierInfo->supPhone; ?>
                                                    </li>
                                                    <li>
                                                        <i class="ace-icon fa fa-caret-right green"></i><?php echo $supplierInfo->supAddress; ?>
                                                    </li>


                                                </ul>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="col-xs-6">
                                            <div class="row">
                                                <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
                                                    Customer Info
                                                </div>
                                            </div>

                                            <div>
                                                <ul class="list-unstyled  spaced">
                                                    <li>
                                                        <i class="ace-icon fa fa-caret-right green"></i><?php echo $customerInfo->customerID . '[' . $customerInfo->customerName . ']' ?>
                                                    </li>

                                                    <li>
                                                        <i class="ace-icon fa fa-caret-right green"></i><?php echo $customerInfo->customerEmail; ?>
                                                    </li>

                                                    <li>
                                                        <i class="ace-icon fa fa-caret-right green"></i><?php echo $customerInfo->customerPhone; ?>
                                                    </li>
                                                    <li>
                                                        <i class="ace-icon fa fa-caret-right green"></i><?php echo $customerInfo->customerAddress; ?>
                                                    </li>


                                                </ul>
                                            </div>
                                        </div>

                                    <?php endif; ?>

                                    <!-- /.col -->
                                </div><!-- /.row -->

                                <div class="space"></div>

                                <div style="min-height:400px;" >


                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <td class="center">#</td>
                                                <td><strong>Product Cat</strong></td>
                                                <td><strong>Product</strong></td>
                                                <td><strong>In</strong></td>
                                                <td><strong>Out</strong></td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $inQty = 0;
                                            $outQty = 0;
                                            $trate = 0;
                                            $tprice = 0;

                                            //  dumpVar($inOutItem);


                                            foreach ($inOutItem as $key => $each_info):

                                                if ($each_info->type == 'Cin') {
                                                    $inQty+=$each_info->quantity;
                                                } else {
                                                    $outQty+=$each_info->quantity;
                                                }
                                                ?>

                                                <tr>
                                                    <td class="center"><?php echo $key + 1; ?></td>
                                                    <td>
                                                        <?php
                                                        echo $this->Common_model->tableRow('productcategory', 'category_id', $each_info->category_id)->title;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $productInfo = $this->Common_model->tableRow('product', 'product_id', $each_info->product_id);
                                                        echo $productInfo->productName;
                                                        echo ' [ ' . $this->Common_model->tableRow('brand', 'brandId', $productInfo->brand_id)->brandName . ' ] ';
                                                        ?>
                                                    </td>
                                                    <td><?php
                                                    if ($each_info->type == 'Cin') {
                                                        echo $each_info->quantity;
                                                    }
                                                        ?> </td>
                                                    <td><?php
                                                    if ($each_info->type == 'Cout') {
                                                        echo $each_info->quantity;
                                                    }
                                                        ?> </td>


                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" align="right">Sub-Total</td>
                                                <td><?php echo $inQty; ?></td>
                                                <td><?php echo $outQty; ?></td>
                                            </tr>
<!--                                            <tr>
                                                <td colspan="7" >
                                                    <strong>  <span>In Words : &nbsp;</span> <?php echo $this->Common_model->get_bd_amount_in_text($tprice); ?></strong>
                                                </td>
                                            </tr>-->
                                            <tr>
                                                <td colspan="7" >
                                                    <span>Narration : &nbsp;</span> <?php echo $purchasesList->narration; ?>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="hr hr8 hr-double hr-dotted"></div>


                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <p>Prepared By:_____________<br />
                                            Date:____________________
                                        </p>                        
                                    </div>
                                    <div class="col-xs-4 text-center">

                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <p>Approved By:________________<br />
                                            Date:_________________</p>  
                                    </div>
                                </div>

                                <hr />
                                <p class="text-center"><?php //echo $this->mtcb->table_row('system_config', 'option', 'ADDRESS')->value;                                                    ?></p>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker.min.js"></script>
