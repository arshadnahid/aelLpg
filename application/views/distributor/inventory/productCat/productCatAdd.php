<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/3'); ?>">Inventory</a>
                </li>
                <li class="active">Add New Product Category</li>
            </ul>

            <ul class="breadcrumb pull-right">
                <li>
                    <a href="<?php echo site_url('productCatList'); ?>">
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
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Category Name<span style="color:red!important"> *</span></label>
                            <div class="col-sm-6">
                                <input type="text" id="form-field-1" name="title" onblur="checkDuplicateCategory(this.value)" value="" class="form-control" placeholder="Category Name" required/>
                                <span id="errorMsg"  style="color:red;display: none;"><i class="ace-icon fa fa-spinner fa-spin orange bigger-120"></i> &nbsp;&nbsp;This category name already exits!!</span>

                            </div>
                        </div>

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
<script src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker.min.js"></script>
<script>
                                    function checkDuplicateCategory(catName) {
                                        var url = '<?php echo site_url("SetupController/checkDuplicateCategory") ?>';
                                        $.ajax({
                                            type: 'POST',
                                            url: url,
                                            data: {'catName': catName},
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

                                    $('#colorpicker1').colorpicker();
</script>