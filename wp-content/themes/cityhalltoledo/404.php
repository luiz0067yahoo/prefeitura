<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://github.com/luiz0067/city-hall-toledo
 *
 * @package WordPress
 * @subpackage city hall toledo
 * @since city hall toledo 1.0
 */

 get_header();
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <title>ERR0R 404</title>
</head>


<body>
    <div id="Erro404">
        <div class="texto">
            <div class="pisca">ERROR</div>
            <label class="pisca" style="font-family:'minecraft' !important;">404</label>
            <hr style="opacity: 0.7">
            <div style="font-family:'Franklin Gothic Medium' !important; font-size:20px">Página Não Encontrada</div>
        </div>
        

       
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        var div = document.getElementById("Erro404");
        setInterval(createStar, 50);

        function createStar() {
            let right = Math.random() * 900;
            let top = Math.random() * screen.height;
            let estrela = document.createElement("div");
            estrela.classList.add("estrela")
            div.appendChild(estrela);
            setInterval(runStar, 20);
            estrela.style.top = top + "px";

            function runStar() {
                if (right >= screen.width) {
                    estrela.remove();
                }
                right += 3;
                estrela.style.right = right + "px";
            }
        }
    })
</script>

</html>
<?php
 get_footer();
?>
