
<div class="main-content">
<div class="main-content-inner">
<div class="page-content">


<div class="row">
<div class="col-xs-12">
<h3 class="header smaller lighter blue">Incentive Views List</h3>

<div class="clearfix">
<div class="pull-right tableTools-container"></div>
</div>
<div class="table-header">
All Incentive
</div>

<!-- div.table-responsive -->

<!-- div.dataTables_borderWrap -->
<div>
<table id="dynamic-table" class="table table-striped table-bordered table-hover">
<thead>


<tr>



<th>Product Name</th>
<th>Start Date</th>
<th>End Date</th>

<th class="">Target Quantity</th>
<th class="">Price Less</th>
<th>Distributor</th>
<th>Action</th>


</tr>

</thead>
<tbody>
         
                    <?php
                        foreach ($offer_info as $v_dist)
                            {
                            	?>


<tr>




<td> <?php echo $v_dist->product_name ?></td>

<td><?php echo $v_dist->start_date ?></td>
<td><?php echo $v_dist->end_date ?></td>


<td><?php echo $v_dist->target_qty ?></td>

<td><?php echo $v_dist->price_less ?></td>

<td><?php echo $v_dist->dist_name ?></td>



<td>
<div class="hidden-sm hidden-xs action-buttons">
<!-- <a class="blue" href="#">
	<i class="ace-icon fa fa-search-plus bigger-130"></i>
</a> -->

<a class="green" href="<?php echo base_url()?>delete_incentive/<?php echo $v_dist->incentive_id?>" onclick="return ask_for_delete()";>
	<i class="ace-icon fa fa-trash-o bigger-130"></i>
</a>



</div>



<div class="hidden-md hidden-lg">
<div class="inline pos-rel">
	<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
		<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
	</button>

	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
		

	

		<li>
			<a class="green" href="<?php echo base_url()?>delete_incentive/<?php echo $v_dist->incentive_id?>" onclick="return ask_for_delete()";>
	<i class="ace-icon fa fa-trash-o bigger-130"></i>
</a>
		</li>
	</ul>
</div>
</div>
</td>
</tr>



<?php } ?>
</tbody>

</table>
</div>
</div>
</div>

</div>
</div>
</div>