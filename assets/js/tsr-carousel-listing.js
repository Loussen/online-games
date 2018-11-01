

/*
TSR - CAROUSEL LISTING
*/


;(function(document,$) {


    window.tsrCarouselListing = window.tsrCarouselListing || {};

/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// TSR - Init
/////////////////////////////////////////////////////////////////////////////////////////////////////////


    tsrCarouselListing.tsrInit = function() {

        tsrCarouselListing.tsrEqualHeights();
        tsrCarouselListing.tsrCarouselInit();

    };



/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// TSR JQUERY FN - Equal heights
/////////////////////////////////////////////////////////////////////////////////////////////////////////

    // Thanks Paul Irish
    $.fn.setAllToMaxHeight = function(){
        return this.height( Math.max.apply(this, $.map( this , function(e){ return $(e).height() }) ) );
    };

/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// TSR - Equal heights
/////////////////////////////////////////////////////////////////////////////////////////////////////////

    tsrCarouselListing.tsrEqualHeights = function () {


        $('.tsr-section-carousel-listing').each(function () {

            var bw = $('body').width();
            var el = $(this);
            var itemHeight 	= $('.tsr-slides > a' , this).outerHeight() - 1 ;

            if(bw >= 600){

                // Service
                $('.tsr-service-desc', this).css('height', 'auto').setAllToMaxHeight();﻿
                $('.tsr-service-price', this).css('height', 'auto').setAllToMaxHeight();﻿
                $('.tsr-service-header', this).css('height', 'auto').setAllToMaxHeight();﻿

                // Product
                $('.tsr-product-header', this).css('height', 'auto').setAllToMaxHeight();﻿
                $('.tsr-product-colors', this).css('height', 'auto').setAllToMaxHeight();﻿
                $('.tsr-product-desc', this).css('height', 'auto').setAllToMaxHeight();﻿
                $('.tsr-product-price', this).css('height', 'auto').setAllToMaxHeight();﻿
                $('.tsr-product-small-print', this).css('height', 'auto').setAllToMaxHeight();﻿
            } else {

                // Service
                $('.tsr-service-desc' , this).css('height', 'auto');
                $('.tsr-service-price' , this).css('height', 'auto');
                $('.tsr-service-header', this).css('height', 'auto');

                // Product
                $('.tsr-product-header', this).css('height', 'auto');
                $('.tsr-product-colors', this).css('height', 'auto');
                $('.tsr-product-desc' , this).css('height', 'auto');
                $('.tsr-product-price' , this).css('height', 'auto');
                $('.tsr-product-small-print' , this).css('height', 'auto');

            }



            //console.log('item height equal: ' + itemHeight);

        });

    };


/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// TSR - Carousel Init
/////////////////////////////////////////////////////////////////////////////////////////////////////////


    tsrCarouselListing.tsrCarouselInit = function () {


        $('.tsr-section-carousel-listing').each(function () {

            var item 		= $('.tsr-slides > a' , this);
            var totalWidth = 0;

            // Calc width
            $(item).each(function() {
                totalWidth += $(this).outerWidth( true );

            });

            // New carousel instance
            var carousel = new CarouselController($(this), totalWidth);

        }); // Each END


    }; // Func END



/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// TSR - Carousel controller
/////////////////////////////////////////////////////////////////////////////////////////////////////////

    function CarouselController(target, totalWidth) {
        var self 			= this;
        self.fireCarousel 	= true;
        self.el 			= $(target);
        self.section 		= $(target);
        self.item 			= $('.tsr-slides > a' , target);
        self.itemHeight 	= $('.tsr-slides > a' , target).outerHeight() - 1 ;
        self.container 		= $('.tsr-container'  , target);
        self.totalWidth  	= totalWidth;

        // Onload
        self.onWindowResize();

        // Resize
        $(window).smartresize(function(){
            self.onWindowResize.apply(self);
        });

    }


/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// TSR - Carousel conditions
/////////////////////////////////////////////////////////////////////////////////////////////////////////

    CarouselController.prototype.onWindowResize = function() {
        var self = this;
        var bw = $('body').width();

        if(bw >= 768 ){

            if(bw <= self.totalWidth + 30) {

                if(self.fireCarousel){

                    self.container.height(self.itemHeight + 11);
                    self.section.addClass('tsr-slider-init');
                    self.container.width('100%');

                    // Do the flex
                    self.container.flexslider({
                        animation: "slide",
                        namespace: "tsr-",
                        selector: ".tsr-slides > a",
                        animationLoop: false,
                        slideshow: false,
                        itemWidth: 240,
                        itemMargin: 0,
                        minItems: 2,
                        maxItems: 12,
                        controlNav: false,
                        directionNav: true,
                        prevText: "",
                        nextText: "",

                    });

                    self.fireCarousel = false;

                }

            } else {


                if(!self.fireCarousel){
                    self.fireCarousel = true;
                    self.container.flexslider('destroy');
                    $('.tsr-control-nav', this).remove();
                    self.section.removeClass('tsr-slider-init');
                }

                self.container.width(self.totalWidth + 24);
                self.container.height(self.itemHeight);

            }

        } else {

            if(!self.fireCarousel){
                self.fireCarousel = true;
                self.container.flexslider('destroy');
                self.section.removeClass('tsr-slider-init');
                $('.tsr-control-nav', this).remove();
            }

            self.container.width('100%');
            self.container.height('auto');

        }

    }; // Func END




/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// Load
/////////////////////////////////////////////////////////////////////////////////////////////////////////

    $(window).on('load', function(){

        tsrCarouselListing.tsrInit();

    });


/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////

})(document,jQuery);

/////////////////////////////////////////////////////////////////////////////////////////////////////////
////// END
/////////////////////////////////////////////////////////////////////////////////////////////////////////
