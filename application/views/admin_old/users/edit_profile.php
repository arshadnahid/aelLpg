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

		



		<form class="form-horizontal" role="form" action="<?php echo base_url()?>update_profile" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Admin Name </label>

				<div class="col-sm-9">
				<input type="hidden" id="form-field-1" name="admin_id" value="<?php echo $admin_info->admin_id?>" class="col-xs-10 col-sm-5"  />
					<input type="text" id="form-field-1" name="admin_name" value="<?php echo $admin_info->admin_name?>" class="col-xs-10 col-sm-5"  />
				</div>
			</div>


				<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email</label>

				<div class="col-sm-9">
					<input type="email" id="form-field-1" name="admin_email" placeholder="email" class="col-xs-10 col-sm-5" value="<?php echo $admin_info->admin_email?>" />
				</div>
            </div>


            		<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Password</label>

				<div class="col-sm-9">
					<input type="password" id="form-field-1" name="admin_password"  class="col-xs-10 col-sm-5" value="<?php echo $admin_info->admin_password?>" />
				</div>
            </div>



            	



            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Address</label>

				<div class="col-sm-6">
			
				
						
						<textarea id="editor1" name="admin_address"><?php echo $admin_info->admin_address?> </textarea>
					
			
				</div>
            </div>

            <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Phone</label>

				<div class="col-sm-9">
					<input type="text" id="form-field-1" name="admin_phone" placeholder="Phone" class="col-xs-10 col-sm-5" value="<?php echo $admin_info->admin_phone?>" />
				</div>
            </div>



            	


            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Logo/Picture</label>

				<div class="col-sm-9">
					<input type="file" id="form-field-1" name="admin_picture" placeholder="Logo/Picture" class="col-xs-10 col-sm-5" />
					
					
				</div>
				<br>
				<img src="<?php echo base_url().$admin_info->admin_picture?>" class="img-responsive img-rounded"  width="304" height="236">

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


