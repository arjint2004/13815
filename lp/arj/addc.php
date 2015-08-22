<div class="row ">
						<div class="panel panel-default">
							<div class="panel-body titasb">
								Others <?php echo $GenreMovie; ?> Movie
							</div>
						</div>

			<?php for($tm=0;$tm<$CountTopMovie;$tm++){?>
			<div class="col-sm-per6 no_padding no_margin">	
                <div class="no_margin view view-tenth">
                    <img  src="<?php echo $TopBackdrop[$tm]; ?>"  alt="<?php echo $TopMovieID[$tm]; ?>"/>
                    <div class="mask">
                        <a class="info" href="<?php echo $TopMovieID[$tm]; ?>"><?php echo $TopMovieTitle[$tm]; ?></a>
                        <p  href="<?php echo $TopBackdrop[$tm]; ?>"  data-toggle="lightbox" data-gallery="imagesizes"><?=$TopDesc[$tm]?></p>
                    </div>
                </div>
            </div>
			<? } ?>
			
		</div>