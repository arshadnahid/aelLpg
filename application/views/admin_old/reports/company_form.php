<div class="main-content">
<div class="main-content-inner">
<div class="page-content">



<div class="row">
<div class="col-xs-12">



<div class="page-header center">
							<h1>
						
								<b>Company Report </b>
							</h1>


</div>

<div class="center">
<h3>
Company Wise search
</h3>
<hr>
</div>

<form method="post" action="<?php echo base_url()?>supplier_report">
		<div class="row" style="margin-left: 10%;">


		<div class="col-md-3 col-xs-3">
		<!-- <h4>Start </h4> -->
		<div class="input-group">

		<input class="form-control date-picker" name="start" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd"dd />
	<span class="input-group-addon">
		<i class="fa fa-calendar bigger-110"></i>
	</span>

		</div>
		</div>

			<!-- <div class="col-md-1 col-xs-1">
<h4>TO </h4>

			</div> -->

		<div class="col-md-3 col-xs-3">
		<!-- <h4>End </h4> -->
		<div class="input-group">

		<input class="form-control date-picker" name="end" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd"dd />
	<span class="input-group-addon">
		<i class="fa fa-calendar bigger-110"></i>
	</span>

		</div>
		</div>


    <div class="col-md-3 col-xs-3">
   
				<select name="comp_id"  class="chosen-select form-control" id="form-field-select-3" data-placeholder="Choose Users...">
					<option value="all">----------All Company--------</option>
					
					
					<?php foreach($comp_info as $comp_info) {?>

					<option value="<?php echo $comp_info->comp_id?>"><?php echo $comp_info->comp_name."---  ( ".$comp_info->dist_name.")"?></option>
					<?php }?>
				</select>
					
				</div>


         <!-- <div class="clearfix form-actions"> -->
				<div class="col-md-3 ">
				<!-- <h4></h4> -->
					<button class="btn btn-info" >
						<i class="ace-icon fa fa-check bigger-110"></i>
						Search
					</button>

				
				</div>
			<!-- </div> -->



		</div>





</div>
</div>
</div>
</div>
</div>