


<div class="row">
<div class="col-xs-12">
<h3 class="center">Chart Of Accounts</h3>
<h3 class="header smaller lighter blue center"><!-- <?php 

//echo $c_info->comp_name;

?> --></h3>
<!-- <h4 class="center">From: <?php echo $st;?> ;  To: <?php echo $ed;?></h4>  -->
<div class="clearfix">
<div class="pull-right tableTools-container"></div>
</div>
<div class="table-header">
Chart Of Accounts
</div>

<!-- div.table-responsive -->

<!-- div.dataTables_borderWrap -->
<table id="dynamic-table" class="table table-striped table-bordered table-hover">
<thead>


<tr>


<th>Serial</th>
<th>Account Name</th>

<th>Code</th>
<th>Financial Statement</th>
<th>Group Name</th>
<th>Sub Group Name</th>
<th></th>






</tr>




</thead>

  <tbody>       
<?php

    $i = 0;
    foreach ($coa_info as $coa_info)
        {
  ?>


<tr>




<td><?php echo ++$i;?></td>
<td> <?php echo $coa_info->aname_name ?></td>

<td><?php echo $coa_info->aname_code?></td>

<td><?php echo $coa_info->financial;?></td>

<td><?php 
$id = $coa_info->scoa_id;
$this->load->model("Ael_account_model");
$coaid = $this->Ael_account_model->all_scoa_view_coa_info($id);

echo $coaid->group_name;
//echo $coa_info->group_name;

?></td>

<td><?php echo $coa_info->sub_group_name?></td>





<td></td>








</tr>


<?php } ?>



</tbody>

</table>




</div>
</div>


