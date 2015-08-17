<section class="title">
	<h4><?php echo lang('movieslider:moviesliders_title') ?></h4>
</section>

<section class="item">
	<div class="content">

	<?php if ($moviesliders): ?>
	
		<table border="0" class="table-list" cellspacing="0">
			<thead>
			<tr>
				<th><?php echo lang('movieslider:movieslider_title') ?></th>
				<th><?php echo lang('global:slug') ?></th>
				<th width="120"></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($moviesliders as $movieslider): ?>
			<tr>
				<td><?php echo lang_label($movieslider->stream_name); ?></td>
				<td><?php echo $movieslider->movieslider_uri; ?></td>
				<td>
					<a href="" class="btn">Edit</a>
					<a href="" class="btn">Delete</a>
					<a href="" class="btn">New Post</a>
				</td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

		<?php echo form_close() ?>

<?php $this->load->view('admin/partials/pagination') ?>

	<?php else: ?>
		<div class="no_data">No moviesliders</div>
	<?php endif ?>
	</div>
</section>