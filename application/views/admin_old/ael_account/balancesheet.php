
<div class="row">
<div class="col-xs-12">

<h3 class="center">Balance Sheet</h3>
<div class="center" id="search_result">
	
</div> 

<div>
	<div class="col-xs-12" >
	<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
		<div class="col-sm-3 col-sm-offset-8 form-group date">
			<div class="input-group">
				<input type="text" class="form-control date-picker" name="search_date" id="search_date" data-date-format='yyyy-mm-dd' placeholder="Date: yyyy-mm-dd">
				<span class="input-group-addon"><i class='fa fa-calendar bigger-110 blue'></i></span>
			</div>
		</div>
		
		<div class="col-sm-1 form-group">
	        <input type="submit" name="buttonSearch" value="Search" id="buttonSearch" onclick="get_search_trial_balance_sheet()" class="btn btn-success btn-sm" >
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

<div class="col-xs-1 col-sm-1 pricing-box">

</div>


<div id="balancesheet_data">
<div class="col-xs-4 col-sm-4 pricing-box">
<div class="widget-box widget-color-grey">
	<div class="widget-header">
		<h5 class="widget-title bigger lighter">Assets</h5>
	</div>

	

	<div class="widget-body widgets-body">
		<div class="widget-main" style="padding: 5px;">



<?php 
$a1 = 0; $a2=0; $a3 =0;
foreach ($coa_info as $coa_info) {
	
	$ass = $coa_info->group_name;


if ($ass == "current assets" || $ass == "Current Assets") {


   $coa_id = $coa_info->coa_id;

 $this->load->model("Ael_account_model");
  $coaid = $this->Ael_account_model->all_scoa_view_blnc($coa_id);
  
echo "<h3>Current Assets </h3>";

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

					 <b><?php 
					
					 	 
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

elseif ($ass == "Long Term Assets" || $ass == "long term assets") {


   $coa_id = $coa_info->coa_id;

 $this->load->model("Ael_account_model");
  $coaid = $this->Ael_account_model->all_scoa_view_blnc($coa_id);
  
echo "
<h3>Long term assets </h3>";

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

					 <b><?php 
					
					 	 
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



}

elseif ($ass == "Others" || $ass == "others" || $ass == "others assets" || $ass == "Others Assets") {


   $coa_id = $coa_info->coa_id;

 $this->load->model("Ael_account_model");
  $coaid = $this->Ael_account_model->all_scoa_view_blnc($coa_id);
  
echo "
<h3>Others assets </h3>";

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

					 <b><?php 
					
					 	 
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
				<span>Total: <?php echo $a1 + $a2 + $a3; ?></span>
			</a>
		</div>




</div>
</div>








<div class="col-xs-4 col-sm-4 pricing-box">
<div class="widget-box widget-color-grey">
	<div class="widget-header">
		<h5 class="widget-title bigger lighter">Liabilities and Owner's Equity</h5>
	</div>

	

	<div class="widget-body widgets-body">
		<div class="widget-main" style="padding: 5px;">



<?php 
$l1 = 0; $l2=0; $l3 =0;
foreach ($loa_info as $loa_info) {
	
	 $ass = $loa_info->group_name;

if ($ass == "Current Liabilities" || $ass == "current liabilities") {


   $coa_id = $loa_info->coa_id;
 
 $this->load->model("Ael_account_model");
  $coaid = $this->Ael_account_model->all_scoa_view_blnc($coa_id);
  
echo "<h3>Current liabilities </h3>";

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

					echo $aid->aname_name." : "; 

					?>

					 <b>&nbsp;	&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?php 
					  
					 	 
					 echo  $l1a =  $aid->ledger_amount;




					 $l1 +=$l1a;
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

elseif ($ass == "long-term liabilities" || $ass == "Long-Term Liabilities" || $ass == "Long Liabilities" || $ass == "long liabilities") {


   $coa_id = $loa_info->coa_id;

 $this->load->model("Ael_account_model");
  $coaid = $this->Ael_account_model->all_scoa_view_blnc($coa_id);
  
echo "<h3>Long term liabilities </h3>";

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

					echo $aid->aname_name." : "; 

					?>

					 <b>&nbsp;	&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?php 
					  
					 	 
					 echo  $l2a =  $aid->ledger_amount;




					 $l2 +=$l2a;
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

elseif ($ass == "Owner's Equity" || $ass == "owner's equity" || $ass == "equity" || $ass == "Equity") {


    $coa_id = $loa_info->coa_id;

 $this->load->model("Ael_account_model");
  $coaid = $this->Ael_account_model->all_scoa_view_blnc($coa_id);
  
echo $ass;

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

					echo $aid->aname_name." : "; 

					?>

					 <b>&nbsp;	&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?php 
					  
					 	 
					 echo  $l3a =  $aid->ledger_amount;




					 $l3 +=$l3a;
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
				<span>Total: <?php echo $l1 + $l2 + $l3; ?></span>
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
<!-- <script type="text/javascript">
function fnUpdateTabs()
 {
  if (parent.window.g_iIEVer>=4) {
   if (parent.document.readyState=="complete"
    && parent.frames['frTabs'].document.readyState=="complete")
   parent.fnSetActiveSheet(3);
  else
   window.setTimeout("fnUpdateTabs();",150);
 }
}

if (window.name!="frSheet")
 window.location.replace("../Sample%20Accounting%20Templates.htm");
else
 fnUpdateTabs();
//-->
<!--</script> -->