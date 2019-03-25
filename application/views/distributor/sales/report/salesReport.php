
<?php
if (isset($_POST['start_date'])):
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
                    <a href="<?php echo site_url('DistributorDashboard/2');?>">Sales</a>
                </li>
                <li class="active">Sales Report</li>
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
                        <div class="col-sm-8 col-sm-offset-2">
                            <div class="table-header">
                                Sales Report
                            </div><br>
                            <div style="background-color: grey!important;">
                                <div class="col-md-4">
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
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                                Search
                                            </button>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-info btn-sm" id="btn-print" onclick="window.print();" style="cursor:pointer;">
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
                //  dumpVar($_POST);
                $from_date = $this->input->post('start_date');
                $to_date = $this->input->post('end_date');
                unset($_SESSION["start_date"]);
                unset($_SESSION["end_date"]);
                $_SESSION["start_date"] = $from_date;
                $_SESSION["end_date"] = $to_date;
                $dist_id = $this->dist_id;
                $total_pvsdebit = '';
                $total_pvscredit = '';
                $total_debit = '';
                $total_credit = '';
                $total_balance = '';
                ?>
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <div class="table-header">
                            Sales Report Period <span style="color:greenyellow;">From <?php echo $from_date; ?> To <?php echo $to_date; ?></span>
                        </div>
                    </div>

                        <div class="col-xs-8 col-xs-offset-2">
                            <div class="noPrint">
<!--                            <button style="border-radius:100px 0 100px 0;" href="<?php echo site_url('SalesController/salesReport_export_excel/') ?>" class="btn btn-success pull-right noPrint">
                                <i class="ace-icon fa fa-download"></i>
                                Excel
                            </button>-->
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
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td align="center"><strong>Date</strong></td>
                                        <td align="center"><strong>Voucher No.</strong></td>
                                        <td align="center"><strong>Customer</strong></td>
                                        <td align="center"><strong>Payment Type</strong></td>
                                        <td align="center"><strong>Memo</strong></td>
                                        <td align="center"><strong>Amount</strong></td>
                                        <td align="center"><strong>GP Amount</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $this->db->where('dist_id', $dist_id);
                                    $this->db->where('form_id', 5);
                                    $this->db->where('date >=', $from_date);
                                    $this->db->where('date <=', $to_date);
                                    $this->db->order_by('date', 'ASC');
                                    $query = $this->db->get('generals')->result();
                                    //dumpVar($data);
                                    $total_debit = 0;
                                    $totalGpAmount = 0;
                                    foreach ($query as $row):
                                        ?>
                                        <tr>
                                            <td><?php echo date('M d, Y', strtotime($row->date)); ?></td>
                                            <td><a title="view invoice" href="<?php echo site_url('salesInvoice_view/' . $row->generals_id); ?>"><?php echo $row->voucher_no; ?></a></td>
                                            <td>
                                                <a href="<?php echo site_url('customerDashboard/' . $row->customer_id); ?>">
                                                    <?php
                                                    $customerInfo = $this->Common_model->tableRow('customer', 'customer_id', $row->customer_id);
                                                    echo $customerInfo->customerID . '[ ' . $customerInfo->customerName . ']';
                                                    ?>
                                                </a>
                                            </td>
                                            <td><?php
                                            if ($row->payType == 1) {
                                                echo "Cash";
                                            } elseif ($row->payType == 2) {
                                                echo "Credit";
                                            } elseif($row->payType == 3) {
                                                echo "Bank";
                                            }else{
                                                echo "Cash";
                                            }
                                                    ?>
                                            </td>
                                            <td><?php echo $row->memo; ?></td>
                                            <td align="right"><?php
                                        echo number_format((float) abs($row->debit), 2, '.', ',');
                                        $total_debit += $row->debit;
                                                    ?>
                                            </td>
                                            <td align="right"><?php
                                        $gpAmount = $this->Sales_Model->getGpAmountByInvoiceId($this->dist_id, $row->generals_id);
                                        $totalGpAmount+=round($gpAmount);
                                        echo number_format((float) round($gpAmount), 2, '.', ',');
                                                    ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- /Search Balance -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" align="right"><strong>Total Sales Amount</strong></td>
                                        <td align="right"><strong><?php echo number_format((float) abs($total_debit), 2, '.', ','); ?>&nbsp;</strong></td>
                                        <td align="right"><strong><?php echo number_format((float) abs($totalGpAmount), 2, '.', ','); ?>&nbsp;</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                </div>
            <?php endif; ?>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
