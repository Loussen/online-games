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
                                            while($row=$result_all_categories->fetch_assoc())
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
                                    while($row=$result_games_by_categories->fetch_assoc())
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
                                                <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnPlay" data-login="false" data-postid="19" data-clubid="75112" data-catid="422130" data-mediaid="5905876" data-video="http://timwe.cachefly.net/webapps/fruit-blade-timwe_1/index.html" data-view="422260  ">
                                                    PLAY                        </button><br>
                                            </p>
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
                        while($row=$result_games_reco->fetch_assoc())
                        {
                            ?>
                            <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($row['name']) . '-' . $row['auto_id']?>">
                                <figure class="tsr-product-image">
                                    <img src="<?=SITE_PATH?>/images/games/<?=$row['image_name']?>">
                                </figure>
                                <div class="tsr-product-content recomendation">
                                    <header class="tsr-product-header" style="height: 40px;"><?=$row['name']?></header>
                                    <p class="tsr-product-desc" style="height: 144px;">
                                        <?=more_string(html_entity_decode($row['text']),195)?>
                                    </p>

                                    <button class="tsr-btn tsr-btn-purple tsr-btn-100 btnDownload" data-login="false" data-postid="19" data-clubid="75112" data-catid="422130" data-mediaid="5657966">
                                        PLAY
                                    </button>
                                    </p>
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