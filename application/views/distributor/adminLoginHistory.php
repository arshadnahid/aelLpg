<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#">Admin</a>
                </li>
                <li class="active">Admin Login History</li>
            </ul>
            
            <ul class="breadcrumb pull-right">
                <li class="active">
                    <i class="ace-icon fa fa-list"></i>
                    <a href="<?php echo site_url('DistributorDashboard/3'); ?>">List</a>
                </li>
               
            </ul>
            
        </div>
        <div class="page-content">
            <div class="row">
                <div class="table-header">
                    Admin Login History
                </div>
                <div>
                    <table id="example" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Date</th>
                                <th>IP Address</th>
                                <th>User Name</th>
                                <th>Log In</th>
                                <th>Log Out</th>
                                <th>Total Stay</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($adminInfo as $key => $value):
                                ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($value->date)); ?></td>
                                    <td><?php echo $value->ipAddress; ?></td>
                                    <td><?php echo $this->Common_model->tableRow('admin', 'admin_id', $value->adminId)->name; ?></td>
                                    <td><?php echo $value->logIn; ?></td>
                                    <td><?php echo $value->logOut; ?></td>
                                    <td><?php
                            if (!empty($value->logOut)):

                                $date1 = date_create($value->logIn);
                                $date2 = date_create($value->logOut);
                                $diff = date_diff($date1, $date2);
                                echo $diff->format("%H:%I:%S");
                            else:
                                echo "<span style='color:red;'>Not Signout</span>";
                            endif;
                                ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>

