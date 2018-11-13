<div id="index">
    <div class="headerWebContainer">
        <section class="tsr-section-header">
            <div class="tsr-header-global">
                <div class="tsr-container">
                    <nav class="tsr-global-left">
                        <menu class="" id="mobileLanguageSelectorDrop">
                            <li style="width:100%;" class="">
                                <a style="width:100%;" data-token="uz" class="mobileLanguageSelectorElement" href="http://play.ucell.uz/asosiy">Uzbek</a>
                            </li>
                            <li style="width:100%;" class="">
                                <a style="width:100%;" data-token="ru" class="mobileLanguageSelectorElement" href="http://play.ucell.uz">Russian</a>
                            </li>
                            <li style="width:100%;" class="is-choosen">
                                <a style="width:100%;" data-token="en" class="mobileLanguageSelectorElement" href="#">English</a>
                            </li>
                            <li class="tsr-btn-arrow-mobile"></li>
                        </menu>
                    </nav>

                    <nav class="tsr-global-right">
                        <menu>
                            <li class="tsr-extra">
                                <span class="label">
<!--                                    <a href="javascript:void(0);" onclick="widgets_subscription.setState({visible: true, fstmodal: 'loginWelcome', tarifmessage: 'Genc OL tariff users subscribe with 50% special discount! 1.00 AZN/week for EA and Java Games and 0.60 AZN/week for Online Games (3 games download).'})">Login</a>-->
                                    <a href="javascript:void(0);" id="login_modal" data-toggle="modal" data-target="#login-modal">Login</a>
                                </span>
                            </li>
                            <li class="tsr-extra">
                                <div class="select-container">
                                    <select id="azercell_language_selector">
                                        <option data-token="uz" value="http://play.ucell.uz/asosiy">UZ</option>
                                        <option data-token="ru" value="http://play.ucell.uz">RU</option>
                                        <option data-token="en" value="http://play.ucell.uz/homepage" selected>EN</option>
                                    </select>
                                    <span class="az_lang_arrow">▼</span>
                                </div>
                            </li>
                        </menu>
                    </nav>
                </div>
            </div>

            <div class="tsr-header-main">
                <div class="tsr-container">
                    <a href="http://play.ucell.uz/homepage" class="topLevelOnes">
                        <figure class="tsr-header-logo">
                            <img src="<?=SITE_PATH."/assets/img/GamEthio.jpg"?>">
                        </figure>
                    </a>
                    <div class="tsr-header-mobileAndExtras">
                        <div class="tsr-container">
                            <nav>
                                <menu>
                                    <li class="tsr-tab-login"><a data-header-tab="login" href="#"></a></li>
                                    <li class="tsr-tab-search"><a data-header-tab="search" href="#"></a></li>
                                    <li class="tsr-tab-menu"><a data-header-tab="menu" href="#"></a></li>
                                </menu>
                            </nav>
                        </div>
                    </div>
                    <!-- NAVIGATION -->
                    <nav class="tsr-main-nav">
                        <menu class="tsr-nav-top-level">
                            <li class="topContentName newButtonForDiscount special">
                                games
                            </li>
                            <li>
                                <a class="menu-item" href="javascript:void(0);">Play<br><strong>ONLINE</strong></a>
                                <menu class="tsr-nav-second-level">
                                    <li>
                                        <a href="http://play.ucell.uz/java-games/new-year-games/937105">
                                            <span>Featured Game</span>
                                            <article class="tsr-landing">
                                                <figure>
                                                    <img src="http://helm.tekmob.com/m3/cache/937105_55.jpg">
                                                </figure>
                                                <header>SNOW MANIA</header>
                                                <button
                                                        data-login="false"
                                                        data-postid="5"
                                                        data-club-id="75112"
                                                        data-view=""
                                                        data-media-id="937105"
                                                        data-cat-id="410730"
                                                        class="tsr-btn"
                                                        data-gencoluserlogin="Genc OL tariff users subscribe with 50% special discount! 1.00 AZN/week for EA and Java Games and 0.60 AZN/week for Online Games (3 games download)."
                                                        data-gencoluser=""
                                                        id="featured_button">
                                                    Subscribe
                                                </button>
                                            </article>
                                        </a>
                                    </li>
                                    <?php

                                        $stmt_select = mysqli_prepare($db,
                                            "SELECT
                                                    `categories`.`name` as `c_name`,
                                                    `categories`.`auto_id` as `c_id`,
                                                    GROUP_CONCAT(`games`.`name`) as `g_names`,
                                                    GROUP_CONCAT(`games`.`auto_id`) as `g_ids`
                                                    FROM `games` 
                                                    LEFT JOIN `categories` ON `games`.`category_id` = `categories`.`auto_id` 
                                                    WHERE `games`.`lang_id`=(?) and `games`.`active`=(?) and `categories`.`lang_id`=(?) and `categories`.`active`=(?)
                                                    group by `categories`.`name` order by `categories`.`order_number` ASC, `games`.`order_number` ASC");

//                                        $stmt_select = mysqli_prepare($db,
//                                            "SELECT
//                                                    `name`,`auto_id`
//                                                    FROM `categories`
//                                                    WHERE `lang_id`=(?) and `active`=(?)
//                                                    order by `order_number` asc");
                                        $stmt_select->bind_param('iiii', $main_lang,$active_status,$main_lang,$active_status);
                                        $stmt_select->execute();
                                        $result = $stmt_select->get_result();

                                        while($row=$result->fetch_assoc())
                                        {
                                            ?>
                                            <li class="has-sub">
                                                <a href="<?=SITE_PATH?>/category/<?=slugGenerator($row['c_name']) . '-' . $row['c_id']?>"
                                                   onclick="location.assign(jQuery(this).attr('href'));"
                                                   class="clickableTabWithLink"><?=$row['c_name']?></a>

                                                <menu class="tsr-nav-third-level">
                                                <?php

                                                    $game_names = $row['g_names'];
                                                    $game_names_arr = explode(",",$game_names);

                                                    $game_ids = $row['g_ids'];
                                                    $game_ids_arr = explode(",",$game_ids);

                                                    if(is_array($game_names_arr) && count($game_names_arr)>0 && is_array($game_ids_arr) && count($game_ids_arr)>0)
                                                    {
                                                        $combine_arr = array_combine($game_ids_arr,$game_names_arr);

                                                        $i = 1;
                                                        foreach ($combine_arr as $key=>$value)
                                                        {
                                                            ?>
                                                                <li>
                                                                    <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($value) . '-' . $key?>">
                                                                        <?=$value?>
                                                                    </a>
                                                                </li>
                                                            <?php

                                                            if($i%2==0)
                                                            {
                                                                ?>
<!--                                                                    </menu>-->
<!--                                                                <li class="has-sub">-->
<!--                                                                    <menu class="tsr-nav-third-level">-->
                                                                <?php
                                                                break;
                                                            }

                                                            $i++;
                                                        }
                                                    }

//                                                    $stmt_select_games = mysqli_prepare($db,
//                                                        "SELECT
//                                                        `name`,`auto_id`
//                                                        FROM `games`
//                                                        WHERE `lang_id`=(?) and `active`=(?) and `category_id`=(?)
//                                                        order by `order_number` asc LIMIT 2");
//                                                    $stmt_select_games->bind_param('iii', $main_lang,$active_status,$row['auto_id']);
//                                                    $stmt_select_games->execute();
//                                                    $result_games = $stmt_select_games->get_result();

//                                                    $i = 1;
//                                                    while($row_games=$result_games->fetch_assoc())
//                                                    {
//                                                        ?>
<!--                                                        <li>-->
<!--                                                            <a href="--><?//=SITE_PATH?><!--/online-games/--><?//=slugGenerator($row['name']) . '-' . $row['auto_id']?><!--/--><?//=slugGenerator($row_games['name']) . '-' . $row_games['auto_id']?><!--">-->
<!--                                                                --><?//=$row_games['name']?>
<!--                                                            </a>-->
<!--                                                        </li>-->
<!--                                                        --><?php
//
//                                                        if($i==3)
//                                                        {
//                                                            ?>
<!--                                                                </menu>-->
<!--                                                            <li class="has-sub">-->
<!--                                                                <menu class="tsr-nav-third-level">-->
<!--                                                            --><?php
//                                                        }
//
//                                                        $i++;
//                                                    }
                                                ?>
                                                </menu>
                                            </li>
                                            <?php
                                        }

                                        $stmt_select->close();
                                    ?>

                                    <li class="tsr-btn-close"><a href="#"></a></li>
                                </menu>
                            </li>
                        </menu>
                    </nav>

                    <article class="tsr-header-search tsr-forms">
                        <form action="http://play.ucell.uz/search/" id="search-form" method="GET">
                            <input type="text" placeholder="Search Term (minimum 3 characters)" id="NeoSearch"
                                   name="Search" value="">
                            <input type="submit" id="NeoSearchButton" class="tsr-btn" value="Search">
                            <a data-parent="search" class="tsr-btn-close" href="#"></a>
                        </form>
                    </article>

                    <article class="tsr-header-login  tsr-forms">
                        <span class="label">
<!--                            <a href="javascript:void(0);"-->
<!--                               onclick="widgets_subscription.setState({visible: true, fstmodal: 'loginWelcome', tarifmessage: 'Genc OL tariff users subscribe with 50% special discount! 1.00 AZN/week for EA and Java Games and 0.60 AZN/week for Online Games (3 games download).'})"-->
<!--                               class="tsr-btn">Login</a>-->
                            <a href="javascript:void(0);" id="login_modal" data-toggle="modal" data-target="#login-modal">Login</a>
                        </span>
                    </article>
                </div>
            </div>
        </section>
    </div>
</div>