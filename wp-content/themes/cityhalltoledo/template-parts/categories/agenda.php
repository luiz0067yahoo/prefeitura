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
?>
    <div class="container align-middle">
        <form id="agendaFrom" class="row row-cols-lg-auto justify-content-center" action="<?php echo get_home_url(); ?>/?systempage=eventos" onsubmit="return false;">
            <div class="input-group-text" style="width: 400px; margin-top: 25px;">
                <div class="input-group">
                    <input  id="search" name="search" type="text" class="form-control input-form" placeholder="O que você busca?">
                </div>
                <button id="searchButton" class="btn-social btn-social-op" style="margin-left: 10px;">
                    <i class="fa fa-search"></i>
                </button>
            </div>
			<input type="hidden" name="eventDate" id="eventDate" value="<?php if(isset($_GET["eventDate"])){echo $_GET["eventDate"];}else{echo date("Y-m-d");}?>" >
			<input type="hidden" name="startDate" id="startDate" value="<?php if(isset($_GET["startDate"])&&($_GET["startDate"]=="true")){echo "true";}?>" >
        </form>
    </div>

    <!-- Anos -->
    <div class="container justify-content-center line_year d-flex" style="text-align: center; margin-top: 10px; border-radius: 10px;">
        <button type="button" class="btnAgendaDia year_left"><i class="fas fa-chevron-left"></i></button>
        <div style="width: 95px;">
            <div class="year text-center w-100" style="border-radius: 10%;"></div>
        </div>
        <button type="button" class="btnAgendaDia year_right"><i class="fas fa-chevron-right"></i></button>
    </div>
    </div>

    <!-- Meses -->
    <div class="container" style="margin-top: 10px;">
        <div class="row justify-content-center mx-auto" style="text-align: center;max-width:1298px">
            <button type="button" class="btnAgendaMes left_mounth float-left"><i class="fas fa-chevron-left"></i></button>
            <div class="col p-0" style=" overflow-x: hidden;">
                <div class="mounths  float-left justify-content-center" style="padding: 0; margin: 0;">
                    <div class="float-left ">
                        <div class=" float-left p-2 mounth">JAN</div>
                    </div>
                    <div class="float-left">
                        <div class="p-2 mounth">FEV</div>
                    </div>
                    <div class="float-left">
                        <div class="p-2 mounth">MAR</div>
                    </div>
                    <div class="float-left">
                        <div class="p-2 mounth">ABR</div>
                    </div>
                    <div class="float-left">
                        <div class="p-2 mounth">MAI</div>
                    </div>
                    <div class="float-left">
                        <div class="p-2 mounth">JUN</div>
                    </div>
                    <div class="float-left">
                        <div class="p-2 mounth">JUL</div>
                    </div>
                    <div class="float-left">
                        <div class="p-2 mounth">AGO</div>
                    </div>
                    <div class="float-left">
                        <div class="p-2 mounth">SET</div>
                    </div>
                    <div class="float-left">
                        <div class="p-2 mounth ">OUT</div>
                    </div>
                    <div class="float-left">
                        <div class="p-2 mounth ">NOV</div>
                    </div>
                    <div class="float-left">
                        <div class="p-2 mounth">DEZ</div>
                    </div>
                </div>
            </div>
            <button type="button" class="btnAgendaMes right_mounth float-left"><i class="fas fa-chevron-right"></i></button>
        </div>

        <!-- Dias -->
        <div class="container d-flex justify-content-center row-cols-lg-auto justify-content-center " style="text-align: center; margin-top: 10px; max-width: 100%;">
            <button type="button" class="btnAgendaDia left_day"><i class="fas fa-chevron-left"></i></button>
            <div class="col p-0" style=" overflow-x: hidden; ">
                <div class="days   " style="padding: 0; margin: 0;max-width:700px">
                    <div class="float-left border_day">
                        <div class="day"></div>
                        <div class="week"></div>
                    </div>
                    <div class="float-left border_day">
                        <div class="day"></div>
                        <div class="week"></div>
                    </div>
                    <div class="float-left border_day">
                        <div class="day day_active"></div>
                        <div class="week"></div>
                    </div>
                    <div class="float-left border_day">
                        <div class="day"></div>
                        <div class="week"></div>
                    </div>
                    <div class="float-left border_day">
                        <div class="day"></div>
                        <div class="week"></div>
                    </div>
                </div>
            </div>
            <button type="button" class="btnAgendaDia right_day"><i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
	<div class="container d-flex justify-content-center">
		<button  class="m-2 btnNoticias" id="searchButtonAll">TODOS OS EVENTOS</button>
	</div>
    <hr style="margin-bottom: 40px;">
    <div class="container" id="loadResultDataEvent">
            
    </div>
