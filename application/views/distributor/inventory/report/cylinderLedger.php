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
                <li class="active">Cylinder Ledger</li>
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
            <div class="row">
                <div class="col-md-12 noPrint">
                    <form id="publicForm" action=""  method="post" class="form-horizontal">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="table-header">
                                Cylinder Ledger Report
                            </div>
                            <br>
                            <div style="background-color: grey!important;">

                                <div class="col-md-4">
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
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"></label>
                                        <div class="col-sm-5">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                                Search
                                            </button>
                                        </div>
                                        <div class="col-sm-5">
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
                $from_date = date('Y-m-d', strtotime($this->input->post('start_date')));
                $to_date = date('Y-m-d', strtotime($this->input->post('end_date')));
                $productId11 = $this->input->post('productId');
                ?>
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1">

                        <div class="table-header">
                            Cylinder Ledger Report <span style="color:greenyellow;">From <?php echo $start_date; ?> To <?php echo $end_date; ?></span>
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
                                    <!--<td align="center"><strong>Voucher</strong></td>-->
                                    <td align="center"><strong>Customer/Supplier</strong></td>
                                    <td align="center"><strong>Product</strong></td>
                                    <td align="center"><strong>Stock In</strong></td>
                                    <td align="center"><strong>Stock Out</strong></td>
                                    <td align="center"><strong>Balance</strong></td>
                                </tr>
                            </thead>
                            <tbody>            
                                <?php
                                $totalIn = 0;
                                $totalOut = 0;
                                $totalOpenig = 0;

                                foreach ($cylinderLedger as $key => $eachInfo):

                                    $ttotalIn = 0;
                                    $ttotalOut = 0;
                                    ?>                                
                                    <tr>
                                        <td><?php echo $key + 1; ?></td> 
                                        <td><?php echo $eachInfo->date; ?></td> 
                                        <!--<td><?php echo $eachInfo->voucher_no; ?></td>--> 
                                        <td>
                                            <?php
                                            if (!empty($eachInfo->customerName)):
                                                echo $eachInfo->customerName;
                                            else:
                                                echo $eachInfo->supName;

                                            endif;
                                            ?>
                                        </td>
                                        <td><?php echo $eachInfo->productName .' [ '. $eachInfo->brandName .']';?></td>
                                        <td align="right">
                                            <?php
                                            if ($eachInfo->type == 'Cin') {
                                                echo $eachInfo->quantity;
                                                $ttotalIn = $eachInfo->quantity;
                                                $totalIn += $eachInfo->quantity;
                                            }
                                            ?>
                                        </td>
                                        <td align="right">
                                            <?php
                                            if ($eachInfo->type == 'Cout') {
                                                echo $eachInfo->quantity;
                                                $ttotalOut = $eachInfo->quantity;
                                                $totalOut += $eachInfo->quantity;
                                            }
                                            ?>
                                        </td>
                                        <td align="right">
                                            <?php
//                                                $bal = $totalIn - $totalOut;
//                                                if ($bal > $bal) {
//                                                    echo "Payable = ";
//                                                } else {
//                                                    echo "Receiable = ";
//                                                }



                                            echo $ttotalIn - $ttotalOut;
                                            // echo $totalIn - $totalOut;
                                            ?>
                                        </td>


                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" align="right"><strong>Total Closing Cylinder Stock (PCS)</strong></td>                             
                                    <td align="right"><strong><?php echo $totalIn; ?>&nbsp;</strong></td>
                                    <td align="right"><strong><?php echo $totalOut; ?>&nbsp;</strong></td>
                                    <td align="right"><strong><?php
//                            $bal = $totalIn - $totalOut;
//                            if ($bal > $bal) {
//                                echo "Payable = ";
//                            } else {
//                                echo "Receiable = ";
//                            }
                            echo $totalIn - $totalOut;
                                ?>&nbsp;</strong></td>

                                </tr>
                            </tfoot> 

                        </table> 
                    </div>
                </div>
            <?php endif; ?>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
