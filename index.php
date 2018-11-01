<?php
    include "gamesmanagement/pages/includes/config.php";
    $do=safe($_GET["do"]);
    if(!is_file("includes/pages/".$do.".php")) $do='index';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "includes/head.php"; ?>
</head>
<body class="page page-id-5 page-template page-template-mvc page-template-homepage page-template-mvchomepage-php tsr-grid">
<?php
    $sql_contact = mysqli_fetch_assoc(mysqli_query($db,"SELECT * FROM `contacts` WHERE `lang_id`='$esas_dil' order by `id` DESC"));
?>
<input type="hidden" name="csrf_" value="<?=set_csrf_()?>" />

    <?php include "includes/header.php"; ?>
    <?php include "includes/pages/".$do.".php"; ?>
    <?php include "includes/footer.php"; ?>

<script src='http://play.ucell.uz/wp-content/themes/ucell-games/dist/js/react-bundle.js'></script>
<div id="5bcd80369409c"></div>
<script>var ReactDOM = require('react-dom');
    var React = require('react');
    var widgets_subscription = ReactDOM.render(React.createFactory(require("widgets\/subscription"))({
        "formsData": [{
            "type": "login",
            "action": "http:\/\/play.ucell.uz\/api\/resetpin",
            "method": "POST",
            "__": {
                "modalTitleLogin": "Are you a Ucell Games Member?",
                "modalTitleSubscribe": "Register for Ucell Games Membership!",
                "invalidEmail": "default_invalidEmail",
                "invalidNumber": "default_invalidNumber",
                "notEmpty": "default_notEmpty",
                "minimalSize": "default_minimalSize",
                "loginSubmit1": "Next",
                "loginNewRegister1": "default_loginNewRegister1",
                "welcome_message_login": "Please insert your Mobile Number (9989XXXXXXXX).   \r\nYou can download or play unlimited games.\r\nThe service has a cost of 631.5 UZS\/daily subscription.\r\n",
                "welcome_message_subscribe": "The service has a cost of 631.5 UZS\/daily subscription. Enjoy your favorite games here!",
                "insert_mobile_phone": "Please insert your Mobile Number (9989XXXXXXXX).   \r\nYou can download or play unlimited games.\r\nThe service has a cost of 631.5 UZS\/daily subscription.\r\n"
            },
            "validations": {"msisdn": ["valNotNull", "valMinSize"]},
            "validatorsMessages": {
                "requiredField": "Your MSISDN is not valid. Please check if you inserted correctly all numbers and please try again.",
                "minLength": "Your MSISDN is not valid. Please check if you inserted correctly all numbers and please try again.",
                "notAllowed": "Your mobile number is not valid. Please try with another mobile number to log in. ",
                "invalidMsisdn": "Invalid Msisdn",
                "somethingWrong": "Something wrong."
            },
            "errorMessages": {"required": "required"},
            "labels": {"msisdn": "default_labelMSISDN", "pin": "Please insert your PIN", "placeholder": "Mobile Number"}
        }, {
            "type": "pin",
            "action": "http:\/\/play.ucell.uz\/api\/login",
            "method": "POST",
            "__": {
                "required": "Please insert your PIN:",
                "minLength": "",
                "modalTitle": "Almost there...",
                "invalidEmail": "default_invalidEmail",
                "invalidNumber": "default_invalidNumber",
                "notEmpty": "default_notEmpty",
                "minimalSize": "default_minimalSize",
                "loginSubmit2": "Next"
            },
            "errorMessages": {
                "required": "Mandatory",
                "minLength": "Your PIN is not valid. Please check if you inserted correctly all numbers and please try again."
            },
            "validations": {"msisdn": ["valNotNull", "valMinSize"]},
            "validatorsMessages": {
                "requiredField": "Mandatory",
                "minLength": "Your PIN is not valid. Please check if you inserted correctly all numbers and please try again.",
                "tooManyAttempts": "Too many attempts!"
            },
            "labels": {"msisdn": "default_labelMSISDN", "pin": "Please insert your PIN:"},
            "widgetAttrs": {"placeholder": "Please insert your PIN:"}
        }, {
            "type": "generalwarning",
            "__": {"modalTitle": "default_generalwarning_title", "submit": "default_generalwarning_submit"}
        }, {
            "type": "messagesent",
            "__": {
                "modalTitle": "Ready to Download?",
                "modalTitlePlay": "Ready to Play?",
                "messageSucesso": "We have just sent an SMS with your content.",
                "messageErro": "At this moment we can't generate link to download.",
                "noCredits": "Your daily 2 download credits have been used. You can now enjoy playing unlimited <u><b><a href=\"http:\/\/oyin.ucell.uz\" target=\"_blank\">Online games<\/a><\/b><\/u>. Stay subscribed with enough balance for more 2 credits tomorrow.",
                "noSubscription": "You are not subscribed..",
                "noFree": "Content is not free.",
                "noMtSend": "Message was not sent.",
                "play": "PLAY",
                "download": "DOWNLOAD",
                "submit": "Close"
            }
        }, {
            "type": "messageSubscribe",
            "__": {
                "modalTitle": "Welcome!!!",
                "messageSucesso": "We have just sent an SMS with your content.",
                "messageErro": "At this moment we can't generate link to download.",
                "errorSubscription": "Erro ao subscrever.",
                "alreadySubscribed": "You are already subscribed.",
                "Subscribed": "Thank you for joining our club.",
                "submit": "Close"
            }
        }, {
            "type": "loginDone",
            "__": {
                "modalTitle": "Welcome!!!",
                "message1": "Click below to check out",
                "message2": "your downloaded content!",
                "tarifmessage": "",
                "submit": "Go"
            }
        }, {
            "type": "loading",
            "__": {"modalTitle": "Ready to Download?", "modalTitlePlay": "Ready to Play?"}
        }, {
            "type": "loginWelcome",
            "action": "",
            "method": "POST",
            "__": {
                "modalTitle": "Are you a Ucell Games Member?",
                "welcome_message": "Login with your phone number",
                "welcome_message1": "and check out your content!",
                "submit": "continue"
            }
        }], "animationTime": 200
    }), document.getElementById("5bcd80369409c"));</script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/tsr-header.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/jquery.debouncing.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/enquire.min.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/jquery.flexslider.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/tsr-carousel-listing.js?ver=1.0.0'></script>
<script type='text/javascript' src='<?=SITE_PATH?>/assets/js/all.min.js?ver=1.0.0'></script>
<!-- Flows Container -->
<section class="flows-container"></section>

</body>
</html>