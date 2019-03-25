<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#">Inventory </a>
                </li>
                <li class="active">Unit Add</li>
            </ul>
            <ul class="breadcrumb pull-right">
                
                <li>
                    <a href="<?php echo site_url('unit'); ?>">
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

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Unit Name<span style="color:red"> *</span></label>
                                <div class="col-sm-6">
                                    <input type="text" onblur="checkDuplicateUnit(this.value)" id="form-field-1" name="unitTtile"  value="" class="form-control" placeholder="Unit Name" required=""/>
                                    <span id="errorMsg"  style="color:red;display: none;"><i class="ace-icon fa fa-spinner fa-spin orange bigger-120"></i> &nbsp;&nbsp;This Unit name already exits!!</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Unit Code</label>
                                <div class="col-sm-6">
                                    <input type="text" id="form-field-1" name="code"  value="" class="form-control" placeholder="Unit code" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        <div class="clearfix form-actions" >
                            <div class="col-md-offset-3 col-md-9">
                                <button onclick="return confirmSwat()"   id="subBtn" class="btn btn-info" type="button">
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

<script>
    function checkDuplicateUnit(unitName) {
        var url = '<?php echo site_url("SetupController/checkDuplicateUnit") ?>';
        $.ajax({
            type: 'POST',
            url: url,
            data: {'unitName': unitName},
            success: function (data)
            {
                if (data == 1) {
                    $("#subBtn").attr('disabled', true);
                    $("#errorMsg").show();
                } else {
                    $("#subBtn").attr('disabled', false);
                    $("#errorMsg").hide();
                }
            }
        });

    }


</script>





