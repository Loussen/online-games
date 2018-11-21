<section class="tsr-row">
    <div class="breadcrumbs">
        <div class="tsr-container">
            <div class="col-12">
                <a href="<?=SITE_PATH?>">Homepage</a>
                <!--<a href="">Home</a>-->
                <span class="ts-icon-breadcrumb-arrow"></span>
                <span class="bread-item-name ">Search</span>
                <!--<a href="">Home</a>-->
                <span class="ts-icon-breadcrumb-arrow"></span>
                <span class="bread-item-name bold"><?=$search?></span>
            </div>
        </div>
    </div>
</section>

<div id="primary" class="content-area">

    <main id="main" class="site-main" role="main">
        <div class="tsr-container">
            <div class="tsr-row">
                <div class="col-full no-padding">
                    <section class="games-list">
                        <div class="tsr-container">
                            <?php
                                if($count_games>0)
                                {
                                    while($row=$result_search->fetch_assoc())
                                    {
                                        ?>
                                        <div class="tsr-module-product listgames">
                                            <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($row['name']) . '-' . $row['auto_id']?>">
                                                <figure class="tsr-product-image">
                                                    <img src="<?=SITE_PATH?>/images/games/<?=$row['image_name']?>">
                                                </figure>
                                                <div class="tsr-product-content">
                                                    <header class="tsr-product-header"><?=$row['name']?></header>
                                                </div>
                                            </a>

                                            <p class="tsr-product-small-print">
<!--                                                <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnPlay" id="subscribe_modal">-->
<!--                                                    PLAY-->
<!--                                                </button><br>-->

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
                                            </p>
                                        </div>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <main id="main" class="site-main" role="main">
                                        <section class="tsr-section-divider">
                                            <header class="tsr-container">
                                            <span>
                                                Search results for "<?=$search?>"
                                            </span>
                                            </header>
                                        </section>

                                        <div class="tsr-container">
                                            <div class="tsr-row">
                                                <div class="col-full">
                                                    <h3>Your search returned no results</h3>
                                                    <h5>Search suggestions</h5>
                                                    <ul style="line-height:24px;margin: 20px 0; list-style-type: none;">
                                                        <li>- Check your spelling</li>
                                                        <li>- Try more general words</li>
                                                        <li>- Try different words with similar meaning</li>
                                                        <li>- Search term with at least 3 characters</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </main>
                                    <?php
                                }
                            ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>

    </main><!-- #main -->
</div>