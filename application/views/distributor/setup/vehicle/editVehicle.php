<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#">Setup</a>
                </li>
                <li class="active">Edit Vehicle</li>
            </ul>
            <ul class="breadcrumb pull-right">
                <li class="active">
                    <i class="ace-icon fa fa-list"></i>
                    <a href="<?php echo site_url('vehicleList'); ?>">List</a>
                </li>
            </ul>
        </div>
        <br>
        <div class="page-content">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form id="publicForm" action=""  method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Vehicle Name </label>
                            <div class="col-sm-6">
                                <input type="text" id="form-field-1" value="<?php echo $vehicleList->vehicleName;?>" name="vehicleName" class="form-control required" placeholder="Vehicle Name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Vehicle Model</label>
                            <div class="col-sm-6">
                                <input type="text" maxlength="11" id="form-field-1"  value="<?php echo $vehicleList->vehicleModel;?>"  name="vehicleModel" placeholder="Vehicle Model" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Chassis Number</label>
                            <div class="col-sm-6">
                                <input type="text" id="form-field-1" name="chassisNumber"  value="<?php echo $vehicleList->chassisNumber;?>" placeholder="Chassis Number" class="form-control" />

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Number Plate</label>
                            <div class="col-sm-6">
                                <input type="text" id="form-field-1" name="numberPlate"  value="<?php echo $vehicleList->numberPlate;?>" placeholder="Number Plate" class="form-control" />
                            </div>
                        </div>
                        <div class="clearfix form-actions" >
                            <div class="col-md-offset-3 col-md-9">
                                <button onclick="return confirmSwat()" id="subBtn" class="btn btn-info" type="button">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Update
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

<script>
    function checkDuplicateEmail(email){
        var url = '<?php echo site_url("SetupController/checkDuplicateEmailForUser") ?>';
        $.ajax({
            type: 'POST',
            url: url,
            data:{ 'email': email},
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
