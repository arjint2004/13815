<div id="commentmovie-preview">

	<p class="width-two-thirds float-left spacer-bottom-half">
		<strong><?php echo lang('commentmovies:posted_label') ?>:</strong> <?php echo format_date($commentmovie->created_on)?><br/>
		<strong><?php echo lang('commentmovies:from_label') ?>:</strong> <?php echo $commentmovie->user_name ?>
	</p>

	<div class="float-right spacer-right buttons buttons-small">
		<?php if ($commentmovie->is_active): ?>
			<?php echo anchor('admin/commentmovies/unapprove/'.$commentmovie->id, lang('global:unapprove'), 'class="button"') ?>
		<?php else:?>
			<?php echo anchor('admin/commentmovies/approve/'.$commentmovie->id, lang('global:approve'), 'class="button"') ?>
		<?php endif?>
		<?php echo anchor('admin/commentmovies/delete/'.$commentmovie->id, lang('global:delete'), 'class="button"')?>
	</div>

	<hr class="clear-both" />

	<p><?php echo (Settings::get('commentmovie_markdown') and $commentmovie->parsed != '') ? $commentmovie->parsed : nl2br($commentmovie->commentmovie) ?></p>

</div>