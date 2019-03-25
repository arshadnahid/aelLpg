
<div class="main-content">
<div class="main-content-inner">
<div class="page-content">


<div class="row">
<div class="col-xs-12">
<h3 class="header smaller lighter blue">Distributor Info Table</h3>

<div class="clearfix">
<div class="pull-right tableTools-container"></div>
</div>
<div class="table-header">
All Distributor
</div>

<!-- div.table-responsive -->

<!-- div.dataTables_borderWrap -->
<div>
<table id="dynamic-table" class="table table-striped table-bordered table-hover">
<thead>


<tr>

<th class="center">
<label class="pos-rel">
<input type="checkbox" class="ace" />
<span class="lbl"></span>
</label>
</th>

<th>Name</th>
<th>Email</th>
<th class="hidden-480">Phone</th>

<th>
Address
</th>
<th class="hidden-480">Picture</th>

<th></th>


</tr>

</thead>
<tbody>
         
                    <?php
                        foreach ($dist_info as $v_dist)
                            {
                            	?>


<tr>


<td class="center">
<label class="pos-rel">
<input type="checkbox" class="ace" />
<span class="lbl"></span>
</label>

</td>

<td> <?php echo $v_dist->dist_name ?></td>

<td><?php echo $v_dist->dist_email ?></td>
<td><?php echo $v_dist->dist_phone ?></td>
<td><?php echo $v_dist->dist_address ?></td>




<td >
<img src="<?php echo base_url().$v_dist->dist_picture ?>" class="img-responsive" style="height: 130px; width: 220px;"></span>
</td>



<td>
<div class="hidden-sm hidden-xs action-buttons">
<!-- <a class="blue" href="#">
	<i class="ace-icon fa fa-search-plus bigger-130"></i>
</a> -->

<a class="green" href="<?php echo base_url()?>edit_distributor/<?php echo $v_dist->dist_id?>">
	<i class="ace-icon fa fa-pencil bigger-130"></i>
</a>
<?Php 

if ($v_dist->dist_label == 0) {
	

 ?>
<a class="red" href="<?php echo base_url()?>Ael_panel/active_distributor/<?php echo $v_dist->dist_id?>"  title="Active">
	<i class="ace-icon "><img  src="<?php echo base_url()?>assets/images/icon/lock.png"></i>
</a>

<?php }
else {?>
<a class="red" href="<?php echo base_url()?>Ael_panel/inactive_distributor/<?php echo $v_dist->dist_id?>"  title="Inactive">
	<i class="ace-icon "><img  src="<?php echo base_url()?>assets/images/icon/unlock.png"></i>
</a>
<?php	
}
?>


</div>



<div class="hidden-md hidden-lg">
<div class="inline pos-rel">
	<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
		<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
	</button>

	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
		

		<li>
			<a href="<?php echo base_url()?>edit_distributor/<?php echo $v_dist->dist_id?>" class="tooltip-success" data-rel="tooltip" title="Edit">
				<span class="green">
					<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
				</span>
			</a>
		</li>

		<li>
			<a href="<?php echo base_url()?>delete_distributor/<?php echo $v_dist->dist_id?>" class="tooltip-error" onclick="return ask_for_delete()"; data-rel="tooltip" title="Delete">
				<span class="red">
					<i class="ace-icon fa fa-trash-o bigger-120"></i>
				</span>
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