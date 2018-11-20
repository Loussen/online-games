<section class="tsr-row">
    <div class="breadcrumbs">
        <div class="tsr-container">
            <div class="col-12">
                <a href="<?=SITE_PATH?>">Homepage</a>
                <!--<a href="">Home</a>-->
                <span class="ts-icon-breadcrumb-arrow"></span>
                <span class="bread-item-name bold">Frequently Asked Questions</span>
            </div>
        </div>
    </div>
</section>

<div id="primary" class="content-area">

    <main id="main" class="site-main" role="main">


        <section class="tsr-section-divider">
            <header class="tsr-container">
                <span>Frequently Asked Questions</span>
            </header>
        </section>
        <div class="tsr-container">
            <div class="tsr-row">
                <div class="col-full">
                    <p>&nbsp;</p>
                    <?php
                        foreach($result_faq_arr as $row)
                        {
                            ?>
                            <p><strong><?=$row['question']?></strong></p>
                            <?=html_entity_decode($row['answer'])?>
                            <p>&nbsp;</p>
                            <?php
                        }
                    ?>

                </div>
            </div>
        </div>




    </main><!-- #main -->
</div>