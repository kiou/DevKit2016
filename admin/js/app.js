$(document).ready(function(){

	/* Tooltip */
	$(document).tooltip({
      track: true
    });

    $('#menu').perfectScrollbar();

    /* DropDown */
    $('.dropDown').on('click',function(){

    	var dropDown = $(this);
        var dropDownMenu = dropDown.find('.dropDownMenu');
    	var dropDownHeight = dropDown.height();

    	dropDownMenu.css({
    		'top':dropDownHeight,
    		'right': "0px"
    	});

    	if(!dropDown.hasClass('active')){
    		dropDown.addClass('active');
    		dropDownMenu.fadeIn('fast');
    	}else{
    		dropDown.removeClass('active');
    		dropDownMenu.fadeOut('fast');
    	}

    });

    /* Picto menu mobile */
    $('#headerMobile').on('click',function(){

        var bouton = $(this);
        var menu = $('#menu');
        var container = $('#container');

        if(!menu.hasClass('active')){
            bouton.addClass('active');
            menu.addClass('active');
            container.addClass('active');
        }else{
            bouton.removeClass('active');
            menu.removeClass('active');
            container.removeClass('active');
        }

    });

    /* Menu principal à gauche */
    $("#menu .menuNav").on('click',function(){

        var menuNav = $(this);
        var ul = menuNav.attr('data-nav');

        /* Si le menu n'est pas cliqué */
        if(menuNav.hasClass('active') == false){

            /* Reset */
            $('#menu .menuNav').removeClass('active');
            $('#menu ul:visible').slideUp('fast');
            
            /* Active */
            menuNav.addClass('active');
            $('ul#'+ul).slideDown('fast');

        }else{
            menuNav.removeClass('active');
            $('ul#'+ul).slideUp('fast');
        }

    });

    /* Publication dépublication */
    $('.tablePublucation').click(function(e){

        e.preventDefault();
       
        var td = $(this);
        var url = td.attr('data-url');
        td.html('<i class="fa fa-refresh loader fa-spin"></i>');
        
        $.ajax(url)
        .done(function(data){
            console.log(data);
            if(data){
                td.html('<a href="#" title="Publication"><i class="tableAction turquoise fa fa-check"></i></a>');
            }else{
                td.html('<a href="#" title="Publication"><i class="tableAction rouge fa fa-check"></i></a>'); 
            }
        })
        .fail(function(){
             alert('Erreur Ajax');
        });

    });

    /* Administration du menu */
    /* Menu avec indentation */
    $('ol.sortable').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div',
        revert: 250,
        maxLevels: 3,
        forcePlaceholderSize: true,
        placeholder: 'placeholder',
        excludeRoot: true,
        update:function(){

            var sortable = $(this);
            var results = sortable.nestedSortable('toArray');
            var url = sortable.attr('data-url');

            $.ajax(url,{
                method:"POST",
                data:{data:results}
            })
            .fail(function(){
                 alert('Erreur Ajax');
            });

        }
    });

    /* Resize de la fenêtre du navigateur */
    $(window).resize(function() {

        var windowWidth = $(window).width();

        var bouton = $('#headerMobile');
        var menu = $('#menu');
        var container = $('#container');

        if(menu.hasClass('active')){
            bouton.removeClass('active');
            menu.removeClass('active');
            container.removeClass('active');
        }

    });

});