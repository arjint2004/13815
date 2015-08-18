

			{{ post }}
			<h2 class="page-heading">Single Blog Post</h2>

                <div class="post">
                    <div class="post__preview">
                        <div class="swiper-container">
                          <div class="swiper-wrapper">
                              <!--First Slide-->
                              <div class="swiper-slide" data-text='{{ title }}'> 
                                 <img src="<?=base_url()?>view.php?image=uploads/default/files/{{image:filename}}&mode=crop&size=878x335" alt=""/>
                              </div>
                              
                              <!--Second Slide-->
                              <div class="swiper-slide" data-text='{{ title }}'>
                                 {{image2:img}}
                              </div>
                              
                              <!--Third Slide-->
                              <div class="swiper-slide" data-text='{{ title }}'> 
                                 {{image3:img}}
                              </div>
                          </div><!-- end swiper wrapper-->
                        </div><!-- end swiper container -->

                        <a class="arrow-left no-hover" href="#"><span class="slider__info"></span></a> 
                        <a class="arrow-right" href="#"><span class="slider__info"></span></a>
                    
                    </div>

                    <h1>{{ title }}</h1>
                    <p class="post__date">{{ helper:lang line="movie:posted_label" }} {{ helper:date timestamp=created_on }} </p>

                    <div class="wave-devider"></div>

                    {{ body }}

                    <div class="info-wrapper">
                        <div class="tags">
                            <ul>
                                {{ if keywords }}
								<div class="keywords">
									{{ keywords }}
										<li class="item-wrap"><a href="{{ url:site }}movie/tagged/{{ keyword }}" class="tags__item">{{ keyword }}</a></li>
									{{ /keywords }}
								</div>
								{{ endif }}
                            </ul>
                        </div>
                        <div class="share">
                            <div class="addthis_toolbox addthis_default_style ">
                                <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                                <a class="addthis_button_tweet"></a>
                                <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                            </div>
                        </div>
                    </div>
                </div>
				{{ /post }}
				
				
                <h2 class="page-heading">Similar posts</h2>

                <? foreach($post[0]['smiliar']['entries'] as $smiliar){?>
                <div class="col-sm-4 col--remove">
                    <div class="post post--preview">
                        <div class="post__image">
							<img src="<?=base_url()?>view.php?image=uploads/default/files/<?=$smiliar['image']['filename']?>&mode=crop&size=270x330" alt=""/>
                            <!--<div class="social social--position social--hide">
                                <span class="social__name">Share:</span>
                                <a href='#' class="social__variant social--first fa fa-facebook"></a>
                                <a href='#' class="social__variant social--second fa fa-twitter"></a>
                                <a href='#' class="social__variant social--third fa fa-vk"></a>
                            </div>-->
                        </div>
                        <p class="post__date"> <?=date('F j, Y',$smiliar['created_date'])?> </p>
                        <a href="<?=site_url('blog/'.date('Y/m', $smiliar['created_on']).'/'.$smiliar['slug'])?>" class="post__title"><?=$smiliar['title']?> <?=date('Y',$smiliar['created_date'])?></a>
                        <a href="<?=site_url('blog/'.date('Y/m', $smiliar['created_on']).'/'.$smiliar['slug'])?>" class="btn read-more post--btn">read more</a>
                    </div>
                </div>
				<? } ?>
                <div class="clearfix"></div>
                    <h2 class="page-heading">comments (<?=$post[0]['commentmovie_count']?>)</h2>
					<div class="comment-wrapper">
					<?php if (Settings::get('enable_comments')): ?>
						<?php //echo lang('comments:title') ?>
						<?php if ($form_display): ?>
							<?php echo $this->comments->form() ?>
						<?php else: ?>
						<?php echo sprintf(lang('movie:disabled_after'), strtolower(lang('global:duration:'.str_replace(' ', '-', $post[0]['comments_enabled'])))) ?>
						<?php endif ?>
						
						<?php echo $this->comments->display() ?>
					<?php endif ?>
					</div>