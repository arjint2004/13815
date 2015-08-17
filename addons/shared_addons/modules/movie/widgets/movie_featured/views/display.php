
<div class="movie-best">
                 <div class="col-sm-10 col-sm-offset-1 movie-best__rating">Today Best choice</div>
                 <div class="col-sm-12 change--col">
                    <? foreach($posts['entries'] as $dtbnr){ ?>
					<div class="movie-beta__item ">
                        <img src="<?=base_url()?>view.php?image=uploads/default/files/<?=$dtbnr['image']['filename']?>&mode=crop&size=360x600" />
                         <span class="best-rate" onclick="window.location='<?=site_url('movie/'.date('Y/m', $dtbnr['created_on']).'/'.$dtbnr['slug']);?>'" style="cursor:pointer;">Detail</span>

                         <ul class="movie-beta__info">
                             <li><span class="best-voted"><?=$dtbnr['title']?></span></li>
                             <li>
                                <p class="movie__time"><?=$dtbnr['runtime']?></p>
                                <p><?=str_replace("&#44; "," | ",$dtbnr['genre'])?> </p>
                                <p><?=$dtbnr['comment_count']?> Comment</p>
                             </li>
                             <li class="last-block">
                                 <a href="<?=site_url('movie/'.date('Y/m', $dtbnr['created_on']).'/'.$dtbnr['slug']);?>" class="slide__link">more</a>
                             </li>
                         </ul>
                     </div>
                     <? } ?>
                 </div>
                <div class="col-sm-10 col-sm-offset-1 movie-best__check">check all movies now playing</div>
            </div>