<div class="main-content">
<div class="main-content-inner">
<div class="page-content">




<div class="row">
<div class="col-xs-12">



<div class="page-header">
							<h1>
								Set Incentive
								
								
							</h1>



							<!--  <h3 class="text-center" style="color:green">
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
            </h3> -->


            <div style="float: right;">
         <a href="<?php echo base_url()?>view_incentive">
            <button class="btn btn-success">View All</button>
</a>
</div>

</div><!-- /.page-header -->

<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<form class="form-horizontal" role="form" method="post" action="<?php echo base_url()?>save_incentive" enctype="multipart/form-data">
			

		 <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-select-3">Product</label>

				<div class="col-sm-4">
				<select name="product_id"  class="chosen-select form-control" id="form-field-select-3" data-placeholder="Choose Users...">
					<option >----------Select Product-----------</option>
					<?php foreach($product_info as $product_info) {?>
					<option value="<?php echo $product_info->product_id?>"><?php echo $product_info->product_name?></option>
					<?php }?>
				</select>
					
				</div>

           </div>


            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Start Date</label>

				<div class="col-sm-3">
					<input class="form-control date-picker" name="start_date" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd"dd />
	
				</div>
            </div>

            




            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> End Date</label>

				<div class="col-sm-3">
					<input class="form-control date-picker" name="end_date" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd"dd />

				</div>
            </div>

            


            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Target Quantity</label>

				<div class="col-sm-9">
					<input type="text" id="form-field-1" name="target_qty" placeholder="Target Quantity" class="col-xs-10 col-sm-5" />
				</div>
            </div>




            <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Price Less (per Product)</label>

				<div class="col-sm-9">
					<input type="Text" id="form-field-1" name="price_less" placeholder="Price Less" class="col-xs-10 col-sm-5" />
				</div>
            </div>


            <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-select-3">Distributor</label>

				<div class="col-sm-4">
				<select name="dist_id" class="chosen-select form-control" id="form-field-select-3" data-placeholder="Choose Users...">
					<option >----------Select Distributor-----------</option>
					<?php foreach($dist_info as $dist_info) {?>
					<option value="<?php echo $dist_info->dist_id?>"><?php echo $dist_info->dist_name?></option>
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
