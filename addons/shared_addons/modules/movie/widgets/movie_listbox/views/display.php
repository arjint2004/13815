
					<? 
					foreach($posts['entries'] as $cv=>$dtbnr){
					   switch($cv){
							case 0:
								$diwalik="movie--test--dark movie--test--left";
							break;
							case 1:
								$diwalik="movie--test--light movie--test--left";
							break;
							case 2:
								$diwalik="movie--test--light movie--test--right";
							break;
							case 3:
								$diwalik="movie--test--dark movie--test--right";
							break;
							case 4:
								$diwalik="movie--test--dark movie--test--left";
							break;
							case 5:
								$diwalik="movie--test--light movie--test--left";
							break;
							case 6:
								$diwalik="movie--test--light movie--test--right";
							break;
							case 7:
								$diwalik="movie--test--dark movie--test--right";
							break;
					   }
					if(file_exists(str_replace("index.php","",$_SERVER['SCRIPT_FILENAME'])."uploads/default/files/".$dtbnr['image']['filename']."")){
					
					//echo "<pre>";print_r(str_replace("index.php","",$_SERVER['SCRIPT_FILENAME'])."uploads/default/files/".$dtbnr['image']['filename']."");
					?>
                        <!-- Movie variant with time -->
                            <div class="movie movie--test <?=$diwalik?>">
                                <div class="movie__images">
                                    <a href="<?=site_url('movie/'.date('Y/m', $dtbnr['created_on']).'/'.$dtbnr['slug']);?>" class="movie-beta__link">
                                        <img src="<?=base_url()?>view.php?image=uploads/default/files/<?=$dtbnr['image']['filename']?>&mode=crop&size=423x423" />
                                    </a>
                                </div>

                                <div class="movie__info">
                                    <a href='<?=site_url('movie/'.date('Y/m', $dtbnr['created_on']).'/'.$dtbnr['slug']);?>' class="movie__title"><?=$dtbnr['title']?> (<?=date('Y',$dtbnr['release_date'])?>)  </a>

                                    <p class="movie__time"><?=$dtbnr['runtime']?> min</p>

                                    <p class="movie__option"><?=$dtbnr['genre']?></p>
                                    
                                    <div class="movie__rate">
                                        <div class="score"></div>
                                        <span class="movie__rating">4.1</span>
                                    </div>               
                                </div>
                            </div>
                         <!-- Movie variant with time -->
						<? } } ?>
						<?//=$posts['pagination']?>

