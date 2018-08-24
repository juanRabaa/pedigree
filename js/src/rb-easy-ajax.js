/*Transitions Types*/
/*************************************************************************************************/
var contentTransitions = {
    slideUp: {
        animating: false,
        beforeSend: function( ajaxOnePageObject, newContent ){
            var $element = ajaxOnePageObject.$ajaxStableContent();
            this.animating = true;
            var _this = this;
            $element.stop().slideUp(function(){
                _this.animating = false;
            });
        },
        success: function( ajaxOnePageObject, newContent, fastCharge ){
            var $result = $($.parseHTML(newContent));
            var $element = ajaxOnePageObject.$ajaxStableContent();

            $element.html($result);
            if ( fastCharge )
                $element.stop(false, true).slideDown(function(){
                    $element.css('height', 'auto');
                });
            else{
                setTimeout(function(){
                    $element.stop(false, true).slideDown(function(){
                        $element.css('height', 'auto');
                    });
                }, 200);
            }
        }
    },
    /*adaptHeight: {
        animating: false,
        beforeSend: function( ajaxOnePageObject, newContent ){
            var $element = ajaxOnePageObject.$ajaxStableContent();
            var currentHeight = $element.outerHeight();
            this.animating = true;
            $element.css('height', currentHeight);
            $element.animate({
                opacity: 0,
            }, 200, function(){
                this.animating = false;
            });
        },
        success: function( ajaxOnePageObject, newContent ){
            //Holder to get a complete height
            var $holder = $('<div></div>');
            var $result = $holder.html(newContent);
            var $element = ajaxOnePageObject.$ajaxStableContent();
            var currentHeight = $element.outerHeight();

            $element.css('height', currentHeight);

            while ( this.animating ){}

            $element.html('');
            $result.appendTo($element);
            setTimeout(function(){
                console.log( $result.outerHeight());
                console.log( $result );
                $element.animate({
                    opacity: 1,
                    height: $result.outerHeight(),
                }, 200);
            }, 200);

        }
    }*/
}


/*Loading Types*/
/*************************************************************************************************/

var loadingTypes = {
    slideUp: {
        activate: function( ajaxOnePageObject ){
            var $loadingElement = ajaxOnePageObject.getLoadingElement();
            if ( $loadingElement ){
                $loadingElement.slideDown();
            }
        },
        deactivate: function( ajaxOnePageObject ){
            var $loadingElement = ajaxOnePageObject.getLoadingElement();
            if ( $loadingElement ){
                $loadingElement.slideUp();
            }
        },
    }
}

/*DATA ATTRIBUTES NAME*/
/***************************************************************************************************/
var ajaxAttributesNames = {
    baseAjax: 'ajax-one-page',
    baseUrl: 'ajax-one-page-url',//url that will process the request
    baseAction: 'ajax-one-page-action',//a value to the action variable being passed to the url, if provided
    baseSelector: 'ajax-one-page-selector',//the selector to find on the ajax result
    goBackButton: 'data-ajax-go-back',//triggers the go back event
    loadingElement: 'data-ajax-load-status',//gets active when loading
    dinamicElement: 'data-ajax-dinamic', //Will be recieving the new content
}

function AJAXOnePage( $AjaxHolder, principalSlug, _url, _action = "" ){
    var ajaxOnePageObject = this;
    this.$AjaxHolder = $AjaxHolder;
    this.$AjaxDinamicHolder = $AjaxHolder.find('['+ ajaxAttributesNames.dinamicElement +']');
    this.resultSelector = $AjaxHolder.attr(ajaxAttributesNames.baseSelector);
    this.principalSlug = principalSlug;
    this.ajaxurl = _url;
    this.ajaxDataAction = _action;
    this.firstContent = this.$AjaxDinamicHolder.html();
    this.pagesHistory = [principalSlug];
    this.data = {};
    this.data[principalSlug] = this.firstContent;
    this.config = {
        transition: contentTransitions.slideUp,
        loadingType: loadingTypes.slideUp,
    }
    this.status = {
        loading: false,
    }

    this.$ajaxNewContent = function(){
        return this.$AjaxDinamicHolder.children('[data-ajax-new-content]');
    }

    this.$ajaxStableContent = function(){
        return this.$AjaxDinamicHolder.children('[data-ajax-stable-content]');
    }

    this.goBack = function(){
        console.log(this.pagesHistory.length);
        if ( this.pagesHistory.length > 1 && !this.isLoading() ){
            var previousContentPath = this.pagesHistory[ this.pagesHistory.length - 2 ];
            //console.log(previousContentPath, this.data[previousContentPath]);
            this.fastContentLoad(this.data[previousContentPath]);
            this.pagesHistory.pop();
            this.toggleBackButton();
        }
    }

    this.isLoading = function(){
        return this.status.loading;
    }

    this.activeLoadingStatus = function(){
        this.$AjaxHolder.addClass('loading-ajax-content');
        this.activateLoadingElement();
        this.status.loading = true;
    }

    this.deactivateLoadingStatus = function(){
        this.$AjaxHolder.removeClass('loading-ajax-content');
        this.deactivateLoadingElement();
        this.status.loading = false;
    }

    this.getLoadingElement = function(){
        return this.$AjaxHolder.find('['+ ajaxAttributesNames.loadingElement +']');
    }

    this.activateLoadingElement = function(){
        this.config.loadingType.activate(this);
    }

    this.deactivateLoadingElement = function(){
        this.config.loadingType.deactivate(this);
    }

    this.$AjaxHolder.on('click','[data-ajax-stable-content] a[href*="'+ this.principalSlug +'"]',function(e){
	 	e.preventDefault();

        if ( !ajaxOnePageObject.$AjaxHolder.hasClass('loading-ajax-content') ){
    	 	var url = $(this).attr('href');
            var regex = '(' + ajaxOnePageObject.principalSlug + '\/*.*)(?<!\/$)';
            var regexMatch = url.match(regex);
            var pagePath = url.match(regex)[0];
            if ( regexMatch[1] )
                pagePath = regexMatch[1];

            var ajaxUrl = url;
            if ( ajaxOnePageObject.ajaxurl )
                 ajaxUrl = ajaxOnePageObject.ajaxurl;

            ajaxOnePageObject.pagesHistory.push(pagePath);
            console.log(ajaxOnePageObject.pagesHistory);
            if ( ajaxOnePageObject.data[pagePath] ){
                ajaxOnePageObject.fastContentLoad(ajaxOnePageObject.data[pagePath]);
                console.log('In DB');
                ajaxOnePageObject.onLoadingEnds();//PASAR A FORMAR PARTE DEL TIPO DE TRANSICION
            }
            else{
                $.ajax({
        			url : ajaxUrl,
        			type: 'post',
                    data: {
        				action : ajaxOnePageObject.ajaxDataAction,
        				page_path: pagePath
        			},
        			beforeSend: function(){
                        ajaxOnePageObject.onLoadingStarts();
                        ajaxOnePageObject.getContentTransition().beforeSend( ajaxOnePageObject, '' );
        			},
        			success: function(resultado){
                        console.log(resultado);
                        console.log(ajaxOnePageObject.resultSelector);
                        if ( ajaxOnePageObject.resultSelector )
                            resultado = $(resultado).find(ajaxOnePageObject.resultSelector).html();
                    //setTimeout( function(){
                        ajaxOnePageObject.getContentTransition().success( ajaxOnePageObject, resultado );
                        ajaxOnePageObject.data[pagePath] = resultado;
                        ajaxOnePageObject.onLoadingEnds();
                    //}, 200);
        			}
        		});
            }
        }
	});

    this.onLoadingStarts = function(){
        this.activeLoadingStatus();
    };

    this.onLoadingEnds = function(){
        this.deactivateLoadingStatus();
        this.toggleBackButton();
    };

    this.fastContentLoad = function( content ){
        this.getContentTransition().beforeSend( this, content );
        this.getContentTransition().success( this, content, true );
    }

    this.toggleBackButton = function(){
        var $goBackButton = this.$goBackButton();
        console.log($goBackButton);
        console.log(this.pagesHistory.length);
        if ( this.pagesHistory.length == 1 )
            $goBackButton.slideUp();
        else
            $goBackButton.slideDown();
    }

    this.$goBackButton = function(){
        return this.$AjaxHolder.find('['+ ajaxAttributesNames.goBackButton +']');
    }

    this.$AjaxHolder.on('click','['+ ajaxAttributesNames.goBackButton +']',function(e){
	 	e.preventDefault();
        ajaxOnePageObject.goBack();
	});

    this.getContentTransition = function(){
        return this.config.transition;
    }

    this.initialize = function(){
        if ( !this.$ajaxNewContent.length || !this.$ajaxStableContent.length ){
            this.$AjaxDinamicHolder.html('');
            this.$AjaxDinamicHolder.append('<div data-ajax-stable-content>'+ this.firstContent +'</div>');
            this.$AjaxDinamicHolder.append('<div data-ajax-new-content></div>');
        }
        this.onLoadingEnds();
    }

    $( document ).ready(function(){
        ajaxOnePageObject.initialize();
    })

}

$( document ).ready(function(){
    $('['+ ajaxAttributesNames.baseAjax +']').each( function(){
        var principalSlug = $(this).attr(ajaxAttributesNames.baseAjax);
        var url = $(this).attr(ajaxAttributesNames.baseUrl);
        var action = $(this).attr(ajaxAttributesNames.baseAction);
        new AJAXOnePage($(this), principalSlug, url, action);
    });
})
