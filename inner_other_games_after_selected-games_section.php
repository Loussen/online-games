<section class="other-games">
    <div class="tsr-row maximize">
        <div class="col-6">
            <section class="most-played-games">
                <h3>Most Played Games</h3>
                <div class="tsr-row maximized">
                    <?php
                    foreach($result_most_played_games_arr as $row)
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
                                        <?php
                                        $link = (subscribe_check($db)==true) ? SITE_PATH."/play-game/".slugGenerator($row['g_name']) . '-' . $row['g_id'] : '';

                                        if(subscribe_check($db)==true)
                                        {
                                            ?>
                                            <span class="tsr-btn btnJoin" data-gameid="<?=$row['g_id']?>" id="play_link" style="cursor: pointer;" onclick="window.location = '<?=$link?>'">
                                                                        Play
                                                                    </span>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class="tsr-btn btnJoin" style="cursor: pointer;" id="subscribe_modal" onclick="return false;">
                                                                        Play
                                                                    </span>
                                            <?php
                                        }
                                        ?>
                                        <!--                                                            <p class="tsr-product-price">-->
                                        <!--                                                                <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnPlay" id="subscribe_modal">-->
                                        <!--                                                                    PLAY-->
                                        <!--                                                                </button>-->
                                        <!--                                                                <!--Subscribe Button-->
                                        <!--                                                            </p>-->
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
                    <section class="tsr-section-productAndService-listing tsr-color-white" style="background: #eee;">

                        <div class="tsr-container">
                            <div class="tsr-slides">
                                <?php
                                foreach($result_similar_games_arr as $row)
                                {
                                    ?>
                                    <div class="tsr-module-service ">
                                        <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($row['name']) . '-' . $row['auto_id']?>">
                                            <figure class="">
                                                <img src="<?=SITE_PATH?>/images/games/<?=$row['image_name']?>" style="height: 170px;">
                                            </figure>
                                            <div class="tsr-service-content">
                                                <header class="tsr-service-header"><?=$row['name']?></header>
                                            </div>
                                        </a>

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
                                            <span class="tsr-btn btnJoin" data-gameid="<?=$row['auto_id']?>" id="play_link" style="cursor: pointer;" onclick="window.location = '<?=$link?>'">
                                                                            Play
                                                                        </span>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <span class="tsr-btn btnJoin" style="cursor: pointer;" id="subscribe_modal" onclick="return false;">
                                                                            Play
                                                                        </span>
                                            <?php
                                        }
                                        ?>

                                        <!--                                                            <p class="tsr-product-price">-->
                                        <!--                                                                <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnPlay" id="subscribe_modal">-->
                                        <!--                                                                    PLAY-->
                                        <!--                                                                </button>-->
                                        <!--                                                                <!--Subscribe Button-->
                                        <!--                                                            </p>-->
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