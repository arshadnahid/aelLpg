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
                    <a href="<?php echo site_url('DistributorDashboard/1'); ?>">Finance</a>
                </li>
                <li class="active">Cash Flow Report</li>
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
                        <div class="col-sm-10 col-md-offset-1">
                            <div class="table-header">
                                Cash Flow
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
            if (isset($_POST['start_date']) && $_POST['end_date']):
          
                $from_date = $this->input->post('start_date');
                $to_date = $this->input->post('end_date');
//
//
//                $this->Finane_Model->getSalesCollection($from_date, $to_date);
//                $this->Finane_Model->getSupplierPayment($from_date, $to_date);
//                $this->Finane_Model->getExpense($from_date, $to_date);
//                $this->Finane_Model->getOthersSourceIncome($from_date, $to_date);



                $dist_id = $this->dist_id;
                $total_pvsdebit = '';
                $total_pvscredit = '';

                $total_debit = '';
                $total_credit = '';
                $total_balance = '';
                  // die("test");
                ?>
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1">
                        <div class="table-header">
                            Cash Flow Report
                        </div>
                        <table class="table table-bordered">
                            <thead><tr>
                                    <td align="center"><strong>Account Code and Name</strong></td>
                                    <td align="center"><strong>Subtotal Balance (In BDT.)</strong></td>
                                    <td align="center"><strong>Total Balance (In BDT.)</strong></td>
                                    <td align="center"><strong>Subtotal Prior Year Balance (In BDT.)</strong></td>
                                    <td align="center"><strong>Total Prior Year Balance (In BDT.)</strong></td>
                                </tr></thead>
                            <tbody>         
                                <tr><td colspan="5"><strong>A. Cash Flow for Operating Activities</strong></td></tr>                    

                                <tr><td colspan="5">1. Cash Flow for Operation</td></tr>  
                                <tr>
                                    <td style="padding-left:30px;">Net Profit/Loss after Taxation</td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td>  
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 						
                                </tr>                      
                                <tr>
                                    <td style="padding-left:30px;">Depreciation on Fixed Assets</td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td>
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 						
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Subsidy for Govt.</td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Adjustment for Prior Year</td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>      


                                <tr><td colspan="5">2. Changes in Net Assets and Liabilities</td></tr> 
                                <tr>
                                    <td style="padding-left:30px;">Provision for Income Tax</td> 
                                    <td align="right">0.00</td>  
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Increase/Decrease in Loan & Advance</td> 
                                    <td align="right">0.00</td>   
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Increase/Decrease in Temporary Advance</td> 
                                    <td align="right">0.00</td>    
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Claim Receivable</td> 
                                    <td align="right">0.00</td>  
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Account Receivable</td> 
                                    <td align="right">0.00</td>  
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Stock in Trade</td> 
                                    <td align="right">0.00</td> 
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Deposit & Advance</td> 
                                    <td align="right">0.00</td>   
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Advance Income Tax</td> 
                                    <td align="right">0.00</td>  
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Advance Rent</td> 
                                    <td align="right">0.00</td> 
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Deposit & Advance Payable</td> 
                                    <td align="right">0.00</td>  
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Account Payable</td> 
                                    <td align="right">0.00</td>    
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Staff Provident Fund</td> 
                                    <td align="right">0.00</td> 
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>  
                                <tr>
                                    <td align="right" colspan="3"><strong>Net Cash Flow from Operating Activities</strong></td> 
                                    <td align="right"><strong>0.00</strong></td>   
                                    <td align="right"><strong>0.00</strong></td> 
                                </tr>                                    


                                <tr><td colspan="5"><strong>B. Cash Flow for Investing Activities</strong></td></tr>
                                <tr>
                                    <td style="padding-left:30px;">Addition of Fixed Assets</td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 
                                </tr>                    
                                <tr>
                                    <td style="padding-left:30px;">Adjustment of Fixed Assets During the Year</td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td>    
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td> 						
                                </tr> 
                                <tr>
                                    <td align="right" colspan="3"><strong>Net Cash Flow Used in Investing Activities</strong></td> 
                                    <td align="right"><strong>0.00</strong></td>                                   
                                    <td align="right"><strong>0.00</strong></td>                                   
                                </tr>                                      


                                <tr><td colspan="5"><strong>C. Cash Flow for Financial Activities</strong></td></tr>
                                <tr>
                                    <td style="padding-left:30px;">LTR with Bank</td> 
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td>  
                                    <td align="right">0.00</td>                                  
                                    <td align="right"></td>   						
                                </tr>                    
                                <tr>
                                    <td align="right" colspan="3"><strong>Net Cash Flow during the Year (A+B+C)</strong></td> 
                                    <td align="right"><strong>0.00</strong></td>   
                                    <td align="right"><strong>0.00</strong></td> 						
                                </tr>

                            <tbody>

                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>





