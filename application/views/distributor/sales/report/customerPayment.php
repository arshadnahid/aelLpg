<?php
if (isset($_POST['start_date'])):
    $customerid = $this->input->post('customerid');
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
                <li class="active"> Customer Payment</li>
            </ul>
            <ul class="breadcrumb pull-right">
                <li>
                    <a href="<?php echo site_url('customerPayment'); ?>">
                        <i class="ace-icon fa fa-list"></i>
                        List
                    </a>
                </li>
            </ul>
        </div>
        <br>
        <div class="page-content">
            <form id="publicForm" action=""  method="post" class="form-horizontal">
                <div class="row  noPrint">
                    <div class="col-md-12">
                        <div class="col-sm-10 col-md-offset-1">
                            <div class="table-header">
                                Customer Payment Receive
                            </div>
                            <br>
                            <div style="background-color: grey!important;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Customer<span style="color:red;"> * </span></label>
                                        <div class="col-sm-8">
                                            <select  name="customerid" class="chosen-select form-control customerId" id="customerId" data-placeholder="Search by Customer"  onchange="check_pretty_cash(this.value)">
                                                <option value=""></option>
                                                <?php foreach ($customerList as $eachInfo): ?>
                                                    <option <?php
                                                if (!empty($customerid) && $customerid == $eachInfo->customer_id) {
                                                    echo "selected";
                                                }
                                                    ?> value="<?php echo $eachInfo->customer_id; ?>"><?php echo $eachInfo->customerName; ?>[<?php echo $eachInfo->customerID; ?>]</option>
                                                    <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Receipt ID<span style="color:red;"> * </span></label>
                                        <div class="col-sm-8">
                                            <input readonly type="text"class="form-control"  name="receiptId" value="<?php
                                                    echo $moneyReceitVoucher;
                                                    ?>"  placeholder=""/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Payment Date<span style="color:red;"> * </span></label>
                                        <div class="col-sm-8">
                                            <input type="text"class="date-picker form-control" id="start_date" name="paymentDate" value="<?php
                                                   if (!empty($from_date)) {
                                                       echo $from_date;
                                                   } else {
                                                       echo date('d-m-Y');
                                                   }
                                                    ?>" data-date-format='dd-mm-yyyy' placeholder="Start Date: dd-mm-yyyy" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Payment Type<span style="color:red;">*</span></label>
                                        <div class="col-sm-8">
                                            <label class="radio-inline"><input checked onclick="getClickValue(this.value)" type="radio" name="payType" class="styled paymentType" checked="checked" value="1">Cash</label>
                                            <label class="radio-inline"><input onclick="getClickValue(this.value)" type="radio" name="payType" class="styled paymentType" value="2" >Bank</label>
                                        </div>
                                    </div>
                                </div>
                                <div  id="bankInfo" style="display: none;" class="col-md-8">
                                    <div class="form-group">
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control required" placeholder="Bank Name" id="bankName" name="bankName" value="">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control required" placeholder="Branch Name" id="branchName" name="branchName" value="">
                                        </div>

                                        <div class="col-sm-3">
                                            <input type="text" class="form-control  required" placeholder="Check NO" id="checkNo" name="checkNo" value="" >
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text"class="date-picker form-control" id="checkDate" name="date" value="<?php
                                                   if (!empty($from_date)) {
                                                       echo $from_date;
                                                   } else {


                                                       echo date('d-m-Y');
                                                   }
                                                    ?>" data-date-format='dd-mm-yyyy' placeholder="Start Date: dd-mm-yyyy"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8" id="cashInfo">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Deposit(DR) <span style="color:red;">*</span></label>
                                            <div class="col-sm-8">
                                                <select  name="accountDr" class="chosen-select form-control checkAccountBalance" id="accountHead" data-placeholder="Search by Account Head"  onchange="check_pretty_cash(this.value)">
                                                    <option value=""></option>
                                                    <?php
                                                    foreach ($accountHeadList as $key => $head) {
                                                        ?>
                                                        <optgroup label="<?php echo $head['parentName']; ?>">
                                                            <?php
                                                            foreach ($head['Accountledger'] as $eachLedger) :
                                                                ?>
                                                                <option paytoAccountCode="<?php echo $eachLedger->code; ?>" paytoAccountName="<?php echo $eachLedger->title; ?>" value="<?php echo $eachLedger->chartId; ?>"><?php echo $eachLedger->title . " ( " . $eachLedger->code . " ) "; ?></option>
                                                            <?php endforeach; ?> 
                                                        </optgroup>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <span id="accountBalance"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div><!-- /.col -->

                <div class="row">
                    <div class="col-sm-10 col-md-offset-1">						
                        <div id="voucherheader" class="table-header" style="display: none;">
                            Due Voucher List
                        </div>
                        <span id="customer_result"></span> 
                    </div>
                    <div class="col-sm-10 col-md-offset-1" id="narration" style="display: none;">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Narration</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <textarea cols="100" rows="2" name="narration" placeholder="Narration" type="text"></textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-10 col-md-offset-1">	
                        <div class="clearfix form-actions" id="submitBtn" style="display: none;">
                            <div class="col-md-offset-3 col-md-9">
                                <button onclick="return confirmWithValidat()" id="subBtn" class="btn btn-info" type="button">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Save
                                </button>
                                &nbsp; &nbsp; &nbsp;
                                <button class="btn" type="reset">
                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div> 
            </form>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script type="text/javascript">
    
    
    function confirmWithValidat(){
        
        
        
        var paymentType = $("input[name='payType']:checked").val();
        var supplierId= $("#customerId").val();
        var paymentDate= $("#start_date").val();
        var bankName= $("#bankName").val();
        var branchName= $("#branchName").val();
        var checkNo= $("#checkNo").val();
        var checkDate= $("#checkDate").val();
        var accountHead= $("#accountHead").val();
        var ttl_amount = Number($(".ttl_amount ").val());
        
        if(isNaN(ttl_amount)){
            ttl_amount=0;
        }
 
        
        if(supplierId == ''){
            swal("Supplier Cnn't be empty!!",'Validatin Error','error');
        }else if(paymentDate == ''){
            swal("Payment Date Cnn't be empty!!",'Validatin Error','error');
        }else if(paymentType == 2 && bankName == ''){
            swal("Bank Name Can't be empty!!",'Validatin Error','error');
        }else if(paymentType == 2 && branchName == ''){
            swal("Branch Name Can't be empty!!",'Validatin Error','error');
        }else if(paymentType == 2 && checkNo == ''){
            swal("Check No Can't be empty!!",'Validatin Error','error');
        }else if(paymentType == 2 && checkDate == ''){
            swal("Check Date Can't be empty!!",'Validatin Error','error');
        }else if(paymentType == 1 && accountHead == ''){
            swal("Account Head Can't be empty!!",'Validatin Error','error');
        }else if(ttl_amount == ''){
            swal("Amount Can't be empty!!");
        }else{
            swal({
                title: "Are you sure ?",
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#73AE28',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true,
                type: 'success'
            },
            function (isConfirm) {
                if (isConfirm) {
                    $("#publicForm").submit();
                }else{
                    return false;
                }
            }); 
        }
       
          
        
    }
    
    
    
    
    
    
    
    
    
    function checkOverAmount(dynamicId){
        var paymentAmount = parseFloat($("#paymentAmount_" + dynamicId).val());
        if(isNaN(paymentAmount)){
            paymentAmount=0;
        }
        var dueAmount = parseFloat($("#dueAmount_" + dynamicId).val());
        if(isNaN(dueAmount)){
            dueAmount=0;
        }
        
        if(paymentAmount > dueAmount){
            $("#paymentAmount_" + dynamicId).val('');
           
        }
        
        var totalVoucherPayment = 0;
        $.each($('.amount'), function () {
            voucherAmount = $(this).val();
            if(isNaN(voucherAmount)){
                $(this).val('');
                voucherAmount=0;
            }
            voucherAmount = Number(voucherAmount);
            totalVoucherPayment += voucherAmount;
        });
        if(totalVoucherPayment > 0){
            $("#subBtn").attr('disabled',false);
        }else{
            $("#subBtn").attr('disabled',true);
        }
        
    }

    function getClickValue(id) {
        if (id == 1) {
            $("#bankInfo").hide(10);
            $("#cashInfo").show(10);
                           
        } else {
            $("#bankInfo").show(10);
            $("#cashInfo").hide(10);
        }
    }
    $(document).ready(function () {
        $('.customerId').change(function () {
            var customer = $(this).val();
            $.ajax({
                type: 'POST',
                data: {customer: customer},
                url: '<?php echo site_url('SalesController/customer_ajax'); ?>',
                success: function (result) {
                    $('#customer_result').html(result);
                    $('#voucherheader').show(1000);
                    $('#narration').show(1000);
                    $('#submitBtn').show(1000);
                }
            });
        });
        $('.checkAccountBalance').change(function(){		
            var accountId = $(this).val();		
            $.ajax({
                type: 'POST', 
                data: {account: accountId}, 
                url: '<?php echo site_url('FinaneController/checkBalance'); ?>', 
                success: function(result){ 
                   
                    $('#accountBalance').html(''); 
                    $('#accountBalance').html(result); 
                } 
            });
        });
        
        
        
    });
</script> 
