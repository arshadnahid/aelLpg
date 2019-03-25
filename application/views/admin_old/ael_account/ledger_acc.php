<style type="text/css">
.table > tbody > tr > .thick-line {
	border: 0px;
    border-top: 2px solid;
}
</style>

<div class="row">
	<div class="col-xs-12">
				<h3 class="header smaller lighter blue">Ledger Account</h3>

				<div class="clearfix">
					<div class="pull-right tableTools-container"></div>
				</div>
				<div class="table-header">
					Results for "Ledger Account"
				</div>

				<!-- div.table-responsive -->

				<!-- div.dataTables_borderWrap -->
				<div>
					<table id="dynamic-table" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>Serial</th>
								<th>Date</th>
								<th>Account Name</th>
								<th>Debit</th>
								<th>Credit</th>
								<th>Balance</th>
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
								<td><?php echo $transaction_info->ledger_date; ?></td>
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
								<td></td>
							</tr>
						<?php }  ?>
							<tr>
                            <td class="thick-line"></td>
							<td class="thick-line"></td>
							<td class="thick-line"></td>
							<td class="thick-line"></td>
							<td class="thick-line text-center"><strong>Total Amount :</strong></td>
							<td class="thick-line text-center"><?php echo $c - $d; ?></td>
						</tr>
					<?php } ?>
						</tbody>	
					</table>
				</div>
			</div>

</div>