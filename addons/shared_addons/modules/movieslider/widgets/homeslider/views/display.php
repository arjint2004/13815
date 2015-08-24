<!-- Slider -->

            <div class="bannercontainer">
                    <div class="banner">
                        <ul>
							<?php foreach($movieslider_widget['entries'] as $post_widget): ?>
                            <li data-transition="fade" data-slotamount="7" class="slide" data-slide='Rush.'>
                                <img alt='' src="<?=base_url()?>view.php?image=uploads/default/files/<?=$post_widget['image']['filename']?>&mode=crop&size=1920x616">
                                <div class="caption slide__name margin-slider" 
                                     data-x="right" 
                                     data-y="80" 

                                     data-splitin="chars"
                                     data-elementdelay="0.1"

                                     data-speed="700" 
                                     data-start="1400" 
                                     data-easing="easeOutBack"

                                     data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:0;transformOrigin:50% 50%;"

                                    data-frames="{ typ :lines;
                                                 elementdelay :0.1;
                                                 start:1650;
                                                 speed:500;
                                                 ease:Power3.easeOut;
                                                 animation:x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:1;transformPerspective:600;transformOrigin:50% 50%;
                                                 },
                                                 { typ :lines;
                                                 elementdelay :0.1;
                                                 start:2150;
                                                 speed:500;
                                                 ease:Power3.easeOut;
                                                 animation:x:0;y:0;z:0;rotationX:00;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:1;transformPerspective:600;transformOrigin:50% 50%;
                                                 }
                                                 "


                                    data-splitout="lines"
                                    data-endelementdelay="0.1"
                                    data-customout="x:-230;y:0;z:0;rotationX:0;rotationY:0;rotationZ:90;scaleX:0.2;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%"

                                    data-endspeed="500"
                                    data-end="8400"
                                    data-endeasing="Back.easeIn"
                                     >
                                    <?=$post_widget['animation_text_1']?>
                                </div>

                                <div class="caption slide__time margin-slider sfr str" 
                                     data-x="right" 
                                     data-hoffset='-243' 
                                     data-y="186" 
                                     data-speed="300" 
                                     data-start="2100" 
                                     data-easing="easeOutBack"
                                     data-endspeed="300"
                                     data-end="8700"
                                     data-endeasing="Back.easeIn"
                                     >
                                     <?=$post_widget['animation_text_2']?>
                                 </div>
                                <div class="caption slide__date margin-slider lfb ltb" 
                                     data-x="right" 
                                     data-hoffset='-149' 
                                     data-y="186" 
                                     data-speed="500" 
                                     data-start="2400" 
                                     data-easing="Power4.easeOut"
                                     data-endspeed="400"
                                     data-end="8200"
                                     data-endeasing="Back.easeIn"
                                     >
                                     <?=$post_widget['animation_text_3']?>
                                 </div>
                                <div class="caption slide__time margin-slider sfr str" 
                                     data-x="right" 
                                     data-hoffset='-113' 
                                     data-y="186" 
                                     data-speed="300" 
                                     data-start="2100" 
                                     data-easing="easeOutBack"
                                     data-endspeed="300"
                                     data-end="8700"
                                     data-endeasing="Back.easeIn"
                                     >
                                    <?=$post_widget['animation_text_4']?>
                                 </div>
                                <div class="caption slide__date margin-slider lfb ltb" 
                                     data-x="right" 
                                     data-y="186" 
                                     data-speed="500" 
                                     data-start="2800" 
                                     data-easing="Power4.easeOut"
                                     data-endspeed="400"
                                     data-end="8200"
                                     data-endeasing="Back.easeIn"
                                     >
                                     <?=$post_widget['animation_text_5']?>
                                </div>
                                <div class="caption slide__text margin-slider customin customout" 
                                     data-x="right" 
                                     data-y="250"
                                     data-customin="x:0;y:100;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:1;scaleY:3;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:0% 0%;"
                                     data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;" 
                                     data-speed="400" 
                                     data-start="3000"
                                     data-endspeed="400"
                                     data-end="8000"
                                     data-endeasing="Back.easeIn">
                                     <?=$post_widget['animation_text_6']?>
                                 </div>
                                <div class="caption margin-slider skewfromright customout " 
                                     data-x="right" 
                                     data-y="324"
                                     data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                                     data-speed="400" 
                                     data-start="3300"
                                     data-easing="Power4.easeOut"
                                     data-endspeed="300"
                                     data-end="7700"
                                     data-endeasing="Power4.easeOut">
                                     <a onclick="window.location='<?=site_url('movieslider/'.date('Y/m', $post_widget['created_on']).'/'.$post_widget['slug']);?>'" style="cursor:pointer;" class="slide__link"><?=$post_widget['animation_text_7']?></a>
                                 </div>
                            </li>
							<?php endforeach ?>

                        </ul>
                    </div>
                </div>

        <!--end slider -->