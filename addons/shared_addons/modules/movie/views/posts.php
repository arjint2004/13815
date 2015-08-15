                <pre><? //print_r($pagination)?></pre>
				<h2 class="page-heading">Movies</h2>
                
                <div class="select-area">
                    <form id='select' class="select" method='get'>
                          <select name="select_item" class="select__sort" tabindex="0">
							<? for($i=date('Y');$i>1950;$i--){?>
							<option value="<?=$i?>"><?=$i?></option>
                            <? } ?>
                        </select>
                    </form>

                    <div class="datepicker">
                      <span class="datepicker__marker"><i class="fa fa-calendar"></i>Date</span>
                      <input type="text" id="datepicker" value='03/10/2014' class="datepicker__input">
                    </div>

                    <form class="select select--film-category" method='get'>
                          <select name="genre" class="select__sort" tabindex="0">
							<? foreach($genre as $datagenre){?>
                            <option value="<?=$datagenre?>"><?=$datagenre?></option>
							<? } ?>
                          </select>
                    </form>

                </div>

                <div class="tags-area">
                    <div class="tags tags--unmarked">
                        <span class="tags__label">Sorted by:</span>
                            <ul>
                                <li class="item-wrap"><a href="#" class="tags__item item-active" data-filter='all'>all</a></li>
                                <li class="item-wrap"><a href="#" class="tags__item" data-filter='release'>release date</a></li>
                                <li class="item-wrap"><a href="#" class="tags__item" data-filter='popularity'>popularity</a></li>
                                <li class="item-wrap"><a href="#" class="tags__item" data-filter='commentmovies'>commentmovies</a></li>
                                <li class="item-wrap"><a href="#" class="tags__item" data-filter='ending'>ending soon</a></li>
                            </ul>
                    </div>
                </div>
				
				<? if(isset($posts)){
						foreach($posts as $dtp){	
				?>			
                <!-- Movie preview item -->
                <div class="movie movie--preview release">
                     <div class="col-sm-5 col-md-3">
                            <div class="movie__images">
                                <img alt='' src="<?=base_url();?>view.php?image=uploads/default/files/<?=$dtp['image']['filename']?>&amp;mode=crop&amp;size=380x592">
                            </div>
                    </div>
                    <div class="col-sm-7 col-md-9">
                            <a href='<?=$dtp['url']?>' class="movie__title link--huge"><?=$dtp['title']?> (<?=date('Y',$dtp['release_date'])?>)</a>

                            <p class="movie__time"><?=$dtp['runtime']?> min</p>
                            <p class="movie__option"><strong>Country: </strong><a href="#"><?=$dtp['country']['code']?></a></p>
                            <p class="movie__option"><strong>Category: </strong><a href="#"><?=$dtp['genre']?></a></p>
                            <p class="movie__option"><strong>Release date: </strong><?=date('F j, Y',$dtp['release_date'])?></p>
                            <p class="movie__option"><strong>Director: </strong><a href="#"><?=$dtp['director']?></a></p>
                            <p class="movie__option"><strong>Actors: </strong><?=$dtp['star']?></p>
                            
                            <p class="movie__option"><strong>ID IMDB: </strong><?=$dtp['id_imdb']?></p>
                            <p class="movie__option"><strong>ID TMDB: </strong><?=$dtp['id_tmdb']?></p>


                            <div class="preview-footer">
                                <div class="movie__rate">
									<div class="score"></div>
									<span class="movie__rate-number"><?=$dtp['comment_count']?> Comment</span>
								</div>
                            </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- end movie preview item -->
				<?
						}
					echo $pagination;	
					}else{
				?>

				{{ helper:lang line="movie:currently_no_posts" }}
				<?	
					}
				?>

                
                <div class="coloum-wrapper">
                    <div class="pagination paginatioon--full">
                            <a href='#' class="pagination__prev">prev</a>
                            <a href='#' class="pagination__next">next</a>
                    </div>
                </div>