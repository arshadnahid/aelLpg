<div class="main-content">
<div class="main-content-inner">
<div class="page-content">


<div class="row">
<div class="col-xs-12">
<h3 class="center">Stock Report</h3>
<h3 class="header smaller lighter blue center"><?php 
// if ($ids == 'all') {
// 	echo "All Suppliers/Companies";
// }
// else {
echo $c_info->dist_name;
//}
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



<th>Product Name</th>
<th>Barcode</th>
<th>Quantity</th>
<th>Purchase Price</th>
<th>Retails Price</th>
<th>Sales Price </th>



<th>Date</th>


</tr>




</thead>

  <tbody>       
<?php

$totals =0 ; $advn = 0; 
    foreach ($p_info as $v_dist)
        {
  ?>


<tr>





<td> <?php echo $v_dist->product_name ?></td>
<td><?php echo  $v_dist->barcode;

?></td>
<td><?php echo json_decode($v_dist->product_qty)?></td>

<td><?php echo $v_dist->purchase_price?></td>

<td><?php echo $totalss = $v_dist->retails_price;
$totals = $totals + $totalss; 

?></td>
<td><?php echo $advns = $v_dist->sale_price;
$advn = $advns +$advn ;

?></td>



<td><?php echo  $v_dist->stock_date;

?></td>





</tr>


<?php } ?>



</tbody>

</table>


<!-- <h3>
<b>Total Amounts: </b><?php echo $totals; ?>
<br><br>
<b>Total Advance: </b><?php echo $advn; ?>
<br><br>
<b>Total Due: </b><?php echo $due; ?>
</h3> -->

</div>
</div>
</div>

</div>
</div>

