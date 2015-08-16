
						<?php echo form_open("comments/create/{$module}", ' id="comment-form" class="comment-form"  method="post"') ?>
						<?php echo form_input('d0ntf1llth1s1n', '', 'style="display:none"') ?>
						
						<?php echo form_hidden('entry', $entry_hash) ?>
						
						<?php if ( ! is_logged_in()): ?>

							<label class="comment-form__info"><?php echo lang('comments:name_label') ?></label>
							<input type="text" name="name" id="name" maxlength="40" value="<?php echo $comment['name'] ?>" />

							<label class="comment-form__info"><?php echo lang('global:email') ?></label>
							<input type="text" name="email" maxlength="40" value="<?php echo $comment['email'] ?>" />

							<label class="comment-form__info"><?php echo lang('comments:website_label') ?></label>
							<input type="text" name="website" maxlength="40" value="<?php echo $comment['website'] ?>" />

						<?php endif ?>
							<label class="comment-form__info"><?php// echo lang('comments:message_label') ?><h6><?php echo lang('comments:your_comment') ?>, 250 characters left:</h6></label>
                            <textarea class="comment-form__text" name="comment" placeholder='Add you comment here'></textarea>
                            <label class="comment-form__info"> </label>
							<?php //echo form_submit('submit', lang('comments:send_label')) ?>
							<input type="submit" class="btn btn-md btn--danger comment-form__btn" value="Comment" name="submit">
						<?php echo form_close() ?>