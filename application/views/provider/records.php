<div id="infoMessage"><?php echo $message;?></div>
<div>
	<div class="page-title">
		<div class="title_left"><h3>Privider List</h3></div>
	</div>
	<div class="clearfix"></div>
	<!-- Product List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class='pull-right'><?php echo anchor("provider/add", '<i class="fa fa-plus"></i> Add</a>', array("class"=>'btn btn-info')) ?></div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
					<?php if(!empty($providers)): ?>
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>ID</th>
									<th><?php echo $this->pagination->sort("name", "Name") ?></th>
									<th>Province</th>
									<th>Country</th>
									<th>Postcode</th>
									<th>Status</th>
									<th>Prrority</th>
							</thead>
							<tbody>
								<?php foreach($providers as $key => $value ) : ?>
								<tr>
									<td><?php echo anchor('provider/edit/'.$value['id'], $value['id'], array('title'=>'Edit')); ?></td>
									<td><?php echo $value['name']; ?></td>
									<td><?php echo $value['province']; ?></td>
									<td><?php echo $value['country']; ?></td>
									<td><?php echo $value['postcode']; ?></td>
									<td><?php echo $value['status']; ?></td>
									<td><?php echo $value['priority']; ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php else: ?>
						<center><?php echo heading("No record available", 4); ?></center>
					<?php endif;
						echo $pagination;
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End List Section -->
</div>
<script>
$(document).ready(function() {
	$('#finished_input').on('change', function() {
		var ck;
		if ($(this).is(':checked')) {
			ck = 1;
		} else {
			ck = 0;
		}
		$.ajax({
			url: '<?php echo $finish_url; ?>',
			type: 'POST',
			datatype: 'json',
			data: {finished : ck},
			success: function(result) {
				location.href='<?php echo base_url() ?>/auth/mytasks';
			}
		});
	});

<?php
if (isset($i)) {
	$str = '';
	if (count ( $claims ) and count ( $cases )) {
		$str = '(' . count ( $cases ) . ' Case' . (count ( $cases ) > 1 ? 's' : '') . '/' . count ( $claims ) . ' Claim' . (count ( $claims ) > 1 ? 's' : '') . ')';
	} elseif (count ( $claims )) {
		$str = '(' . count ( $claims ) . ' Claim' . (count ( $claims ) > 1 ? 's' : '') . ')';
	} elseif (count ( $cases )) {
		$str = '(' . count ( $cases ) . ' Case' . (count ( $cases ) > 1 ? 's' : '') . ')';
	}
	if ($str) {
?>
	$(".task_heading").text('My Tasks! <?php echo $str; ?>');
<?php
	}
}
?>
});
</script>