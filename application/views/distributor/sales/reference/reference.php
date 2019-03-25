<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/2'); ?>">Sales</a>
                </li>
                <li class="active">Reference List</li>
            </ul>


            <ul class="breadcrumb pull-right">
                <li>
                    <a class="saleAddPermission" href="<?php echo site_url('referenceAdd'); ?>">
                        <i class="ace-icon fa fa-plus"></i>
                        Add 
                    </a>
                </li>


            </ul>


        </div>


        <div class="page-content">
            <div class="row">

                <div class="table-header">
                    Reference List
                </div>


                <!-- div.table-responsive -->

                <!-- div.dataTables_borderWrap -->
                <div>
                    <table id="example" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>

                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($referenceList as $key => $value): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $value->refCode; ?></td>
                                    <td><?php echo $value->referenceName; ?></td>
                                    <td><?php echo $value->referenceEmail; ?></td>
                                    <td><?php echo $value->referencePhone; ?></td>
                                    <td><?php echo $value->referenceAddress; ?></td>

                                    <td>
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            <!--                                            <a class="blue" href="#">
                                                                                            <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                                                        </a>-->

                                            <a class="green saleEditPermission" href="<?php echo site_url('editReference/' . $value->reference_id); ?>">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </a>

                                            <a class="red saleDeletePermission" href="javascript:void(0)" onclick="deleteReference('<?php echo $value->reference_id; ?>')">
                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
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

<script>
    function deleteReference(deleteId){
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
            type: 'success'
        },
        function (isConfirm) {
            if (isConfirm) {
                window.location.href = "deleteReference/" + deleteId;
            }else{
                return false;
            }
        });
    } 
</script>



