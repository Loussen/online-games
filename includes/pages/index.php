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

                    $stmt_select = mysqli_prepare($db,"SELECT 
                                                              `image_name`,
                                                              `url` 
                                                              FROM `slider`
                                                              WHERE `lang_id`=(?) and `active`=(?) 
                                                              order by `order_number` asc");
                    $stmt_select->bind_param('ii', $main_lang,$active_status);
                    $stmt_select->execute();
                    $result = $stmt_select->get_result();

                    while($row = $result->fetch_assoc())
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

                    $stmt_select->close();
                ?>
            </div>
        </div>
    </div>
    <!-- SECTION LIST -->
    <section class="tsr-section-divider tsr-color-white">
        <header class="tsr-container">
            <span>Top Weekly</span>
        </header>
    </section>

    <section class="tsr-section-carousel-listing front-categories">
        <div class="tsr-container">
            <div class="tsr-slides">
                <?php
                    $stmt_select = mysqli_prepare($db,
                        "SELECT 
                                `games`.`name` as `g_name`,
                                `games`.`image_name` as `g_image_name`,
                                `games`.`auto_id` as `g_id`,
                                `categories`.`auto_id` as `c_id`,
                                `categories`.`name` as `c_name` 
                                FROM `games`
                                LEFT JOIN `categories` on `games`.`category_id`=`categories`.`auto_id`
                                WHERE `games`.`lang_id`=(?) and `games`.`active`=(?) and `categories`.`lang_id`=(?) and `categories`.`active`=(?)
                                order by `games`.`order_number` asc");
                    $stmt_select->bind_param('iiii', $main_lang,$active_status,$main_lang,$active_status);
                    $stmt_select->execute();
                    $result = $stmt_select->get_result();

                    while($row = $result->fetch_assoc())
                    {
                        ?>
                        <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($row['c_name']) . '-' . $row['c_id']?>/<?=slugGenerator($row['g_name']) . '-' . $row['g_id']?>" class="tsr-module-product">
                            <figure class="tsr-product-image" style="text-align:center;">
                                <img src="<?=SITE_PATH?>/images/games/<?=$row['g_image_name']?>"
                                     style="max-width:250px; width: 100%;"/>
                            </figure>
                            <div class="tsr-product-content">
                                <header class="tsr-product-header"><?=$row['g_name']?></header>
                                <!--                            <p class="tsr-product-pric" style="height: 20px;color: #0083be; font-weight:bold;">
                                                                                                     AZN                                                            </p>-->
                                <!--Play Button-->
                                <p class="tsr-product-small-print"><br/>
                                    <span class="tsr-btn btnJoin"
                                          data-clubid="75112"
                                          data-login="false"
                                          data-gencoluserlogin="Genc OL tariff users subscribe with 50% special discount! 1.00 AZN/week for EA and Java Games and 0.60 AZN/week for Online Games (3 games download)."
                                          data-gencoluser=" ">
                                    Play
                                </span>
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
    <section class="tsr-section-divider tsr-color-white">
        <header class="tsr-container">
            <span>Top Java Games</span>
        </header>
    </section>

    <section class="tsr-section-carousel-listing front-categories">
        <div class="tsr-container">
            <div class="tsr-slides">
                <?php
                    $stmt_select = mysqli_prepare($db,
                        "SELECT 
                                    `games`.`name` as `g_name`,
                                    `games`.`image_name` as `g_image_name`,
                                    `games`.`auto_id` as `g_id`,
                                    `categories`.`auto_id` as `c_id`,
                                    `categories`.`name` as `c_name` 
                                    FROM `games`
                                    LEFT JOIN `categories` on `games`.`category_id`=`categories`.`auto_id`
                                    WHERE `games`.`lang_id`=(?) and `games`.`active`=(?) and `categories`.`lang_id`=(?)
                                    order by `games`.`order_number` asc");
                    $stmt_select->bind_param('iii', $main_lang,$active,$main_lang);
                    $stmt_select->execute();
                    $result = $stmt_select->get_result();

                    while($row = $result->fetch_assoc())
                    {
                        ?>
                        <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($row['c_name']) . '-' . $row['c_id']?>/<?=slugGenerator($row['g_name']) . '-' . $row['g_id']?>" class="tsr-module-product">
                            <figure class="tsr-product-image" style="text-align:center;">
                                <img src="<?=SITE_PATH?>/images/games/<?=$row['g_image_name']?>"
                                     style="max-width:250px; width: 100%;"/>
                            </figure>
                            <div class="tsr-product-content">
                                <header class="tsr-product-header"><?=$row['g_name']?></header>
                                <!--                            <p class="tsr-product-pric" style="height: 20px;color: #0083be; font-weight:bold;">
                                                                                                     AZN                                                            </p>-->
                                <!--Play Button-->
                                <p class="tsr-product-small-print"><br/>
                                    <span class="tsr-btn btnJoin"
                                          data-clubid="75112"
                                          data-login="false"
                                          data-gencoluserlogin="Genc OL tariff users subscribe with 50% special discount! 1.00 AZN/week for EA and Java Games and 0.60 AZN/week for Online Games (3 games download)."
                                          data-gencoluser=" ">
                                    Play
                                </span>
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