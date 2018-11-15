<section class="tsr-row">
    <div class="breadcrumbs">
        <div class="tsr-container">
            <div class="col-12">
                <a href="<?=SITE_PATH?>">Homepage</a>
                <!--<a href="">Home</a>-->
                <span class="ts-icon-breadcrumb-arrow"></span>
                <span class="bread-item-name ">Online Games</span>
                <!--<a href="">Home</a>-->
                <span class="ts-icon-breadcrumb-arrow"></span>
                <a href="<?=SITE_PATH?>/category/<?=slugGenerator($current_category_name) . '-' . $current_category_id?>"><?=$current_category_name?></a>
                <!--<a href="">Home</a>-->
                <span class="ts-icon-breadcrumb-arrow"></span>
                <span class="bread-item-name bold"><?=$current_game_name?></span>
            </div>
        </div>
    </div>
</section>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <section class="tsr-grid">
            <div class="tsr-container">
                <section class="selected-games">
                    <div class="tsr-row">
                        <div class="col-5">
                            <div class="selected-games-slider">

                                <script>
                                    jQuery(document).ready(function ($) {

                                        // console.log($JssorArrowNavigator$);

                                        var slider_options = {
                                            $AutoPlay: false,
                                            $ArrowNavigatorOptions: {
                                                $Class: $JssorArrowNavigator$
                                            },
                                            $ThumbnailNavigatorOptions: {
                                                $Class: $JssorThumbnailNavigator$,
                                                $Cols: 2,
                                                $SpacingX: 0,
                                                $SpacingY: 0,
                                                $Orientation: 2,
                                                $Align: 0
                                            }
                                        };

                                        var slider_slider = new $JssorSlider$("slider", slider_options);

                                        //responsive code begin
                                        //you can remove responsive code if you don't want the slider scales while window resizing
                                        function ScaleSlider() {
                                            var refSize = slider_slider.$Elmt.parentNode.clientWidth;
                                            if (refSize) {
                                                refSize = Math.min(refSize, 465);
                                                slider_slider.$ScaleWidth(refSize);
                                            }
                                            else {
                                                window.setTimeout(ScaleSlider, 30);
                                            }
                                        }
                                        ScaleSlider();
                                        $(window).bind("load", ScaleSlider);
                                        $(window).bind("resize", ScaleSlider);
                                        $(window).bind("orientationchange", ScaleSlider);
                                        //responsive code end
                                    });
                                </script>
                                <div id="slider" style="width: 465px; height: 250px;">
                                    <!-- Loading Screen -->
                                    <div data-u="slides" class="slider-slides">
                                        <?php
                                            if($count_gallery>0)
                                            {
                                                $i=1;
                                                while($row=$result_game_gallery->fetch_assoc())
                                                {
                                                    if($i==1)
                                                    {
                                                        ?>
                                                        <div>
                                                            <img data-u="image" src="<?=SITE_PATH.'/images/games/'.$current_game_image_name?>" />
                                                            <div data-u="thumb">
                                                                <img class="i" src="<?=SITE_PATH.'/images/games/'.$current_game_image_name?>" />
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div>
                                                        <img data-u="image" src="<?=SITE_PATH.'/images/game_gallery/'.$row['image_name']?>" />
                                                        <div data-u="thumb">
                                                            <img class="i" src="<?=SITE_PATH.'/images/game_gallery/'.$row['image_name']?>" />
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <div>
                                                    <img data-u="image" src="<?=SITE_PATH.'/images/games/'.$current_game_image_name?>" />
                                                    <div data-u="thumb">
                                                        <img class="i" src="<?=SITE_PATH.'/images/games/'.$current_game_image_name?>" />
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <!-- Thumbnail Navigator -->
                                    <div data-u="thumbnavigator" class="slider-thumbnails" data-autocenter="2">
                                        <!-- Thumbnail Item Skin Begin -->
                                        <div data-u="slides" style="cursor: default;">
                                            <div data-u="prototype" class="p">
                                                <div data-u="thumbnailtemplate" class="tp"></div>
                                            </div>
                                        </div>
                                        <!-- Thumbnail Item Skin End -->
                                    </div>
                                    <?php
                                        if($count_gallery>0)
                                        {
                                            ?>
                                            <!-- Arrow Navigator -->
                                            <span data-u="arrowleft" class="left-arrow" data-autocenter="2"></span>
                                            <span data-u="arrowright" class="right-arrow" data-autocenter="2"></span>
                                            <?php
                                        }
                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-7">
                            <div class="game-data">
                                <div class="selected-type">
                                    <h5>Game</h5>
                                </div>

                                <div class="selected-title">
                                    <h1><?=$current_game_name?></h1>
                                </div>

                                <div class="selected-type">
                                    <h5><?=$current_category_name?></h5>
                                </div>

                                <div class="selected-classification">

                                    <img src="<?=SITE_PATH?>/assets/img/filled_star.png">
                                    <img src="<?=SITE_PATH?>/assets/img/filled_star.png">
                                    <img src="<?=SITE_PATH?>/assets/img/filled_star.png">

                                    <img src="<?=SITE_PATH?>/assets/img/star.png">
                                    <img src="<?=SITE_PATH?>/assets/img/star.png">
                                </div>

                                <div class="selected-description">
                                    <p>
                                        <span class="more">
                                            <?=html_entity_decode($current_game_text)?>
                                        </span>
                                    </p>
                                </div>

                                <div class="game-platform">
                                    <button class="tsr-btn tsr-btn-blue btnPlay" data-login="false" data-postid="19"
                                            data-clubid="75112" data-catid="" data-mediaid="" data-video=""
                                            data-view="422260  ">
                                        PLAY
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="other-games">
                    <div class="tsr-row maximize">
                        <div class="col-6">
                            <section class="most-played-games">
                                <h3>Most Played Games</h3>
                                <div class="tsr-row maximized">
                                    <?php
                                        while($row=$result_most_played_game->fetch_assoc())
                                        {
                                            ?>
                                            <div class="col-6 maximized mobilemax">
                                                <div class="other-games-content">
                                                    <div class="most-played-games-game">
                                                        <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($row['g_name']) . '-' . $row['g_id']?>">
                                                            <div class="game-figure">
                                                                <img src="<?=SITE_PATH?>/images/games/<?=$row['g_image_name']?>">
                                                            </div>
                                                        </a>
                                                        <div class="most-played-games-game-content">
                                                            <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($row['g_name']) . '-' . $row['g_id']?>">
                                                                <div class="game-name">
                                                                    <?=$row['g_name']?>
                                                                </div>
                                                            </a>
                                                            <p class="tsr-product-price">
                                                                <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnPlay" id="subscribe_modal">
                                                                    PLAY
                                                                </button>
                                                                <!--Subscribe Button-->
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                </div>
<!--                                <div class="tsr-row maximized">-->
<!--                                    <div class="col-12">-->
<!--                                        <a href="http://play.ucell.uz/online-games/top-games"-->
<!--                                           class="tsr-btn-view-all"><span>View all<i>(29)</i></span></a>-->
<!--                                    </div>-->
<!--                                </div>-->
                            </section>
                        </div>
                        <div class="col-6">
                            <section class="similar-games">
                                <h3>Similar Games</h3>

                                <div class="other-games-content">
                                    <section class="tsr-section-productAndService-listing tsr-color-white">

                                        <div class="tsr-container">
                                            <div class="tsr-slides">
                                                <?php
                                                    while($row=$result_similar_games->fetch_assoc())
                                                    {
                                                        ?>
                                                        <div class="tsr-module-service ">
                                                            <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($row['name']) . '-' . $row['auto_id']?>">
                                                                <figure class="">
                                                                    <img src="<?=SITE_PATH?>/images/games/<?=$row['image_name']?>">
                                                                </figure>
                                                                <div class="tsr-service-content">
                                                                    <header class="tsr-service-header"><?=$row['name']?></header>
                                                                </div>
                                                            </a>

                                                            <p>
                                                                <img class="rating-star" src="<?=SITE_PATH?>/assets/img/filled_star.png">
                                                                <img class="rating-star" src="<?=SITE_PATH?>/assets/img/filled_star.png">
                                                                <img class="rating-star" src="<?=SITE_PATH?>/assets/img/filled_star.png">

                                                                <img class="rating-star" src="<?=SITE_PATH?>/assets/img/star.png">
                                                                <img class="rating-star" src="<?=SITE_PATH?>/assets/img/star.png">
                                                            </p>

                                                            <p class="tsr-product-price">
                                                                <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnPlay" id="subscribe_modal">
                                                                    PLAY
                                                                </button>
                                                                <!--Subscribe Button-->
                                                            </p>
                                                        </div>
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </main><!-- #main -->
</div><!-- #primary -->


