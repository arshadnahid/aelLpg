<div class="col-xs-8 col-sm-8 pricing-box">
<div class="widget-box widget-color-grey">
	<div class="widget-header">
		<h5 class="widget-title bigger lighter">Income Statement</h5>
	</div>

	

	<div class="widget-body widgets-body">
		<div class="widget-main" style="padding: 5px;">



<?php 
$a1 = 0; $a2=0; $a3 =0;
foreach ($coa_info as $coa_info) {
	
	$ass = $coa_info->group_name;

if ($ass == "Income" || $ass == "income") {


   $coa_id = $coa_info->coa_id;

 $this->load->model("Ael_account_model");
  $coaid = $this->Ael_account_model->all_scoa_view_blnc($coa_id);
  
echo "<h3>Revenue</h3>";

foreach ($coaid as $coaid) {

 

?>


	

	<ul class="list-unstyled spaced2">



				<li>
					<i class="ace-icon fa fa-check grey"></i>
					<?php 

					  $scoa_id = $coaid->scoa_id;
					  
					 $aid = $this->Ael_account_model->search_all_account_view_blnc_by_date($scoa_id, $search_start_date, $search_end_date);

					foreach ($aid as $aid) {

					 if (isset($aid->aname_id)) {



					echo "</br>".$aid->aname_name." : "; 

					?>

					
					 <b style="padding-left: 60%"><?php 
					
					 	 
					 echo  $aa =  $aid->ledger_amount;
                     
					 $a1 += $aa;

					


					 }



					 else
					 {
					 	echo "00";
					 }


 }
					

					?></b>

			

				</li>
	
	
			
			</ul>







<?php } 


}

elseif ($ass == "Cost of sales" || $ass == "cost of sales") {


   $coa_id = $coa_info->coa_id;

 $this->load->model("Ael_account_model");
  $coaid = $this->Ael_account_model->all_scoa_view_blnc($coa_id);
  
echo "
<h3>Cost of Sales</h3>";

foreach ($coaid as $coaid) {

 

?>


	

	<ul class="list-unstyled spaced2">




				<li>
					<i class="ace-icon fa fa-check grey"></i>
					<?php 

					  $scoa_id = $coaid->scoa_id;
					  
					 $aid = $this->Ael_account_model->search_all_account_view_blnc_by_date($scoa_id, $search_start_date, $search_end_date);

					foreach ($aid as $aid) {

					 if (isset($aid->aname_id)) {



					echo "</br>".$aid->aname_name." : "; 

					?>

					<b style="padding-left: 60%">&nbsp;	&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?php 
					
					 	 
					 echo  $a2a =  $aid->ledger_amount;

					 $a2 += $a2a;

					

					 }



					 else
					 {
					 	echo "00";
					 }
					 }
					

					?></b>

					


			

				</li>
	
	
	
			
			</ul>







<?php } 

?>

<!-- 
<ul class="list-unstyled spaced2">




				<li>
					<i class="ace-icon fa fa-check grey"></i>
					<?php 


					echo " Gross Profit ( Loss) "; 

					?>

					<b style="padding-left: 60%">&nbsp;	&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
					 <?php 
					
					 	 
					 echo  $a1 +  $a2;

					 

					?></b>

			

				</li>
	
	
	
			
			</ul> -->



<?php
}

elseif ($ass == "Expense" || $ass == "expense" ) {


   $coa_id = $coa_info->coa_id;

 $this->load->model("Ael_account_model");
  $coaid = $this->Ael_account_model->all_scoa_view_blnc($coa_id);
  
echo "
<h3>Operating Expenses</h3>";

foreach ($coaid as $coaid) {

 

?>


	

	<ul class="list-unstyled spaced2">




				<li>
					<i class="ace-icon fa fa-check grey"></i>
					<?php 

					  $scoa_id = $coaid->scoa_id;
					  
					 $aid = $this->Ael_account_model->search_all_account_view_blnc_by_date($scoa_id, $search_start_date, $search_end_date);

					foreach ($aid as $aid) {

					 if (isset($aid->aname_id)) {



					echo "</br>".$aid->aname_name." : "; 

					?>

					<b style="padding-left: 60%">&nbsp;	&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?php 
					
					 	 
					 echo  $a3a =  $aid->ledger_amount;

					 $a3 += $a3a;

					


					 }



					 else
					 {
					 	echo "00";
					 }
 }
					

					?></b>

			

				</li>
	
	
	
			
			</ul>







<?php } 



}

}


?>

			<hr />
			<div class="price">
				
			</div>
		</div>

		
	</div>

	<div>
			<a href="#" class="btn btn-block btn-grey">
				<i class="ace-icon fa fa-shopping-cart bigger-110"></i>
				<span>Net Income (Loss): <?php echo ($a1 + $a2) - $a3; ?></span>
			</a>
		</div>




</div>
</div>