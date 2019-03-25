<?php
if (isset($_POST['start_date'])):
    $referenceId = $this->input->post('referenceId');
    $from_date = $this->input->post('start_date');
    $to_date = $this->input->post('end_date');
endif;
?>
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state  noPrint" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/2'); ?>">Sales</a>
                </li>
                <li class="active">Reference Sales Report</li>
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
            <div class="row  noPrint">
                <div class="col-md-12">
                    <form id="publicForm" action=""  method="post" class="form-horizontal">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="table-header">
                                Reference Sales Report
                            </div><br>
                            <div style="background-color: grey!important;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Reference</label>
                                        <div class="col-sm-9">
                                            <select  id="referenceId" name="referenceId"  class="chosen-select form-control" id="form-field-select-3" data-placeholder="Search by Customer ID or Name">
                                                <option <?php
if ($referenceId == 'all') {
    echo "selected";
}
?> value="all">All</option>
                                                    <?php foreach ($referenceList as $key => $eachReference): ?>
                                                    <option <?php
                                                    if (!empty($referenceId) && $referenceId == $eachReference->reference_id) {
                                                        echo "selected";
                                                    }
                                                        ?> value="<?php echo $eachReference->reference_id; ?>"><?php echo $eachReference->refCode . ' [ ' . $eachReference->referenceName . ' ] '; ?></option>
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
                                                    if (!empty($from_date)) {
                                                        echo $from_date;
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
                                                   if (!empty($to_date)):

                                                       echo $to_date;

                                                   else:

                                                       echo date('Y-m-d');

                                                   endif;
                                                    ?>" data-date-format='yyyy-mm-dd' placeholder="End Date: yyyy-mm-dd"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
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

                $referenceId = $this->input->post('referenceId');

                if ($referenceId != 'all'):
                    ?>
                    <div class="row">
                        <div class="col-xs-10 col-xs-offset-1">
                            <div class="table-header">
                               Reference Sales Report Period <span style="color:greenyellow;">From <?php echo $from_date; ?> To <?php echo $to_date; ?></span>
                            </div>
                            <table class="table table-responsive">
                                <tr>
                                    <td style="text-align:center;">
                                        <h3><?php echo $companyInfo->companyName; ?></h3>
                                        <p><?php echo $companyInfo->dist_address; ?></p>
                                        <strong>Phone : </strong><?php echo $companyInfo->dist_phone; ?><br>
                                        <strong>Email : </strong><?php echo $companyInfo->dist_email; ?><br>
                                        <strong>Website : </strong><?php echo $companyInfo->dis_website; ?><br>
                                        <strong><?php echo $pageTitle; ?></strong>
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td align="center"><strong>Date</strong></td>
                                        <td align="center"><strong>Voucher No.</strong></td>
                                        <td align="center"><strong>Payment Type</strong></td>
                                        <td align="center"><strong>Memo</strong></td>
                                        <td align="center"><strong>Amount</strong></td>
                                    </tr>
                                </thead>
                                <tbody>                             
                                    <?php
                                    $totalAmount = 0;
                                    $totalOpening = 0;
                                    foreach ($refOpList as $key => $row):

                                        if ($key == 0):
                                            ?>                       
                                            <tr>
                                                <td align="right" colspan="4"><strong>Opening</strong></td>
                                                <td align="right"><?php echo $row->totalOpening;$totalOpening+=$row->totalOpening; ?></td>
                                            </tr>
                                            <?php
                                        endif;
                                        ?>
                                        <tr>
                                            <td><?php echo date('M d, Y', strtotime($row->date)); ?></td> 
                                            <td><?php echo $row->voucher_no; ?></td> 
                                            <td><?php
                            if ($row->payType == 1) {
                                echo "Cash";
                            } elseif ($row->payType == 2) {
                                echo "Credit";
                            } else if($row->payTpe == 3){
                                echo "Bank";
                            }else{
                                echo "Cash";
                            }
                                        ?></td> 
                                            <td><?php echo $row->memo; ?></td>                                
                                            <td align="right"><?php
                                    echo number_format((float) abs($row->individualAmount), 2, '.', ',');
                                    $total_debit += $row->individualAmount;
                                        ?></td> 
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- /Search Balance -->                            
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" align="right"><strong>Total Sales Amount</strong></td>    
                                        <td align="right"><strong><?php echo number_format((float) abs($total_debit+$totalOpening), 2, '.', ','); ?>&nbsp;</strong></td>
                                    </tr>
                                </tfoot>                            
                            </table> 
                        </div>
                    </div>
                <?php else:
                    ?>

                    <div class="row">

                        <div class="col-xs-10 col-xs-offset-1">

                            <div class="table-header">

                                Reference Sales Report Period <span style="color:greenyellow;">From <?php echo $from_date; ?> To <?php echo $to_date; ?></span>

                            </div>

                            <!--                            <div class="noPrint">
                            
                                                            <a style="border-radius:100px 0 100px 0;" href="<?php echo site_url('SalesController/customerSalesReport_export_excel/') ?>" class="btn btn-success pull-right">
                                                                <i class="ace-icon fa fa-download"></i>
                                                                Excel 
                                                            </a></div>-->
                            <table class="table table-responsive">
                                <tr>
                                    <td style="text-align:center;">
                                        <h3><?php echo $companyInfo->companyName; ?>.</h3>
                                        <p><?php echo $companyInfo->dist_address; ?>
                                        </p>
                                        <strong>Phone : </strong><?php echo $companyInfo->dist_phone; ?><br>
                                        <strong>Email : </strong><?php echo $companyInfo->dist_email; ?><br>
                                        <strong>Website : </strong><?php echo $companyInfo->dis_website; ?><br>
                                        <strong><?php echo $pageTitle; ?></strong>
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td align="center"><strong>Sl</strong></td>
                                        <td align="center"><strong>Reference</strong></td>
                                        <td align="center"><strong>Amount</strong></td>
                                    </tr>
                                </thead>
                                <tbody>                             
                                    <?php
                                    $total_debit = 0;
                                    $totalOpenig = 0;
                                    $sl = 1;

                                    foreach ($refOpList as $key => $value):

                                        if ($key == 0):
                                            $totalOpenig+=$value->totalOpening;
                                            ?>
                                            <tr>
                                                <td colspan="2" align="right"><strong>Opening Balance</strong></td>
                                                <td align="right" ><?php echo $value->totalOpening; ?></td>
                                            </tr>
                                            <?php
                                        endif;
                                        if (!empty($value->individualAmount)):
                                            ?>                                
                                            <tr>
                                                <td><?php echo $sl++; ?></td> 
                                                <td><?php echo $value->refCode . ' [ ' . $value->referenceName . ' ] '; ?></td> 
                                                <td align="right"><?php
                            echo number_format((float) abs($value->individualAmount), 2, '.', ',');
                            $total_debit += $value->individualAmount;
                                            ?>
                                                </td>                                    
                                            </tr>
                                            <?php
                                        endif;
                                    endforeach;
                                    ?>
                                    <!-- /Search Balance -->                            
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" align="right"><strong>Total Sales Amount</strong></td>                             
                                        <td align="right"><strong><?php echo number_format((float) abs($total_debit + $totalOpenig), 2, '.', ','); ?>&nbsp;</strong></td>
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



