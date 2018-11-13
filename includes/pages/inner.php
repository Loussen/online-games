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
                                    <!-- Arrow Navigator -->
                                    <span data-u="arrowleft" class="left-arrow" data-autocenter="2"></span>
                                    <span data-u="arrowright" class="right-arrow" data-autocenter="2"></span>
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
                                    <div class="col-6 maximized mobilemax">
                                        <div class="other-games-content">
                                            <div class="most-played-games-game">
                                                <a href="http://play.ucell.uz/online-games/top-games/5905876">
                                                    <div class="game-figure">
                                                        <img src="./inner_files/5905876_34.jpg">
                                                    </div>
                                                </a>
                                                <div class="most-played-games-game-content">
                                                    <a href="http://play.ucell.uz/online-games/top-games/5905876">
                                                        <div class="game-name">
                                                            Fruit Blade
                                                        </div>
                                                    </a>
                                                    <div class="download-most-played-games">
                                                        <button class="tsr-btn-download btnPlay" data-login="false"
                                                                data-postid="19" data-clubid="75112" data-catid="422130"
                                                                data-mediaid="5905876" data-view="422260  ">
                                                            PLAY
                                                        </button>
                                                    </div>
                                                    <div class="game-arrow">
                                                        <img src="./inner_files/arrow.png_">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 maximized mobilemax">
                                        <div class="other-games-content">
                                            <div class="most-played-games-game">
                                                <a href="http://play.ucell.uz/online-games/top-games/5657966">
                                                    <div class="game-figure">
                                                        <img src="./inner_files/5657966_34.jpg">
                                                    </div>
                                                </a>
                                                <div class="most-played-games-game-content">
                                                    <a href="http://play.ucell.uz/online-games/top-games/5657966">
                                                        <div class="game-name">
                                                            Sean The Miner
                                                        </div>
                                                    </a>
                                                    <div class="download-most-played-games">
                                                        <button class="tsr-btn-download btnPlay" data-login="false"
                                                                data-postid="19" data-clubid="75112" data-catid="422130"
                                                                data-mediaid="5657966" data-view="422260  ">
                                                            PLAY
                                                        </button>
                                                    </div>
                                                    <div class="game-arrow">
                                                        <img src="./inner_files/arrow.png_">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 maximized mobilemax">
                                        <div class="other-games-content">
                                            <div class="most-played-games-game">
                                                <a href="http://play.ucell.uz/online-games/top-games/3456094">
                                                    <div class="game-figure">
                                                        <img src="./inner_files/3456094_34.jpg">
                                                    </div>
                                                </a>
                                                <div class="most-played-games-game-content">
                                                    <a href="http://play.ucell.uz/online-games/top-games/3456094">
                                                        <div class="game-name">
                                                            Feelingz
                                                        </div>
                                                    </a>
                                                    <div class="download-most-played-games">
                                                        <button class="tsr-btn-download btnPlay" data-login="false"
                                                                data-postid="19" data-clubid="75112" data-catid="422130"
                                                                data-mediaid="3456094" data-view="422260  ">
                                                            PLAY
                                                        </button>
                                                    </div>
                                                    <div class="game-arrow">
                                                        <img src="./inner_files/arrow.png_">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 maximized mobilemax">
                                        <div class="other-games-content">
                                            <div class="most-played-games-game">
                                                <a href="http://play.ucell.uz/online-games/top-games/5905950">
                                                    <div class="game-figure">
                                                        <img src="./inner_files/5905950_34.jpg">
                                                    </div>
                                                </a>
                                                <div class="most-played-games-game-content">
                                                    <a href="http://play.ucell.uz/online-games/top-games/5905950">
                                                        <div class="game-name">
                                                            Guess The Soccer Star
                                                        </div>
                                                    </a>
                                                    <div class="download-most-played-games">
                                                        <button class="tsr-btn-download btnPlay" data-login="false"
                                                                data-postid="19" data-clubid="75112" data-catid="422130"
                                                                data-mediaid="5905950" data-view="422260  ">
                                                            PLAY
                                                        </button>
                                                    </div>
                                                    <div class="game-arrow">
                                                        <img src="./inner_files/arrow.png_">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 maximized mobilemax">
                                        <div class="other-games-content">
                                            <div class="most-played-games-game">
                                                <a href="http://play.ucell.uz/online-games/top-games/3456102">
                                                    <div class="game-figure">
                                                        <img src="./inner_files/3456102_34.jpg">
                                                    </div>
                                                </a>
                                                <div class="most-played-games-game-content">
                                                    <a href="http://play.ucell.uz/online-games/top-games/3456102">
                                                        <div class="game-name">
                                                            Zombie Taps
                                                        </div>
                                                    </a>
                                                    <div class="download-most-played-games">
                                                        <button class="tsr-btn-download btnPlay" data-login="false"
                                                                data-postid="19" data-clubid="75112" data-catid="422130"
                                                                data-mediaid="3456102" data-view="422260  ">
                                                            PLAY
                                                        </button>
                                                    </div>
                                                    <div class="game-arrow">
                                                        <img src="./inner_files/arrow.png_">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 maximized mobilemax">
                                        <div class="other-games-content">
                                            <div class="most-played-games-game">
                                                <a href="http://play.ucell.uz/online-games/top-games/5905952">
                                                    <div class="game-figure">
                                                        <img src="./inner_files/5905952_34.jpg">
                                                    </div>
                                                </a>
                                                <div class="most-played-games-game-content">
                                                    <a href="http://play.ucell.uz/online-games/top-games/5905952">
                                                        <div class="game-name">
                                                            Robots Vs Aliens
                                                        </div>
                                                    </a>
                                                    <div class="download-most-played-games">
                                                        <button class="tsr-btn-download btnPlay" data-login="false"
                                                                data-postid="19" data-clubid="75112" data-catid="422130"
                                                                data-mediaid="5905952" data-view="422260  ">
                                                            PLAY
                                                        </button>
                                                    </div>
                                                    <div class="game-arrow">
                                                        <img src="./inner_files/arrow.png_">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 maximized mobilemax">
                                        <div class="other-games-content">
                                            <div class="most-played-games-game">
                                                <a href="http://play.ucell.uz/online-games/top-games/5905912">
                                                    <div class="game-figure">
                                                        <img src="./inner_files/5905912_34.jpg">
                                                    </div>
                                                </a>
                                                <div class="most-played-games-game-content">
                                                    <a href="http://play.ucell.uz/online-games/top-games/5905912">
                                                        <div class="game-name">
                                                            Space Chasers
                                                        </div>
                                                    </a>
                                                    <div class="download-most-played-games">
                                                        <button class="tsr-btn-download btnPlay" data-login="false"
                                                                data-postid="19" data-clubid="75112" data-catid="422130"
                                                                data-mediaid="5905912" data-view="422260  ">
                                                            PLAY
                                                        </button>
                                                    </div>
                                                    <div class="game-arrow">
                                                        <img src="./inner_files/arrow.png_">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 maximized mobilemax">
                                        <div class="other-games-content">
                                            <div class="most-played-games-game">
                                                <a href="http://play.ucell.uz/online-games/top-games/5905884">
                                                    <div class="game-figure">
                                                        <img src="./inner_files/5905884_34.jpg">
                                                    </div>
                                                </a>
                                                <div class="most-played-games-game-content">
                                                    <a href="http://play.ucell.uz/online-games/top-games/5905884">
                                                        <div class="game-name">
                                                            Flappy Lamp
                                                        </div>
                                                    </a>
                                                    <div class="download-most-played-games">
                                                        <button class="tsr-btn-download btnPlay" data-login="false"
                                                                data-postid="19" data-clubid="75112" data-catid="422130"
                                                                data-mediaid="5905884" data-view="422260  ">
                                                            PLAY
                                                        </button>
                                                    </div>
                                                    <div class="game-arrow">
                                                        <img src="./inner_files/arrow.png_">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 maximized mobilemax">
                                        <div class="other-games-content">
                                            <div class="most-played-games-game">
                                                <a href="http://play.ucell.uz/online-games/top-games/4972274">
                                                    <div class="game-figure">
                                                        <img src="./inner_files/4972274_34.jpg">
                                                    </div>
                                                </a>
                                                <div class="most-played-games-game-content">
                                                    <a href="http://play.ucell.uz/online-games/top-games/4972274">
                                                        <div class="game-name">
                                                            What's My Icon Game
                                                        </div>
                                                    </a>
                                                    <div class="download-most-played-games">
                                                        <button class="tsr-btn-download btnPlay" data-login="false"
                                                                data-postid="19" data-clubid="75112" data-catid="422130"
                                                                data-mediaid="4972274" data-view="422260  ">
                                                            PLAY
                                                        </button>
                                                    </div>
                                                    <div class="game-arrow">
                                                        <img src="./inner_files/arrow.png_">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 maximized mobilemax">
                                        <div class="other-games-content">
                                            <div class="most-played-games-game">
                                                <a href="http://play.ucell.uz/online-games/top-games/4015306">
                                                    <div class="game-figure">
                                                        <img src="./inner_files/4015306_34.jpg">
                                                    </div>
                                                </a>
                                                <div class="most-played-games-game-content">
                                                    <a href="http://play.ucell.uz/online-games/top-games/4015306">
                                                        <div class="game-name">
                                                            The Saloon
                                                        </div>
                                                    </a>
                                                    <div class="download-most-played-games">
                                                        <button class="tsr-btn-download btnPlay" data-login="false"
                                                                data-postid="19" data-clubid="75112" data-catid="422130"
                                                                data-mediaid="4015306" data-view="422260  ">
                                                            PLAY
                                                        </button>
                                                    </div>
                                                    <div class="game-arrow">
                                                        <img src="./inner_files/arrow.png_">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 maximized mobilemax">
                                        <div class="other-games-content">
                                            <div class="most-played-games-game">
                                                <a href="http://play.ucell.uz/online-games/top-games/5905946">
                                                    <div class="game-figure">
                                                        <img src="./inner_files/5905946_34.jpg">
                                                    </div>
                                                </a>
                                                <div class="most-played-games-game-content">
                                                    <a href="http://play.ucell.uz/online-games/top-games/5905946">
                                                        <div class="game-name">
                                                            Temple Crossing
                                                        </div>
                                                    </a>
                                                    <div class="download-most-played-games">
                                                        <button class="tsr-btn-download btnPlay" data-login="false"
                                                                data-postid="19" data-clubid="75112" data-catid="422130"
                                                                data-mediaid="5905946" data-view="422260  ">
                                                            PLAY
                                                        </button>
                                                    </div>
                                                    <div class="game-arrow">
                                                        <img src="./inner_files/arrow.png_">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 maximized mobilemax">
                                        <div class="other-games-content">
                                            <div class="most-played-games-game">
                                                <a href="http://play.ucell.uz/online-games/top-games/5905932">
                                                    <div class="game-figure">
                                                        <img src="./inner_files/5905932_34.jpg">
                                                    </div>
                                                </a>
                                                <div class="most-played-games-game-content">
                                                    <a href="http://play.ucell.uz/online-games/top-games/5905932">
                                                        <div class="game-name">
                                                            Candy Slide
                                                        </div>
                                                    </a>
                                                    <div class="download-most-played-games">
                                                        <button class="tsr-btn-download btnPlay" data-login="false"
                                                                data-postid="19" data-clubid="75112" data-catid="422130"
                                                                data-mediaid="5905932" data-view="422260  ">
                                                            PLAY
                                                        </button>
                                                    </div>
                                                    <div class="game-arrow">
                                                        <img src="./inner_files/arrow.png_">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tsr-row maximized">
                                    <div class="col-12">
                                        <a href="http://play.ucell.uz/online-games/top-games"
                                           class="tsr-btn-view-all"><span>View all<i>(29)</i></span></a>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-6">
                            <section class="similar-games">
                                <h3>Similar Games</h3>

                                <div class="other-games-content">
                                    <section class="tsr-section-productAndService-listing tsr-color-white">

                                        <div class="tsr-container">
                                            <div class="tsr-slides">
                                                <div class="tsr-module-service ">
                                                    <a href="http://play.ucell.uz/online-games/sports/5905960">
                                                        <figure class="">
                                                            <img src="./inner_files/5905960_42.jpg">
                                                        </figure>
                                                        <div class="tsr-service-content">
                                                            <header class="tsr-service-header">Soccer Pro</header>
                                                        </div>
                                                    </a>

                                                    <p>

                                                        <img class="rating-star" src="./inner_files/filled_star.png">
                                                        <img class="rating-star" src="./inner_files/filled_star.png">
                                                        <img class="rating-star" src="./inner_files/filled_star.png">

                                                        <img class="rating-star" src="./inner_files/star.png">
                                                        <img class="rating-star" src="./inner_files/star.png">
                                                    </p>

                                                    <p class="tsr-product-price">
                                                        <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnPlay"
                                                                data-login="false" data-postid="19" data-clubid="75112"
                                                                data-catid="422134" data-mediaid="5905960"
                                                                data-view="422260  ">
                                                            PLAY
                                                        </button>


                                                        <!--Subscribe Button-->
                                                    </p>
                                                    <p class="tsr-product-small-print">
                                                <span class="tsr-btn btnJoin" data-clubid="" data-login="false"
                                                      data-gencoluserlogin="Genc OL tariff users subscribe with 50% special discount! 1.00 AZN/week for EA and Java Games and 0.60 AZN/week for Online Games (3 games download)."
                                                      data-gencoluser=" ">
                                                      Subscribe                                        </span>
                                                    </p>
                                                </div>
                                                <div class="tsr-module-service ">
                                                    <a href="http://play.ucell.uz/online-games/sports/4972278">
                                                        <figure class="">
                                                            <img src="./inner_files/4972278_42.jpg">
                                                        </figure>
                                                        <div class="tsr-service-content">
                                                            <header class="tsr-service-header">Super Boxing</header>
                                                        </div>
                                                    </a>

                                                    <p>

                                                        <img class="rating-star" src="./inner_files/filled_star.png">
                                                        <img class="rating-star" src="./inner_files/filled_star.png">
                                                        <img class="rating-star" src="./inner_files/filled_star.png">

                                                        <img class="rating-star" src="./inner_files/star.png">
                                                        <img class="rating-star" src="./inner_files/star.png">
                                                    </p>

                                                    <p class="tsr-product-price">
                                                        <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnPlay"
                                                                data-login="false" data-postid="19" data-clubid="75112"
                                                                data-catid="422134" data-mediaid="4972278"
                                                                data-view="422260  ">
                                                            PLAY
                                                        </button>


                                                        <!--Subscribe Button-->
                                                    </p>
                                                    <p class="tsr-product-small-print">
                                                <span class="tsr-btn btnJoin" data-clubid="" data-login="false"
                                                      data-gencoluserlogin="Genc OL tariff users subscribe with 50% special discount! 1.00 AZN/week for EA and Java Games and 0.60 AZN/week for Online Games (3 games download)."
                                                      data-gencoluser=" ">
                                                      Subscribe                                        </span>
                                                    </p>
                                                </div>
                                                <div class="tsr-module-service ">
                                                    <a href="http://play.ucell.uz/online-games/sports/5905880">
                                                        <figure class="">
                                                            <img src="./inner_files/5905880_42.jpg">
                                                        </figure>
                                                        <div class="tsr-service-content">
                                                            <header class="tsr-service-header">Touchdown Pro</header>
                                                        </div>
                                                    </a>

                                                    <p>

                                                        <img class="rating-star" src="./inner_files/filled_star.png">
                                                        <img class="rating-star" src="./inner_files/filled_star.png">
                                                        <img class="rating-star" src="./inner_files/filled_star.png">

                                                        <img class="rating-star" src="./inner_files/star.png">
                                                        <img class="rating-star" src="./inner_files/star.png">
                                                    </p>

                                                    <p class="tsr-product-price">
                                                        <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnPlay"
                                                                data-login="false" data-postid="19" data-clubid="75112"
                                                                data-catid="422134" data-mediaid="5905880"
                                                                data-view="422260  ">
                                                            PLAY
                                                        </button>


                                                        <!--Subscribe Button-->
                                                    </p>
                                                    <p class="tsr-product-small-print">
                                                <span class="tsr-btn btnJoin" data-clubid="" data-login="false"
                                                      data-gencoluserlogin="Genc OL tariff users subscribe with 50% special discount! 1.00 AZN/week for EA and Java Games and 0.60 AZN/week for Online Games (3 games download)."
                                                      data-gencoluser=" ">
                                                      Subscribe                                        </span>
                                                    </p>
                                                </div>
                                                <div class="tsr-module-service ">
                                                    <a href="http://play.ucell.uz/online-games/sports/5657978">
                                                        <figure class="">
                                                            <img src="./inner_files/5657978_42.jpg">
                                                        </figure>
                                                        <div class="tsr-service-content">
                                                            <header class="tsr-service-header">Fail Circle</header>
                                                        </div>
                                                    </a>

                                                    <p>

                                                        <img class="rating-star" src="./inner_files/filled_star.png">
                                                        <img class="rating-star" src="./inner_files/filled_star.png">
                                                        <img class="rating-star" src="./inner_files/filled_star.png">

                                                        <img class="rating-star" src="./inner_files/star.png">
                                                        <img class="rating-star" src="./inner_files/star.png">
                                                    </p>

                                                    <p class="tsr-product-price">
                                                        <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnPlay"
                                                                data-login="false" data-postid="19" data-clubid="75112"
                                                                data-catid="422134" data-mediaid="5657978"
                                                                data-view="422260  ">
                                                            PLAY
                                                        </button>


                                                        <!--Subscribe Button-->
                                                    </p>
                                                    <p class="tsr-product-small-print">
                                                <span class="tsr-btn btnJoin" data-clubid="" data-login="false"
                                                      data-gencoluserlogin="Genc OL tariff users subscribe with 50% special discount! 1.00 AZN/week for EA and Java Games and 0.60 AZN/week for Online Games (3 games download)."
                                                      data-gencoluser=" ">
                                                      Subscribe                                        </span>
                                                    </p>
                                                </div>
                                                <div class="tsr-module-service ">
                                                    <a href="http://play.ucell.uz/online-games/sports/5657956">
                                                        <figure class="">
                                                            <img src="./inner_files/5657956_42.jpg">
                                                        </figure>
                                                        <div class="tsr-service-content">
                                                            <header class="tsr-service-header">Football Tricks 14
                                                            </header>
                                                        </div>
                                                    </a>

                                                    <p>

                                                        <img class="rating-star" src="./inner_files/filled_star.png">
                                                        <img class="rating-star" src="./inner_files/filled_star.png">
                                                        <img class="rating-star" src="./inner_files/filled_star.png">

                                                        <img class="rating-star" src="./inner_files/star.png">
                                                        <img class="rating-star" src="./inner_files/star.png">
                                                    </p>

                                                    <p class="tsr-product-price">
                                                        <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnPlay"
                                                                data-login="false" data-postid="19" data-clubid="75112"
                                                                data-catid="422134" data-mediaid="5657956"
                                                                data-view="422260  ">
                                                            PLAY
                                                        </button>


                                                        <!--Subscribe Button-->
                                                    </p>
                                                    <p class="tsr-product-small-print">
                                                <span class="tsr-btn btnJoin" data-clubid="" data-login="false"
                                                      data-gencoluserlogin="Genc OL tariff users subscribe with 50% special discount! 1.00 AZN/week for EA and Java Games and 0.60 AZN/week for Online Games (3 games download)."
                                                      data-gencoluser=" ">
                                                      Subscribe                                        </span>
                                                    </p>
                                                </div>
                                                <div class="tsr-module-service ">
                                                    <a href="http://play.ucell.uz/online-games/sports/5905944">
                                                        <figure class="">
                                                            <img src="./inner_files/5905944_42.jpg">
                                                        </figure>
                                                        <div class="tsr-service-content">
                                                            <header class="tsr-service-header">Pool Game</header>
                                                        </div>
                                                    </a>

                                                    <p>

                                                        <img class="rating-star" src="./inner_files/filled_star.png">
                                                        <img class="rating-star" src="./inner_files/filled_star.png">
                                                        <img class="rating-star" src="./inner_files/filled_star.png">

                                                        <img class="rating-star" src="./inner_files/star.png">
                                                        <img class="rating-star" src="./inner_files/star.png">
                                                    </p>

                                                    <p class="tsr-product-price">
                                                        <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnPlay"
                                                                data-login="false" data-postid="19" data-clubid="75112"
                                                                data-catid="422134" data-mediaid="5905944"
                                                                data-view="422260  ">
                                                            PLAY
                                                        </button>


                                                        <!--Subscribe Button-->
                                                    </p>
                                                    <p class="tsr-product-small-print">
                                                <span class="tsr-btn btnJoin" data-clubid="" data-login="false"
                                                      data-gencoluserlogin="Genc OL tariff users subscribe with 50% special discount! 1.00 AZN/week for EA and Java Games and 0.60 AZN/week for Online Games (3 games download)."
                                                      data-gencoluser=" ">
                                                      Subscribe                                        </span>
                                                    </p>
                                                </div>
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


