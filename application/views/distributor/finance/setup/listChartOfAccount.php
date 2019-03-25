


<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/1'); ?>">Setup</a>
                </li>
                <li class="active">Chart Of Account List</li>
            </ul>
            
            <ul class="breadcrumb pull-right">
                <li>
                    <a class="financeAddPermission" href="<?php echo site_url('chartOfAccount'); ?>">
                        <i class="ace-icon fa fa-plus"></i>
                        Add 
                    </a>
                </li>
                

            </ul>
            
            
        </div>
        <div class="page-content">
            <div class="row">
                <div class="table-header">
                    Chart List
                </div>
                <div>
                    <table id="example" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Account Code</th>
                                <th>Account Name</th>
                                <th>Parent Account</th>
                                <th class="hidden-480">Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($chartList as $key => $value):
                                $menuName = $this->Common_model->get_single_data_by_single_column('chartofaccount', 'chart_id', $value->parentId);
                                ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php
                            if (strlen($value->accountCode) == 6):
                                echo $value->accountCode . ' - 000 ' . ' - 0000 ';
                            elseif (strlen($value->accountCode) == 11):
                                echo $value->accountCode . ' - 0000 ';
                            else:
                                echo $value->accountCode;
                            endif;
                                ?></td>
                                    <td><?php echo $value->title; ?></td>
                                    <td><?php echo $menuName->title; ?></td>
                                    <td> <?php
                                    if ($value->common != 1):
                                        if ($value->status == 1):
                                        ?>

                                                <a href="javascript:void(0)" onclick="chartStatusChange('<?php echo $value->chart_id; ?>','2')" class="label label-danger arrowed">
                                                    <i class="ace-icon fa fa-fire bigger-110"></i>
                                                    Inactive</a>
                                            <?php else: ?>
                                                <a href="javascript:void(0)" onclick="chartStatusChange('<?php echo $value->chart_id; ?>','1')" class="label label-success arrowed">
                                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                                    Active
                                                </a>
                                            <?php
                                            endif;
                                        else:
                                            ?>
                                            <a href="javascript:void(0)" class="label label-danger arrowed">
                                                <i class="ace-icon fa fa-fire bigger-110"></i>
                                                Inactive</a>
                                        <?php endif; ?>




                                    </td>



                                    <td>
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            <!--                                            <a class="blue" href="#">
                                                                                            <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                                                        </a>-->

                                            <a  class="green financeEditPermission" <?php if ($value->common != '1') { ?> href="<?php echo site_url('editChartOfAccount/' . $value->chart_id); ?>"<?php } else { ?> style="color:red!important;" <?php } ?>>
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </a>

                <!--                                            <a class="red" href="javascript:void(0)" onclick="deleteData('supplier','sup_id','supplierList','<?php echo $value->chart_id; ?>')">
                                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                            </a>-->


                                            <!--                                            <a onclick="return isconfirm()" class="red" href="#">
                                                                                            
                                                                                        </a>-->
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




