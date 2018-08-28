$(document).ready(function(){
    var $slider = $('.slider.home').first();
    var $slide = $slider.find('.slide').first();
    var $leftButton = $slider.find('.left-button').first();
    var $rightButton =  $slider.find('.right-button').first();
    var $bullets = $slider.find('.slides-pagination .bullet');

    var images = ['assets/img/dog.jpg', 'assets/img/dog2.jpg', 'assets/img/dog3.jpg', 'assets/img/dog4.jpg'];
    var index = 0;

    function setCurrentImage(){
        console.log(index);
        $slide.css('background-image', 'url('+ images[index] +')');
        setCurrentBullet();
    }

    function setCurrentBullet(){
        $bullets.removeClass('active');
        $($bullets[index])  .addClass('active');
    }

    $leftButton.on('click', function(){
        if(index == 0)
            index = images.length;
        index--;
        setCurrentImage();
    });

    $rightButton.on('click', function(){
        if(index == images.length - 1)
            index = -1;
        index++;
        setCurrentImage();
    });

    $bullets.on('click', function(){
        index = $(this).index();
        setCurrentImage();
    });
});
