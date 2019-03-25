<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/3'); ?>">Inventory</a>
                </li>
                <li class="active">Cylinder Exchange List</li>
            </ul>
            
            <ul class="breadcrumb pull-right">
                <li>
                    <a class="inventoryAddPermission" href="<?php echo site_url('cylinderInOutJournalAdd'); ?>">
                        <i class="ace-icon fa fa-plus"></i>
                        Add 
                    </a>
                </li>
                

            </ul>
            
            
        </div>
        <div class="page-content">
            <div class="row">
                <div class="table-header">
                    Cylinder Exchange List
                </div>
                <div>
                    <table id="example" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Date</th>
                                <th>PV.No</th>
                                <th>Supplier/Customer</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Narration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($cylinderList as $key => $value):
                                ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($value->date)); ?></td>
                                    <td><?php echo $value->voucher_no; ?></td>
                                    <td><?php
                            if (!empty($value->supplier_id)):
                                $suplierInfo = $this->Common_model->tableRow('supplier', 'sup_id', $value->supplier_id);

                                echo $suplierInfo->supID . ' [ ' . $suplierInfo->supName . ' ] ';
                            else:
                                $customerInfo = $this->Common_model->tableRow('customer', 'customer_id', $value->customer_id);

                                echo $customerInfo->customerID . ' [ ' . $customerInfo->customerName . ' ] ';
                            endif;
                                ?></td>
                                    <td align="right"><?php echo number_format((float) $value->qtyIn, 2, '.', ','); ?></td>
                                    <td align="right"><?php echo number_format((float) $value->qtyOut, 2, '.', ','); ?></td>
                                    <td><?php echo $value->narration; ?></td>
                                    <td>
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            <a class="blue" href="<?php echo site_url('cylinderInOutJournalView/' . $value->generals_id); ?>">
                                                <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                            </a>
                                            <a class="green inventoryEditPermission" href="<?php echo site_url('cylinderInOutJournalEdit/' . $value->generals_id); ?>">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
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





