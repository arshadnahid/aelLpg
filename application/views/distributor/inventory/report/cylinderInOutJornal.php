
<style>
    table tbody tr td{
        margin: 1px!important;
        padding: 1px!important;
    }
    table tfoot tr td{
        margin: 1px!important;
        padding: 1px!important;
    }
    table tbody tr td{
        margin: 1px!important;
        padding: 1px!important;
    }
</style>
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/3'); ?>">Inventory</a>
                </li>
                <li class="active">Cylinder In/Out </li>
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
                <div class="col-md-12">

                    <form id="publicForm" action=""  method="post" class="form-horizontal">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Date</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input class="form-control date-picker" name="date" id="id-date-picker-1" type="text" value="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Voucher ID</label>
                                <div class="col-sm-6">
                                    <input type="text" id="form-field-1" name="voucherid" readonly value="<?php echo $voucherID; ?>" class="form-control" placeholder="Product Code" />
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Payee <span style="color:red;">*</span></label>
                                <div class="col-sm-6">
                                    <select name="payType" onchange="selectPayType(this.value)" class="chosen-select form-control" id="form-field-select-3" data-placeholder="Search by payee">
                                        <option value=""></option>
                                        <option value="1">Miscellaneous</option>
                                        <option value="2">Customer</option>
                                        <option value="3">Supplier</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="searchValue"></div>
                            <div id="oldValue">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Payee To <span style="color:red;">*</span></label>
                                    <div class="col-sm-6">
                                        <select  id="productID" onchange="getProductPrice(this.value)" class="chosen-select form-control" id="form-field-select-3" data-placeholder="Search by Name">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">


                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Pay. From ( CR ) <span style="color:red;">*</span></label>
                                <div class="col-sm-6">
                                    <select  name="accountCr" class="chosen-select form-control  checkAccountBalance" id="form-field-select-3" data-placeholder="Search by Account Head"  onchange="check_pretty_cash(this.value)">
                                        <option value=""></option>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <span id="accountBalance"></span>
                            </div>
                        </div>
                        <div class="col-md-10 col-md-offset-1">
                            <br>
                            <div class="table-header">
                                Select Account Head
                            </div>
                            <table class="table table-bordered table-hover" id="show_item">
                                <thead>
                                    <tr>
                                        <td style="width:40%"  align="center"><strong>Account Head</strong></td>
                                        <td style="width:20%" align="center"><strong>Amount</strong></td>
                                        <td style="width:20%" align="center"><strong>Memo</strong></td>
                                        <td style="width:20%" align="center"><strong>Action</strong></td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <td>

                                            <select   class="chosen-select form-control paytoAccount" id="form-field-select-3" data-placeholder="Search by Account Head"  onchange="check_pretty_cash(this.value)">
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
                                        </td>
                                        <td><input type="text" class="form-control text-right amountt amount3" onkeyup="checkOverAmount(this.value)" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"  placeholder="0.00"></td>
                                        <td><input type="text" class="form-control text-right memo" placeholder="Memo"  ></td>
                                        <td><a id="add_item" class="btn btn-info form-control" href="javascript:;" title="Add Item"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Item</a></td>
                                    </tr> 
                                    <tr>
                                        <td align="right"><strong>Sub-Total(BDT)</strong></td>
                                        <td align="right"><strong class="tttotal_amount"></strong></td>

                                        <td align="right"><strong class=""></strong></td>
                                        <td></td>
                                    </tr> 
                                </tfoot> 
                            </table> 
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Narration</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <textarea cols="100" rows="2" name="narration" placeholder="Narration" type="text"></textarea>

                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="clearfix"></div>
                        <div class="clearfix form-actions" >
                            <div class="col-md-offset-3 col-md-9">
                                <button onclick="return isconfirm()" id="subBtn" class="btn btn-info" type="submit">
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
                    </form>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker.min.js"></script>

<script>
     
    function checkOverAmount(amount){
        //        var closeAmount=  Number($("#closeAmount").val());
        //        if(isNaN(closeAmount) || closeAmount == ''){
        //             productItemValidation("Please Select Pay.from(CR) Account!");
        //        }
      
        var total_amount = 0;
        $.each($('.amount3'), function () {
            quantity = $(this).val();
            quantity = Number(quantity);
            total_amount += quantity;
        });
        if(closeAmount < total_amount){
            $("#subBtn").attr('disabled',true);
            productItemValidation("Account Balance Not Available!");
            this.value = '';
            $(this).val(0);
        }else{
            $("#subBtn").attr('disabled',false);
        }
    }
    
    
    
    
    function selectPayType(payid){
        
        var url = '<?php echo site_url("FinaneController/getPayUserList") ?>';
        $.ajax({
            type: 'POST',
            url: url,
            data:{'payid':payid},
            success: function (data)
            {
                $("#searchValue").html(data);
                $("#oldValue").hide(1000);
                $('.chosenRefesh').chosen();
                $(".chosenRefesh").trigger("chosen:updated");
            }
        });
        
    }
    
    
    
    
    function saveNewSupplier(){
        var url = '<?php echo site_url("SetupController/saveNewSupplier") ?>';
        $.ajax({
            type: 'POST',
            url: url,
            data:$("#publicForm2").serializeArray(),
            success: function (data)
            {
                $('#myModal').modal('toggle');
                $('#hideNewSup').hide(1000);
                $('#supplierid').chosen();
                //$('#customerid option').remove();
                $('#supplierid').append($(data));
                $("#supplierid").trigger("chosen:updated");
            }
        });
    }
    
    
    function checkDuplicatePhone(phone){
        var url = '<?php echo site_url("SetupController/checkDuplicateEmail") ?>';
        $.ajax({
            type: 'POST',
            url: url,
            data:{ 'phone': phone},
            success: function (data)
            {
                if(data == 1){
                    $("#subBtn2").attr('disabled',true);
                    $("#errorMsg").show(1000);
                }else{
                    $("#subBtn2").attr('disabled',false);
                    $("#errorMsg").hide(1000);
                }
            }
        });
        
    }
    
   
</script>


<script type="text/javascript">
   
    $('.amountt').change(function(){ 
        $(this).val(parseFloat($(this).val()).toFixed(2));
    });  
    var findAmount = function () {
        var ttotal_amount = 0;
        $.each($('.amount'), function () {
            amount = $(this).val();
            amount = Number(amount);
            ttotal_amount += amount;
        });
        $('.tttotal_amount').html(parseFloat(ttotal_amount).toFixed(2));
    };
    
    $(document).ready(function () {
    
        $("#add_item").click(function () {
            
      
            var accountId = $('.paytoAccount').val();
            var accountName = $(".paytoAccount").find('option:selected').attr('paytoAccountName');
            var accountCode = $(".paytoAccount").find('option:selected').attr('paytoAccountCode');
            var amount = $('.amountt').val();
            var memo = $('.memo').val();
          
            if(accountId  == '' || accountId == null){
                productItemValidation("Account Head can't be empty.");
                return false;
            }else if(amount == ''){
                productItemValidation("Amount can't be empty.");
                return false;
            }else{
                $("#show_item tbody").append('<tr class="new_item' + accountId + '"><td style="padding-left:15px;">' + accountName + ' [ ' +  accountCode    + ' ] ' + '<input type="hidden" name="accountDr[]" value="' + accountId + '"></td><td style="padding-left:15px;"  align="right">' + amount + '<input class="amount amount3" type="hidden"  name="amountDr[]" value="' + amount + '"></td><td align="right">' + memo + '<input type="hidden" class="add_quantity" name="memoDr[]" value="' + memo + '"></td><td><a del_id="' + accountId  + '" class="delete_item btn form-control btn-danger" href="javascript:;" title=""><i class="fa fa-times"></i>&nbsp;Remove</a></td></tr>');
            }
            $('.amountt').val('');
            $('.memo').val('');
            $('.paytoAccount').val('').trigger('chosen:updated');
            // $(".paytoAccount").trigger("chosen:updated");
            findAmount();
                                          
        });
        $(document).on('click','.delete_item', function () {
            if(confirm("Are you sure?")){
                var id = $(this).attr("del_id");
                $('.new_item' + id).remove();
                findAmount();
            }
        });
    });
</script>  
