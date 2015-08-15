<?php if ( ! empty($commentmovies)): ?>

	<table border="0" class="table-list" cellspacing="0">
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
				<th width="25%"><?php echo lang('commentmovies:message_label') ?></th>
				<th width="25%"><?php echo lang('commentmovies:item_label') ?></th>
				<th><?php echo lang('global:author') ?></th>
				<th width="80"><?php echo lang('commentmovies_active.date_label') ?></th>
				<th width="<?php echo Settings::get('moderate_commentmovies') ? 265 : 120 ?>"></th>
			</tr>
		</thead>
	
		<tfoot>
			<tr>
				<td colspan="7">
					<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
				</td>
			</tr>
		</tfoot>
	
		<tbody>
			<?php foreach ($commentmovies as $commentmovie): ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $commentmovie->id) ?></td>
					<td>
						<a href="<?php echo site_url('admin/commentmovies/preview/'.$commentmovie->id) ?>" rel="modal" target="_blank">
							<?php if( strlen($commentmovie->commentmovie) > 30 ): ?>
								<?php echo character_limiter((Settings::get('commentmovie_markdown') and $commentmovie->parsed > '') ? strip_tags($commentmovie->parsed) : $commentmovie->commentmovie, 30) ?>
							<?php else: ?>
								<?php echo (Settings::get('commentmovie_markdown') and $commentmovie->parsed > '') ? strip_tags($commentmovie->parsed) : $commentmovie->commentmovie ?>
							<?php endif ?>
						</a>
					</td>
				
					<td>
						<strong><?php echo lang($commentmovie->singular) ? lang($commentmovie->singular) : $commentmovie->singular ?>: </strong>
						<?php echo anchor($commentmovie->cp_uri ? $commentmovie->cp_uri : $commentmovie->uri, $commentmovie->entry_title ? $commentmovie->entry_title : '#'.$commentmovie->entry_id) ?>
					</td>
					
					<td>
						<?php if ($commentmovie->user_id > 0): ?>
							<?php echo anchor('admin/users/edit/'.$commentmovie->user_id, user_displayname($commentmovie->user_id, false)) ?>
						<?php else: ?>
							<?php echo mailto($commentmovie->user_email, $commentmovie->user_name) ?>
						<?php endif ?>
					</td>
				
					<td><?php echo format_date($commentmovie->created_on) ?></td>
					
					<td class="align-center buttons buttons-small">
						<?php if ($this->settings->moderate_commentmovies): ?>
							<?php if ($commentmovie->is_active): ?>
								<?php echo anchor('admin/commentmovies/unapprove/'.$commentmovie->id, lang('buttons:deactivate'), 'class="button deactivate"') ?>
							<?php else: ?>
								<?php echo anchor('admin/commentmovies/approve/'.$commentmovie->id, lang('buttons:activate'), 'class="button activate"') ?>
							<?php endif ?>
						<?php endif ?>
					
						<?php echo anchor('admin/commentmovies/edit/'.$commentmovie->id, lang('global:edit'), 'class="button edit"') ?>
						<?php echo anchor('admin/commentmovies/delete/'.$commentmovie->id, lang('global:delete'), array('class'=>'confirm button delete')) ?>
						<?php echo anchor('admin/commentmovies/report/'.$commentmovie->id, 'Report', array('class'=>'button edit')) ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	
<?php else: ?>

	<div class="no_data"><?php echo lang('commentmovies:no_commentmovies') ?></div>

<?php endif ?>
