<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/3'); ?>">Inventory</a>
                </li>
                <li class="active">Product List</li>
            </ul>
            <ul class="breadcrumb pull-right">
                <li>
                    <a class="inventoryAddPermission" href="<?php echo site_url('addproductType'); ?>">
                        <i class="ace-icon fa fa-plus"></i>
                        Add
                    </a>
                </li>
            </ul>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="table-header">
                    Product List
                </div>
                <div>
                    <table id="productDatatable" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Product Category</th>
                                
                                <th>Status</th>
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
<script src="<?php echo base_url('assets/setup.js'); ?>"></script>
<script>
    function deleteProduct(deleteId){
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
                window.location.href = "deleteProduct/" + deleteId;
            }else{
                return false;
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        //datatables
        var table = $('#productDatatable').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ordering" : false,
            //"order": [],
         //   "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('ServerFilterController/productTypeList') ?>",
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
    function productTypeStatusChange(product_type_id,supStatus){

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

            var base_u = $('#baseUrl').val();
            var main_url = base_u +'ProductController/productTypeStatusChange';
            $.ajax({
                url: main_url,
                type: 'post',
                data: {
                    product_type_id: product_type_id,
                    status: supStatus
                },
                success: function(data) {
                    setTimeout(function(){
                        window.location.reload(1);
                    }, 100);
                    if(data == 1){

                        window.location.replace(base_u +"productType");
                    }
                }
            });

        }else{
            return false;
        }
    });
}
  function deleteProductType(deleteId){
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
                window.location.href = "deleteProductType/" + deleteId;
            }else{
                return false;
            }
        });
    }

</script>
