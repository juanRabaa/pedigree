var imageSliderTypes = {
    backgroundType: {
        time: 4000,
        styles: {
            interval: {
                'transform': 'scale(1.2)',
            },
            base: {
                'transition': 'transform 20s',
            }
        },
        animTimeout: null,
        animation: function( rgImageSliderObject ){
            var $currentImage = rgImageSliderObject.$currentImage();
            rgImageSliderObject.goToNext();
        },
        goToNext: function( rgImageSliderObject ){
            var $currentImage = rgImageSliderObject.$currentImage();

            /*Fast zoom in effect*/
            $currentImage.css('transition', 'transform 1s');
            $currentImage.css('transform', 'scale(2)');

            $currentImage.finish().animate({
                'opacity': '0',
            }, 200, function(){
                $currentImage.css('transition', 'transform 0s');
                $currentImage.css('transform', 'scale(1)');
                $currentImage.css('opacity', '1');
                rgImageSliderObject.animationEnds();
            });
        },
        goToPrevious: function( rgImageSliderObject ){
            var $currentImage = rgImageSliderObject.$currentImage();

            /*Fast zoom in effect*/
            $currentImage.css('transition', 'transform 1s');
            $currentImage.css('transform', 'scale(2)');

            $currentImage.finish().animate({
                'opacity': '0',
            }, 200, function(){
                $currentImage.css('transition', 'transform 0s');
                $currentImage.css('transform', 'scale(1)');
                $currentImage.css('opacity', '1');
                rgImageSliderObject.animationEnds();
            });
        }
    }
}

var imageSliderAttributes = {
    baseHolder: 'rb-images-slider',
    dinamicElement: 'rb-image-slider-dinamic',
    sliderImage: 'rg-image-slider-image',
    currentImage: 'rb-images-slider-current',
    nextImage: 'rb-images-slider-next',
    previousImage: 'rb-images-slider-previous',
}



function rbImageSlider ( $holder ){
    var rgImageSliderObject = this;
    this.$holder = $holder;
    this.$dinamicElement = $holder.find('['+ imageSliderAttributes.dinamicElement +']');
    this.images = $holder.attr(imageSliderAttributes.baseHolder).split(',');
    this.imagesLength = this.images.length;
    this.currentIndex = 0;
    this.config = {
        type: imageSliderTypes.backgroundType,
        interval: true,
        turnAround: true,
    }
    this.rbStatus = {
        movingForwards: true,
    }
    this.animInterval = null;

    console.log(this.images);

    //Information methods//
    this.hasInterval = function(){
        return this.config.interval;
    }

    this.hasTurnAround = function(){
        return this.config.turnAround;
    }

    this.getSliderType = function(){
        return this.config.type;
    }

    this.$currentImage = function(){
        return this.$dinamicElement.find('['+ imageSliderAttributes.currentImage +']');
    }

    this.$nextImage = function(){
        return this.$dinamicElement.find('['+ imageSliderAttributes.nextImage +']');
    }

    this.changeBackImageTo = function( index ){
        var src = this.images[index];
        this.$nextImage().css('background-image', 'url('+ src +')');
    }

    this.changeBackImageToNext = function(){
        this.changeBackImageTo(this.getNextIndex());
    }

    this.changeBackImageToPrevious = function(){
        this.changeBackImageTo(this.getPreviousIndex());
    }

    this.$images = function(){
        return this.$dinamicElement.children();
    }

    //Current image ON THE ARRAY
    this.currentImageSrc = function(){
        return this.images[this.currentIndex];
    }

    //Next image ON THE ARRAY
    this.nextImageSrc = function(){
        if ( this.currentIndex != (this.imagesLength - 1) )//if not last
            return this.images[this.currentIndex + 1];
        else if ( this.hasTurnAround() )//if last AND turn around avaible
            return this.images[0];
        return '';
    }

    //Previous image ON THE ARRAY
    this.previousImageSrc = function(){
        if ( this.currentIndex != 0 )//if not first
            return this.images[this.currentIndex - 1];
        else if ( this.hasTurnAround() )//if first AND turn around avaible
            return this.images[ (this.imagesLength - 1) ];
        return '';
    }

    this.initialize = function(){
        this.initializeHTML();
        this.initializeStyles();
        if ( this.hasInterval() )
            this.initializeAnimation();
    }

    this.initializeHTML = function(){
        var $nextImage = $('<div ' + imageSliderAttributes.nextImage + ' ></div>')
            .css('background-image', 'url('+ this.nextImageSrc()+ ')');
        var $currentImage = $('<div ' + imageSliderAttributes.currentImage + ' ></div>')
            .css('background-image', 'url('+ this.currentImageSrc()+ ')');

        $nextImage.appendTo( this.$dinamicElement );
        $currentImage.appendTo( this.$dinamicElement );

        this.$holder.on('click', '['+ imageSliderAttributes.nextImage +']', function(){
            rgImageSliderObject.goToNext();
        });
        this.$holder.on('click', '['+ imageSliderAttributes.previousImage +']', function(){
            rgImageSliderObject.goToPrevious();
        });
    }

    this.initializeStyles = function(){
        var holderPosition = this.$holder.css('position');
        if ( holderPosition == 'static' )
            this.$holder.css('position', 'relative');

        this.$dinamicElement.css({
            'overflow': 'hidden',
            'position': 'relative'
        });

        this.applyImagesBaseStyle();
    }

    this.initializeAnimation = function(){
        this.animInterval = setInterval( function(){
            this.getSliderType().animation( this );
        }, this.getSliderType().time );
        this.applyIntervalStyles();
    }

    this.applyIntervalStyles = function(){
        //console.log(this.getSliderType().styles.interval);
        this.$currentImage().css( this.getSliderType().styles.interval );
    }

    this.applyImagesBaseStyle = function(){
        this.$images().css({
            'width': '100%',
            'height': '100%',
            'background-size': 'cover',
            'background-position': 'center',
            'background-attachment': 'fixed',
            'background-repeat': 'no-repeat',
            'position': 'absolute',
            'top': 0,
            'left': 0,
        }).css( this.getSliderType().styles.base );
    }

    this.resetAnimation = function(){
        clearInterval(this.animInterval);
        this.applyImagesBaseStyle();
        this.initializeAnimation();
    }

    this.goToNext = function(){
        this.rbStatus.movingForwards = true;
        this.changeBackImageToNext();
        this.getSliderType().goToNext( this );
    }

    this.goToPrevious = function(){
        this.rbStatus.movingForwards = false;
        this.changeBackImageToPrevious();
        //this.$nextImage().css('background-image', 'url('+ this.previousImageSrc() +')');
        console.log(this.previousImageSrc());
        this.getSliderType().goToPrevious( this );
    }

    this.getNextIndex = function(){
        var index = this.currentIndex + 1;
        if ( index == this.imagesLength )
            index = 0;
        return index;
    }

    this.getPreviousIndex = function(){
        var index = this.currentIndex - 1;
        if ( index <= -1 )
            index = this.imagesLength-1;
        return index;
    }

    this.animationEnds = function(){
        this.updateIndex();
        this.updateImagesSrcs();
        this.applyImagesBaseStyle();
        if ( rgImageSliderObject.hasInterval() )
            rgImageSliderObject.resetAnimation();
    }

    this.updateIndex = function(){
        if ( this.rbStatus.movingForwards )
            this.currentIndex = this.getNextIndex();
        else
            this.currentIndex = this.getPreviousIndex();
        //console.log(this.currentIndex);
    }

    this.updateImagesSrcs = function(){
        this.$currentImage().css('background-image', this.$nextImage().css('background-image') );
    }

    this.initialize();
}

$( document ).ready(function(){
    $('[' + imageSliderAttributes.baseHolder +']').each(function(){
        rbImageSlider($(this));
    })
})
