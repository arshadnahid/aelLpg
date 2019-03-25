
<div class="row">
<div class="col-xs-12">

<h3 class="center">Income Statement</h3>
<div class="center" id="search_result">
	
</div> 
<div>
	<div class="col-xs-12" >
	<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
		<div class="col-sm-3 col-sm-offset-5 form-group date">
			<div class="input-group">
				<input type="text" class="form-control date-picker" name="search_start_date" id="search_start_date" data-date-format='yyyy-mm-dd' placeholder="Start Date: yyyy-mm-dd">
				<span class="input-group-addon"><i class='fa fa-calendar bigger-110 blue'></i></span>
			</div>
		</div>
		<div class="col-sm-3 form-group date">
			<div class="input-group">
				<input type="text" class="form-control date-picker" name="search_end_date" id="search_end_date" data-date-format='yyyy-mm-dd' placeholder="End Date: yyyy-mm-dd">
				<span class="input-group-addon"><i class='fa fa-calendar bigger-110 blue'></i></span>
			</div>
		</div>
		<div class="col-sm-1 form-group">
            <input type="submit" name="buttonSearch" value="Search" id="buttonSearch" onclick="get_search_income_st()" class="btn btn-success btn-sm" >
        </div>
        
		<span class="input-group col-xs-6 col-xs-offset-6" style="color: red" id="search_date_error"></span>
        
    </div>
</div>

<div class="clearfix">
<div class="pull-right tableTools-container"></div>
</div>

<hr>


<!-- PAGE CONTENT BEGINS -->

<div class="row">

<div class="col-xs-2 col-sm-2 pricing-box">

</div>


<div id="income_st_data">
<div class="col-xs-12 col-sm-12">
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
	<?php
	  $scoa_id = $coaid->scoa_id;
					  
					 $aid = $this->Ael_account_model->all_account_view_blnc($scoa_id);

					foreach ($aid as $aid) {

					 if (isset($aid->aname_id)) { ?>





				<li>
					<i class="ace-icon fa fa-check grey"></i>
					<?php 

				
					echo "".$aid->aname_name." : "; 

					?>

					
					 <b style=""><?php 
					
					 	 
					 echo  $aa =  $aid->ledger_amount;
                     
					 $a1 += $aa; 

					


					

					?></b>

			

				</li>
	
	
				<?php	 }



					 else
					 {
					 	echo "00";
					 }


 } ?>
			
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
					  
					 $aid = $this->Ael_account_model->all_account_view_blnc($scoa_id);

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
					  
					 $aid = $this->Ael_account_model->all_account_view_blnc($scoa_id);

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
</div>



<div class="col-xs-1 col-sm-1 pricing-box">

</div>

</div>






</div>
</div>
<script src="<?php echo base_url()?>assets/ael_account.js"></script>
