$(document).ready(function(){
    var $menu = $(".header .menu").first();
    var $menuButton = $menu.find('.menu-icon').first();

    function menuIsOpen(){
        return $menu.hasClass('active');
    }

    function openMenu(){
        console.log($menu);
        $menu.addClass('active');
    }

    function closeMenu(){
        $menu.removeClass('active');
    }

    $menuButton.on('click', function(){
        if( menuIsOpen() )
            closeMenu();
        else
            openMenu();
    });
});
