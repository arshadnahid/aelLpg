
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
		