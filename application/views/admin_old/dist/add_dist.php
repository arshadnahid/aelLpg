<div class="main-content">
<div class="main-content-inner">
<div class="page-content">




<div class="row">
<div class="col-xs-12">



<div class="page-header">
							<h1>
								Distributor
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Add New Distributor
								</small>
							</h1>



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


            <div style="float: right;">
         <a href="<?php echo base_url()?>view_distributor">
            <button class="btn btn-success">View All</button>
</a>
</div>

</div><!-- /.page-header -->

<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<form class="form-horizontal" role="form" method="post" action="<?php echo base_url()?>save_disributor" enctype="multipart/form-data">
			

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Distributor Name </label>

				<div class="col-sm-9">
					<input type="text" id="form-field-1" name="dist_name" placeholder="Name" class="col-xs-10 col-sm-5" />
				</div>
            </div>


            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> User Name</label>

				<div class="col-sm-9">
					<input type="text" id="form-field-1" name="dist_email" placeholder="User Name" class="col-xs-10 col-sm-5" />
				</div>
            </div>


            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Password</label>

				<div class="col-sm-9">
					<input type="Password" id="form-field-1" name="dist_password" placeholder="Password" class="col-xs-10 col-sm-5" />
				</div>
            </div>



            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email</label>

				<div class="col-sm-9">
					<input type="email" id="form-field-1" name="demail" placeholder="User Email" class="col-xs-10 col-sm-5" />
				</div>
            </div>



            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Phone</label>

				<div class="col-sm-9">
					<input type="text" id="form-field-1" name="dist_phone" placeholder="Phone" class="col-xs-10 col-sm-5" />
				</div>
            </div>



            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Address</label>

				<div class="col-sm-6">
			
				
						
						<textarea id="editor1" name="dist_address"></textarea>
					
			
				</div>
            </div>



            	


            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Logo/Picture</label>

				<div class="col-sm-9">
					<input type="file" id="form-field-1" name="dist_picture" placeholder="Logo/Picture" class="col-xs-10 col-sm-5" />
				</div>
            </div>


            <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Zone</label>

				<div class="col-sm-9">
					<!-- <input type="Text" id="form-field-1" name="zone" placeholder="Zone" class="col-xs-10 col-sm-5" /> -->
					<select name="zone"  class="chosen-select col-xs-10 col-sm-5" id="form-field-select-3" data-placeholder="Choose Users...">
						<option >----------Select Zone-----------</option>
						<?php foreach($zone_info as $z_info) {?>
						<option value="<?php echo $z_info->zone_name?>"><?php echo $z_info->zone_name?></option>
						<?php }?>
					</select>
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
