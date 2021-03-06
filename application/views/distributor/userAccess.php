<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/4'); ?>">User</a>
                </li>
                <li class="active">User Access</li>
            </ul><!-- /.breadcrumb -->

            <ul class="breadcrumb pull-right">
                <li class="active">
                    <i class="ace-icon fa fa-list"></i>
                    <a href="<?php echo site_url('DistributorDashboard/4'); ?>">List</a>
                </li>

            </ul>


        </div>
        <div class="page-content">
            <div class="row">
                <form id="publicForm" action="<?php echo site_url('insert_menu_accessList'); ?>" method="POST" class="form-horizontal" role="form">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">User List</label>
                            <div class="col-sm-6">
                                <select id="user_id" name="user_id" onchange="get_menu_list()"  class="chosen-select form-control" id="form-field-select-3" data-placeholder="Select User">
                                    <option selected disabled></option>
                                    <?php foreach ($adminList as $each_info): ?>
                                        <option value="<?php echo $each_info->admin_id; ?>"><?php echo $each_info->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="return confirmSwat()" id="diabledBtn" disabled class="btn btn-info" type="button">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Submit
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12">
                        <div id="new_data"></div>
                    </div>
                </form>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>

<script>

    function get_menu_list() {
        
        $("#diabledBtn").attr('disabled',false);
        var url = '<?php echo site_url("HomeController/get_menu_list") ?>';
        var user_id = $('#user_id').val();
        $.ajax({
            type: 'POST',
            url: url,
            data:
                {
                'user_id': user_id
            },
            success: function (data)

            {
                $("#new_data").html(data);

            }
        });
    }


</script>

<!--<div>
                                                                                                                        <label for="form-field-select-3">Chosen</label>

                                                                                                                        <br />
                                                                                                                        <select class="chosen-select form-control" id="form-field-select-3" data-placeholder="Choose a State...">
                                                                                                                                <option value="">  </option>
                                                                                                                                <option value="AL">Alabama</option>
                                                                                                                                <option value="AK">Alaska</option>
                                                                                                                                <option value="AZ">Arizona</option>
                                                                                                                                <option value="AR">Arkansas</option>
                                                                                                                                <option value="CA">California</option>
                                                                                                                                <option value="CO">Colorado</option>
                                                                                                                                <option value="CT">Connecticut</option>
                                                                                                                                <option value="DE">Delaware</option>
                                                                                                                                <option value="FL">Florida</option>
                                                                                                                                <option value="GA">Georgia</option>
                                                                                                                                <option value="HI">Hawaii</option>
                                                                                                                                <option value="ID">Idaho</option>
                                                                                                                                <option value="IL">Illinois</option>
                                                                                                                                <option value="IN">Indiana</option>
                                                                                                                                <option value="IA">Iowa</option>
                                                                                                                                <option value="KS">Kansas</option>
                                                                                                                                <option value="KY">Kentucky</option>
                                                                                                                                <option value="LA">Louisiana</option>
                                                                                                                                <option value="ME">Maine</option>
                                                                                                                                <option value="MD">Maryland</option>
                                                                                                                                <option value="MA">Massachusetts</option>
                                                                                                                                <option value="MI">Michigan</option>
                                                                                                                                <option value="MN">Minnesota</option>
                                                                                                                                <option value="MS">Mississippi</option>
                                                                                                                                <option value="MO">Missouri</option>
                                                                                                                                <option value="MT">Montana</option>
                                                                                                                                <option value="NE">Nebraska</option>
                                                                                                                                <option value="NV">Nevada</option>
                                                                                                                                <option value="NH">New Hampshire</option>
                                                                                                                                <option value="NJ">New Jersey</option>
                                                                                                                                <option value="NM">New Mexico</option>
                                                                                                                                <option value="NY">New York</option>
                                                                                                                                <option value="NC">North Carolina</option>
                                                                                                                                <option value="ND">North Dakota</option>
                                                                                                                                <option value="OH">Ohio</option>
                                                                                                                                <option value="OK">Oklahoma</option>
                                                                                                                                <option value="OR">Oregon</option>
                                                                                                                                <option value="PA">Pennsylvania</option>
                                                                                                                                <option value="RI">Rhode Island</option>
                                                                                                                                <option value="SC">South Carolina</option>
                                                                                                                                <option value="SD">South Dakota</option>
                                                                                                                                <option value="TN">Tennessee</option>
                                                                                                                                <option value="TX">Texas</option>
                                                                                                                                <option value="UT">Utah</option>
                                                                                                                                <option value="VT">Vermont</option>
                                                                                                                                <option value="VA">Virginia</option>
                                                                                                                                <option value="WA">Washington</option>
                                                                                                                                <option value="WV">West Virginia</option>
                                                                                                                                <option value="WI">Wisconsin</option>
                                                                                                                                <option value="WY">Wyoming</option>
                                                                                                                        </select>
                                                                                                                </div>-->