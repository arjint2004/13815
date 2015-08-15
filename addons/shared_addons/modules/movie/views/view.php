
                <div class="movie">
                    <h2 class="page-heading"><?=$post[0]['title']?></h2>
                    
                    <div class="movie__info">
                        <div class="col-sm-6 col-md-4 movie-mobile">
                            <div class="movie__images">
                                <span class="movie__rating">5.0</span>
                                <img alt='' src="<?=base_url();?>view.php?image=uploads/default/files/<?=$post[0]['image']['filename']?>&amp;mode=crop&amp;size=380x592">
                            </div>
                            <div class="movie__rate">Your vote: <div id='score' class="score"></div></div>
                        </div>

                        <div class="col-sm-6 col-md-8">
                            <p class="movie__time"><?=$post[0]['runtime']?> min</p>
                            <p class="movie__option"><strong>Country: </strong><a href="#"><?=$post[0]['country']['code']?></a></p>
                            <p class="movie__option"><strong>Category: </strong><a href="#"><?=$post[0]['genre']?></a></p>
                            <p class="movie__option"><strong>Release date: </strong><?=date('F j, Y',$post[0]['release_date'])?></p>
                            <p class="movie__option"><strong>Director: </strong><a href="#"><?=$post[0]['director']?></a></p>
                            <p class="movie__option"><strong>Actors: </strong><?=$post[0]['star']?></p>
                            
                            <p class="movie__option"><strong>ID IMDB: </strong><?=$post[0]['id_imdb']?></p>
                            <p class="movie__option"><strong>ID TMDB: </strong><?=$post[0]['id_tmdb']?></p>

                            <a href="#" class="comment-link">Comments:  <?=$post[0]['commentmovie_count']?></a>

                            <div class="movie__btns">
                                <a href="#" class="btn btn-md btn--warning">book a ticket for this movie</a>
                                <a href="#" class="watchlist">Add to watchlist</a>
                            </div>

                            <div class="share">
                                <span class="share__marker">Share: </span>
                                <div class="addthis_toolbox addthis_default_style ">
                                    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                                    <a class="addthis_button_tweet"></a>
                                    <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="clearfix"></div>
                    
                    <h2 class="page-heading"><?=$post[0]['title']?></h2>

                    <p class="movie__describe"><?=$post[0]['body']?></p>

                    <h2 class="page-heading">Others Movie</h2>
                    
                    <div class="movie__media">
                        <div class="movie__media-switch">
                            <a href="#" class="watchlist list--video" data-filter='media-video'>10 Movie</a>
                        </div>
                        <div class="swiper-container">
                          <div class="swiper-wrapper">
                              <? foreach($post[0]['others'] as $dataother){?>

							  <!--First Slide-->
                              <div class="swiper-slide media-video">
                                <a href='<?=site_url('movie/'.date('Y/m', $dataother['created_on']).'/'.$dataother['slug']);?>' class="movie__media-item ">
                                     <img alt='<?=$dataother['title']?>' title='<?=$dataother['title']?>'  src="<?=base_url();?>view.php?image=uploads/default/files/<?=$dataother['filename']?>&amp;mode=crop&amp;size=400x240">
                                </a>
                              </div>
                              <? } ?>
                        
                          </div>
                        </div>

                    </div>

                </div>

                <!--<h2 class="page-heading">showtime &amp; tickets</h2>-->
                <div class="choose-container">
                    <!--<form id='select' class="select" method='get'>
                          <select name="select_item" id="select-sort" class="select__sort" tabindex="0">
                            <option value="1" selected='selected'>London</option>
                            <option value="2">New York</option>
                            <option value="3">Paris</option>
                            <option value="4">Berlin</option>
                            <option value="5">Moscow</option>
                            <option value="3">Minsk</option>
                            <option value="4">Warsawa</option>
                            <option value="5">Kiev</option>
                        </select>
                    </form>

                    <div class="datepicker">
                      <span class="datepicker__marker"><i class="fa fa-calendar"></i>Date</span>
                      <input type="text" id="datepicker" value='03/10/2014' class="datepicker__input">
                    </div>

                    <a href="#" id="map-switch" class="watchlist watchlist--map"><span class="show-map">Show cinemas on map</span><span  class="show-time">Show cinema time table</span></a>
                    
                    <div class="clearfix"></div>

                    <div class="time-select">
                        <div class="time-select__group group--first">
                            <div class="col-sm-4">
                                <p class="time-select__place">Cineworld</p>
                            </div>
                            <ul class="col-sm-8 items-wrap">
                                <li class="time-select__item" data-time='09:40'>09:40</li>
                                <li class="time-select__item" data-time='13:45'>13:45</li>
                                <li class="time-select__item active" data-time='15:45'>15:45</li>
                                <li class="time-select__item" data-time='19:50'>19:50</li>
                                <li class="time-select__item" data-time='21:50'>21:50</li>
                            </ul>
                        </div>

                        <div class="time-select__group">
                            <div class="col-sm-4">
                                <p class="time-select__place">Empire</p>
                            </div>
                            <ul class="col-sm-8 items-wrap">
                                <li class="time-select__item" data-time='10:45'>10:45</li>
                                <li class="time-select__item" data-time='16:00'>16:00</li>
                                <li class="time-select__item" data-time='19:00'>19:00</li>
                                <li class="time-select__item" data-time='21:15'>21:15</li>
                                <li class="time-select__item" data-time='23:00'>23:00</li>
                            </ul>
                        </div>

                        <div class="time-select__group">
                            <div class="col-sm-4">
                                <p class="time-select__place">Curzon</p>
                            </div>
                            <ul class="col-sm-8 items-wrap">
                                <li class="time-select__item" data-time='09:00'>09:00</li>
                                <li class="time-select__item" data-time='11:00'>11:00</li>
                                <li class="time-select__item" data-time='13:00'>13:00</li>
                                <li class="time-select__item" data-time='15:00'>15:00</li>
                                <li class="time-select__item" data-time='17:00'>17:00</li>
                                <li class="time-select__item" data-time='19:0'>19:00</li>
                                <li class="time-select__item" data-time='21:0'>21:00</li>
                                <li class="time-select__item" data-time='23:0'>23:00</li>
                                <li class="time-select__item" data-time='01:0'>01:00</li>
                            </ul>
                        </div>

                        <div class="time-select__group">
                            <div class="col-sm-4">
                                <p class="time-select__place">Odeon</p>
                            </div>
                            <ul class="col-sm-8 items-wrap">
                                <li class="time-select__item" data-time='10:45'>10:45</li>
                                <li class="time-select__item" data-time='16:00'>16:00</li>
                                <li class="time-select__item" data-time='19:00'>19:00</li>
                                <li class="time-select__item" data-time='21:15'>21:15</li>
                                <li class="time-select__item" data-time='23:00'>23:00</li>
                            </ul>
                        </div>

                        <div class="time-select__group group--last">
                            <div class="col-sm-4">
                                <p class="time-select__place">Picturehouse</p>
                            </div>
                            <ul class="col-sm-8 items-wrap">
                                <li class="time-select__item" data-time='17:45'>17:45</li>
                                <li class="time-select__item" data-time='21:30'>21:30</li>
                                <li class="time-select__item" data-time='02:20'>02:20</li>
                            </ul>
                        </div>
                    </div>-->
                    
                    <!-- hiden maps with multiple locator
                    <div  class="map">
                        <div id='cimenas-map'></div> 
                    </div>-->

                    <h2 class="page-heading">comments (<?=$post[0]['commentmovie_count']?>)</h2>
					<?php if (Settings::get('enable_commentmovies')): ?>
						<?php //echo lang('commentmovies:title') ?>
						<?php if ($form_display): ?>
							<?php echo $this->commentmovies->form() ?>
						<?php else: ?>
						<?php echo sprintf(lang('movie:disabled_after'), strtolower(lang('global:duration:'.str_replace(' ', '-', $post[0]['commentmovies_enabled'])))) ?>
						<?php endif ?>
						
						<?php echo $this->commentmovies->display() ?>
					<?php endif ?>
                    
            </div>