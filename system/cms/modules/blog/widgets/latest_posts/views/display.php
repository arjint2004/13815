

			<div class="col-sm-12">
                <h2 class="page-heading">Latest news</h2>
				<?php foreach($blog_widget['entries'] as $post_widget): ?>
                <div class="col-sm-4 similar-wrap col--remove">
                    <div class="post post--preview post--preview--wide">
                        <div class="post__image">
                            <img alt='' src="<?=base_url()?>view.php?image=uploads/default/files/<?=$post_widget['image']['filename']?>&mode=crop&size=270x330">
                            <!--<div class="social social--position social--hide">
                                <span class="social__name">Share:</span>
                                <a href='#' class="social__variant social--first fa fa-facebook"></a>
                                <a href='#' class="social__variant social--second fa fa-twitter"></a>
                                <a href='#' class="social__variant social--third fa fa-vk"></a>
                            </div>-->
                        </div>
                        <p class="post__date"><?=date('F j, Y',$post_widget['created_on'])?></p>
                        <a href="<?=site_url('blog/'.date('Y/m', $post_widget['created_on']).'/'.$post_widget['slug']);?>" class="post__title"><?=$post_widget['title']?></a>
                        <a href="<?=site_url('blog/'.date('Y/m', $post_widget['created_on']).'/'.$post_widget['slug']);?>" class="btn read-more post--btn">read more</a>
                    </div>
                </div>
				<?php endforeach ?>              
            </div>