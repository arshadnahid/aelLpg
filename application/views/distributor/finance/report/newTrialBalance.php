<?php
if (isset($_POST['start_date'])):
    $account = $this->input->post('accountHead');
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
                    <a href="<?php echo site_url('DistributorDashboard/1'); ?>">Finance</a>
                </li>
                <li class="active">Trial Balance</li>
            </ul>
             <ul class="breadcrumb pull-right">
                <li class="active">
                    <i class="ace-icon fa fa-list"></i>
                    <a href="<?php echo site_url('DistributorDashboard/1'); ?>">List</a>
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
                                Trial Balance
                            </div>
                            <br>
                            <div style="background-color: grey!important;">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> From Date</label>
                                        <div class="col-sm-8">
                                            <input type="text"class="date-picker form-control" id="start_date" name="start_date" value="<?php
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
                                            <input type="text" class="date-picker form-control" id="end_date" name="end_date" value="<?php
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
                                        <div class="col-sm-2"></div>
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
            if (isset($_POST['start_date']) && isset($_POST['end_date'])):
                $sub_total_pvsdebit = '';
                $sub_total_pvscredit = '';
                $sub_total_debit = '';
                $sub_total_credit = '';
                $sub_total_debit_balance = '';
                $sub_total_credit_balance = '';



                $opDr = '';
                $opCr = '';
                $pDr = '';
                $pCr = '';
                $cDr = '';
                $cCr = '';


                unset($_SESSION["start_date"]);
                unset($_SESSION["end_date"]);


                $_SESSION["start_date"] = $from_date;
                $_SESSION["end_date"] = $to_date;
                $dist_id = $this->dist_id;
                $finalTrialBalancedr = '';
                $finalTrialBalancecr = '';
                ?>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="table-header">
                            Trial Balance <span style="color:greenyellow;">From <?php echo $from_date; ?> To <?php echo $to_date; ?></span>

                        </div>
<!--                        <div class="noPrint">
                        <a style="border-radius:100px 0 100px 0;" href="<?php echo site_url('FinaneController/trialBalance_export_excel/') ?>" class="btn btn-success pull-right">
                            <i class="ace-icon fa fa-download"></i>
                            Excel 
                        </a></div>-->
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
                                    <td rowspan="2" align="center" style="padding-top:15px;"><strong>Account Name</strong></td>
                                    <td colspan="2" align="center"><strong>Brought Forward</strong></td>
                                    <td colspan="2" align="center"><strong>This Period</strong></td>
                                    <td colspan="2" align="center"><strong>Balance (In BDT.)</strong></td>
                                </tr>
                                <tr>
                                    <td align="center"><strong>Debit</strong></td>
                                    <td align="center"><strong>Credit</strong></td>
                                    <td align="center"><strong>Debit</strong></td>
                                    <td align="center"><strong>Credit</strong></td>
                                    <td align="center"><strong>Debit</strong></td>
                                    <td align="center"><strong>Credit</strong></td>
                                </tr>
                            </thead>
                            <tbody> 
                                <!-- Assets -->
                                <tr class="item-row">
                                    <td colspan="7"><strong>A. Assets</strong></td> 
                                </tr>                    

                                <?php
                                $twoa = 1;
                                foreach ($assetList as $row_cta):
                                    ?>                         
                                    <tr class="item-row">
                                        <td colspan="7"><strong>&nbsp;&nbsp;A.<?php
                            if ($row_cta['parentName']): echo $twoa;
                            endif;
                                    ?> <?php echo $row_cta['parentName']; ?></strong>
                                        </td> 
                                    </tr> 
                                    <!-- chart_master --> 
                                    <?php
                                    foreach ($row_cta['Accountledger'] as $row_cma):

                                        // Opening Balance
                                        $total_opendebit = $this->Finane_Model->opening_balance_dr($this->dist_id, $row_cma->chartId);
                                        $total_opencredit = $this->Finane_Model->opening_balance_cr($this->dist_id, $row_cma->chartId);

                                        $total_pvsdebit = '';
                                        $total_pvscredit = '';
                                        $this->db->where('dist_id', $this->dist_id);
                                        $this->db->where('account', $row_cma->chartId);
                                        $this->db->where('date <', $from_date);
                                        $query_pvs = $this->db->get('generalledger')->result_array();

                                        foreach ($query_pvs as $row_pvs):
                                            $total_pvsdebit += $row_pvs['debit'];
                                            $total_pvscredit += $row_pvs['credit'];
                                        endforeach;
                                        $total_pvsdebit += $total_opendebit;
                                        $total_pvscredit += $total_opencredit;







                                        $sub_total_pvsdebit += $total_pvsdebit;
                                        $sub_total_pvscredit += $total_pvscredit;

                                        $total_debit = '';
                                        $total_credit = '';
                                        $this->db->where('dist_id', $this->dist_id);
                                        $this->db->where('account', $row_cma->chartId);
                                        $this->db->where('date >=', $from_date);
                                        $this->db->where('date <=', $to_date);
                                        $query = $this->db->get('generalledger')->result_array();
                                        foreach ($query as $row):
                                            $total_debit += $row['debit'];
                                            $total_credit += $row['credit'];
                                        endforeach;



                                        $sub_total_debit += $total_debit;
                                        $sub_total_credit += $total_credit;

                                        $debit_balance = $total_pvsdebit + $total_debit;
                                        $credit_balance = $total_pvscredit + $total_credit;


                                        $ddbitValue = $total_debit - $total_credit;
                                        $ddcreditValue = $total_credit - $total_debit;


                                        $cbbbb = $debit_balance - $credit_balance;
                                        $dbbbb = $credit_balance - $debit_balance;



                                        if (!empty($total_pvsdebit) || !empty($total_pvscredit) || !empty($ddbitValue) || !empty($ddcreditValue) || !empty($cbbbb) || !empty($dbbbb)):


//                                            if ($row_cma->chartId == "72") {
//
//
//                                                echo $total_pvsdebit;
//                                                echo "<br>";
//                                                echo $total_pvscredit;
//                                                echo "<br>";
//                                                echo $ddbitValue;
//                                                echo "<br>";
//                                                echo $ddcreditValue;
//                                                echo "<br>";
//                                                echo $debit_balance;
//                                                echo "<br>";
//                                                echo $credit_balance;
//
//                                                // echo $this->db->last_query();die;
//                                                //  die("test");
//                                            }
                                            ?>                         
                                            <tr>
                                                <td><a href="<?php echo site_url('generalLedger/' . $row_cma->chartId); ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_cma->title; ?></a></td>                                 
                                                <!-- PVS Balance -->
                                                <?php ?>   


                                                <!--Opening trial balance start -->

                                                <td align="right">
                                                    <?php
                                                    if ($total_pvsdebit >= $total_pvscredit): echo number_format((float) $total_pvsdebit - $total_pvscredit, 2, '.', ',');

                                                        $opDr+=$total_pvsdebit - $total_pvscredit;

                                                    else:

                                                        echo '0.00';
                                                    endif;
                                                    ?></td> 
                                                <td align="right">
                                                    <?php
                                                    if ($total_pvsdebit < $total_pvscredit): echo number_format((float) $total_pvscredit - $total_pvsdebit, 2, '.', ',');

                                                        $opCr+=$total_pvscredit - $total_pvsdebit;
                                                    else:

                                                        echo '0.00';

                                                    endif;
                                                    ?>
                                                </td> 




                                                <td align="right">
                                                    <?php
                                                    if ($total_debit >= $total_credit):
                                                        echo number_format((float) $total_debit - $total_credit, 2, '.', ',');

                                                        $pDr+=$total_debit - $total_credit;
                                                    else: echo '0.00';
                                                    endif;
                                                    ?>
                                                </td> 

                                                <td align="right">
                                                    <?php
                                                    if ($total_debit < $total_credit): echo number_format((float) $total_credit - $total_debit, 2, '.', ',');
                                                        $pCr+=$total_credit - $total_debit;

                                                    else: echo '0.00';
                                                    endif;
                                                    ?>

                                                </td> 

                                                <!--present trial balance end -->
                                                <!--paresent trial balance start -->
                                                <!-- /This Period -->  
                                                <?php ?> 
                                                <!--Present trial balance End -->
                                                <!--closing trial balance start -->

                                                <td align="right">
                                                    <?php
                                                    if ($debit_balance >= $credit_balance): echo number_format((float) $debit_balance - $credit_balance, 2, '.', ',');

                                                        $cDr+=$debit_balance - $credit_balance;

                                                    else: echo '0.00';
                                                    endif;
                                                    ?>

                                                </td> 
                                                <td align="right">

                                                    <?php
                                                    if ($debit_balance < $credit_balance): echo number_format((float) $credit_balance - $debit_balance, 2, '.', ',');
                                                        $cCr+=$credit_balance - $debit_balance;
                                                    else: echo '0.00';
                                                    endif;
                                                    ?>
                                                </td> 
                                                <!-- /Balance --> 
                                                <?php
                                                $sub_total_debit_balance += $debit_balance;
                                                $sub_total_credit_balance += $credit_balance;
                                                $finalTrialBalancedr +=abs($debit_balance - $credit_balance);
                                                $finalTrialBalancecr +=abs($credit_balance - $debit_balance);
                                                ?>                                 
                                            </tr>




                                            <?php
                                        endif;

                                    endforeach;
                                    ?>                     
                                    <!-- /chart_master --> 
                                    <?php $twoa++; ?>
                                <?php endforeach; ?>                     
                                <!-- /chart_type -->      

                                <tr class="item-row">
                                    <td colspan="7"><strong>B. Liability</strong></td> 
                                </tr>




                                <?php
                                $twoa = 1;

                                foreach ($liabilityList as $row_cta):
                                    ?>                         
                                    <tr class="item-row">
                                        <td colspan="7"><strong>&nbsp;&nbsp;B.<?php
                            if ($row_cta['parentName']): echo $twoa;
                            endif;
                                    ?>. <?php echo $row_cta['parentName']; ?></strong>
                                        </td> 
                                    </tr> 
                                    <!-- chart_master --> 
                                    <?php
                                    foreach ($row_cta['Accountledger'] as $row_cma):



                                        // Opening Balance
                                        $total_opendebit = $this->Finane_Model->opening_balance_dr($this->dist_id, $row_cma->chartId);
                                        $total_opencredit = $this->Finane_Model->opening_balance_cr($this->dist_id, $row_cma->chartId);

                                        $total_pvsdebit = '';
                                        $total_pvscredit = '';
                                        $this->db->where('dist_id', $this->dist_id);
                                        $this->db->where('account', $row_cma->chartId);
                                        $this->db->where('date <', $from_date);
                                        $query_pvs = $this->db->get('generalledger')->result_array();
                                        foreach ($query_pvs as $row_pvs):
                                            $total_pvsdebit += $row_pvs['debit'];
                                            $total_pvscredit += $row_pvs['credit'];
                                        endforeach;
                                        $total_pvsdebit += $total_opendebit;
                                        $total_pvscredit += $total_opencredit;




                                        $sub_total_pvsdebit += $total_pvsdebit;
                                        $sub_total_pvscredit += $total_pvscredit;

                                        $total_debit = '';
                                        $total_credit = '';
                                        $this->db->where('dist_id', $this->dist_id);
                                        $this->db->where('account', $row_cma->chartId);
                                        $this->db->where('date >=', $from_date);
                                        $this->db->where('date <=', $to_date);
                                        $query = $this->db->get('generalledger')->result_array();
                                        foreach ($query as $row):
                                            $total_debit += $row['debit'];
                                            $total_credit += $row['credit'];
                                        endforeach;

                                        $sub_total_debit += $total_debit;
                                        $sub_total_credit += $total_credit;

                                        $debit_balance = $total_pvsdebit + $total_debit;
                                        $credit_balance = $total_pvscredit + $total_credit;
                                        $ddbitValue = $total_debit - $total_credit;
                                        $ddcreditValue = $total_credit - $total_debit;


                                        $cbbbb = $debit_balance - $credit_balance;
                                        $dbbbb = $credit_balance - $debit_balance;



                                        if (!empty($total_pvsdebit) || !empty($total_pvscredit) || !empty($ddbitValue) || !empty($ddcreditValue) || !empty($cbbbb) || !empty($dbbbb)):


//                                            if ($row_cma->chartId == "72") {
//
//
//                                                echo $total_pvsdebit;
//                                                echo "<br>";
//                                                echo $total_pvscredit;
//                                                echo "<br>";
//                                                echo $ddbitValue;
//                                                echo "<br>";
//                                                echo $ddcreditValue;
//                                                echo "<br>";
//                                                echo $debit_balance;
//                                                echo "<br>";
//                                                echo $credit_balance;
//
//                                                // echo $this->db->last_query();die;
//                                                //  die("test");
//                                            }
                                            
                                            
                                            
                                            
                                            
                                            
                                            ?>                         
                                            <tr>
                                                <td><a href="<?php echo site_url('generalLedger/' . $row_cma->chartId); ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $row_cma->title; ?></a></td>                                 
                                                <!-- PVS Balance -->
                                                <?php
                                                ?>     
                                                <td align="right"><?php
                                if ($total_pvsdebit >= $total_pvscredit): echo number_format((float) $total_pvsdebit - $total_pvscredit, 2, '.', ',');

                                    $opDr+=$total_pvsdebit - $total_pvscredit;
                                else: echo '0.00';
                                endif;
                                                ?></td> 
                                                <td align="right"><?php
                                    if ($total_pvsdebit < $total_pvscredit): echo number_format((float) $total_pvscredit - $total_pvsdebit, 2, '.', ',');
                                        $opCr+=$total_pvscredit - $total_pvsdebit;

                                    else: echo '0.00';
                                    endif;
                                                ?></td> 
                                                <!-- PVS Balance -->

                                                <td align="right"><?php
                                    if ($total_debit >= $total_credit): echo number_format((float) $total_debit - $total_credit, 2, '.', ',');

                                        $pDr+=$total_debit - $total_credit;

                                    else: echo '0.00';
                                    endif;
                                                ?></td> 
                                                <td align="right"><?php
                                    if ($total_debit < $total_credit): echo number_format((float) $total_credit - $total_debit, 2, '.', ',');
                                        $pCr+=$total_credit - $total_debit;

                                    else: echo '0.00';
                                    endif;
                                                ?></td> 

                                                <td align="right"><?php
                                    if ($debit_balance >= $credit_balance): echo number_format((float) $debit_balance - $credit_balance, 2, '.', ',');
                                        $cDr+=$debit_balance - $credit_balance;
                                    else: echo '0.00';
                                    endif;
                                                ?></td> 
                                                <td align="right"><?php
                                    if ($debit_balance < $credit_balance): echo number_format((float) $credit_balance - $debit_balance, 2, '.', ',');
                                        $cCr+=$credit_balance - $debit_balance;
                                    else: echo '0.00';
                                    endif;
                                                ?></td> 
                                                <!-- /Balance --> 
                                                <?php
                                                $sub_total_debit_balance += $debit_balance;
                                                $sub_total_credit_balance += $credit_balance;
                                                ?>                                 
                                            </tr>
                                            <?php
                                        endif;

                                    endforeach;
                                    ?>                     
                                    <!-- /chart_master --> 
                                    <?php $twoa++; ?>
                                <?php endforeach; ?>     
                                <tr class="item-row">
                                    <td colspan="7"><strong>C. Income</strong></td> 
                                </tr>                    
                                <!-- chart_class -->


                                <!-- chart_type -->
                                <?php
                                $twoa = 1;

                                foreach ($income as $row_cta):
                                    ?>                         
                                    <tr class="item-row">
                                        <td colspan="7"><strong>&nbsp;&nbsp;C.<?php
                            if ($row_cta['parentName']): echo $twoa;
                            endif;
                                    ?>. <?php echo $row_cta['parentName']; ?></strong>
                                        </td> 
                                    </tr> 
                                    <!-- chart_master --> 
                                    <?php
                                    foreach ($row_cta['Accountledger'] as $row_cma):


                                        $total_opendebit = $this->Finane_Model->opening_balance_dr($this->dist_id, $row_cma->chartId);
                                        $total_opencredit = $this->Finane_Model->opening_balance_cr($this->dist_id, $row_cma->chartId);

                                        $total_pvsdebit = '';
                                        $total_pvscredit = '';
                                        $this->db->where('dist_id', $this->dist_id);
                                        $this->db->where('account', $row_cma->chartId);
                                        $this->db->where('date <', $from_date);
                                        $query_pvs = $this->db->get('generalledger')->result_array();
                                        foreach ($query_pvs as $row_pvs):
                                            $total_pvsdebit += $row_pvs['debit'];
                                            $total_pvscredit += $row_pvs['credit'];
                                        endforeach;
                                        $total_pvsdebit += $total_opendebit;
                                        $total_pvscredit += $total_opencredit;


                                        $sub_total_pvsdebit += $total_pvsdebit;
                                        $sub_total_pvscredit += $total_pvscredit;

                                        $total_debit = '';
                                        $total_credit = '';
                                        $this->db->where('dist_id', $this->dist_id);
                                        $this->db->where('account', $row_cma->chartId);
                                        $this->db->where('date >=', $from_date);
                                        $this->db->where('date <=', $to_date);
                                        $query = $this->db->get('generalledger')->result_array();
                                        foreach ($query as $row):
                                            $total_debit += $row['debit'];
                                            $total_credit += $row['credit'];
                                        endforeach;


                                        $sub_total_debit += $total_debit;
                                        $sub_total_credit += $total_credit;

                                        $debit_balance = $total_pvsdebit + $total_debit;
                                        $credit_balance = $total_pvscredit + $total_credit;

                                        $ddbitValue = $total_debit - $total_credit;
                                        $ddcreditValue = $total_credit - $total_debit;


                                        $cbbbb = $debit_balance - $credit_balance;
                                        $dbbbb = $credit_balance - $debit_balance;



                                        if (!empty($total_pvsdebit) || !empty($total_pvscredit) || !empty($ddbitValue) || !empty($ddcreditValue) || !empty($cbbbb) || !empty($dbbbb)):
                                            ?>                        
                                            <tr>
                                                <td><a href="<?php echo site_url('generalLedger/' . $row_cma->chartId); ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $row_cma->title; ?></a></td>                                 
                                                <!-- PVS Balance -->
                                                <?php
                                                // Opening Balance
                                                ?>     
                                                <td align="right"><?php
                                if ($total_pvsdebit >= $total_pvscredit): echo number_format((float) $total_pvsdebit - $total_pvscredit, 2, '.', ',');

                                    $opDr+=$total_pvsdebit - $total_pvscredit;
                                else: echo '0.00';
                                endif;
                                                ?></td> 
                                                <td align="right"><?php
                                    if ($total_pvsdebit < $total_pvscredit): echo number_format((float) $total_pvscredit - $total_pvsdebit, 2, '.', ',');
                                        $opCr+=$total_pvscredit - $total_pvsdebit;
                                    else: echo '0.00';
                                    endif;
                                                ?></td> 
                                                <!-- PVS Balance -->

                                                <td align="right"><?php
                                    if ($total_debit >= $total_credit): echo number_format((float) $total_debit - $total_credit, 2, '.', ',');

                                        $pDr+=$total_debit - $total_credit;

                                    else: echo '0.00';
                                    endif;
                                                ?></td> 
                                                <td align="right"><?php
                                    if ($total_debit < $total_credit): echo number_format((float) $total_credit - $total_debit, 2, '.', ',');
                                        $pCr+=$total_credit - $total_debit;
                                    else: echo '0.00';
                                    endif;
                                                ?></td> 
                                                <!-- /This Period -->  

                                                <td align="right"><?php
                                    if ($debit_balance >= $credit_balance): echo number_format((float) $debit_balance - $credit_balance, 2, '.', ',');

                                        $cDr+=$debit_balance - $credit_balance;

                                    else: echo '0.00';
                                    endif;
                                                ?></td> 
                                                <td align="right"><?php
                                    if ($debit_balance < $credit_balance): echo number_format((float) $credit_balance - $debit_balance, 2, '.', ',');
                                        $cCr+=$credit_balance - $debit_balance;
                                    else: echo '0.00';
                                    endif;
                                                ?></td> 
                                                <!-- /Balance --> 
                                                <?php
                                                $sub_total_debit_balance += $debit_balance;
                                                $sub_total_credit_balance += $credit_balance;
                                                ?>                                 
                                            </tr>
                                            <?php
                                        endif;

                                    endforeach;
                                    ?>                     
                                    <!-- /chart_master --> 
                                    <?php $twoa++; ?>
                                <?php endforeach; ?>
                                <tr class="item-row">
                                    <td colspan="7"><strong>D. Expense</strong></td> 
                                </tr>                    
                                <!-- chart_class -->
                                <!-- chart_type -->
                                <?php
                                $twoa = 1;
                                $expenseDebetBalance = 0;
                                foreach ($expense as $row_cta):
                                    ?>                         
                                    <tr class="item-row">
                                        <td colspan="7"><strong>&nbsp;&nbsp;D.<?php
                            if ($row_cta['parentName']): echo $twoa;
                            endif;
                                    ?>. <?php echo $row_cta['parentName']; ?></strong>
                                        </td> 
                                    </tr> 
                                    <!-- chart_master --> 
                                    <?php
                                    foreach ($row_cta['Accountledger'] as $row_cma):

                                        // Opening Balance
                                        $total_opendebit = $this->Finane_Model->opening_balance_dr($this->dist_id, $row_cma->chartId);
                                        $total_opencredit = $this->Finane_Model->opening_balance_cr($this->dist_id, $row_cma->chartId);

                                        $total_pvsdebit = '';
                                        $total_pvscredit = '';
                                        $this->db->where('dist_id', $this->dist_id);
                                        $this->db->where('account', $row_cma->chartId);
                                        // $this->db->where('account', 140);
                                        $this->db->where('date <', $from_date);
                                        $query_pvs = $this->db->get('generalledger')->result_array();
                                        // echo $this->db->last_query();die;
                                        // dumpVar($query_pvs);


                                        foreach ($query_pvs as $row_pvs):
                                            $total_pvsdebit += $row_pvs['debit'];
                                            $total_pvscredit += $row_pvs['credit'];
                                        endforeach;
                                        $total_pvsdebit += $total_opendebit;
                                        $total_pvscredit += $total_opencredit;


                                        $sub_total_pvsdebit += $total_pvsdebit;
                                        $sub_total_pvscredit += $total_pvscredit;

                                        $total_debit = '';
                                        $total_credit = '';
                                        $this->db->where('dist_id', $this->dist_id);
                                        $this->db->where('account', $row_cma->chartId);
                                        $this->db->where('date >=', $from_date);
                                        $this->db->where('date <=', $to_date);
                                        $query = $this->db->get('generalledger')->result_array();
                                        foreach ($query as $row):
                                            $total_debit += $row['debit'];
                                            $total_credit += $row['credit'];
                                        endforeach;



                                        $sub_total_debit += $total_debit;
                                        $sub_total_credit += $total_credit;

                                        $debit_balance = $total_pvsdebit + $total_debit;
                                        $credit_balance = $total_pvscredit + $total_credit;


                                        $ddbitValue = $total_debit - $total_credit;
                                        $ddcreditValue = $total_credit - $total_debit;


                                        $cbbbb = $debit_balance - $credit_balance;
                                        $dbbbb = $credit_balance - $debit_balance;



                                        if (!empty($total_pvsdebit) || !empty($total_pvscredit) || !empty($ddbitValue) || !empty($ddcreditValue) || !empty($cbbbb) || !empty($dbbbb)):
                                            ?>                        
                                            <tr>
                                                <td><a href="<?php echo site_url('generalLedger/' . $row_cma->chartId); ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_cma->title; ?></a></td>                                 
                                                <!-- PVS Balance -->
                                                <?php ?>     
                                                <td align="right">
                                                    <?php
                                                    if ($total_pvsdebit >= $total_pvscredit): echo number_format((float) $total_pvsdebit - $total_pvscredit, 2, '.', ',');

                                                        $opDr+= $total_pvsdebit - $total_pvscredit;

                                                    else: echo '0.00';
                                                    endif;
                                                    ?>
                                                </td> 
                                                <td align="right">
                                                    <?php
                                                    if ($total_pvsdebit < $total_pvscredit): echo number_format((float) $total_pvscredit - $total_pvsdebit, 2, '.', ',');
                                                        $opCr+= $total_pvscredit - $total_pvsdebit;
                                                    else: echo '0.00';
                                                    endif;
                                                    ?>
                                                </td> 
                                                <!-- PVS Balance -->

                                                <td align="right"><?php
                                    if ($total_debit >= $total_credit): echo number_format((float) $total_debit - $total_credit, 2, '.', ',');
                                        $pDr+= $total_debit - $total_credit;
                                    else: echo '0.00';
                                    endif;
                                                    ?></td> 
                                                <td align="right"><?php
                                    if ($total_debit < $total_credit): echo number_format((float) $total_credit - $total_debit, 2, '.', ',');
                                        $pCr+= $total_credit - $total_debit;
                                    else: echo '0.00';
                                    endif;
                                                    ?></td> 

                                                <td align="right"><?php
                                    if ($debit_balance >= $credit_balance):
                                        echo number_format((float) $debit_balance - $credit_balance, 2, '.', ',');
                                        $cDr+= $debit_balance - $credit_balance;
                                    else:
                                        echo '0.00';
                                    endif;
                                                    ?></td> 
                                                <td align="right"><?php
                                    if ($debit_balance < $credit_balance):
                                        echo number_format((float) $credit_balance - $debit_balance, 2, '.', ',');
                                        $cCr+= $credit_balance - $debit_balance;
                                    else:
                                        echo '0.00';
                                    endif;
                                                    ?></td> 
                                                <!-- /Balance --> 
                                                <?php
                                                $sub_total_debit_balance += $debit_balance;
                                                //$expenseDebetBalance += $debit_balance;
                                                $sub_total_credit_balance += $credit_balance;
                                                ?>                                 
                                            </tr>
                                            <?php
                                        endif;

                                    endforeach;
                                    ?>                     
                                    <!-- /chart_master --> 
                                    <?php $twoa++; ?>
                                    <?php
                                endforeach;
                                $opnignReturn = $this->db->get_where('retainearning', array('dist_id' => $this->dist_id))->row()->cr;
                                ?>
                            </tbody>    
                            <tfoot>
                                <tr>
                                    <td align="right"><strong>Total Ending Balance (In BDT.)</strong></td>
                                    <td align="right">
                                        <strong><?php
                            echo number_format((float) $opDr, 2, '.', ',');
                                ?></strong>
                                    </td>
                                    <td align="right"><strong><?php
                                        echo number_format((float) $opCr + $opnignReturn, 2, '.', ',');
                                ?></strong>
                                    </td>
                                    <td align="right"><strong><?php echo number_format((float) $pDr, 2, '.', ','); ?></strong></td>
                                    <td align="right"><strong><?php echo number_format((float) $pCr, 2, '.', ','); ?></strong></td>
                                    <td align="right"><strong><?php echo number_format((float) $cDr, 2, '.', ','); ?></strong></td> 
                                    <td align="right"><strong><?php echo number_format((float) $cCr + $opnignReturn, 2, '.', ','); ?></strong></td> 
                                </tr>
                            </tfoot>                
                        </table>  
                    </div>
                </div>
                <?php
            else:
            endif;
            ?>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>










