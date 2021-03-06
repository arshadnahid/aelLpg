<style>
    table tr td{
        margin: 2px!important;
        padding: 2px!important;
    }
</style>

<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/1'); ?>">Finance </a>
                </li>
                <li>You can entry opening balance only one time.<span style="color:red!important;">Be Careful!!</span></li>
            </ul>
            <ul class="breadcrumb pull-right">
                <li>
                    <a class="addPermission" href="<?php echo site_url('supplierOpening'); ?>">
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
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Voucher  ID</label>
                                <div class="col-sm-6">
                                    <input type="text" id="form-field-1" name="voucherid" readonly value="SOB<?php echo rand(100000, 7000000); ?>" class="form-control" placeholder="Product Code" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1">  Date</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <input class="form-control date-picker" name="purchasesDate" id="id-date-picker-1" type="text" value="<?php echo date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-10 col-md-offset-1">
                            <div class="table-header">
                                Supplier
                            </div>
                            <table class="table table-bordered table-hover" id="show_item">
                                <thead>
                                    <tr>
                                        <td  align="center"><strong>Supplier</strong></td>
                                        <td align="center"><strong>Payable</strong></td>
                                        <!--<td  align="center"><strong>Cr</strong></td>-->
                                        <td align="center"><strong>Action</strong></td>
                                    </tr>
                                </thead>
                                <tbody></tbody>

                                <tfoot>
                                    <tr>
                                        <td>
                                            <!--<select data-placeholder="(:-- Select Category --:)"  class="category_product select-search1">-->
                                            <select id="category_product"  class="chosen-select form-control" id="form-field-select-3" data-placeholder="Search by Supplier">
                                                <option value=""></option>
                                                <?php
                                                foreach ($supList as $eachCat):
                                                    ?>
                                                    <option catName="<?php echo $eachCat->supID . ' [ ' . $eachCat->supName . ' ] '; ?>" value="<?php echo $eachCat->sup_id; ?>">
                                                        <?php echo $eachCat->supID . '[' . $eachCat->supName . ']'; ?>
                                                    </option>													
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control text-right dr"  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" placeholder="0.00" ></td>
                                        <!--<td><input type="text" class="form-control text-right cr"  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" placeholder="0.00" ></td>-->
                                        <td><a id="add_item" class="btn btn-info form-control" href="javascript:;" title="Add Item"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Item</a></td>
                                    </tr> 
                                    <tr>
                                        <td align="right"><strong>Sub-Total(BDT)</strong></td>
                                        <td align="right"><strong class="total_debit"></strong></td>
                                        <!--<td align="right"><strong class="total_credit"></strong></td>-->
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
                                <button onclick="return confirmSwat()" id="subBtn" class="btn btn-info" type="button">
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


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Supplier</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="publicForm2" action=""  method="post" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Supplier ID </label>
                                <div class="col-sm-6">
                                    <input type="text" id="form-field-1" name="supplierId" readonly value="<?php echo isset($supplierID) ? $supplierID : ''; ?>" class="form-control" placeholder="SupplierID" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Supplier Name </label>

                                <div class="col-sm-6">
                                    <input type="text" id="form-field-1" name="supName" class="form-control required" placeholder="Name" />
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Phone</label>
                                <div class="col-sm-6">
                                    <input type="text" maxlength="11" id="form-field-1" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onblur="checkDuplicatePhone(this.value)" name="supPhone" placeholder="Phone" class="form-control" />
                                    <span id="errorMsg"  style="color:red;display: none;"><i class="ace-icon fa fa-spinner fa-spin orange bigger-120"></i> &nbsp;&nbsp;Phone Number already Exits!!</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email</label>
                                <div class="col-sm-6">
                                    <input type="email" id="form-field-1" name="supEmail" placeholder="Email" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Address</label>
                                <div class="col-sm-6">
                                    <!--<textarea id="editor1" cols="10" rows="5" name="comp_add"></textarea>-->
                                    <textarea  cols="6" rows="3" placeholder="Type Address.." class="form-control" name="supAddress"></textarea>
                                </div>
                            </div>



                            <div class="clearfix form-actions" >
                                <div class="col-md-offset-3 col-md-9">
                                    <button onclick="saveNewSupplier()" id="subBtn2" class="btn btn-info" type="button" >
                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                        Save
                                    </button>
                                    &nbsp; &nbsp; &nbsp;
                                    <button class="btn" type="reset" data-dismiss="modal">
                                        <i class="ace-icon fa fa-undo bigger-110"></i>
                                        Reset
                                    </button>
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



<script>
    
    
    
    $(document).on("keyup", ".add_debit", function () {
     
        findTotalCal();
    });
    
    
    function showBankinfo(id){
        if(id == 3){
            $("#showBankInfo").show(1000); 
        }else{
            $("#showBankInfo").hide(1000);   
        }
       
        if(id == 1){
            $("#hideAccount").show(1000);
        }else{
            $("#hideAccount").hide(1000); 
        }
        
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
                $('#hideNewSup').hide();
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
                    $("#errorMsg").show();
                }else{
                    $("#subBtn2").attr('disabled',false);
                    $("#errorMsg").hide();
                }
            }
        });
        
    }
    
   
</script>


<script type="text/javascript">
    
    
  


    var findTotaldr = function () {
        var total_debit = 0;
        $.each($('.add_debit'), function () {
            debit = $(this).val();
            debit = Number(debit);
            total_debit += debit;
        });
        $('.total_debit').html(parseFloat(total_debit));
    };
    var findTotalcr = function () {
        var total_credit = 0;
        $.each($('.add_credit'), function () {
            credit = $(this).val();
            credit = Number(credit);
            total_credit += credit;
        });
        $('.total_credit').html(parseFloat(total_credit));
    };


    var findTotalCal = function () {
        findTotaldr();
        findTotalcr();
     
    };

    
    
    $(document).ready(function () {

        var j = 0;
        $("#add_item").click(function () {
            var productCatID = $('#category_product').val();
            var productCatName = $("#category_product").find('option:selected').attr('catName');
       
            var debit = $('.dr').val();
            var credit = $('.cr').val();
            if(productCatID == '' || productCatID == 0){
                swal("Supplier Name Can't be empty!!", "Validation Error!", "error");
            }else if(debit == '' || debit == 0){
                swal("Payable Amount Can't be empty!!", "Validation Error!", "error");
            }else{
                // $("#show_item tbody").append('<tr class="new_item' + productCatID + j + '"><td style="padding-left:15px;">' + productCatName + '<input type="hidden" name="suplierID[]" value="' + productCatID + '"></td><td style="padding-left:15px;">' + debit + '<input type="hidden" class="add_debit"  name="debit[]" value="' + debit + '"></td><td align="right">' + credit + '<input type="hidden" class="add_credit" name="credit[]" value="' + credit + '"></td><td><a del_id="' + productCatID + j  + '" class="delete_item btn form-control btn-danger" href="javascript:;" title=""><i class="fa fa-times"></i>&nbsp;Remove</a></td></tr>');
                $("#show_item tbody").append('<tr class="new_item' + productCatID + j + '"><td style="padding-left:15px;">' + productCatName + '<input type="hidden" name="suplierID[]" value="' + productCatID + '"></td><td style="padding-left:15px;" align="right"><input type="text" class="add_debit text-right form-control"  name="debit[]" value="' + debit + '"></td><td><a del_id="' + productCatID + j  + '" class="delete_item btn form-control btn-danger" href="javascript:;" title=""><i class="fa fa-times"></i>&nbsp;Remove</a></td></tr>');
                $('.dr').val('');
                $('#category_product').val('').trigger('chosen:updated');
                j++;
                findTotalCal();
          
            }                          
        });
        $(document).on('click','.delete_item', function () {
            var id = $(this).attr("del_id");
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
                    $('.new_item' + id).remove();
                    findTotalCal();
                }else{
                    return false;
                }
            });
         
        });
    });
               
    function getProductPrice(product_id) {
       
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('FinaneController/getProductPrice'); ?>",
            data: 'product_id=' + product_id,
            success: function (data) {
                $('.rate').val(data);
            }
        });
    }
    function getProductList(cat_id) {
       
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('FinaneController/getProductList'); ?>",
            data: 'cat_id=' + cat_id,
            success: function (data) {
                
                $('#productID').chosen();
                $('#productID option').remove();
                $('#productID').append($(data));
                $("#productID").trigger("chosen:updated");
                
            }
        });
    }

</script>  



<script>
    function checkDuplicateCategory(catName){
        var url = '<?php echo site_url("SetupController/checkDuplicateCategory") ?>';
        $.ajax({
            type: 'POST',
            url: url,
            data:{ 'catName': catName},
            success: function (data)
            {
                if(data == 1){
                    $("#subBtn").attr('disabled',true);
                    $("#errorMsg").show();
                }else{
                    $("#subBtn").attr('disabled',false);
                    $("#errorMsg").hide();
                }
            }
        });
        
    }
</script>