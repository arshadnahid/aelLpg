<style type="text/css">
.table > tbody > tr > .thick-line {
	border: 0px;
    border-top: 2px solid;
}
</style>

<div class="row">
	<div class="col-xs-12">
				<h3 class="header smaller lighter blue">Trial Balance</h3>

				

				<div>
				<div class="col-xs-12" >
				<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
					<div class="col-sm-3 col-sm-offset-8 form-group date">
						<div class="input-group">
							<input type="text" class="form-control date-picker" name="search_date" id="search_date" data-date-format='yyyy-mm-dd' placeholder="Date: yyyy-mm-dd">
							<span class="input-group-addon"><i class='fa fa-calendar bigger-110 blue'></i></span>
						</div>
					</div>
					
					<div class="col-sm-1 form-group">
	                    <input type="submit" name="buttonSearch" value="Search" id="buttonSearch" onclick="get_search_trial_blnc()" class="btn btn-success btn-sm" >
	                </div>
	                
					<span class="input-group col-xs-6 col-xs-offset-6" style="color: red" id="search_date_error"></span>
	                
	            </div>
	            </div>


				<div class="clearfix">
					<div class="pull-right tableTools-container"></div>
				</div>
				<div class="table-header" id="search_result">
					Results for "Trial Balance"
				</div>

				<!-- div.table-responsive -->

				<!-- div.dataTables_borderWrap -->
				<div id="trial_balance_data">
					<table id="dynamic-table" class="table table-striped table-bordered table-hover">
					<!-- <thead>
							<tr>
								<th></th>
								
								<th></th>
								<th class="thick-line text-center">General Ledger Account Balance</th>
								<th></th>
								
							</tr>
						</thead> -->
						<thead>
							<tr>
								<th>Serial</th>
								
								<th>Account Name</th>
								<th>Debit</th>
								<th>Credit</th>
								
							</tr>
						</thead>
						<tbody>
						<?php 
						$i = 0;
						$c = 0;
						$d = 0;
						if(isset($ledger_info)){
						foreach($ledger_info as $transaction_info){
							$i++;

							?>
							<tr>
								<td><?php echo $i; ?></td>
								
								<td><?php echo $transaction_info->aname_name; ?></td>
								<td><?php if($transaction_info->ledger_credit_debit == 2){
										echo $transaction_info->ledger_amount;
										$d += $transaction_info->ledger_amount;
									}
								?>
								</td>
								<td><?php if($transaction_info->ledger_credit_debit == 1){
										echo $transaction_info->ledger_amount;
										$c += $transaction_info->ledger_amount;
									}
								?>
								</td>
								
							</tr>
						<?php }  ?>
							<tr>
                            <td class="thick-line"></td>
							<td class="thick-line text-right"><strong>Totals : </strong></td>
							
							<td class="thick-line text-center"><strong><?php echo $d; ?></strong></td>
							<td class="thick-line text-center"><?php echo $c; ?></td>
						</tr>
					<?php } ?>
						</tbody>	
					</table>
				</div>
			</div>

</div>
<script src="<?php echo base_url()?>assets/ael_account.js"></script>