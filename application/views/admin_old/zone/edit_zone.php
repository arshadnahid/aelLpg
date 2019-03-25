<div class="main-content">
<div class="main-content-inner">
<div class="page-content">




<div class="row">
<div class="col-xs-12">



<div class="page-header">
							<h1>
								Zone
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Edit Zone
								</small>
							</h1>



							 <h3 class="text-center" style="color:green">
                <?php
                	echo $this->session->flashdata('msg');
                
                ?>
            </h3>


            <div style="float: right;">
         <a href="<?php echo base_url()?>view_zone">
            <button class="btn btn-success">View All</button>
</a>
</div>

</div><!-- /.page-header -->

<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<form class="form-horizontal" role="form" method="post" action="<?php echo base_url().'update_zone/'.$zone_info->zone_id;?>" enctype="multipart/form-data">
			

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> District Name </label>

				<div class="col-sm-9">
					<input type="text" id="district_name" name="district_name" placeholder="District Name" class="col-xs-10 col-sm-5" value="<?php echo $zone_info->district_name; ?>" />
				</div>
            </div>


        	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Thana Name</label>

				<div class="col-sm-9">
					<input type="text" id="thana_name" name="thana_name" placeholder="Thana Name" class="col-xs-10 col-sm-5" value="<?php echo $zone_info->thana_name; ?>"/>
				</div>
            </div>


            <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Zone</label>

				<div class="col-sm-9">
					<input type="Text" id="zone_name" name="zone_name" placeholder="Zone" class="col-xs-10 col-sm-5" value="<?php echo $zone_info->zone_name; ?>"/>
					<span class="col-xs-10 red"><?php echo $this->session->flashdata('er_msg');; ?></span>
				</div>
            </div>

            <div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<button class="btn btn-info" >
						<i class="ace-icon fa fa-check bigger-110"></i>
						Submit
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
