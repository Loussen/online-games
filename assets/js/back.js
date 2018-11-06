jQuery(document).ready(function(){

    jQuery("div.modal-dialog div.modal-header button.close").click(function(){
        jQuery("div#login-modal").animate({width:'toggle'},100);
        jQuery("div#modal-backdrop").css("display","none");
    });

    jQuery("a#login_modal").click(function(){
       // jQuery("div#login-modal").fadeIn();
       jQuery("div#login-modal").animate({width:'toggle'},100);
       jQuery("div#modal-backdrop").css("display","block");
    });

    // jQuery("div").not('#login-modal').click(function(){
    //     jQuery("div#login-modal").fadeOut;
    //     jQuery("div.modal-backdrop").css("display","none");
    // })

});

// Get the modal
var modal = document.getElementById('login-modal');

var backdrop = document.getElementById('modal-backdrop');

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        backdrop.style.display = "none";
    }
};