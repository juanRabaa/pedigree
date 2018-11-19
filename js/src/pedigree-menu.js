$(document).ready(function(){
    var $menu = $(".header .menu").first();
    var $menuButton = $menu.find('.menu-icon').first();
    var $menuContent = $menu.find('.menu-content').first();

    function menuIsOpen(){
        return $menu.hasClass('active');
    }

    function openMenu(){
        $menuContent.slideDown(300, function(){
            $menu.addClass('active');
        });
    }

    function closeMenu(){
        $menuContent.slideUp(300, function(){
            $menu.removeClass('active');
        });
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
        var $content = $submenu.find('.menu-sub').first();
        var isOpen = $submenu.hasClass('active');
        //If the submenu is open
        if( isOpen ){
            $submenu.removeClass('active');
            $content.slideUp(300, function(){
                $submenu.removeClass('active');
            });
        }
        else{
            $submenu.addClass('opening');
            $content.slideDown(300, function(){
                $submenu.addClass('active');
                $submenu.removeClass('opening');
            });
        }
    });

    function updateMenu(){
        var htmlOffsetTop = $(window).scrollTop();
    	var $header = $('.header');
        var $placeHolder = $('.header-placeholder');

        if (htmlOffsetTop <= 30){
            $header.removeClass('fixed');
            $placeHolder.height( 110 );
            $header.height( 110 );
        }
        else{
            $header.addClass('fixed');
            $header.height( 50 );
            $placeHolder.height( 84 );
        }
    }

    // =========================================================================
    // MENU FIXED
    // =========================================================================
    $(document).on('scroll', function(){
        updateMenu();
    })

    //On ready
    updateMenu();
});
