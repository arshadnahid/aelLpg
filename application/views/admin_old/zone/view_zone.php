
<div class="main-content">
<div class="main-content-inner">
<div class="page-content">


<div class="row">
<div class="col-xs-12">
<h3 class="header smaller lighter blue">Zone Info Table</h3>

<div class="clearfix">
<div class="pull-right tableTools-container"></div>
</div>
<div class="table-header">
All Zone
</div>

<!-- div.table-responsive -->

<!-- div.dataTables_borderWrap -->
<div>
<table id="dynamic-table" class="table table-striped table-bordered table-hover">
<thead>


<tr>

<th class="center">SL</th>

<th>District Name</th>
<th>Thana Name</th>
<th>Zone Name</th>
<th>Zone Date</th>


<th>Action</th>
<th></th>


</tr>

</thead>
<tbody>
         
                    <?php
                    $count = 0;

                        foreach ($zone_info as $v_dist)
                            {
                            	?>


<tr>


<td class="center"> <?php echo ++$count ?></td>

<td> <?php echo $v_dist->district_name ?></td>

<td><?php echo $v_dist->thana_name ?></td>
<td><?php echo $v_dist->zone_name ?></td>
<td><?php echo $v_dist->zone_date ?></td>




<td>
<div class="hidden-sm hidden-xs action-buttons">

<a class="green" href="<?php echo base_url()?>edit_zone/<?php echo $v_dist->zone_id?>">
	<i class="ace-icon fa fa-pencil bigger-130"></i>
</a>

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
</div>