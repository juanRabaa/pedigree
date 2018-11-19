$(document).ready(function(){
    var index = 0;
    var autoInterval = null;
    var intervalTimeout = null;

    // =========================================================================
    // GETTERS
    // =========================================================================
    function getCurrentIndex(){
        return $('#slider-section .slide.active').index();
    }

    function getBullets(){
        return $('#slider-section .slides-pagination .bullet');
    }

    function getNextButton(){
        return $('#slider-section .left-button');
    }

    function getPrevButton(){
        return $('#slider-section .right-button');
    }

    function getSlider(){
        return $('#slider-section');
    }

    function getSlides(){
        return $('#slider-section .slide');
    }

    function getNextIndex(){
        var index = getCurrentIndex();
        if(index == amountOfSlides() - 1)
            return 0;
        return index+1;
    }

    function getPrevIndex(){
        var index = getCurrentIndex();
        if(index == 0)
            return amountOfSlides() - 1;
        return index-1;
    }

    function amountOfSlides(){
        return getSlides().length;
    }

    // =========================================================================
    // SETTERS
    // =========================================================================
    function setCurrentImage(index){
        $slides = getSlides();
        $slides.removeClass('active');
        $($slides[index]).addClass('active');
        setCurrentBullet(index);
    }

    function setCurrentBullet(index){
        var $bullets = getBullets();
        $bullets.removeClass('active');
        $($bullets[index]).addClass('active');
    }

    // =========================================================================
    // METHODS
    // =========================================================================
    function goToNext(){
        setCurrentImage( getNextIndex() );
    }

    function goToPrev(){
        setCurrentImage( getPrevIndex() );
    }

    // =========================================================================
    // EVENTS
    // =========================================================================
    $(document).on('click', '#slider-section .left-button', function(){
        goToPrev();
    });

    $(document).on('click', '#slider-section .right-button', function(){
        goToNext();
    });

    $(document).on('click', '#slider-section .bullet', function(){
        var index = $(this).index();
        setCurrentImage(index);
    });

    // =========================================================================
    // VIDEO
    // =========================================================================
    var player = null;

    function openVideoPanel(videoID){
        var $slider = getSlider();
        var $videoPanel = $slider.children('.video-container');
        $videoPanel.css("display", "flex");
        $videoPanel.hide();
        if(!player){
            if(YT){
                player = new YT.Player('slide-video', {
                    height: '1024',
                    width: '860',
                    videoId: videoID,
                    events: {
                        'onReady': function(event){
                            event.target.playVideo();
                        },
                    }
                });
            }
        }
        else {
            var video_data = player.getVideoData();
            if( video_data['video_id'] == videoID )
                player.playVideo();
            else
                player.loadVideoById(videoID);
        }
        $videoPanel.fadeIn();
    }

    function closeVideoPanel(){
        var $slider = getSlider();
        var $videoPanel = $slider.children('.video-container');
        if(player){
            player.pauseVideo();
        }
        $videoPanel.fadeOut();
    }

    $(document).on('click', '#slider-section .slide.active .play-button', function(){
        var videoID = $(this).closest('.slide').attr('data-url');
        if( videoID ){
            openVideoPanel(videoID);
        }
    });

    $(document).on('click', '#slider-section .video-container .exit-button', function(){
        closeVideoPanel();
    });

    $(document).on('click', '#slider-section .video-container', function(event){
        if( !$(event.target).is('#slide-video') )
            closeVideoPanel();
    });

    // =========================================================================
    // SWIPE
    // =========================================================================
    var hammertime = new Hammer( document.getElementById("slider-section") );

    hammertime.on('swipeleft', function(ev) {
        goToNext();
    });
    hammertime.on('swiperight', function(ev) {
        goToPrev();
    });
});
