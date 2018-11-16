<?php
    include "gamesmanagement/pages/includes/config.php";
    $do=safe($_GET["do"]);
    if(!is_file("includes/pages/".$do.".php")) $do='index';

    include "includes/functions.php";

    sec_session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/head.php"; ?>
</head>
<body class="page page-id-5 page-template page-template-mvc no-touch page-template-homepage page-template-mvchomepage-php tsr-grid">
<?php
//    $sql_contact = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `contacts` WHERE `lang_id`='$esas_dil' order by `id` DESC"));
?>
<input type="hidden" name="csrf_" value="<?=set_csrf_()?>" />

    <?php include "includes/header.php"; ?>
    <?php include "includes/pages/".$do.".php"; ?>
    <?php include "includes/footer.php"; ?>

<div class="fade in modal" role="dialog" id="login-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"">
    <div class="modal-dialog">
        <div class="modal-content" role="document">
            <div class="modal-header">
                <button type="button" class="close close-login" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Login modal</h4>
            </div>
            <div class="logmodal-container modal-body">
                <div>
                    <div>
                        <div class="col-xs-12 modal-height" id="loading">
                            <img align="center" id="loading-image" src="<?=SITE_PATH?>/assets/img/load.gif   " alt="Loading..." style="display: none; position: fixed; z-index: 1; margin-left: 180px; margin-top: -30px;">
                            <form id="login-form" method="POST">
                                <div id="react-message">
                                    Please insert your Mobile Number (9989XXXXXXXX).
                                    You can download or play unlimited games.
                                    The service has a cost of 631.5 UZS/daily subscription.
                                </div>
                                <div>
                                    <div class="form-group">
                                        <label class="control-label" for="id_msisdn"></label>
                                        <input type="text" placeholder="" maxlength="9" name="msisdn" class="form-control" id="id_msisdn">
                                        <span class="help-block">
                                            <span class="error_message"></span>
                                        </span>
                                    </div>
                                </div>
                                <input type="hidden" name="login_form" value="login_form" />
                                <input type="submit" class="logmodal-submit" value="Next">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fade in modal" role="dialog" id="subscribe-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"">
    <div class="modal-dialog">
        <div class="modal-content" role="document">
            <div class="modal-header">
                <button type="button" class="close close-subscribe" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Subscribe moodal</h4>
            </div>
            <div class="logmodal-container modal-body">
                <div>
                    <div>
                        <div class="col-xs-12 modal-height" id="loading">
                            <img align="center" id="loading-image" src="<?=SITE_PATH?>/assets/img/load.gif   " alt="Loading..." style="display: none; position: fixed; z-index: 1; margin-left: 180px; margin-top: -30px;">
                            <form id="subscribe-form" method="POST">
                                <div id="react-message">
                                    Please insert your Mobile Number (9989XXXXXXXX).
                                    You can download or play unlimited games.
                                    The service has a cost of 631.5 UZS/daily subscription.
                                </div>
                                <div>
                                    <div class="form-group">
                                        <label class="control-label" for="id_msisdn"></label>
                                        <input type="text" placeholder="" maxlength="9" name="msisdn" class="form-control" id="id_msisdn">
                                        <span class="help-block">
                                                <span class="error_message"></span>
                                            </span>
                                    </div>
                                </div>
                                <input type="hidden" name="subscribe_form" value="subscribe_form" />
                                <input type="submit" class="logmodal-submit" value="Next">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fade in modal" role="dialog" id="sms-modal-subscribe" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"">
    <div class="modal-dialog">
    <div class="modal-content" role="document">
        <div class="modal-header">
            <button type="button" class="close close-sms-subscribe" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Sms code for subscribe</h4>
        </div>
        <div class="logmodal-container modal-body">
            <div>
                <div>
                    <div class="col-xs-12 modal-height" id="loading">
                        <img align="center" id="loading-image" src="<?=SITE_PATH?>/assets/img/load.gif   " alt="Loading..." style="display: none; position: fixed; z-index: 1; margin-left: 180px; margin-top: -30px;">
                        <form id="sms-form-subscribe" method="POST">
                            <div id="react-message">
                                Please insert your Mobile Number (9989XXXXXXXX).
                                You can download or play unlimited games.
                                The service has a cost of 631.5 UZS/daily subscription.
                            </div>
                            <div>
                                <div class="form-group">
                                    <label class="control-label" for="id_msisdn"></label>
                                    <input type="text" placeholder="" maxlength="6" name="sms_code" class="form-control" id="id_msisdn">
                                    <span class="help-block">
                                        <span class="error_message"></span>
                                    </span>
                                </div>
                            </div>
                            <input type="hidden" name="check_sms_form_for_subscribe" value="sms_form_subscribe" />
                            <input type="submit" class="logmodal-submit" value="Apply">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="fade in modal" role="dialog" id="sms-modal-login" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"">
    <div class="modal-dialog">
        <div class="modal-content" role="document">
            <div class="modal-header">
                <button type="button" class="close close-sms-login" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Sms code for login</h4>
            </div>
            <div class="logmodal-container modal-body">
            <div>
                <div>
                    <div class="col-xs-12 modal-height" id="loading">
                        <img align="center" id="loading-image" src="<?=SITE_PATH?>/assets/img/load.gif" alt="Loading..." style="display: none; position: fixed; z-index: 1; margin-left: 180px; margin-top: -30px;">
                        <form id="sms-form-login" method="POST">
                            <div id="react-message">
                                Please insert your Mobile Number (9989XXXXXXXX).
                                You can download or play unlimited games.
                                The service has a cost of 631.5 UZS/daily subscription.
                            </div>
                            <div>
                                <div class="form-group">
                                    <label class="control-label" for="id_msisdn"></label>
                                    <input type="text" placeholder="" maxlength="6" name="sms_code" class="form-control" id="id_msisdn">
                                    <span class="help-block">
                                        <span class="error_message"></span>
                                    </span>
                                </div>
                            </div>
                            <input type="hidden" name="check_sms_form_for_login" value="sms_form" />
                            <input type="submit" class="logmodal-submit" value="Apply">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<div id="modal-backdrop2"></div>

<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/tsr-header.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/jquery.debouncing.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/enquire.min.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/jquery.flexslider.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/tsr-carousel-listing.js?ver=1.0.0'></script>
<!--<script type='text/javascript' src='--><?//=SITE_PATH?><!--/assets/js/all.min.js?ver=1.0.0'></script>-->
<?php
    if($do=="inner")
    {
        ?>
        <script type='text/javascript' src='<?=SITE_PATH?>/assets/js/jssor.slider.min.js'></script>
        <?php
    }
?>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/back.js'></script>

<script>
    jQuery(document).on('submit','form#subscribe-form',function(e){

        e.preventDefault();

        jQuery('#loading-image').show();
        jQuery('#loading').css('opacity','0.3');
        jQuery('.has-error').removeClass('has-error');

        var formData = new FormData(this);

        jQuery.ajax({
            url: base_url+'/ajax.php',
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                if(data.code==0)
                {
                    jQuery('[name="'+data.err_param+'"]').addClass('has-error');
                    jQuery('form#subscribe-form span.help-block').show();
                    jQuery('form#subscribe-form span.help-block span.error_message').html(data.content);
                }
                else if(data.code==2)
                {
                    jQuery('form#subscribe-form span.help-block').hide();
                    jQuery('form#subscribe-form span.help-block span.error_message').html('');
                    jQuery("div#subscribe-modal").hide('fast');
                    jQuery("div#sms-modal-subscribe").show('fast');
                }
                else
                {
                    jQuery('form#subscribe-form span.help-block').hide();
                    jQuery('form#subscribe-form span.help-block span.error_message').html('');
                    jQuery("div#subscribe-modal").hide('fast');
                    jQuery("div#sms-modal-subscribe").show('fast');
                }

                jQuery('#loading-image').hide();
                jQuery('#loading').css('opacity','1');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                jQuery('#loading-image').hide();
                jQuery('#loading').css('opacity','1');
            }
        });
    });

    jQuery(document).on('submit','form#sms-form-subscribe',function(e){

        e.preventDefault();

        jQuery('#loading-image').show();
        jQuery('#loading').css('opacity','0.3');
        jQuery('.has-error').removeClass('has-error');

        var formData = new FormData(this);

        jQuery.ajax({
            url: base_url+'/ajax.php',
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                if(data.code==0)
                {
                    jQuery('[name="'+data.err_param+'"]').addClass('has-error');
                    jQuery('form#sms-form-subscribe span.help-block').show();
                    jQuery('form#sms-form-subscribe span.help-block span.error_message').html(data.content);
                }
                else
                {
                    // Success
                    location.reload();
                }

                jQuery('#loading-image').hide();
                jQuery('#loading').css('opacity','1');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                jQuery('#loading-image').hide();
                jQuery('#loading').css('opacity','1');
            }
        });
    });

    jQuery(document).on('submit','form#login-form',function(e){

        e.preventDefault();

        jQuery('#loading-image').show();
        jQuery('#loading').css('opacity','0.3');
        jQuery('.has-error').removeClass('has-error');

        var formData = new FormData(this);

        jQuery.ajax({
            url: base_url+'/ajax.php',
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                if(data.code==0)
                {
                    jQuery('[name="'+data.err_param+'"]').addClass('has-error');
                    jQuery('form#login-form span.help-block').show();
                    jQuery('form#login-form span.help-block span.error_message').html(data.content);
                }
                else
                {
                    jQuery('form#login-form span.help-block').hide();
                    jQuery('form#login-form span.help-block span.error_message').html('');
                    jQuery("div#login-modal").hide('fast');
                    jQuery("div#sms-modal-login").show('fast');
                }

                jQuery('#loading-image').hide();
                jQuery('#loading').css('opacity','1');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                jQuery('#loading-image').hide();
                jQuery('#loading').css('opacity','1');
            }
        });
    });

    jQuery(document).on('submit','form#sms-form-login',function(e){

        e.preventDefault();

        jQuery('#loading-image').show();
        jQuery('#loading').css('opacity','0.3');
        jQuery('.has-error').removeClass('has-error');

        var formData = new FormData(this);

        jQuery.ajax({
            url: base_url+'/ajax.php',
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                if(data.code==0)
                {
                    jQuery('[name="'+data.err_param+'"]').addClass('has-error');
                    jQuery('form#sms-form-login span.help-block').show();
                    jQuery('form#sms-form-login span.help-block span.error_message').html(data.content);
                }
                else
                {
                    // Success
                    location.reload();
                }

                jQuery('#loading-image').hide();
                jQuery('#loading').css('opacity','1');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                jQuery('#loading-image').hide();
                jQuery('#loading').css('opacity','1');
            }
        });
    });

</script>

<!-- Flows Container -->
<section class="flows-container"></section>

</body>
</html>