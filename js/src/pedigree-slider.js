$(document).ready(function(){
    var $slider = $('.slider.home').first();
    var $slide = $slider.find('.slide').first();
    var $leftButton = $slider.find('.left-button').first();
    var $rightButton =  $slider.find('.right-button').first();
    var $bullets = $slider.find('.slides-pagination .bullet');

    var images = ['assets/img/dog.jpg', 'assets/img/dog2.jpg', 'assets/img/dog3.jpg', 'assets/img/dog4.jpg'];
    var index = 0;
    var autoInterval = null;
    var intervalTimeout = null;

    function loadImages(){
        images.forEach(function(imgSrc){
            var image = new Image();
            image.src = imgSrc;
            image.onload = function(){
                console.log(imgSrc);
            };
        });
    }

    function setCurrentImage(){
        $slide.css('background-image', 'url('+ images[index] +')');
        setCurrentBullet();
    }

    function setCurrentBullet(){
        $bullets.removeClass('active');
        $($bullets[index])  .addClass('active');
    }

    function setNextIndex(){
        if(index == images.length - 1)
            index = -1;
        index++;
    }

    function setAutoInterval(){
        autoInterval = setInterval(function(){
            setNextIndex();
            setCurrentImage();
        }, 3000);
    }

    function resetAutoInterval(){
        clearInterval(autoInterval);
        setTimeout(function(){
            setAutoInterval();
        }, 3000);
    }

    $leftButton.on('click', function(){
        if(index == 0)
            index = images.length;
        index--;
        cleanAutoInterval();
        setCurrentImage();
    });

    $rightButton.on('click', function(){
        setNextIndex();
        setCurrentImage();
    });

    $bullets.on('click', function(){
        index = $(this).index();
        setCurrentImage();
    });

    loadImages();
});
