<div class="row">
	<div class="col-xs-6">
        <input type="hidden" id="baseUrl" value="<?php //echo base_url();?>">
		<div class="col-xs-12">
			<h3 class="header smaller lighter blue">Add Chart of Accounts</h3>
			<form role="form" method="post" action="<?php echo base_url()?>Ael_account/add_coa" enctype="multipart/form-data">

				<div class="col-sm-12 form-group">
                    <label>Group Name</label>
                    <input type="text" name="group_name" id="group_name" placeholder="Enter group_name Here.." class="form-control" value="<?php //echo set_value('group_name'); ?>">
                	<span style="color: red"><?php //echo form_error('group_name'); ?></span>
                </div>
                <div class="col-sm-12 form-group">
                    <label>Code</label>
                    <input type="text" name="coa_code" id="coa_code" placeholder="Enter coa_code Here.." class="form-control" value="<?php //echo set_value('coa_code'); ?>">
                	<span style="color: red"><?php //echo form_error('coa_code'); ?></span>
                </div>
                
                <div class="col-sm-12 form-group">
                    <input type="submit" name="buttonAddcoa" value="Add" id="buttonAddcoa" class="btn btn-success" >
                </div>
                </form>
    	</div>
	</div>

    <div class="col-xs-6">
        <input type="hidden" id="baseUrl" value="<?php //echo base_url();?>">
        <div class="col-xs-12">
            <h3 class="header smaller lighter blue">Add Sub Chart of Accounts</h3>
            <form role="form" method="post" action="<?php echo base_url()?>Ael_account/add_sub_coa" enctype="multipart/form-data">
                <div class="col-sm-12 form-group">
                        <label>COA Group Name</label>
                        <select id="coa_group_name" class="form-control" name="coa_group_name">
                            <option value="">---Select Group Name---</option>
                            <?php if(isset($coa_info)){
                                foreach ($coa_info as $a_info) {
                                ?>
                            <option value="<?php echo $a_info->coa_id; ?>"><?php echo $a_info->group_name." - ".$a_info->coa_code; ?></option>
                            <?php   
                                } } ?>
                        </select>
                        <span style="color: red"><?php //echo form_error('coa_group_name'); ?></span>
                    </div>

                <div class="col-sm-12 form-group">
                    <label>Sub Group Name</label>
                    <input type="text" name="sub_group_name" id="sub_group_name" placeholder="Enter Sub group_name Here.." class="form-control" value="<?php //echo set_value('sub_group_name'); ?>">
                    <span style="color: red"><?php //echo form_error('sub_group_name'); ?></span>
                </div>
                <div class="col-sm-12 form-group">
                    <label>Sub Code</label>
                    <input type="text" name="scoa_code" id="scoa_code" placeholder="Enter Sub coa_code Here.." class="form-control" value="<?php //echo set_value('scoa_code'); ?>">
                    <span style="color: red"><?php //echo form_error('scoa_code'); ?></span>
                </div>
                
                <div class="col-sm-12 form-group">
                    <input type="submit" name="buttonAddscoa" value="Add" id="buttonAddscoa" class="btn btn-success" >
                </div>
                </form>
        </div>
    </div>

    <div class="col-xs-6">
        <input type="hidden" id="baseUrl" value="<?php //echo base_url();?>">
        <div class="col-xs-12">
            <h3 class="header smaller lighter blue">Add Account Name</h3>
            <form role="form" method="post" action="<?php echo base_url()?>Ael_account/add_account" enctype="multipart/form-data">
                <div class="col-sm-12 form-group">
                        <label>COA Sub Group Name</label>
                        <select id="coa_sub_group_name" class="form-control" name="coa_sub_group_name">
                            <option value="">---Select Sub Group Name---</option>
                            <?php if(isset($scoa_info)){
                                foreach ($scoa_info as $sc_data) {
                                ?>
                            <option value="<?php echo $sc_data->scoa_id; ?>"><?php echo $sc_data->sub_group_name." - ".$sc_data->scoa_code; ?></option>
                            <?php   
                                } } ?>
                        </select>
                        <span style="color: red"><?php //echo form_error('coa_sub_group_name'); ?></span>
                    </div>

                <div class="col-sm-12 form-group">
                    <label>Account Name</label>
                    <input type="text" name="aname_name" id="aname_name" placeholder="Enter Acc name Here.." class="form-control" value="<?php //echo set_value('aname_name'); ?>">
                    <span style="color: red"><?php //echo form_error('aname_name'); ?></span>
                </div>

                <div class="col-sm-12 form-group">
                    <label>Financial Statement</label>
                    <input type="text" name="financial" id="financial" placeholder="Enter  financial Here.." class="form-control" value="">
                    <span style="color: red"><?php //echo form_error('financial'); ?></span>
                </div>
                
                <div class="col-sm-12 form-group">
                    <label>Account Code</label>
                    <input type="text" name="aname_code" id="aname_code" placeholder="Enter  acc code Here.." class="form-control" value="">
                    <span style="color: red"><?php //echo form_error('aname_code'); ?></span>
                </div>
                
                <div class="col-sm-12 form-group">
                    <input type="submit" name="buttonAddscoa" value="Add" id="buttonAddscoa" class="btn btn-success" >
                </div>
                </form>
        </div>
    </div>
</div>