<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#">Setup</a>
                </li>
                <li class="active">Vehicle List</li>
            </ul>
             <ul class="breadcrumb pull-right">
                <li class="active addPermission"><a href="<?php echo site_url('vehicleAdd'); ?>" >
                        <i class="ace-icon 	fa fa-plus"></i>  Add
                    </a>
                </li>
            </ul>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="table-header">
                    User List
                </div>
                <div>
                    <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Model</th>
                                <th>Chassis Number</th>
                                <th>Number Plate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($vehicleList as $key => $value): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $value->vehicleName; ?></td>
                                    <td><?php echo $value->vehicleModel; ?></td>
                                    <td><?php echo $value->chassisNumber; ?></td>
                                    <td><?php echo $value->numberPlate; ?></td>
                                    <td>
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            <a class="green" href="<?php echo site_url('vehicleEdit/' . $value->id); ?>">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </a>
                                            <a class="red" href="<?php echo site_url('vehicleDelete/' . $value->id); ?>">
                                                <i class="ace-icon fa fa-trash bigger-130"></i>
                                            </a>
                                        </div>
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
