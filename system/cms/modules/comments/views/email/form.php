
						<?php echo form_open("commentmovies/create/{$module}", ' id="comment-form" class="comment-form"  method="post"') ?>
						<?php echo form_input('d0ntf1llth1s1n', '', 'style="display:none"') ?>
						
						<?php echo form_hidden('entry', $entry_hash) ?>
						
						<?php if ( ! is_logged_in()): ?>

							<label class="comment-form__info"><?php echo lang('commentmovies:name_label') ?></label>
							<input type="text" name="name" id="name" maxlength="40" value="<?php echo $commentmovie['name'] ?>" />

							<label class="comment-form__info"><?php echo lang('global:email') ?></label>
							<input type="text" name="email" maxlength="40" value="<?php echo $commentmovie['email'] ?>" />

							<label class="comment-form__info"><?php echo lang('commentmovies:website_label') ?></label>
							<input type="text" name="website" maxlength="40" value="<?php echo $commentmovie['website'] ?>" />

						<?php endif ?>
							<label class="comment-form__info"><?php// echo lang('commentmovies:message_label') ?><h6><?php echo lang('commentmovies:your_commentmovie') ?>, 250 characters left:</h6></label>
                            <textarea class="comment-form__text" name="commentmovie" placeholder='Add you comment here'></textarea>
                            <label class="comment-form__info"> </label>
							<?php //echo form_submit('submit', lang('commentmovies:send_label')) ?>
							<input type="submit" class="btn btn-md btn--danger comment-form__btn" value="Comment" name="submit">
						<?php echo form_close() ?>