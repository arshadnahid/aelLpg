<!-- /section:basics/sidebar -->
			<div class="main-content">
				<div class="main-content-inner">
					<!-- #section:basics/content.breadcrumbs -->
					

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->



		          <h3 class="text-center" style="color:green">
                <?php
                $message = $this->session->userdata('message');
                if ($message) {
                    echo $message;
                    $this->session->unset_userdata('message');
                }
                $exception = $this->session->userdata('exception');
                if ($exception) {
                    echo $exception;
                    $this->session->unset_userdata('exception');
                }
                ?>
            </h3>

		



		<form class="form-horizontal" role="form" action="<?php echo base_url()?>update_dist" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Distributor Name </label>

				<div class="col-sm-9">
				<input type="hidden" id="form-field-1" name="dist_id" value="<?php echo $dist_info->dist_id?>" class="col-xs-10 col-sm-5"  />
					<input type="text" id="form-field-1" name="dist_name" value="<?php echo $dist_info->dist_name?>" class="col-xs-10 col-sm-5"  />
				</div>
			</div>


				<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email</label>

				<div class="col-sm-9">
					<input type="email" id="form-field-1" name="dist_email" placeholder="email" class="col-xs-10 col-sm-5" value="<?php echo $dist_info->dist_email?>" />
				</div>
            </div>




            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email</label>

				<div class="col-sm-9">
					<input type="email" id="form-field-1" name="demail" value="<?php echo $dist_info->demail?>" class="col-xs-10 col-sm-5" />
				</div>
            </div>


            	



            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Phone</label>

				<div class="col-sm-9">
					<input type="text" id="form-field-1" name="dist_phone" placeholder="Phone" class="col-xs-10 col-sm-5" value="<?php echo $dist_info->dist_phone?>" />
				</div>
            </div>



            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Address</label>

				<div class="col-sm-6">
			
				
						
						<textarea id="editor1" name="dist_address"><?php echo $dist_info->dist_address?> </textarea>
					
			
				</div>
            </div>



            	


            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Logo/Picture</label>

				<div class="col-sm-9">
					<input type="file" id="form-field-1" name="dist_picture" placeholder="Logo/Picture" class="col-xs-10 col-sm-5" />
					
					
				</div>
				<br>
				<img src="<?php echo base_url().$dist_info->dist_picture?>" class="img-responsive img-rounded"  alt="Cinque Terre" width="304" height="236">

            </div>


			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Zone</label>

				<div class="col-sm-9">
					<!-- <input type="text" id="form-field-1" name="zone" placeholder="zone" class="col-xs-10 col-sm-5" value="<?php echo $dist_info->zone?>" /> -->

					<select name="zone"  class="chosen-select col-xs-10 col-sm-5" id="form-field-select-3" data-placeholder="Choose Users...">
						<option >----------Select Zone-----------</option>
						<?php foreach($zone_info as $z_info) {?>
						<option value="<?php echo $z_info->zone_name; ?>" <?php echo ($dist_info->zone == $z_info->zone_name) ? 'selected="selected"' : ''; ?>><?php echo $z_info->zone_name; ?></option>
						<?php }?>
					</select>
				</div>
            </div>

			

			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<button class="btn btn-info" >
						<i class="ace-icon fa fa-check bigger-110"></i>
						Update
					</button>

					&nbsp; &nbsp; &nbsp;
					
				</div>
			</div>

</form>
			<div class="hr hr-24"></div>


		</div><!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->

	</div>
	</div>


