<div class="row">
	<div class="col-xs-6">
        <input type="hidden" id="baseUrl" value="<?php //echo base_url();?>">
        <div class="col-xs-12">
            <h3 class="header smaller lighter blue">Add Ledger Account</h3>
            <form role="form" method="post" action="<?php echo base_url()?>Ael_account/add_ledger" enctype="multipart/form-data">
                <div class="col-sm-12 form-group">
                        <label>Account Name</label>
                        <select id="a_name" class="form-control" name="a_name">
                            <option value="">---Select Account Name---</option>
                            <?php if(isset($account_info)){
                                foreach ($account_info as $sc_data) {
                                ?>
                            <option value="<?php echo $sc_data->aname_id; ?>"><?php echo $sc_data->aname_name." - ".$sc_data->aname_code; ?></option>
                            <?php   
                                } } ?>
                        </select>
                        <span style="color: red"><?php //echo form_error('a_name'); ?></span>
                    </div>

                <div class="col-sm-6 form-group date">
					<div class="input-group">
						<input type="text" class="form-control date-picker" name="ledger_date" id="ledger_date" data-date-format='yyyy-mm-dd' placeholder="Date: yyyy-mm-dd">
						<span class="input-group-addon"><i class='fa fa-calendar bigger-110 blue'></i></span>
					</div>
				</div>
                <div class="col-sm-12 form-group">
                    <label>Debit/Credit</label>
                    <select id="ledger_credit_debit" class="form-control" name="ledger_credit_debit">
                        <option value="">---Select credit/debit---</option>
                        <option value="1">Credit</option>
                        <option value="2">Debit</option>
                    </select>
                    <span style="color: red"><?php //echo form_error('ledger_credit_debit'); ?></span>
                </div>
                <div class="col-sm-12 form-group">
                    <label>Ledger Amount</label>
                    <input type="text" name="ledger_amount" id="ledger_amount" placeholder="Enter ledger_amount Here.." class="form-control" value="<?php //echo set_value('ledger_amount'); ?>">
                	<span style="color: red"><?php //echo form_error('ledger_amount'); ?></span>
                </div>
                
                <div class="col-sm-12 form-group">
                    <input type="submit" name="buttonAddLedger" value="Add" id="buttonAddLedger" class="btn btn-success" >
                </div>
                </form>
        </div>
    </div>
</div>