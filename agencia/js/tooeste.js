    if ($( window ).width()<1000){
    	$("#navbarNavDropdown").hide();	
    	$("#anuncio_eventos").hide();	
    }
    
    //abrir_menus
    
    $("#abrir_menus").click(function(){
    	$("#navbarNavDropdown").toggle();	
    });
    $(".modal_banner").click(function(){
        $("#modal_banner").modal('toggle');	
        $("#modal_banner_title").html($(this).attr("alt"));
        $("#modal_banner_image").attr("src",$(this).attr("fotoexpandida"));
    });
    $('.carousel').each(function (){
    	$(this).carousel({
    		interval: 2000,
    		cycle: true
    	}); 
    });
    var lightbox = new SimpleLightbox({
        $items: $('.galleryItem')
    });