

<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/2');?>">Sales</a>
                </li>
                <li class="active">Customer Payment Cheque</li>
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
        <div class="page-content">
            <div class="row">
                <div class="table-header">
                    Customer Pending Cheque
                </div>
                <div>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>

                                <td align="center">SL</td>
                                <td align="center"><strong>Date</strong></td>
                                <td align="center"><strong>Voucher No.</strong></td>
                                <td align="center"><strong>Customer</strong></td>
                                <td align="center"><strong>Bank Name</strong></td>
                                <td align="center"><strong>Bank Branch</strong></td>
                                <td align="center"><strong>Cheque No</strong></td>
                                <td align="center"><strong>Cheque Date</strong></td>
                                <td align="center"><strong>Amount (In BDT.)</strong></td>
                                <?php
                                if (!empty($approvedid) && $approvedid == 1):
                                    ?>

                                    <td align="center"><strong>Approved Date</strong></td>
                                    <?php
                                endif;
                                ?>
                                <td align="center"><strong>Action</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($customerPendingCheque as $key => $row):
                                ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo date('d.m.Y', strtotime($row->date)); ?></td> 
                                    <td><a href="<?php echo site_url('viewMoneryReceipt/' . $row->moneyReceitid); ?>"><?php echo $row->receitID; ?></a></td>
                                    <td nowrap><a href="<?php echo site_url('customerDashboard/' . $row->customerid); ?>"><?php
                            $customerInfo = $this->Common_model->tableRow('customer', 'customer_id', $row->customerid);
                            echo $customerInfo->customerID . ' [ ' . $customerInfo->customerName . ' ] ';
                                ?></a></td>
                                    <td><?php echo $row->bankName; ?></td>
                                    <td><?php echo $row->branchName; ?></td>
                                    <td><?php echo $row->checkNo; ?></td>
                                    <td><?php echo $row->checkDate; ?></td>
                                    <td align="right"><?php echo number_format((float) $row->totalPayment, 2, '.', ','); ?></td>
                                    <?php
                                    if (!empty($approvedid) && $approvedid == 1):
                                        ?>
                                        <td><?php echo $row->received_date; ?></td>
                                    <?php endif; ?>

                                    <td class="center">
        <!--                                    <a href="<?php echo site_url('dealer_payment_edit/' . $row->moneyReceitid); ?>" class="btn btn-link btn-icon btn-xs tip" title="Edit"><i class="fa fa-edit"></i></a>                     -->

                                        <?php if ($row->checkStatus == 1): ?>
                                            <a onclick="getValue('<?php echo $row->moneyReceitid; ?>', '<?php echo $row->bankName; ?>', '<?php echo $row->branchName; ?>', '<?php echo $row->checkNo; ?>', '<?php echo $row->checkDate; ?>', '<?php echo $row->totalPayment; ?>', '<?php echo $this->Common_model->tableRow('customer', 'customer_id', $row->customerid)->customerName; ?>', '<?php echo $row->customerid; ?>','<?php echo $row->mainInvoiceId; ?>')" data-toggle="modal" data-target="#myModal" href="#" class="btn btn-success btn-xs " title="Check Payment Receive?"><i  class="fa fa-refresh fa-spin fa-fw"></i>Receive?</a> 
                                            <a onclick="return isconfirm()" class="btn btn-danger btn-xs "  href="<?php echo site_url('dishonourCustomerChwque/'.$row->moneyReceitid); ?>" ><i  class="fa fa-refresh fa-spin fa-fw"></i>Dishonour?</a> 
                                        <?php else: ?>
                                            <button   href="#" class="btn btn-success btn-xs " title="Check Payment Received"><i  class="fa fa-check"></i>Received</button> 
                                        <?php endif; ?>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script>

    function getValue(receitid, bankName, branchName, ceckNo, checkDate, amount, clientName, clientID,mainInvoiceId) {
        $("#amount").val('');
        $("#bankName").val('');
        $("#bankBranch").val('');
        $("#checkno").val('');
        $("#clientName").val('');
        $("#clientID").val('');
        $("#receiteID").val('');
        $("#mainInvoiceId").val('');

        $("#mainInvoiceId").val(mainInvoiceId);
        $("#amount").val(amount);
        $("#bankName").val(bankName);
        $("#bankBranch").val(branchName);
        $("#checkno").val(ceckNo);
        $("#clientName").val(clientName);
        $("#clientID").val(clientID);
        $("#receiteID").val(receitid);
    }
</script>
<style>

    .chosen-container{
        width: 350px !important;
    }


</style>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Customer Pending Cheque Approved</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="post" class="form-horizontal validate" role="form"> 

                            <div class="col-md-12">
                                <!-- Supplier -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">Deposit Account<span style="color:red;"> *</span></label>
                                    <div class="input-group">
                                        <div class="col-sm-9">

                                            <select id="form-field-select-3" data-placeholder="Search by Account" style="width:100%"  name="accountDr" class="chosen-select   checkAccountBalance" id="form-field-select-3">
                                                <option value="" selected disabled></option>
                                                <?php
                                                foreach ($accountHeadList as $key => $head) {
                                                    ?>
                                                    <optgroup label="<?php echo $head['parentName']; ?>">
                                                        <?php
                                                        foreach ($head['Accountledger'] as $eachLedger) :
                                                            ?>
                                                            <option value="<?php echo $eachLedger->chartId; ?>"><?php echo $eachLedger->title . " ( " . $eachLedger->code . " ) "; ?></option>
                                                        <?php endforeach; ?>
                                                    </optgroup>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label text-right">Date<span style="color:red;">*</span></label>
                                    <div class="col-md-8">

                                        <div class="input-group">
                                            <input class="form-control date-picker" name="paymentDate" id="id-date-picker-1" type="text" value="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" required />
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar bigger-110"></i>
                                            </span>
                                        </div>

                                    </div>
                                </div> 


                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">Remarks</label>
                                    <div class="col-sm-8">
                                        <textarea type="text" class="form-control"  name="narration" placeholder="Remarks"/></textarea>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">Client Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" readonly id="clientName" name="clientName" placeholder="0.00"/>
                                        <input type="hidden" class="form-control" readonly id="clientID" name="clientID" placeholder="0.00"/>
                                        <input type="hidden" class="form-control" readonly id="receiteID" name="receiteID" placeholder="0.00"/>
                                        <input type="hidden" class="form-control" readonly id="mainInvoiceId" name="mainInvoiceId" placeholder="0.00"/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">Amount</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" readonly id="amount" name="bankName" placeholder="0.00"/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">Bank Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" readonly id="bankName" name="bankName" placeholder="Bank Name"/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">Bank Branch</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" readonly id="bankBranch" name="bankName" placeholder="Bank Name"/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right">Check NO</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" readonly id="checkno" name="bankName" placeholder="Bank Name"/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right"></label>
                                    <div class="col-sm-8">
                                        <button type="submit"   onclick="return isconfirm()" class="btn btn-success"> <i class="fa fa-save"></i>&nbsp;Save</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-times"></i>&nbsp;Close</button>
                                    </div>
                                </div> 
                            </div>
                        </form>
                    </div>



                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>

    </div>
</div>

