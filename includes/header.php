<div id="index">
    <div class="headerWebContainer">
        <section class="tsr-section-header">
            <div class="tsr-header-global">
                <div class="tsr-container">
<!--                    <nav class="tsr-global-left">-->
<!--                        <menu class="" id="mobileLanguageSelectorDrop">-->
<!--                            <li style="width:100%;" class="">-->
<!--                                <a style="width:100%;" data-token="uz" class="mobileLanguageSelectorElement" href="http://play.ucell.uz/asosiy">Uzbek</a>-->
<!--                            </li>-->
<!--                            <li style="width:100%;" class="">-->
<!--                                <a style="width:100%;" data-token="ru" class="mobileLanguageSelectorElement" href="http://play.ucell.uz">Russian</a>-->
<!--                            </li>-->
<!--                            <li style="width:100%;" class="is-choosen">-->
<!--                                <a style="width:100%;" data-token="en" class="mobileLanguageSelectorElement" href="#">English</a>-->
<!--                            </li>-->
<!--                            <li class="tsr-btn-arrow-mobile"></li>-->
<!--                        </menu>-->
<!--                    </nav>-->

                    <nav class="tsr-global-right">
                        <menu>
                            <li class="tsr-extra">
                                <span class="label">
<!--                                    <a href="javascript:void(0);" onclick="widgets_subscription.setState({visible: true, fstmodal: 'loginWelcome', tarifmessage: 'Genc OL tariff users subscribe with 50% special discount! 1.00 AZN/week for EA and Java Games and 0.60 AZN/week for Online Games (3 games download).'})">Login</a>-->
                                    <?php
                                        if(login_check($db))
                                        {
                                            ?>
                                            <a href="<?=SITE_PATH."/logout.php"?>">Logout</a>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <a href="javascript:void(0);" id="subscribe_modal">Login</a>
                                            <?php
                                        }
                                    ?>
                                </span>
                            </li>
<!--                            <li class="tsr-extra">-->
<!--                                <div class="select-container">-->
<!--                                    <select id="azercell_language_selector">-->
<!--                                        <option data-token="uz" value="http://play.ucell.uz/asosiy">UZ</option>-->
<!--                                        <option data-token="ru" value="http://play.ucell.uz">RU</option>-->
<!--                                        <option data-token="en" value="http://play.ucell.uz/homepage" selected>EN</option>-->
<!--                                    </select>-->
<!--                                    <span class="az_lang_arrow">▼</span>-->
<!--                                </div>-->
<!--                            </li>-->
                        </menu>
                    </nav>
                </div>
            </div>

            <div class="tsr-header-main">
                <div class="tsr-container">
                    <a href="<?=SITE_PATH?>" class="topLevelOnes">
                        <figure class="tsr-header-logo">
                            <img src="<?=SITE_PATH."/assets/img/GameEthio.png"?>">
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
                                <a style="font-weight: bold;" href="javascript:void(0);">Play<br><strong>ONLINE</strong></a>
                                <menu class="tsr-nav-second-level">
                                    <li>
                                        <?php
                                            $featuregame = 1;
                                            $stmt_select = mysqli_prepare($db,
                                                "SELECT 
                                                                    `name`,
                                                                    `image_name`,
                                                                    `auto_id`
                                                                    FROM `games`
                                                                    WHERE `lang_id`=(?) and `active`=(?) and `featuregame`=(?)
                                                                    LIMIT 1");
                                            $stmt_select->bind_param('iii', $main_lang,$active_status,$featuregame);
                                            $stmt_select->execute();
                                            $stmt_select->bind_result($featured_game_name,$featured_game_image_name,$featured_game_id);
                                            $stmt_select->fetch();
                                            $stmt_select->close();
                                        ?>
                                        <a href="<?=SITE_PATH?>/online-games/<?=slugGenerator($featured_game_name) . '-' . $featured_game_id?>">

                                            <span>Featured Game</span>
                                            <article class="tsr-landing">
                                                <figure>
                                                    <img src="<?=SITE_PATH?>/images/games/<?=$featured_game_image_name?>">
                                                </figure>
                                                <header><?=$featured_game_name?></header>
                                                <button id="featured_button" class="tsr-btn">
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
                                                   class="clickableTabWithLink" style="font-weight: bold;"><?=$row['c_name']?></a>

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

                                                        ?>
                                                        <li>
                                                            <a href="<?=SITE_PATH?>/category/<?=slugGenerator($row['c_name']) . '-' . $row['c_id']?>">
                                                                More >
                                                            </a>
                                                        </li>
                                                        <?php
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
<!--                            <li>-->
<!--                                <a style="font-weight: bold;" href="--><?//=SITE_PATH?><!--/frequently-asked-questions">Frequently Asked<br>-->
<!--                                    <strong>Questions</strong></a>-->
<!--                            </li>-->
                        </menu>
                    </nav>

                    <article class="tsr-header-search tsr-forms">
                        <form action="<?=SITE_PATH?>/search" id="search-form" method="GET">
                            <input type="text" placeholder="Search" id="NeoSearch"
                                   name="search" value="">
                            <input type="submit" id="NeoSearchButton" class="tsr-btn" value="Search">
                            <a data-parent="search" class="tsr-btn-close" href="#"></a>
                        </form>
                    </article>

                    <article class="tsr-header-login  tsr-forms">
                        <span class="label">
<!--                            <a href="javascript:void(0);"-->
<!--                               onclick="widgets_subscription.setState({visible: true, fstmodal: 'loginWelcome', tarifmessage: 'Genc OL tariff users subscribe with 50% special discount! 1.00 AZN/week for EA and Java Games and 0.60 AZN/week for Online Games (3 games download).'})"-->
<!--                               class="tsr-btn">Login</a>-->
                            <?php
                                if(login_check($db))
                                {
                                    ?>
                                    <a href="<?=SITE_PATH."/logout.php"?>">Logout</a>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <a href="javascript:void(0);" id="subscribe_modal" data-toggle="modal">Login</a>
                                    <?php
                                }
                            ?>
                        </span>
                    </article>
                </div>
            </div>
        </section>
    </div>
</div>