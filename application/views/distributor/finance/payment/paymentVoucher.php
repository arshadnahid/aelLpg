<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/1'); ?>">Finance</a>
                </li>
                <li class="active">Payment Voucher</li>
            </ul>
            <ul class="breadcrumb pull-right">
                <li>
                    <a title="Add New Payment Voucher" class="financeAddPermission" href="<?php echo site_url('paymentVoucherAdd'); ?>">
                        <i class="ace-icon fa fa-plus"></i>
                        Add 
                    </a>
                </li>
            </ul>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="table-header">
                    Payment Voucher

                </div>
                <div>
                    <table id="paymentDatatable" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Date</th>
                                <th>PV.No</th>
                                <th>Type</th>
                                <th>Voucher By</th>
                                <th>Memo</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script>
    $(document).ready(function() {
        //datatables
        var table = $('#paymentDatatable').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ordering" : false,
            //"order": [], 
            //   "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('ServerFilterController/paymentList') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [ 0 ], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
            //            "columns": [
            //                {data: 'brandName'},
            //                ]
        });
    });
   
</script>





