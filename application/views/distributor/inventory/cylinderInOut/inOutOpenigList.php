<div class="main-content">

    <div class="main-content-inner">

        <div class="breadcrumbs ace-save-state" id="breadcrumbs">

            <ul class="breadcrumb">

                <li>

                    <i class="ace-icon fa fa-home home-icon"></i>

                    <a href="<?php echo site_url('DistributorDashboard/3'); ?>">Inventory</a>

                </li>

                <li class="active">Cylinder Opening List</li>

            </ul>

            

            <ul class="breadcrumb pull-right">

                  <?php if (empty($cylinderOpening)): ?>

                <li>

                    <a class="inventoryAddPermission" href="<?php echo site_url('cylinderOpeningAdd'); ?>">

                        <i class="ace-icon fa fa-plus"></i>

                        Add 

                    </a>

                </li>

                  <?php endif; ?>



            </ul>

            

            

            

        </div>

        <div class="page-content">

            <div class="row">

                <div class="table-header">

                    Cylinder Opening List

                </div>

                <div>

                    <table id="example" class="table table-striped table-bordered table-hover">

                        <thead>

                            <tr>

                                <th>Sl</th>

                                <th>Date</th>

                                <th>PV.No</th>

                                <th>Narration</th>

                                <th>Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            foreach ($cylinderOpening as $key => $value):

                                ?>

                                <tr>

                                    <td><?php echo $key + 1; ?></td>

                                    <td><?php echo date('M d, Y', strtotime($value->date)); ?></td>

                                    <td><?php echo $value->voucher_no; ?></td>

                                    <td><?php echo $value->narration; ?></td>

                                    <td>

                                        <div class="hidden-sm hidden-xs action-buttons">

                                            <a class="blue" href="<?php echo site_url('cylinderOpeningView/' . $value->generals_id); ?>">

                                                <i class="ace-icon fa fa-search-plus bigger-130"></i>

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

</div><script src="<?php echo base_url('assets/setup.js'); ?>"></script>

