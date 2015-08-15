<fieldset id="filters">

	<legend><?php echo lang('global:filters') ?></legend>
	
		<?php echo form_open('') ?>
		<?php echo form_hidden('f_module', $module_details['slug']) ?>
		<ul>
			<?php if (Settings::get('moderate_commentmovies')): ?>
				<li>
					<?php echo lang('commentmovies:status_label', 'f_active') ?>
					<?php echo form_dropdown('f_active', array(0 =>lang('commentmovies:inactive_title'), 1 => lang('commentmovies:active_title')), (int) $commentmovies_active) ?>
    			</li>
	
			<?php endif ?>
	
			<li>
            	<?php echo lang('commentmovies:module_label', 'module_slug') ?>
            	<?php echo form_dropdown('module_slug', array(0 => lang('global:select-all')) + $module_list) ?>
        	</li>
	
			<li><?php echo anchor(current_url() . '#', lang('buttons:cancel'), 'class="cancel"') ?></li>
		</ul>
		
		<?php echo form_close() ?>
	
</fieldset>
