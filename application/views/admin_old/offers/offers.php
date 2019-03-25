<div class="main-content">
<div class="main-content-inner">
<div class="page-content">




<div class="row">
<div class="col-xs-12">



<div class="page-header">
							<h1>
								Set Offers
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Add New Offers
								</small>
							</h1>



							


            <div style="float: right;">
         <a href="<?php echo base_url()?>view_offer">
            <button class="btn btn-success">View All</button>
</a>
</div>

</div><!-- /.page-header -->

<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<form class="form-horizontal" role="form" method="post" action="<?php echo base_url()?>save_setoffers" enctype="multipart/form-data">
			

		 <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-select-3">Product</label>

				<div class="col-sm-4">
				<select name="product_id"  class="chosen-select form-control" id="form-field-select-3" data-placeholder="Choose Users...">
					<option >----------Select Product-----------</option>
					<?php foreach($offers_info as $offers_info) {?>
					<option value="<?php echo $offers_info->product_id?>"><?php echo $offers_info->product_name?></option>
					<?php }?>
				</select>
					<!-- <input type="text" id="form-field-1" name="user_label" placeholder="label" class="col-xs-10 col-sm-5" /> -->
				</div>

           </div>


            	<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Offers </label>

				<div class="col-sm-9">
					<textarea rows="6" name="offers" style="width: 420px;"></textarea>
				</div>
            </div>


           



            	


            <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Logo/Picture</label>

				<div class="col-sm-9">
					<input type="file" id="form-field-1" name="pic" placeholder="Logo/Picture" class="col-xs-10 col-sm-5" />
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
