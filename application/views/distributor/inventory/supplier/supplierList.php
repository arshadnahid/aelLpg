<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#">Setup</a>
                </li>
                <li class="active">Supplier List</li>
            </ul>

            <ul class="breadcrumb pull-right">
                <li>
                    <a class="inventoryAddPermission" href="<?php echo site_url('Supplier'); ?>">
                        <i class="ace-icon fa fa-plus"></i>
                        Add 
                    </a>
                </li>
            </ul>
        </div>


        <div class="page-content">
            <div class="row">
                <div class="table-header">
                    Supplier List
                </div>
                <div>
                    <table id="supplierdatatable" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Supplier ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
<!--                                <th>Image</th>-->
                                <th class="hidden-480">Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($supplierList as $key => $value): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><a href="<?php echo site_url('supplierDashboard/' . $value->sup_id); ?>"><?php echo $value->supID; ?></a></td>
                                    <td><?php echo $value->supName; ?></td>
                                    <td><?php echo $value->supEmail; ?></td>
                                    <td><?php echo $value->supPhone; ?></td>
                                    <td><?php echo $value->supAddress; ?></td>
                                    <td><?php
                            if ($value->status == 1):
                                    ?>
                                            <a href="javascript:void(0)" onclick="supplierStatusChange('<?php echo $value->sup_id; ?>','2')" class="label label-danger arrowed">
                                                <i class="ace-icon fa fa-fire bigger-110"></i>
                                                Inactive</a>
                                        <?php else: ?>
                                            <a href="javascript:void(0)" onclick="supplierStatusChange('<?php echo $value->sup_id; ?>','1')" class="label label-success arrowed">
                                                <i class="ace-icon fa fa-check bigger-110"></i>
                                                Active
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            <?php if ($value->dist_id != 1): ?>
                                                <a class="green inventoryEditPermission" href="<?php echo site_url('supplierUpdate/' . $value->sup_id); ?>">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>
                                                <a class="red inventoryDeletePermission" href="javascript:void(0)" onclick="deleteSupplier('<?php echo $value->sup_id; ?>',2)">
                                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                </a>

                                            <?php endif; ?>

                                        </div>


                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>







                    <!--                    -->
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div><script src="<?php echo base_url('assets/setup.js'); ?>"></script>


<script>
    
    function deleteSupplier(id){
    
        swal({
            title: "Are you sure ?",
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#73AE28',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: true,
            type: 'warning'
        },
        function (isConfirm) {
            if (isConfirm) {
                // var base_u = $('#baseUrl').val();
                var main_url = '<?php echo site_url(); ?>' + 'SetupController/supplierDelete';
                $.ajax({
                    url: main_url,
                    type: 'post',
                    data: {
                        id: id,
                    },
                    success: function(data) { 
                        if(data == 1){
                            setTimeout(function(){
                                window.location.reload(1);
                            }, 100);
                            window.location.replace('<?php echo site_url(); ?>'+'supplierList');
                        }
                    }
                });
            }else{
                return false;
            }
        });
    }
    
    $(document).ready(function() {
        //datatables
        var table = $('#supplierdatatable').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('ServerFilterController/supplierList') ?>",
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




