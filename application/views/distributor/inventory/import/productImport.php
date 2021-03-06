<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo site_url('DistributorDashboard/3'); ?>">Inventory</a>
                </li>
                <li class="active">Product Import</li>
            </ul>
            <ul class="breadcrumb pull-right">
                <li>
                    <a href="<?php echo site_url('DistributorDashboard/3'); ?>">
                        <i class="ace-icon fa fa-list"></i>
                        List
                    </a>
                </li>
            </ul>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-md-12">
                    <form id="publicForm" action=""  method="post" class="form-horizontal" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Product CSV File</label>
                                <div class="col-sm-6">
                                    <input type="file" id="form-field-1" name="proImport"  value="" class="form-control"  />
                                </div>
                                <button  id="subBtn" class="btn btn-xs btn-info" type="submit">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Save
                                </button>
                                <button class="btn btn-xs" type="reset">
                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                    Reset
                                </button>
                                <a type="button" class="btn btn-xs btn-info" href="<?php echo base_url() ?>excelfiles/product.csv"><i class="fa fa-cloud-download"></i> &nbsp; Download CSV Format</a>
                                <a style="display: none;" href="<?php echo site_url('ImportController/saveImportProduct'); ?>" id="showSaveBtn" class="btn btn-xs btn-success" ><i class="fa fa-check"></i> Save</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div><!-- /.col -->
            <div class="row">
                <div class="table-header">
                    Inventory Adjustment
                </div>
                <div>
                    <table id="example" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Unit</th>
                                <th>Product</th>
                                <th>Purchases Price</th>
                                <th>Retail Price(MRP)</th>
                                <th>Whole Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($productList as $key => $value):
                                ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php
                            if ($value->catId == 0) {
                                echo "<span style='color:red;'>Not Match</span>";
                            } else {
                                echo $value->catName;
                            }
                                ?></td>
                                    <td><?php
                                    if ($value->brandId == 0) {
                                        echo "<span style='color:red;'>Not Match</span>";
                                    } else {
                                        echo $value->brandName;
                                    }
                                ?></td>
                                    <td><?php
                                    if ($value->unitId == 0) {
                                        echo "<span style='color:red;'>Not Match</span>";
                                    } else {
                                        echo $value->unitName;
                                    }
                                ?></td>
                                    <td><?php echo $value->productName; ?></td>
                                    <td><?php echo $value->purchasesPrice; ?></td>
                                    <td><?php echo $value->purchasesPrice; ?></td>
                                    <td><?php echo $value->purchasesPrice; ?></td>
                                    <td>
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            <a href="#" data-toggle="modal" data-target="#myModal" class="blue" onclick="callEditModel('<?php echo $value->importId; ?>')">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Product Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <span id="loadEditMode"></span>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script>
<?php if (count($productList) == 0): ?>
        $("#showSaveBtn").show();
<?php endif; ?>
    function callEditModel(importId){
        var main_url = '<?php echo site_url(); ?>' + 'InventoryController/updateProductInfo';
        $.ajax({
            url: main_url,
            type: 'post',
            data: {
                importId: importId,
            },
            success: function(data) {
                $("#loadEditMode").html(data);
            }
        });
    }
</script>
