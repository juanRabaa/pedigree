$(document).ready(function(){
    var $slider = $('.slider.home').first();
    var $slides = $slider.find('.slide');
    var amountOfSlides = $slides.length;
    var $leftButton = $slider.find('.left-button').first();
    var $rightButton =  $slider.find('.right-button').first();
    var $bullets = $slider.find('.slides-pagination .bullet');

    var index = 0;
    var autoInterval = null;
    var intervalTimeout = null;

    function setCurrentImage(){
        $slides.removeClass('active');
        $($slides[index]).addClass('active');
        setCurrentBullet();
    }

    function setCurrentBullet(){
        $bullets.removeClass('active');
        $($bullets[index]).addClass('active');
    }

    function setNextIndex(){
        if(index == amountOfSlides - 1)
            index = -1;
        index++;
    }

    $leftButton.on('click', function(){
        if(index == 0)
            index = amountOfSlides;
        index--;
        setCurrentImage();
    });

    $rightButton.on('click', function(){
        console.log($slides);
        setNextIndex();
        setCurrentImage();
    });

    $bullets.on('click', function(){
        index = $(this).index();
        setCurrentImage();
    });

});
