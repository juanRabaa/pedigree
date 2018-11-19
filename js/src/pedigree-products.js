$(document).ready(function(){
    function changeContent($table, content){
        var $contentElement = $table.find('.content').first();
        //var currentHeight = $contentElement.height();
        $contentElement.addClass('animating');
        $contentElement.html(content);
        // var nextHeight = $contentElement.height();
        // $contentElement.height(currentHeight);
        // setTimeout(function(){
        //     $contentElement.height(nextHeight);
        // }, 20);
        // setTimeout(function(){
        //     $contentElement.height('auto');
        // }, 200);
        setTimeout(function(){
            $contentElement.removeClass('animating');
        }, 1);
    }

    function activateTab($tab){
        var $table = $tab.closest('.product-table');
        if( !$tab.hasClass('active') ){
            $table.find('.trigger').removeClass('active');
            $tab.addClass('active');
            changeContent( $table, $tab.attr('data-content') );
        }
    }

    $(document).on('click', '.pedigree-product .product-table .trigger', function(){
        activateTab($(this));
    });

    // =========================================================================
    // STARS
    // =========================================================================
    function RB_star($element, direction, images){
        this.$element = $element;
        this.direction = direction;
        this.$star = $('<div class="rb-star"><img/></div>');
        this.images = images ? images : ["https://purepng.com/public/uploads/large/purepng.com-yellow-starstargeometricallydecagonconcavestardomyellow-stargold-1421526501428nalhw.png"];

        this.render = function(){
            this.$star.appendTo('body');
            this.$star.find('img').attr('src', this.getRandomImageSrc() );
        };

        this.getRandomImageSrc = function(){
            var length = this.images.length;
            var randIndex = Math.round( Math.random() * length );
            return this.images[randIndex];
        }

        this.getElementCenter = function(){
            var elementHeight = this.$element.height();
            var elementWidth = this.$element.width();
            var elementOffset = this.$element.offset();
            var elementCenter = {
                top: elementOffset.top + elementHeight/2,
                left: elementOffset.left + elementWidth/2,
            };
            return elementCenter;
        };

        this.positionStarOnElementCenter = function(){
            elementCenter = this.getElementCenter();
            this.$star.css({
                position: 'absolute',
                top: elementCenter.top - this.$star.height()/2 + 'px',
                left: elementCenter.left - this.$star.width()/2  + 'px',
            })
        };

        this.animate = function(){
            this.positionStarOnElementCenter();
            var elementHeight = this.$element.height();
            var elementWidth = this.$element.width();
            var starOffset = this.$star.offset();

            var directionDistance = this.direction == 1 ? elementWidth/2 + 50 : - (elementWidth/2 + 50);
            var newLeft = starOffset.left + directionDistance;
            var newTop = starOffset.top - (elementHeight/2 * Math.random());
            var animationTime = 600 + ( 400 * Math.random() );
            var $star = this.$star;

            $star.animate({
                left:  newLeft + 'px',
            }, { duration: animationTime, queue: false});

            // $star.animate({
            //     opacity: 0,
            // }, { duration: animationTime + 100, queue: false });

            $star.animate({
                top:  newTop + 'px',
            }, { duration:  animationTime/1.5, queue: false, complete: function(){
                $star.animate({
                    top: newTop * 1.2 + 'px',
                    opacity: 0,
                }, animationTime/3, function(){
                    $star.remove();
                });
            }});

        };
    }

    function startAnimationOn($element, amount, images){
        for( var i = 0; i < amount; i++){
            var direction = Math.random() > 0.5 ? 1 : 2;
            var star = new RB_star($element, direction, images);
            star.render();
            star.animate();
        }
    }

    $('.related-posts.products-list-boxes .post-box .product-image img').on('mouseover', function(){
        var images = JSON.parse($(this).closest('.product-image').attr('data-images'));
        if($.isArray(images) && images[0]){
            startAnimationOn($(this), 25, images);
        }
    });


});

// =========================================================================
// SUCURSALES
// =========================================================================
function similarity(s1, s2) {
  var longer = s1;
  var shorter = s2;
  if (s1.length < s2.length) {
    longer = s2;
    shorter = s1;
  }
  var longerLength = longer.length;
  if (longerLength == 0) {
    return 1.0;
  }
  return (longerLength - editDistance(longer, shorter)) / parseFloat(longerLength);
}

function editDistance(s1, s2) {
  s1 = s1.toLowerCase();
  s2 = s2.toLowerCase();

  var costs = new Array();
  for (var i = 0; i <= s1.length; i++) {
    var lastValue = i;
    for (var j = 0; j <= s2.length; j++) {
      if (i == 0)
        costs[j] = j;
      else {
        if (j > 0) {
          var newValue = costs[j - 1];
          if (s1.charAt(i - 1) != s2.charAt(j - 1))
            newValue = Math.min(Math.min(newValue, lastValue),
              costs[j]) + 1;
          costs[j - 1] = lastValue;
          lastValue = newValue;
        }
      }
    }
    if (i > 0)
      costs[s2.length] = lastValue;
  }
  return costs[s2.length];
}

function Pedigree_Places_List( $list, $controls ){
    var Pedigree_Places_List = this;
	this.$list = $list;
    this.indexPositions = [];
    this.$items = $list.find('.branch-item');
    this.$controls = $controls;
    this.filters = {
        prov: '',
        localidad: '',
    };

    this.saveCurrentIndexes = function(){
        this.indexPositions = [];
        this.$items.each(function(){
            var index = $(this).index();
            var offset = $(this).offset();
            Pedigree_Places_List.indexPositions[index] = {
                top: offset.top,
                left: offset.left
            }
            $(this).attr('data-prev-index', $(this).index());
        });
    };

    // =============================================================================
    // GETTERS
    // =============================================================================
    this.getDataByAttr = function(attr){
        var provincias = [];
        this.$items.each(function(){
            var prov = $(this).attr(attr);
            if( provincias.indexOf(prov) == -1 && prov != '' )
                provincias.push(prov);
        });
        return provincias;
    };

    this.getPlacesOrderedBy = function(attr){
        var els = this.$items.get();
        els.sort(function(el1, el2){
            return $(el1).attr(attr).trim().localeCompare($(el2).attr(attr).trim());
        });
        return els;
    };

    // =========================================================================
    // FILTER AND ORDER
    // =========================================================================
    this.filterByAll = function(){
        var List = this;
        this.$items.each(function(){
            var prov = $(this).attr('data-prov').toLowerCase().replace(/\s/g, "");
            var localidad =  $(this).attr('data-localidad').toLowerCase().replace(/\s/g, "");
            // var simProv = Pedigree_Places_List.filters.prov != '' ? similarity(prov, Pedigree_Places_List.filters.prov) : 1;
            // var simLocalidad = Pedigree_Places_List.filters.localidad != '' ? similarity(localidad, Pedigree_Places_List.filters.localidad) : 1;
            var isFromProv = false;
            var isFromLocalidad = false;
            if( List.filters.prov == '' || prov == '' || ( prov == List.filters.prov.toLowerCase().replace(/\s/g, "") ) )
                isFromProv = true;
            if( List.filters.localidad == '' || localidad == '' || ( localidad == List.filters.localidad.toLowerCase().replace(/\s/g, "") ) )
                isFromLocalidad = true;

            if( isFromProv && isFromLocalidad )
                $(this).slideDown(100);
            else
                $(this).slideUp(100);
        });
    };

    this.filterBy = function( attr, val ){
        this.$items.each(function(){
            var currentValue = $(this).attr(attr);
            var sim = similarity(currentValue, val);
            if( sim < 0.4 )
                $(this).slideUp(100);
            else
                $(this).slideDown(100);
        });
    };

    this.orderPlacesBy = function(attr, animate){
        this.saveCurrentIndexes();
        var els = this.getPlacesOrderedBy(attr);
        if(animate){
            this.$list.height( this.$list.height() );
            els.forEach(function(el, index){
                if( index == els.length - 1 ){
                    moveItemToNewIndex( $(el), index, function(){
                        $('.branches-list').html(els);
                        Pedigree_Places_List.$list.height( 'auto' );
                    });
                }
                else
                    moveItemToNewIndex( $(el), index );
            });
        }
        else{
            this.$list.html(els);
        }
    };

    this.orderPlacesByName = function(animate){
        this.orderPlacesBy('data-name', animate);
    };

    // =============================================================================
    // ANIMATION
    // =============================================================================
    this.moveItemToNewIndex = function( $item, newIndex, cb ){
        var offset = $item.offset();
        $item.css({
            position: 'absolute',
            top: offset.top,
            left: offset.left,
        });
        $item.animate({
           top: this.indexPositions[newIndex].top,
           left: this.indexPositions[newIndex].left
       }, 400, function(){
           $item.css({
               position: 'relative',
               top: 0,
               left: 0,
           });
            if(cb)
                cb($(this));
       });
    };

    // =========================================================================
    // MARKUP
    // =========================================================================
    this.updateProvSelectionOptions = function(){
        var $prov = this.$controls.find('[data-prov]');
        if($prov.length != 0){
            var provincias = this.getDataByAttr('data-prov');
            $prov.html('<option selected value="">None</option>');
            provincias.forEach(function(el){
                $prov.append('<option value="'+el+'">'+el+'</option>');
            });
        }
    };

    this.updateLocalidadesSelectionOptions = function(){
        var $loc = this.$controls.find('[data-localidad]');
        if($loc.length != 0){
            var localidades = this.getDataByAttr('data-localidad');
            $loc.html('<option selected value="">None</option>');
            localidades.forEach(function(el){
                $loc.append('<option value="'+el+'">'+el+'</option>');
            });
        }
    };

    this.generateControls = function(){
        this.updateProvSelectionOptions();
        this.updateLocalidadesSelectionOptions();
        this.initializeControlsEvents();
    };

    this.initializeControlsEvents = function(){
        this.$controls.on('change input', '[data-prov]', function(){
            var value = $(this).val();
            Pedigree_Places_List.filters.prov = value;
            Pedigree_Places_List.filterList();
        });
        this.$controls.on('change input', '[data-localidad]', function(){
            var value = $(this).val();
            Pedigree_Places_List.filters.localidad = value;
            Pedigree_Places_List.filterList();
        });
    };

    this.filterList = function(){
        this.filterByAll();
    };

    this.generateControls();
}
