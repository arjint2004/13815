<section class="title">
	<h4><?php echo sprintf(lang('commentmovies:edit_title'), $commentmovie->id) ?></h4>
</section>

	<section class="item">
	<div class="content">
	<?php echo form_open($this->uri->uri_string(), 'class="form_inputs"') ?>

		<?php echo form_hidden('user_id', $commentmovie->user_id) ?>
		<?php echo form_hidden('active', $commentmovie->is_active) ?>

		<ul class="fields">
			<?php if ( ! $commentmovie->user_id): ?>
			<li>
				<label for="user_name"><?php echo lang('commentmovies:name_label') ?>:</label>
				<div class="input">
					<?php echo form_input('user_name', $commentmovie->user_name, 'maxlength="100"') ?>
				</div>
			</li>

			<li>
				<label for="user_email"><?php echo lang('global:email') ?>:</label>
				<div class="input">
					<?php echo form_input('user_email', $commentmovie->user_email, 'maxlength="100"') ?>
				</div>
			</li>
			<?php else: ?>
			<li>
				<label for="user_name"><?php echo lang('commentmovies:name_label') ?>:</label>
				<p><?php echo $commentmovie->user_name ?></p>
			</li>
			<li>
				<label for="user_email"><?php echo lang('global:email') ?>:</label>
				<p><?php echo $commentmovie->user_email ?></p>
			</li>
			<?php endif ?>

			<li>
				<label for="user_website"><?php echo lang('commentmovies:website_label') ?>:</label>
				<div class="input">
					<?php echo form_input('user_website', $commentmovie->user_website) ?>
				</div>
			</li>

			<li>
				<label for="commentmovie"><?php echo lang('commentmovies:message_label') ?>:</label><br />
				<?php echo form_textarea(array('name'=>'commentmovie', 'value' => $commentmovie->commentmovie, 'rows' => 5)) ?>
			</li>
		</ul>

		<div class="buttons float-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
		</div>

	<?php echo form_close() ?>
	</div>
</section>