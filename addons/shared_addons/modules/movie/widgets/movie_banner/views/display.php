<? foreach($posts['entries'] as $dtbnr){ ?>
    <div class="banner-wrap">
        <img alt='banner' src="<?=base_url()?>view.php?image=uploads/default/files/<?=$dtbnr['image']['filename']?>&mode=crop&size=380x592">
    </div>
<? } ?>	

<pre><? //print_r($tenlast);?></pre>
                    <div class="category category--discuss category--count marginb-sm mobile-category ls-cat">
                        <h3 class="category__title">the last  <br><span class="title-edition">10 release</span></h3>
                        <ol>
						<? foreach($tenlast['entries'] as $tenlast){ ?>
                            <li><a href="<?=site_url('movie/'.date('Y/m', $tenlast['created_on']).'/'.$tenlast['slug']);?>" class="category__item"><?=$tenlast['title']?></a></li>
						<? } ?>
                        </ol>
                    </div>		
					
                    <div class="category category--cooming category--count marginb-sm mobile-category rs-cat">
                        <h3 class="category__title">coming soon<br><span class="title-edition">movies</span></h3>
                        <ol>
                            <? foreach($cmsn['entries'] as $cmsndt){ ?>
							<li><a href="<?=site_url('movie/'.date('Y/m', $cmsndt['created_on']).'/'.$cmsndt['slug']);?>" class="category__item"><?=$cmsndt['title']?></a></li>
							<? } ?>
                        </ol>
                    </div>