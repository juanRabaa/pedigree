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

    // =========================================================================
    // Toggle menu
    // =========================================================================
    $menuButton.on('click', function(){
        if( menuIsOpen() )
            closeMenu();
        else
            openMenu();
    });
    // =============================================================================
    // Toggle submenu
    // =============================================================================
    $menu.on('click', '.submenu-button .down-button', function(){
        var $submenu = $(this).closest('.submenu-button');
        var isOpen = $submenu.hasClass('active');
        //If the submenu is open
        if( isOpen ){
            $submenu.removeClass('active');
        }
        else
            $submenu.addClass('active');
    });
});
