
					<?
					$cc=0;
					$cc2=1;
					foreach($posts['entries'] as $cv=>$dtbnr){
					if(file_exists(str_replace("index.php","",$_SERVER['SCRIPT_FILENAME'])."uploads/default/files/".$dtbnr['image']['filename']."") && $dtbnr['image']['filename']!=''){
						if($cc2%2==0){
							$cc=$cc-1;
						}
						$cc=$cc+1;
						$cc2=$cc2+1;
						if($cc%2==0){$diwalik="movie--test--dark movie--test--left";}else{$diwalik="movie--test--light movie--test--right";}
					//echo "<pre>";print_r(str_replace("index.php","",$_SERVER['SCRIPT_FILENAME'])."uploads/default/files/".$dtbnr['image']['filename']."");
					?>
                        <!-- Movie variant with time -->
                            <div class="movie movie--test <?=$diwalik?>">
                                <div class="movie__images">
                                    <a href="<?=site_url('movie/'.date('Y/m', $dtbnr['created_on']).'/'.$dtbnr['slug']);?>" class="movie-beta__link">
                                        <img src="<?=base_url()?>view.php?image=uploads/default/files/<?=$dtbnr['image']['filename']?>&mode=crop&size=423x423" />
                                    </a>
                                </div>
								<? $rnd=rand(1,50)/10;?>
                                <div class="movie__info">
                                    <a href='<?=site_url('movie/'.date('Y/m', $dtbnr['created_on']).'/'.$dtbnr['slug']);?>' class="movie__title"><?=$dtbnr['title']?> (<?=date('Y',$dtbnr['release_date'])?>)  </a>

                                    <p class="movie__time"><?=$dtbnr['runtime']?> min</p>

                                    <p class="movie__option"><?=$dtbnr['genre']?></p>
									
                                    <div class="movie__rate">
                                        <div class="score" style="cursor: pointer; width: 130px;">
											<?=imgreate($rnd);?>
										</div>
                                        <span class="movie__rating"><?=$rnd;?></span>
                                    </div>               
                                </div>
                            </div>
                         <!-- Movie variant with time -->
						<? } } ?>
						<?//=$posts['pagination']?>

