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
                        <div class="col-3">
                            <div class="selected-games-slider">

<!--                                <script>-->
<!--                                    jQuery(document).ready(function ($) {-->
<!---->
<!--                                        // console.log($JssorArrowNavigator$);-->
<!---->
<!--                                        var slider_options = {-->
<!--                                            $AutoPlay: false,-->
<!--                                            $ArrowNavigatorOptions: {-->
<!--                                                $Class: $JssorArrowNavigator$-->
<!--                                            },-->
<!--                                            $ThumbnailNavigatorOptions: {-->
<!--                                                $Class: $JssorThumbnailNavigator$,-->
<!--                                                $Cols: 2,-->
<!--                                                $SpacingX: 0,-->
<!--                                                $SpacingY: 0,-->
<!--                                                $Orientation: 2,-->
<!--                                                $Align: 0-->
<!--                                            }-->
<!--                                        };-->
<!---->
<!--                                        var slider_slider = new $JssorSlider$("slider", slider_options);-->
<!---->
<!--                                        //responsive code begin-->
<!--                                        //you can remove responsive code if you don't want the slider scales while window resizing-->
<!--                                        function ScaleSlider() {-->
<!--                                            var refSize = slider_slider.$Elmt.parentNode.clientWidth;-->
<!--                                            if (refSize) {-->
<!--                                                refSize = Math.min(refSize, 465);-->
<!--                                                slider_slider.$ScaleWidth(refSize);-->
<!--                                            }-->
<!--                                            else {-->
<!--                                                window.setTimeout(ScaleSlider, 30);-->
<!--                                            }-->
<!--                                        }-->
<!--                                        ScaleSlider();-->
<!--                                        $(window).bind("load", ScaleSlider);-->
<!--                                        $(window).bind("resize", ScaleSlider);-->
<!--                                        $(window).bind("orientationchange", ScaleSlider);-->
<!--                                        //responsive code end-->
<!--                                    });-->
<!--                                </script>-->
                                <div style="/*width: 465px; height: 250px;*/">
                                    <!-- Loading Screen -->
                                    <div data-u="slides" class="slider-slides">
                                        <div>
                                            <img style="width: 250px; height: 200px;" data-u="image" src="<?=SITE_PATH.'/images/games/'.$current_game_image_name?>" />
<!--                                            <div data-u="thumb">-->
<!--                                                <img class="i" src="--><?//=SITE_PATH.'/images/games/'.$current_game_image_name?><!--" />-->
<!--                                            </div>-->
                                        </div>
                                        <?php
//                                            if($count_gallery>100000)
//                                            {
//                                                $i=1;
//                                                while($row=$result_game_gallery->fetch_assoc())
//                                                {
//                                                    if($i==1)
//                                                    {
//                                                        ?>
<!--                                                        <div>-->
<!--                                                            <img data-u="image" src="--><?//=SITE_PATH.'/images/games/'.$current_game_image_name?><!--" />-->
<!--                                                            <div data-u="thumb">-->
<!--                                                                <img class="i" src="--><?//=SITE_PATH.'/images/games/'.$current_game_image_name?><!--" />-->
<!--                                                            </div>-->
<!--                                                        </div>-->
<!--                                                        --><?php
//                                                    }
//                                                    ?>
<!--                                                    <div>-->
<!--                                                        <img data-u="image" src="--><?//=SITE_PATH.'/images/game_gallery/'.$row['image_name']?><!--" />-->
<!--                                                        <div data-u="thumb">-->
<!--                                                            <img class="i" src="--><?//=SITE_PATH.'/images/game_gallery/'.$row['image_name']?><!--" />-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                    --><?php
//                                                    $i++;
//                                                }
//                                            }
//                                            else
//                                            {
//                                                ?>
<!--                                                <div>-->
<!--                                                    <img data-u="image" src="--><?//=SITE_PATH.'/images/games/'.$current_game_image_name?><!--" />-->
<!--                                                    <div data-u="thumb">-->
<!--                                                        <img class="i" src="--><?//=SITE_PATH.'/images/games/'.$current_game_image_name?><!--" />-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                                --><?php
//                                            }
                                        ?>
                                    </div>
                                    <!-- Thumbnail Navigator -->
<!--                                    <div data-u="thumbnavigator" class="slider-thumbnails" data-autocenter="2">-->
                                        <!-- Thumbnail Item Skin Begin -->
<!--                                        <div data-u="slides" style="cursor: default;">-->
<!--                                            <div data-u="prototype" class="p">-->
<!--                                                <div data-u="thumbnailtemplate" class="tp"></div>-->
<!--                                            </div>-->
<!--                                        </div>-->
                                        <!-- Thumbnail Item Skin End -->
<!--                                    </div>-->
                                    <?php
//                                        if($count_gallery>10000)
//                                        {
//                                            ?>
<!--                                            <!-- Arrow Navigator -->
<!--                                            <span data-u="arrowleft" class="left-arrow" data-autocenter="2"></span>-->
<!--                                            <span data-u="arrowright" class="right-arrow" data-autocenter="2"></span>-->
<!--                                            --><?php
//                                        }
                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-9">
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

                                    <?php
                                        $stars = '';
                                        for($i=1;$i<=5;$i++)
                                        {
                                            if($i<=$current_game_star)
                                            {
                                                $stars .= '<img src="'.SITE_PATH.'/assets/img/filled_star.png">';
                                            }
                                            else
                                            {
                                                $stars .= '<img src="'.SITE_PATH.'/assets/img/star.png">';
                                            }
                                        }

                                        echo $stars;
                                    ?>
                                </div>

                                <div class="selected-description">
                                    <p>
                                        <span class="more">
                                            <?=html_entity_decode($current_game_text)?>
                                        </span>
                                    </p>
                                </div>

                                <div class="game-platform">
                                    <?php
                                        $link = (subscribe_check($db)==true) ? SITE_PATH."/play-game/".slugGenerator($current_game_name) . '-' . $current_game_id : '';

                                        if(subscribe_check($db)==true)
                                        {
                                            ?>
                                            <span class="tsr-btn btnJoin" data-gameid="<?=$current_game_id?>" id="play_link" style="cursor: pointer;" onclick="window.location = '<?=$link?>'">
                                                Play
                                            </span>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class="tsr-btn btnJoin" id="subscribe_modal" style="cursor: pointer;" onclick="return false;">
                                                Play
                                            </span>
                                            <?php
                                        }
                                    ?>
<!--                                    <button class="tsr-btn tsr-btn-blue btnPlay" id="subscribe_modal">-->
<!--                                        PLAY-->
<!--                                    </button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <!-- SECTION LIST -->
        <section class="tsr-section-divider tsr-color-white">
            <header class="tsr-container">
                <span>Similar Games</span>
            </header>
        </section>

        <section class="tsr-section-carousel-listing front-categories">
            <div class="tsr-container">
                <div class="tsr-slides">
                    <?php

                    foreach($result_similar_games_arr as $row)
                    {
                        ?>
                        <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($row['name']) . '-' . $row['auto_id']?>" class="tsr-module-product">
                            <figure class="tsr-product-image" style="text-align:center;">
                                <img src="<?=SITE_PATH?>/images/games/<?=$row['image_name']?>"
                                     style="max-width:250px; width: 100%;"/>
                            </figure>
                            <div class="tsr-product-content">
                                <header class="tsr-product-header"><?=$row['name']?></header>
                                <p>
                                    <?php
                                    $stars = '';
                                    for($i=1;$i<=5;$i++)
                                    {
                                        if($i<=$row['star'])
                                        {
                                            $stars .= '<img class="rating-star" src="'.SITE_PATH.'/assets/img/filled_star.png">';
                                        }
                                        else
                                        {
                                            $stars .= '<img class="rating-star" src="'.SITE_PATH.'/assets/img/star.png">';
                                        }
                                    }

                                    echo $stars;
                                    ?>
                                </p>
                                <?php
                                $link = (subscribe_check($db)==true) ? SITE_PATH."/play-game/".slugGenerator($row['name']) . '-' . $row['auto_id'] : '';

                                if(subscribe_check($db)==true)
                                {
                                    ?>
                                    <span class="tsr-btn btnJoin" data-gameid="<?=$row['auto_id']?>" id="play_link" onclick="window.location = '<?=$link?>'">
                                                Play
                                            </span>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <span class="tsr-btn btnJoin" id="subscribe_modal" onclick="return false;">
                                                Play
                                            </span>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="clear"></div>
                        </a>
                        <?php
                    }

                    //                    $stmt_select->close();
                    ?>
                </div>
            </div>
        </section>
        <br/>
        <section class="tsr-section-divider tsr-color-white">
            <header class="tsr-container">
                <span>Most Played Games</span>
            </header>
        </section>

        <section class="tsr-section-carousel-listing front-categories">
            <div class="tsr-container">
                <div class="tsr-slides">
                    <?php

                    foreach ($result_most_played_games_arr as $row)
                    {
                        ?>
                        <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($row['g_name']) . '-' . $row['g_id']?>" class="tsr-module-product">
                            <figure class="tsr-product-image" style="text-align:center;">
                                <img src="<?=SITE_PATH?>/images/games/<?=$row['g_image_name']?>" style="max-width:250px; width: 100%;"/>
                            </figure>
                            <div class="tsr-product-content">
                                <header class="tsr-product-header"><?=$row['g_name']?></header>
                                <p>
                                    <?php
                                    $stars = '';
                                    for($i=1;$i<=5;$i++)
                                    {
                                        if($i<=$row['g_star'])
                                        {
                                            $stars .= '<img class="rating-star" src="'.SITE_PATH.'/assets/img/filled_star.png">';
                                        }
                                        else
                                        {
                                            $stars .= '<img class="rating-star" src="'.SITE_PATH.'/assets/img/star.png">';
                                        }
                                    }

                                    echo $stars;
                                    ?>
                                </p>
                                <!--Play Button-->
                                <p class="tsr-product-small-print"><br/>
                                    <?php
                                    $link = (subscribe_check($db)==true) ? SITE_PATH."/play-game/".slugGenerator($row['g_name']) . '-' . $row['g_id'] : '';

                                    if(subscribe_check($db)==true)
                                    {
                                        ?>
                                        <span class="tsr-btn btnJoin" id="play_link" data-gameid="<?=$row['g_id']?>" onclick="window.location = '<?=$link?>'">
                                                Play
                                            </span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span class="tsr-btn btnJoin" id="subscribe_modal" onclick="return false;">
                                                Play
                                            </span>
                                        <?php
                                    }
                                    ?>

                                </p>
                            </div>
                            <div class="clear"></div>
                        </a>
                        <?php
                    }
                    $stmt_select->close();
                    ?>
                </div>
            </div>
        </section>
        <br/>

        <br/>
        <!-- END SECTION LIST -->
    </main><!-- #main -->
</div><!-- #primary -->


