<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#">Cylinder</a>
                </li>
                <li class="active">Cylinder  List</li>
            </ul>
            
            <ul class="breadcrumb pull-right">
                <li>
                    <a class="saleAddPermission" href="<?php echo site_url('cylinderReceiveAdd'); ?>">
                        <i class="ace-icon fa fa-plus"></i>
                        Add 
                    </a>
                </li>
                

            </ul>
            
            
        </div>
        <div class="page-content">
            <div class="row">
                <div class="table-header">
                    Cylinder List
                </div>
                <div>
                    <table id="example" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Date</th>
                                <th>CV.No</th>
                                <th>Type</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Memo</th>
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
                                    <td><a title="view invoice" href="<?php echo site_url('salesInvoice_view/' . $value->generals_id); ?>"><?php echo $value->voucher_no; ?></a></td>
                                    <td><?php echo $this->Common_model->tableRow('form', 'form_id', $value->form_id)->name; ?></td>
                                    <td><a href="<?php echo site_url('customerDashboard/' . $value->customer_id); ?>"><?php
                            $customerInfo = $this->Common_model->tableRow('customer', 'customer_id', $value->customer_id);

                            echo $customerInfo->customerID . ' [ ' . $customerInfo->customerName . ' ] ';
                                ?></a></td>
                                    <td><?php echo number_format((float) $value->debit, 2, '.', ','); ?></td>
                                    <td><?php echo $value->narration; ?></td>
                                    <td>
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            <a class="blue" href="<?php echo site_url('cylinderReceiveView/' . $value->generals_id); ?>">
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





