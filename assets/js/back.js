jQuery(document).ready(function(){

    jQuery("div.modal-dialog div.modal-header button.close-login").click(function(){
        // jQuery("div#login-modal").animate({width:'toggle'},100);
        jQuery("div#login-modal").hide();
        jQuery("div#modal-backdrop2").css("display","none");
    });

    jQuery("div.modal-dialog div.modal-header button.close-subscribe").click(function(){
        // jQuery("div#subscribe-modal").animate({width:'toggle'},100);
        jQuery("div#subscribe-modal").hide();
        jQuery("div#modal-backdrop2").css("display","none");
    });

    jQuery("a#login_modal").click(function(){
       // jQuery("div#login-modal").animate({width:'toggle'},100);
       jQuery("div#login-modal").show();
       jQuery("div#modal-backdrop2").css("display","block");
    });

    jQuery("span#subscribe_modal, button#subscribe_modal").click(function(){
        // jQuery("div#subscribe-modal").animate({width:'toggle'},100);
        jQuery("div#subscribe-modal").show();
        jQuery("div#modal-backdrop2").css("display","block");
    });

    // jQuery("div").not('#login-modal').click(function(){
    //     jQuery("div#login-modal").fadeOut;
    //     jQuery("div.modal-backdrop2").css("display","none");
    // })

});

// Get the modal
var modal_login = document.getElementById('login-modal');
var modal_subscribe = document.getElementById('subscribe-modal');

var backdrop = document.getElementById('modal-backdrop2');

window.onclick = function(event) {
    if (event.target == modal_login) {
        modal_login.style.display = "none";
        backdrop.style.display = "none";
    }
};

window.onclick = function(event) {
    if (event.target == modal_subscribe) {
        modal_subscribe.style.display = "none";
        backdrop.style.display = "none";
    }
};