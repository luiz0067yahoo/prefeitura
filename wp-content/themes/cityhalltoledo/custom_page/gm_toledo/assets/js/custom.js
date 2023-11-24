
(function() {
  "use strict";

  $.ajax({
    url: "assets/files/",
    success: function(data){
      var html = '';
      if ($(data).find("td > a").length>1) {
        $(data).find("td > a").each(function() {
          if (openFile($(this).attr("href"))) {
  //console.log('a', ($(this).attr('href')))

            let value = $(this).attr("href");

            html += '<a class="col-6 col-md-4 col-lg-2" href="assets/files/' + value + '" target="_blank">';
            html += ' <abbr title="' + decodeURI(value) + '">'
            html += '   <div class="card h-100">';
            html += '     <i class="bi bi-file-earmark-pdf icon-pdf"></i>';
            html += '     <div class="card-body">';
            html += '       <p class="card-text text-truncate">' + decodeURI(value) + '</p>';
            html += '     </div>';
            html += '   </div>';
            html += ' </abbr>';
            html += '</a>'

          }
        });
      } else
        html = '<label class="text-center">Não foi possível encontrar os documentos.</label>';

		  $(".list-files").html(html);

    }
  });

  function openFile(file) {
    var extension = file.substr((file.lastIndexOf('.') +1));
    switch(extension) {
      case 'pdf':
        return true;
      default:
        return false;
    }
  };

})()
