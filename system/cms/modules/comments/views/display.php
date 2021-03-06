					
                        <div class="comment-sets">
							<?php if ($comments): ?>
								<?php foreach ($comments as $item): ?>
									<div class="comment">
										<div class="comment__images">
											<?php echo gravatar($item->user_email, 60) ?>
										</div>

										<a href='#' class="comment__author"><span class="social-used fa fa-facebook"></span><?php echo $item->user_name ?></a>
										<p class="comment__date"><?php echo format_date($item->created_on) ?></p>
											<?php if (Settings::get('comment_markdown') and $item->parsed): ?>
												<p class="comment__message"><?php echo $item->parsed ?></p>
											<?php else: ?>
												<p class="comment__message"><?php echo nl2br($item->comment) ?></p>
											<?php endif ?>

									</div>
								<?php endforeach ?>
							<?php else: ?>
								<?php echo lang('comments:no_comments') ?>
							<?php endif ?>
							<div class="comment-more">
								<a href="#" class="watchlist">Show more comments</a>
							</div>

						</div>
