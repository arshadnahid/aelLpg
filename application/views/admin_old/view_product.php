<div class="main-content">
<div class="main-content-inner">
<div class="page-content">


<div class="row">
<div class="col-xs-12">
<h3 class="header smaller lighter blue">Product Info Table</h3>

<div class="clearfix">
<div class="pull-right tableTools-container"></div>
</div>
<div class="table-header">
All Product
</div>

<!-- div.table-responsive -->

<!-- div.dataTables_borderWrap -->

<table id="dynamic-table" class="table table-striped table-bordered table-hover">
<thead>


<tr>

<th class="center">
Product Code
</th>

<th>Product Name</th>


<th>Purchase Price</th>
<th>Sale Price</th>
<th>Retails Price</th>

<th>Image</th>


<th>Action</th>

<th></th>
</tr>

</thead>

  <tbody>       
<?php
    foreach ($product_info as $v_dist)
        {
  ?>


<tr>


<td class="center">
<?php echo $v_dist->product_code ?>
</label>

</td>

<td><a href="<?php echo base_url()?>stock_Product/<?php echo $v_dist->product_id?>"> <?php echo $v_dist->product_name ?></a></td>

<!-- <td><?php echo $v_dist->product_details?></td> -->

<td><?php echo $v_dist->purchase_price?></td>

<td><?php echo $v_dist->sale_price?></td>
<td><?php echo $v_dist->retails_price?></td>

<td><img src="<?php echo base_url().$v_dist->product_pic?>" style="height: 50px;"></td> 



<!-- 
<td>
<span>
<img src="<?php echo base_url().$v_dist->product_pic ?>" class="img-responsive" style="height: 130px; width: 220px;"></span>
</td>
 -->


<td>
<div class="hidden-sm hidden-xs action-buttons">
<!-- <a class="green" href="<?php echo base_url()?>barcode_product/<?php echo $v_dist->product_id?>"  title="Barcode Product">
	<i class="ace-icon fa fa-barcode bigger-130"></i>
</a> -->

<a class="green" href="<?php echo base_url()?>Ael_panel/edit_product/<?php echo $v_dist->product_id?>">
	<i class="ace-icon fa fa-pencil bigger-130"></i>
</a>

<!-- <a class="red" href="<?php echo base_url()?>Dist_panel/delete_product/<?php echo $v_dist->product_id?>" onclick="return ask_for_delete()";>
	<i class="ace-icon fa fa-trash-o bigger-130"></i>
</a> -->
</div>



<div class="hidden-md hidden-lg">
<div class="inline pos-rel">
	<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
		<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
	</button>

	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
		
		<li>
			<a href="<?php echo base_url()?>Dist_panel/delete_product/<?php echo $v_dist->product_id?>" class="tooltip-success" data-rel="tooltip" title="Edit">
				<span class="green">
					<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
				</span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url()?>edit_product/<?php echo $v_dist->product_id?>" class="tooltip-success" data-rel="tooltip" title="Edit">
				<span class="green">
					<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
				</span>
			</a>
		</li>

	
	</ul>
</div>
</div>
</td>


<td></td>



</tr>



<?php } ?>
</tbody>

</table>
</div>
</div>
</div>

</div>
</div>

