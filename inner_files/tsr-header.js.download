
/*
TSR - HEADER
*/ 


;(function(document,$) {


    window.tsrHeader = window.tsrHeader || {};

    // Scope Variables
    var tsrBw = $('body').width();

/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// TSR - Init
/////////////////////////////////////////////////////////////////////////////////////////////////////////

    tsrHeader.tsrInit = function() {
       
        tsrHeader.tsrGlobalNav();
        tsrHeader.tsrMainNav.mainInit();
        tsrHeader.tsrTabNav.tabInit();
         
    };


/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// TSR - Equal heights
/////////////////////////////////////////////////////////////////////////////////////////////////////////

	// Thanks Paul Irish
	$.fn.setAllToMaxHeight = function(){
		return this.height( Math.max.apply(this, $.map( this , function(e){ return $(e).height() }) ) );
	}


/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// TSR - Global navigation
/////////////////////////////////////////////////////////////////////////////////////////////////////////

    tsrHeader.tsrGlobalNav = function () {

        // Close 

            $('.tsr-header-global .tsr-btn-close').on('click',function () {
                var el = $(this);
                el.closest('.tsr-header-global').fadeOut('fast').addClass('is-hidden-mobile');
                return false;
            });


        // Arrow

            $('.tsr-global-left .tsr-btn-arrow-mobile').live('click',function () {

                var el = $(this);
                var elParent = $(this).parent();

                if(elParent.hasClass('is-expanded')){
                    elParent.removeClass('is-expanded');
                } else {
                    elParent.addClass('is-expanded');
                }

                return false;
            });

    };

   
/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// TSR - Tab navigation mobile and search desktop
/////////////////////////////////////////////////////////////////////////////////////////////////////////
    
     tsrHeader.tsrTabNav =  {

            tabInit: function() {
                  
                    // enquire.js
                    enquire.register("screen and (min-width:768px)", {
              
                            setup : function() {

                                tsrHeader.tsrTabNav.tabMobileClick();
                                tsrHeader.tsrTabNav.globalCloneMobile();
                                
                            },
                            match : function() {

                                tsrHeader.tsrTabNav.tabMobileDestroy();
                                tsrHeader.tsrTabNav.tabDesktopClick();
                                tsrHeader.tsrTabNav.globalCloneDestroy();
                                
                            },
                            unmatch : function() {

                                tsrHeader.tsrTabNav.tabDesktopDestroy();
                                tsrHeader.tsrTabNav.tabMobileClick();
                                tsrHeader.tsrTabNav.globalCloneMobile();

                            }

                    }, true); 


            }, // tabInit


            tabDesktopClickReset: function(el,elParent) {
                   
                    $('.tsr-header-mobileAndExtras a').each(function () {

                        var el = $(this);
                        var elData =  el.attr('data-header-tab');
                        var elParent = $(this).closest('.tsr-section-header');
                        var classParent = elData+'-is-expanded' ;

                        elParent.removeClass(classParent);

                    }); 

                    $('.tsr-header-mobileAndExtras li').removeClass('is-expanded');
                    $('.tsr-main-nav menu li').removeClass('is-expanded'); // Expanded submenus
                   
            }, // tabDesktopClickReset


            tabDesktopClick: function() {

                $('.tsr-header-mobileAndExtras a').on('click',function () {
        
                    var el = $(this);
                    var elData =  el.attr('data-header-tab');
                    var elParent = $(this).closest('.tsr-section-header');
                    var classParent = elData+'-is-expanded';
                    var classTarget = '.tsr-header-' + elData;
                    var targetHeight   = $(classTarget).outerHeight();

                    
                    //console.log(classParent);


                    // if somthing is expanded
                    if(elParent.is('[class*="-is-expanded"]')) { 
                            
                           // if this one is expanded
                           if(elParent.hasClass(classParent)){

                                // Animate contract accordingly
                                elParent.animate({
                                    paddingBottom: 0 ,
                                }, 350, function() {

                                    // Reset after anmation done
                                    tsrHeader.tsrTabNav.tabDesktopClickReset();

                                });
      
                             } else {
                            
                                   // if any expanded -> Reset
                                   tsrHeader.tsrTabNav.tabDesktopClickReset();

                                    // Animate expand  accordingly
                                    elParent.animate({
                                        paddingBottom: targetHeight ,
                                    }, 350);

                                    // Add expanded classes 
                                    el.parent().addClass('is-expanded');
                                    elParent.addClass(classParent);
                              }

                    // else, if nothing is expanded
                    } else {

                        // Animate expand accordingly
                        elParent.animate({
                            paddingBottom: targetHeight ,
                        }, 350);

                        // Add expanded classes
                        el.parent().addClass('is-expanded');
                        elParent.addClass(classParent);     

                    }

                    return false;
                });
                    
            }, // tabDesktopClick


            tabDesktopDestroy: function(el,elParent) {

                  //console.log('tabDesktopDestroy');
                  $('.tsr-header-mobileAndExtras a').off('click');
                   
            }, // tabMobileDestroy


            tabMobileDestroy: function(el,elParent) {

                  $('.tsr-header-mobileAndExtras a').off('click');
                  tsrHeader.tsrTabNav.tabDesktopClickReset();
                   
            }, // tabMobileDestroy


            tabMobileClickReset: function(el,elParent) {
                   
                    $('.tsr-header-mobileAndExtras a').each(function () {

                        var el = $(this);
                        var elData =  el.attr('data-header-tab');
                        var elParent = $(this).closest('.tsr-section-header');
                        var classParent = elData+'-is-expanded' ;

                        elParent.removeClass(classParent);

                    }); 

                    $('.tsr-header-mobileAndExtras li').removeClass('is-expanded');
                    $('.tsr-main-nav menu li').removeClass('is-expanded'); // Expanded submenus
                   
            }, // tabMobileClickReset


            tabMobileClick: function() {

                $('.tsr-header-mobileAndExtras a').on('click',function () {
        
                    var el = $(this);
                    var elData =  el.attr('data-header-tab');
                    var elParent = $(this).closest('.tsr-section-header');
                    var classParent = elData+'-is-expanded' ;

                       // console.log(classParent);

                    if(elParent.hasClass(classParent)){
                        tsrHeader.tsrTabNav.tabMobileClickReset(el,elParent);
                    } else {
                        tsrHeader.tsrTabNav.tabMobileClickReset(el,elParent);
                        el.parent().addClass('is-expanded');
                        elParent.addClass(classParent);
                    } 

                    return false;
                });
                    
            }, // tabMobileClick


// ** Extra for global "CLONE"

            globalCloneMobile: function(el,elParent) {
                   
                $( ".tsr-global-right menu li" ).clone().appendTo( ".tsr-nav-top-level");
                $( ".tsr-global-left" ).clone().appendTo(".tsr-main-nav");

            }, // globalCloneMobile

// ** Extra for global "CLONE"

            globalCloneDestroy: function(el,elParent) {
                   
                $( ".tsr-nav-top-level .tsr-extra").remove();
                $( ".tsr-main-nav .tsr-global-left").remove();

            } // globalCloneDestroy


     }; // tsrHeader.tsrTabNav END


   


/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// TSR - Main navigation mobile and desktop
/////////////////////////////////////////////////////////////////////////////////////////////////////////
    
     tsrHeader.tsrMainNav =  {

            mainInit: function() {
                  
                    // enquire.js
                    enquire.register("screen and (min-width:768px)", {
              
                            setup : function() {
                                
                                $('.tsr-main-nav menu > li > menu').parent().addClass('has-sub');
                                tsrHeader.tsrMainNav.mainMobileClick();

                            },
                            match : function() {

                                tsrHeader.tsrMainNav.mainMobileDestroy();
                                tsrHeader.tsrMainNav.mainDesktopClose();
                                tsrHeader.tsrMainNav.mainDesktopClick();
                                
                            },
                            unmatch : function() {

                                tsrHeader.tsrMainNav.mainDesktopDestroy();
                                tsrHeader.tsrMainNav.mainMobileClick();

                            }

                    }, true); // True -> makes the "matched" work for ie8

            }, // mainInit


            mainDesktopClose: function() {
                   
                // Close menu
                $('.tsr-main-nav .tsr-btn-close > a').on('click',function () {
                    $(this).closest('.is-expanded').children('a').trigger('click');    
                    return false;
                });
       



                // Close menu
                $('.tsr-header-login  .tsr-btn-close, .tsr-header-cart  .tsr-btn-close, .tsr-header-search  .tsr-btn-close').on('click',function () {

                     var el = $(this);
                     var elTarget =  '.tsr-tab-' + el.attr('data-parent') + '> a';
                    // console.log(elTarget);

                    $(elTarget).trigger('click');    

                    return false;
                });

            }, // mainDesktopClose


            mainDesktopClickReset: function(el,elParent) {
                
                    $('.tsr-header-mobileAndExtras a').each(function () {

                        var el = $(this);
                        var elData =  el.attr('data-header-tab');
                        var elParent = $(this).closest('.tsr-section-header');
                        var classParent = elData+'-is-expanded' ;

                        elParent.removeClass(classParent);

                    }); 

                $('.tsr-header-mobileAndExtras li').removeClass('is-expanded');
                $('.tsr-main-nav .is-expanded').removeClass('is-expanded');

            }, // mainDesktopClickReset


            mainDesktopClick: function() {

                    // Toggle menu (Desktop)
                    $('.tsr-main-nav menu .has-sub > a').on('click',function () {
                       
                        var el          = $(this);
                        var elParent    = $(this).parent();
                        var elEqual     = $('.tsr-section-header .tsr-main-nav .tsr-nav-second-level > li + li');
                        var animatedParent  = $('.tsr-section-header');


                    // if somthing is expanded
                    if(animatedParent.is('[class*="-is-expanded"]')) { 


                            // Check if main menu is expanded
                            if(animatedParent.hasClass('mainNav-is-expanded')){

                                    // Check if the clicked links es expanded or not
                                    if(elParent.hasClass('is-expanded')){                                   
                           
                                        animatedParent.animate({paddingBottom: 0,}, 450, function() {
                                            el.parent().removeClass('is-expanded');
                                            animatedParent.removeClass('mainNav-is-expanded');
                                            tsrHeader.tsrMainNav.mainDesktopClickReset();
                                        });

                                    } else {
                    
                                        
                                        // Remove class from all
                                        tsrHeader.tsrMainNav.mainDesktopClickReset();

                                        // Set class to this one
                                        el.parent().addClass('is-expanded');
                                       
                                        // Set variable with correct data
                                        elEqual = $('.tsr-section-header .tsr-main-nav .is-expanded .tsr-nav-second-level > li + li');
                                        elEqual.css('height','auto').setAllToMaxHeight()﻿;

                                        // Set variable with correct data
                                        subMenuHeight = el.next('.tsr-nav-second-level').outerHeight();

                                        // Animate menu
                                        animatedParent.animate({paddingBottom: subMenuHeight,}, 450);

                                    }

                            } else {


                                         // Remove class from all
                                        tsrHeader.tsrMainNav.mainDesktopClickReset();

                                        // Add classes
                                        el.parent().addClass('is-expanded');
                                        animatedParent.addClass('mainNav-is-expanded');
                                        
                                        // Set variable with correct data
                                        elEqual = $('.tsr-section-header .tsr-main-nav .is-expanded .tsr-nav-second-level > li + li');
                                        elEqual.css('height','auto').setAllToMaxHeight()﻿;
                                        
                                        // Set variable with correct data
                                        subMenuHeight = el.next('.tsr-nav-second-level').outerHeight();

                                        // Animate menu
                                        animatedParent.animate({paddingBottom: subMenuHeight,}, 450);

                            }

                    // else, if nothing is expanded
                    } else {
                        
                                        // Remove class from all
                                        tsrHeader.tsrMainNav.mainDesktopClickReset();

                                        // Add classes
                                        el.parent().addClass('is-expanded');
                                        animatedParent.addClass('mainNav-is-expanded');
                                        
                                        // Set variable with correct data
                                        elEqual = $('.tsr-section-header .tsr-main-nav .is-expanded .tsr-nav-second-level > li + li');
                                        elEqual.css('height','auto').setAllToMaxHeight()﻿;
                                        
                                        // Set variable with correct data
                                        subMenuHeight = el.next('.tsr-nav-second-level').outerHeight();

                                        // Animate menu
                                        animatedParent.animate({paddingBottom: subMenuHeight,}, 450);

                    } // if [class*="-is-expanded"] END    




                       
                      
                        return false;
                    });

                    
            }, // mainDesktopClick


            mainDesktopDestroy: function(el,elParent) {

               // console.log('mainDesktopDestroy');
                $('.tsr-main-nav menu a').off('click');
                $('.tsr-main-nav .tsr-btn-close > a').off('click');
                
                // Reset height
                $('.tsr-section-header .tsr-main-nav .tsr-nav-second-level > li + li').css('height','auto');

                // Reset Margin
                $('.tsr-section-header').css('paddingBottom','0');
                   
            }, // mainMobileDestroy

            mainMobileDestroy: function(el,elParent) {

               // console.log('mainMobileDestroy');
                $('.tsr-main-nav menu a').off('click');
                   
            }, // mainMobileDestroy

            mainMobileClickReset: function(el,elParent) {
                   
                // Används ej?
                // console.log('mainMobileClickReset');
                

            }, // mainMobileClickReset

            mainMobileClick: function() {
           
                    // Toggle menu mobile
                    $('.tsr-main-nav menu .has-sub > a').on('click',function () {
                        
                        var el = $(this);
                        var elParent = $(this).parent();

                        if(elParent.hasClass('is-expanded')){

                            // Remove class
                            el.parent().removeClass('is-expanded');

                        } else {
                            
                            // Add class
                            el.parent().addClass('is-expanded');

                        }
                        return false;
                    });

            } // mainMobileClick

     };

          


/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// Load
/////////////////////////////////////////////////////////////////////////////////////////////////////////

    $(window).on('load', function(){
      tsrHeader.tsrInit();
    });


/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////

})(document,jQuery);

/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// END
/////////////////////////////////////////////////////////////////////////////////////////////////////////


    

