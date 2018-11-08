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
    $sql_contact = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `contacts` WHERE `lang_id`='$esas_dil' order by `id` DESC"));
?>
<input type="hidden" name="csrf_" value="<?=set_csrf_()?>" />

    <?php include "includes/header.php"; ?>
    <?php include "includes/pages/".$do.".php"; ?>
    <?php include "includes/footer.php"; ?>

<!--<script src='http://play.ucell.uz/wp-content/themes/ucell-games/dist/js/react-bundle.js'></script>-->
<!--<div id="5bcd80369409c"></div>-->
<!--<script>var ReactDOM = require('react-dom');-->
<!--    var React = require('react');-->
<!--    var widgets_subscription = ReactDOM.render(React.createFactory(require("widgets\/subscription"))({-->
<!--        "formsData": [{-->
<!--            "type": "login",-->
<!--            "action": "http:\/\/play.ucell.uz\/api\/resetpin",-->
<!--            "method": "POST",-->
<!--            "__": {-->
<!--                "modalTitleLogin": "Are you a Ucell Games Member?",-->
<!--                "modalTitleSubscribe": "Register for Ucell Games Membership!",-->
<!--                "invalidEmail": "default_invalidEmail",-->
<!--                "invalidNumber": "default_invalidNumber",-->
<!--                "notEmpty": "default_notEmpty",-->
<!--                "minimalSize": "default_minimalSize",-->
<!--                "loginSubmit1": "Next",-->
<!--                "loginNewRegister1": "default_loginNewRegister1",-->
<!--                "welcome_message_login": "Please insert your Mobile Number (9989XXXXXXXX).   \r\nYou can download or play unlimited games.\r\nThe service has a cost of 631.5 UZS\/daily subscription.\r\n",-->
<!--                "welcome_message_subscribe": "The service has a cost of 631.5 UZS\/daily subscription. Enjoy your favorite games here!",-->
<!--                "insert_mobile_phone": "Please insert your Mobile Number (9989XXXXXXXX).   \r\nYou can download or play unlimited games.\r\nThe service has a cost of 631.5 UZS\/daily subscription.\r\n"-->
<!--            },-->
<!--            "validations": {"msisdn": ["valNotNull", "valMinSize"]},-->
<!--            "validatorsMessages": {-->
<!--                "requiredField": "Your MSISDN is not valid. Please check if you inserted correctly all numbers and please try again.",-->
<!--                "minLength": "Your MSISDN is not valid. Please check if you inserted correctly all numbers and please try again.",-->
<!--                "notAllowed": "Your mobile number is not valid. Please try with another mobile number to log in. ",-->
<!--                "invalidMsisdn": "Invalid Msisdn",-->
<!--                "somethingWrong": "Something wrong."-->
<!--            },-->
<!--            "errorMessages": {"required": "required"},-->
<!--            "labels": {"msisdn": "default_labelMSISDN", "pin": "Please insert your PIN", "placeholder": "Mobile Number"}-->
<!--        }, {-->
<!--            "type": "pin",-->
<!--            "action": "http:\/\/play.ucell.uz\/api\/login",-->
<!--            "method": "POST",-->
<!--            "__": {-->
<!--                "required": "Please insert your PIN:",-->
<!--                "minLength": "",-->
<!--                "modalTitle": "Almost there...",-->
<!--                "invalidEmail": "default_invalidEmail",-->
<!--                "invalidNumber": "default_invalidNumber",-->
<!--                "notEmpty": "default_notEmpty",-->
<!--                "minimalSize": "default_minimalSize",-->
<!--                "loginSubmit2": "Next"-->
<!--            },-->
<!--            "errorMessages": {-->
<!--                "required": "Mandatory",-->
<!--                "minLength": "Your PIN is not valid. Please check if you inserted correctly all numbers and please try again."-->
<!--            },-->
<!--            "validations": {"msisdn": ["valNotNull", "valMinSize"]},-->
<!--            "validatorsMessages": {-->
<!--                "requiredField": "Mandatory",-->
<!--                "minLength": "Your PIN is not valid. Please check if you inserted correctly all numbers and please try again.",-->
<!--                "tooManyAttempts": "Too many attempts!"-->
<!--            },-->
<!--            "labels": {"msisdn": "default_labelMSISDN", "pin": "Please insert your PIN:"},-->
<!--            "widgetAttrs": {"placeholder": "Please insert your PIN:"}-->
<!--        }, {-->
<!--            "type": "generalwarning",-->
<!--            "__": {"modalTitle": "default_generalwarning_title", "submit": "default_generalwarning_submit"}-->
<!--        }, {-->
<!--            "type": "messagesent",-->
<!--            "__": {-->
<!--                "modalTitle": "Ready to Download?",-->
<!--                "modalTitlePlay": "Ready to Play?",-->
<!--                "messageSucesso": "We have just sent an SMS with your content.",-->
<!--                "messageErro": "At this moment we can't generate link to download.",-->
<!--                "noCredits": "Your daily 2 download credits have been used. You can now enjoy playing unlimited <u><b><a href=\"http:\/\/oyin.ucell.uz\" target=\"_blank\">Online games<\/a><\/b><\/u>. Stay subscribed with enough balance for more 2 credits tomorrow.",-->
<!--                "noSubscription": "You are not subscribed..",-->
<!--                "noFree": "Content is not free.",-->
<!--                "noMtSend": "Message was not sent.",-->
<!--                "play": "PLAY",-->
<!--                "download": "DOWNLOAD",-->
<!--                "submit": "Close"-->
<!--            }-->
<!--        }, {-->
<!--            "type": "messageSubscribe",-->
<!--            "__": {-->
<!--                "modalTitle": "Welcome!!!",-->
<!--                "messageSucesso": "We have just sent an SMS with your content.",-->
<!--                "messageErro": "At this moment we can't generate link to download.",-->
<!--                "errorSubscription": "Erro ao subscrever.",-->
<!--                "alreadySubscribed": "You are already subscribed.",-->
<!--                "Subscribed": "Thank you for joining our club.",-->
<!--                "submit": "Close"-->
<!--            }-->
<!--        }, {-->
<!--            "type": "loginDone",-->
<!--            "__": {-->
<!--                "modalTitle": "Welcome!!!",-->
<!--                "message1": "Click below to check out",-->
<!--                "message2": "your downloaded content!",-->
<!--                "tarifmessage": "",-->
<!--                "submit": "Go"-->
<!--            }-->
<!--        }, {-->
<!--            "type": "loading",-->
<!--            "__": {"modalTitle": "Ready to Download?", "modalTitlePlay": "Ready to Play?"}-->
<!--        }, {-->
<!--            "type": "loginWelcome",-->
<!--            "action": "",-->
<!--            "method": "POST",-->
<!--            "__": {-->
<!--                "modalTitle": "Are you a Ucell Games Member?",-->
<!--                "welcome_message": "Login with your phone number",-->
<!--                "welcome_message1": "and check out your content!",-->
<!--                "submit": "continue"-->
<!--            }-->
<!--        }], "animationTime": 200-->
<!--    }), document.getElementById("5bcd80369409c"));</script>-->

<div class="fade in modal" role="dialog" id="login-modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"">
    <div class="modal-dialog">
        <div class="modal-content" role="document">
            <div class="modal-header">
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Are you a Ucell Games Member?</h4>
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
                                        <input type="text" placeholder="" maxlength="12" name="msisdn" class="form-control" id="id_msisdn">
                                        <span class="help-block">
                                            <span class="error_message">Your MSISDN is not valid. Please check if you inserted correctly all numbers and please try again.</span>
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
<div id="modal-backdrop"></div>

<!--<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">-->
<!--    <div class="modal-dialog">-->
<!--        <div class="loginmodal-container">-->
<!--            <div>-->
<!--                <button type="button" style="margin-top: -5px;" class="close" aria-label="Close"><span aria-hidden="true">×</span></button>-->
<!---->
<!--                <h1>Are you a Ucell Games Member?</h1>-->
<!--            </div>-->
<!--            <form>-->
<!--                <input type="text" name="user" placeholder="Username">-->
<!--                <input type="password" name="pass" placeholder="Password">-->
<!--                <input type="submit" name="login" class="login loginmodal-submit" value="Login">-->
<!--            </form>-->
<!---->
<!--            <div class="login-help">-->
<!--                <a href="#">Register</a> - <a href="#">Forgot Password</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/tsr-header.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/jquery.debouncing.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/enquire.min.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/jquery.flexslider.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/tsr-carousel-listing.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/all.min.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/back.js'></script>

<script>
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
                }
                else if(data.code==-1)
                {
                    jQuery('div.error_contact').show();
                }
                else
                {
                    jQuery("div#login-modal").animate({width:'toggle'},100);
                    jQuery("div#login-modal").animate({width:'toggle'},100);
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