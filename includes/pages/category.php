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
            </div>
        </div>
    </div>
</section>

<div id="primary" class="content-area">

    <main id="main" class="site-main" role="main">
        <section class="tsr-section-productAndService-listing tsr-color-gray">
            <div class="tsr-container">
                <div class="tsr-row" style="margin-bottom: 15px;">
                    <div class="col-2 no-padding">
                        <div style="padding: 10px;">
                        </div>

                        <section class="sidebar-filters">
                            <ul>
                                <li>
                                    <span class="title open">Genre</span>
                                    <ul>
                                        <?php
                                            foreach($result_all_categories_arr as $row)
                                            {
                                                $class_active = ($category_id==$row['auto_id']) ? 'active' : '';
                                                ?>
                                                <li>
                                                    <a class="<?=$class_active?>" href="<?=SITE_PATH?>/category/<?=slugGenerator($row['name']) . '-' . $row['auto_id']?>"><?=$row['name']?></a>
                                                </li>
                                                <?php
                                            }
                                        ?>
                                    </ul>
                                </li>
                            </ul>
                        </section>

                    </div>
                    <div class="col-10 no-padding">
                        <div style="padding: 10px;">
                        </div>
                        <section class="games-list">
                            <div class="tsr-container">
                                <?php
                                    foreach ($result_games_by_categories_arr as $row)
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
<!--                                            <p class="tsr-product-small-print">-->
<!--                                                <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnPlay" id="subscribe_modal">-->
<!--                                                    PLAY-->
<!--                                                </button><br>-->
<!--                                            </p>-->
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </section>
                        <?php
                            if($count_rows > $limit)
                            {
                                $show= 5;
                                ?>
                                <section class="pagination-azercell-container">
                                    <div class="tsr-container">
                                        <div class="tsr-pagination">
                                            <div class="tsr-center">
                                                <?php
                                                    if($page>1)
                                                    {
                                                        ?>
                                                        <a href="<?=SITE_PATH?>/category/<?=slugGenerator($current_category_name) . '-' . $current_category_id.'/'.($page-1)?>" class="tsr-dir-previous">&lt;</a>
                                                        <?php
                                                    }

                                                    for ($i = $page - $show; $i <= $page + $show; $i++)
                                                    {
                                                        if ($i > 0 && $i <= $max_page)
                                                        {
                                                            if ($i == $page)
                                                            {
                                                                ?>
                                                                <a href="javascript:void(0);" class="tsr-active"><?=$i?></a>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <a href="<?=SITE_PATH?>/category/<?=slugGenerator($current_category_name) . '-' . $current_category_id.'/'.$i?>"><?=$i?></a>
                                                                <?php
                                                            }
                                                        }
                                                    }

                                                    if ($page < $max_page)
                                                    {
                                                        ?>
                                                        <a href="<?=SITE_PATH?>/category/<?=slugGenerator($current_category_name) . '-' . $current_category_id.'/'.($page + 1)?>">&gt;</a>
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <section class="tsr-section-divider tsr-color-white">
            <header class="tsr-container">
            <span>
                Recommendation
            </span>
            </header>
        </section>

        <section class="tsr-section-carousel-listing">
            <div class="tsr-container" style="width: 732px; height: 567px;">
                <div class="tsr-slides">
                    <?php
                        foreach($result_reco_games_arr as $row)
                        {
                            ?>
                            <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($row['name']) . '-' . $row['auto_id']?>" class="tsr-module-product">
                                <figure class="tsr-product-image">
                                    <img src="<?=SITE_PATH?>/images/games/<?=$row['image_name']?>">
                                </figure>
                                <div class="tsr-product-content recomendation">
                                    <header class="tsr-product-header" style="height: 40px;">
                                        <?=$row['name']?>
                                    </header>
<!--                                    <p class="tsr-product-desc" style="height: 144px;">-->
<!--                                        --><?//=more_string(html_entity_decode($row['text']),120)?>
<!--                                    </p>-->

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
<!--                                    <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnDownload" id="subscribe_modal">-->
<!--                                        PLAY-->
<!--                                    </button>-->
                                </div>
                            </a>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </section>


    </main><!-- #main -->
</div>