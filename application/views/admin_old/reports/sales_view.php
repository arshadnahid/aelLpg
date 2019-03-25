<div class="main-content">
<div class="main-content-inner">
<div class="page-content">


<div class="row">
<div class="col-xs-12">
<h3 class="center">Sales Report</h3>
<h3 class="header smaller lighter blue center"><?php 
if ($ids == 'all') {
	echo "All Distributor";
}
else {
echo $c_info->dist_name;
}
?></h3>
<h4 class="center">From: <?php echo $st;?> ;  To: <?php echo $ed;?></h4> 
<div class="clearfix">
<div class="pull-right tableTools-container"></div>
</div>
<div class="table-header">
Reports
</div>

<!-- div.table-responsive -->

<!-- div.dataTables_borderWrap -->

<table id="dynamic-table" class="table table-striped table-bordered table-hover">
<thead>


<tr>


<th>Invoice</th>
<th>Comapny Name</th>

<th>Product Name</th>
<th>Quantity</th>
<th>Sale Price</th>
<th>Total Price</th>
<th>Profit</th>







</tr>




</thead>

  <tbody>       
<?php

$totals =0 ; $profit = 0;
    foreach ($p_info as $v_dist)
        {
  ?>


<tr>




<td>
	<a href="<?php echo base_url()?>Sales/invoice_reading/<?php echo $v_dist->invoice ?>" target="_blank"> 
		<?php echo $v_dist->invoice ?>
	
</a>
</td>
<td> <?php 

 echo $v_dist->comp_name;
// $comid = json_decode($is);
// $this->load->model('Report_model');

// $name = $this->Report_model->view_reports($comid[0]);
//echo $name->comp_name;
    
 ?>
 	
 </td>



<td><?php 
echo $v_dist->product_name;





?></td>

<td><?php 
echo $v_dist->quantity;

// $nm = json_decode($js);
// echo implode("<br>",$nm);

?></td>

<td><?php 
echo $v_dist->reatils_price;





?></td>

<td><?php 
echo $v_dist->sale_price;

$totals += $v_dist->sale_price;
?></td>


<td><?php 
echo $v_dist->profit;


$profit += $v_dist->profit;

?></td>


</tr>


<?php } ?>

<h3>
<b>Total Sales: </b><?php echo $totals; ?>
<br>
<b>Total Profit: </b><?php echo $profit; ?>

</h3>

</tbody>

</table>




</div>
</div>
</div>

</div>
</div>

