<div class="main-content">
<div class="main-content-inner">
<div class="page-content">




<div class="row">
<div class="col-xs-12">



<div class="page-header">
							<h1>
								Distributor Account
								<!-- <small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Add New Distributor
								</small> -->
							</h1>

</div><!-- /.page-header -->

<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<form class="form-horizontal" role="form" method="post" action="<?php echo base_url()?>Admin_account/check_dist" enctype="multipart/form-data">
			

			


            <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Choose Distributor</label>

				<div class="col-sm-9">
					<select name="dist_id"  class="chosen-select col-xs-10 col-sm-5" id="dist_id" data-placeholder="Choose Users...">
						<!-- <option >----------Select Distributor-----------</option> -->
						<?php foreach($dist_info as $z_info) {?>
						<option value="<?php echo $z_info->dist_id?>"><?php echo $z_info->dist_name?></option>
						<?php }?>
					</select>
				</div>
            </div>

            <div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<button class="btn btn-info" >
						<i class="ace-icon fa fa-check bigger-110"></i>
						GO !!
					</button>

					&nbsp; &nbsp; &nbsp;
					<button class="btn" type="reset">
						<i class="ace-icon fa fa-undo bigger-110"></i>
						Reset
					</button>
				</div>
			</div>





</form>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
