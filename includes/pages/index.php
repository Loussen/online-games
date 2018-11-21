<main class="wrap">
    <script type="text/javascript">var lsjQuery = jQuery;</script>
    <script type="text/javascript"> lsjQuery(document).ready(function () {
            if (typeof lsjQuery.fn.layerSlider == "undefined") {
                lsShowNotice('layerslider_7', 'jquery');
            } else {
                lsjQuery("#layerslider_7").layerSlider({
                    responsive: false,
                    responsiveUnder: 940,
                    skin: 'lightskin',
                    skinsPath: 'assets/skins/'
                })
            }
        }); </script>
    <div class="ls-wp-fullwidth-container">
        <div class="ls-wp-fullwidth-helper">
            <div id="layerslider_7" class="ls-wp-container" style="width:100%;height:480px;margin:0 auto;margin-bottom: 0px;">
                <?php
                    $active = 1;

                    if(!$cache->isCached('slider'))
                    {
                        $stmt_select = mysqli_prepare($db,"SELECT 
                                                              `image_name`,
                                                              `url` 
                                                              FROM `slider`
                                                              WHERE `lang_id`=(?) and `active`=(?) 
                                                              order by `order_number` asc");
                        $stmt_select->bind_param('ii', $main_lang,$active_status);
                        $stmt_select->execute();
                        $result = $stmt_select->get_result();

                        $result_slider_arr = [];
                        while($row=$result->fetch_assoc())
                        {
                            $result_slider_arr[] = $row;
                        }

                        $cache->store('slider',$result_slider_arr, 40);
                    }
                    else
                    {
                        $result_slider_arr = $cache->retrieve('slider');
                    }


                    foreach($result_slider_arr as $row)
                    {
                        ?>
                        <div class="ls-slide" data-ls=" transition2d: all;">
                            <img src="<?=SITE_PATH?>/assets/img/blank.gif"
                                 data-src="<?=SITE_PATH?>/images/slider/<?=$row['image_name']?>"
                                 class="ls-bg" alt="Slide background"/>
                            <a href="<?=$row['url']?>" target="_blank" class="ls-link"></a>
                        </div>
                        <?php
                    }

//                    $stmt_select->close();
                ?>
            </div>
        </div>
    </div>
    <!-- SECTION LIST -->
    <section class="tsr-section-divider tsr-color-white">
        <header class="tsr-container">
            <span>Top Games</span>
        </header>
    </section>

    <section class="tsr-section-carousel-listing front-categories">
        <div class="tsr-container">
            <div class="tsr-slides">
                <?php
                    $topgame_status = 1;

                    if(!$cache->isCached('top_games'))
                    {
                        $stmt_select = mysqli_prepare($db,
                            "SELECT 
                                `games`.`name` as `g_name`,
                                `games`.`image_name` as `g_image_name`,
                                `games`.`auto_id` as `g_id`,
                                `games`.`star` as `g_star`
                                FROM `games`
                                WHERE `games`.`lang_id`=(?) and `games`.`active`=(?) and `games`.`topgame`=(?) and `games`.`recogame`=0
                                order by `games`.`order_number` asc");
                        $stmt_select->bind_param('iii', $main_lang,$active_status,$topgame_status);
                        $stmt_select->execute();
                        $result = $stmt_select->get_result();

                        $result_top_games_arr = [];
                        while($row=$result->fetch_assoc())
                        {
                            $result_top_games_arr[] = $row;
                        }

                        $cache->store('top_games',$result_top_games_arr, 40);
                    }
                    else
                    {
                        $result_top_games_arr = $cache->retrieve('top_games');
                    }

                    foreach($result_top_games_arr as $row)
                    {
                        ?>
                        <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($row['g_name']) . '-' . $row['g_id']?>" class="tsr-module-product">
                            <figure class="tsr-product-image" style="text-align:center;">
                                <img src="<?=SITE_PATH?>/images/games/<?=$row['g_image_name']?>"
                                     style="max-width:250px; width: 100%;"/>
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
                                <!--                            <p class="tsr-product-pric" style="height: 20px;color: #0083be; font-weight:bold;">
                                                                                                     AZN                                                            </p>-->
                                <!--Play Button-->
                                    <?php
                                        $link = (subscribe_check($db)==true) ? SITE_PATH."/play-game/".slugGenerator($row['g_name']) . '-' . $row['g_id'] : '';

                                        if(subscribe_check($db)==true)
                                        {
                                            ?>
                                            <span class="tsr-btn btnJoin" data-gameid="<?=$row['g_id']?>" id="play_link" onclick="window.location = '<?=$link?>'">
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
<!--                                <p class="tsr-product-small-print"><br/>-->
<!--                                    <span class="tsr-btn btnJoin" id="subscribe_modal" onclick="return false;">-->
<!--                                    Play-->
<!--                                </span>-->
                                </p>
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
                    $stmt_select = mysqli_prepare($db,
                        "SELECT
                                    `play_game`.`id`
                                    FROM `play_game`
                                    LEFT JOIN `games` on `games`.`auto_id`=`play_game`.`games_id`
                                    WHERE `games`.`lang_id`=(?) and `games`.`active`=(?)
                                    GROUP BY `play_game`.`games_id`");
                    $stmt_select->bind_param('ii', $main_lang,$active_status);
                    $stmt_select->execute();
                    $result = $stmt_select->get_result();
                    $count_games = mysqli_num_rows($result);

                    if($count_games>0)
                    {
                        if(!$cache->isCached('most_played_games_index'))
                        {
                            $stmt_select = mysqli_prepare($db,
                                "SELECT 
                                `games`.`name` as `g_name`,
                                `games`.`image_name` as `g_image_name`,
                                `games`.`auto_id` as `g_id`,
                                `games`.`star` as `g_star`,
                                sum(`play_game`.`count`) as `play_count`
                                FROM `play_game`
                                LEFT JOIN `games` on `games`.`auto_id`=`play_game`.`games_id`
                                WHERE `games`.`lang_id`=(?) and `games`.`active`=(?)
                                GROUP BY `play_game`.`games_id` order by `play_count` desc");
                            $stmt_select->bind_param('ii', $main_lang,$active_status);
                            $stmt_select->execute();
                            $result = $stmt_select->get_result();

                            $result_most_played_games_index_arr = [];
                            while($row=$result->fetch_assoc())
                            {
                                $result_most_played_games_index_arr[] = $row;
                            }

                            $cache->store('most_played_games_index',$result_most_played_games_index_arr, 40);
                        }
                        else
                        {
                            $result_most_played_games_index_arr = $cache->retrieve('most_played_games_index');
                        }
                    }
                    else
                    {
                        if(!$cache->isCached('most_played_games_index'))
                        {
                            $stmt_select = mysqli_prepare($db,
                                "SELECT 
                                `games`.`name` as `g_name`,
                                `games`.`image_name` as `g_image_name`,
                                `games`.`auto_id` as `g_id`,
                                `games`.`star` as `g_star`
                                FROM `games`
                                WHERE `games`.`lang_id`=(?) and `games`.`active`=(?) and `games`.`topgame`=0 and `games`.`recogame`=1
                                order by `games`.`order_number` asc");
                            $stmt_select->bind_param('ii', $main_lang,$active_status);
                            $stmt_select->execute();
                            $result = $stmt_select->get_result();

                            $result_most_played_games_index_arr = [];
                            while($row=$result->fetch_assoc())
                            {
                                $result_most_played_games_index_arr[] = $row;
                            }

                            $cache->store('most_played_games_index',$result_most_played_games_index_arr, 40);
                        }
                        else
                        {
                            $result_most_played_games_index_arr = $cache->retrieve('most_played_games_index');
                        }
                    }

                    foreach ($result_most_played_games_index_arr as $row)
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

</main>