<? 
error_reporting(0);
include ('arj/data_ori.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Watch
        <?php echo $Title; ?> Full Movie Streaming</title>
    <meta name="keywords" content="Watch <?php echo $Title; ?> Movie, Watch <?php echo $Title; ?> Movie Streaming, Watch <?php echo $Title; ?> Movie Streaming Online, Watch <?php echo $Title; ?> Movie Stream, <?php echo $Title; ?> Movie Streaming, <?php echo $Title; ?> Free Movie Streaming"
    />
    <meta name="description" content="Watch <?php echo $Title; ?> movie streaming in HD: <?php echo $Title; ?> download full Movie Streaming Online" />
    <meta name="robots" content="noodp,noydir">
    <link href='http://fonts.googleapis.com/css?family=Signika:600,400,300' rel='stylesheet' type='text/css'>
    <script src="script/main.js" type="text/javascript"></script>
    <link href="style.css" rel="stylesheet" type="text/css" media="screen">
    <link href="script/player.css" type="text/css" rel="stylesheet" />
</head>

<body class="home color-red">
    <div class="root">
        
        <div style="display:none;">
            <input type="hidden" name="locale" value="en" id="locale" />
        </div>
        <div style="display:none;">
            <input type="hidden" name="landing_name" value="player2" id="landing_name" />
        </div>
        <div style="display:none;">
            <input type="hidden" name="second_step_redirection_url" value="<?php echo $aff_link; ?>" id="second_step_redirection_url" />
        </div>
        <section class="slider12 p07">
            <div id="player_section">
                <div class="limiter2">
                    
                    <div id="movie_player" style="background:url('<?php if($Backdrop==FALSE){ echo 'asset/images/blank.jpg'; }else{ echo $Backdrop; } ?>') center repeat-x #000;background-size:contain;">
                        <div id="movie_player_green"></div>
                        <div class="overlay"></div>
                        <div id="box_stream_break">
                            <div class="limited_offer_player">
                                <div class="offer_reg"> <span class="txt_reg_user">You are not registered.</span>
                                    <br>
                                    <br> <span class="offer1">Please Sign Up or Login!</span>  <span class="offer2 show_dialog">Try premium account for FREE!</span>
                                    <br> <span class="offer3">Right now you are using a player with low buffering priority, try the premium account for free!</span>
                                    <br>
                                    <div class="the_big_butt show_dialog">REGISTER PREMIUM ACCOUNT FOR FREE</div>
                                </div>
                            </div>
                        </div>
                        <div id="big_play_butt"></div>
                        <div id="big_play_throbbler"></div>
                        <div class="player_top"> <span>Watch <?php echo $Title; ?></span> 
                            <!--<div class="player_top_box ptb2">Rates: <font color="#fff">98%</font> 
                                <div class="stars_box"></div>
                            </div>-->
                            <div class="player_top_box ptb1">Views:
                                <br><span class="views"><?=rand(700,1000);?></span> 
                            </div>
                        </div>
                        <div class="player_bottom">
                            <div class="play_progresso show_dialog">
                                <div class="progresso_knob"></div>
                                <div class="progress_bar" style="width:5px"></div>
                            </div>
                            <div class="player_controls">
                                <div class="bott_box bb1">
									<div class="pause1 ps" ></div>
									<div class="pause2 ps" ></div>
									<div class="arrow-right"></div>
								</div>
                                <div id="timer_section" class="bott_box bb2 show_dialog"> <span style="float:left;">0:00:00</span> <div style="float:left;">/ <?php echo $Runtime.":00"; ?></div>
                                </div>
                                <div id="resolution" class="bott_box bb3">1080p
                                    <div class="res_choice">
                                        <div class="boxxy">240p</div>
                                        <div class="boxxy">720p</div>
                                        <div class="boxxy boxyhi">1080p</div>
                                    </div>
                                </div>
                                <div class="bott_box bvolume">
                                    <div id="volume_barro" class="show_dialog"></div>
                                </div>
                                <div class="bott_box bb1last show_dialog"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </section>
        
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
</body>

</html>
