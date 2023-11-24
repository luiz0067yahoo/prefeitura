jQuery(document).ready(function() {
    jQuery("*").click(function(event) { //all element clicked 
        element = jQuery(event.target); //element clicked
        if (element.prop("tagName") != 'a') element = element.closest('a'); //not is tagName <a></a> then parent is tagname <a></a>
        if ((element.length != 0) && (element.attr("href") != null) && (element.attr("href") != undefined) && (element.attr("href").length > 0)) { //exists element tagname <a></a> and not empty href 
            event.preventDefault(); //start event
            const url = new URL(element.attr("href")); //start object url with href
            if (!jQuery('.containerMiniMenu').hasClass('d-none')) jQuery('.containerMiniMenu').addClass('d-none'); //hidde div className containerMiniMenu
            loadDivMain(url.pathname); //load file by path
            event.stopPropagation(); //no refresh page
        } else if (element.length == 0) { //not is element tagname <a></a>
            element = jQuery(event.target); //load element event click
            if (element.attr("id") != "iconAcount") element = jQuery(event.target).closest('#iconAcount'); //element id is iconAcount if not load parent element with id iconAcount
            if (element.length != 0) { //element have id = iconAcount
                jQuery('.containerMiniMenu').toggleClass('d-none'); //toggle hidde show div className containerMiniMenu
                return 0; //exit function
            }
        }
        if (!jQuery('.containerMiniMenu').hasClass('d-none')) jQuery('.containerMiniMenu').addClass('d-none'); //hidde div className containerMiniMenu
    });


    function loadDivMain(pathname_) {
        if (pathname_ === '/agencia/formacao_academica/') {
            $('#divMain').load('http://localhost/agencia/formacao_academica.html');
        } else if (pathname_ === '/agencia/conhecimentos/') {
            $('#divMain').load('http://localhost/agencia/conhecimentos.html');
        } else if (pathname_ === '/agencia/cargo_pretendido/') {
            $('#divMain').load('http://localhost/agencia/cargo_pretendido.html');
        } else if (pathname_ === '/agencia/dados_pessoais/') {
            $('#divMain').load('http://localhost/agencia/dados_pessoais.html');
        } else if (pathname_ === '/agencia/dados_basicos/') {
            $('#divMain').load('http://localhost/agencia/dados_basicos.html');
        } else if (pathname_ === '/agencia/experiencia_profissional/') {
            $('#divMain').load('http://localhost/agencia/experiencia_profissional.html');
        } else {
            $('#divMain').load('http://localhost/agencia/dados_basicos.html');
        }
    }
    $('#divHeader').load('http://localhost/agencia/header_.html');
    loadDivMain(window.location.pathname);
    $('#divFooter').load('http://localhost/agencia/footer.html');
    jQuery('a').click(function(event) {
        event.preventDefault();
        const url = new URL($(this).href);
        loadDivMain(url.pathname);
        event.stopPropagation();
    });

    /*$('a').click(function(event) {
        event.preventDefault();
        const url = new URL($(this).href);
        loadDivMain(url.pathname);
        event.stopPropagation();
    });*/
    /*if (!jQuery('.containerMiniMenu').hasClass('d-none')) {
        jQuery('*').click(function(event) {
            if ((jQuery(event.target).closest('.containerMiniMenu').length == 0) && (event.target.id != "iconAcount")) {
                jQuery('.containerMiniMenu').addClass('d-none');
            }
            if ($(event.target).prop("tagName") == 'a') {

            }
        });
    } else*/




});