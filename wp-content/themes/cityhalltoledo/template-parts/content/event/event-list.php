<?php 
global $wpdb;
global $post;

$str_conditions="";
$args=[];
$result =null;
$total=0;
$param   = ( !is_front_page() ) ? 'page' : 'paged';
$paged   = ( get_query_var( $param ) ) ? get_query_var( $param ) : 1;

$page=$paged;
$rows_per_page=9;

$search="%%";
if(isset($_GET["search"]))
	$search=strtoupper("%".$_GET["search"]."%");

$eventDate= date('Y-m-d');
if(isset($_GET["eventDate"]))
	$eventDate=$_GET["eventDate"];   

$post_ids=[];
if(isset($_GET["startDate"])&&($_GET["startDate"]=="true")){
	$str_conditions=" WHERE(UPPER(nome_do_evento) LIKE %s OR UPPER(categoria_evento) LIKE %s)and (%s <=  data_inicial ) ";
	$args=[$search,$search,$eventDate];
}
else{
	$str_conditions=" WHERE(UPPER(nome_do_evento) LIKE %s OR UPPER(categoria_evento) LIKE %s) and (((data_final is null) and (data_inicial=%s))OR(NOT(data_final is null) and (%s BETWEEN data_inicial AND data_final))) ";
	$args=[$search,$search,$eventDate,$eventDate];
}

	$post_ids=[];
	$result_post_ids = $wpdb->get_results($wpdb->prepare("SELECT post_id FROM {$wpdb->prefix}cadastro_eventos  $str_conditions  ORDER BY data_inicial ASC",$args));
	foreach ($result_post_ids as $post_){
		array_push($post_ids,$post_->post_id);
	}
	$total = $wpdb->get_var($wpdb->prepare("SELECT count(ID) FROM {$wpdb->prefix}cadastro_eventos  $str_conditions  ORDER BY data_inicial ASC",$args));
	$offset = ($page - 1) * $rows_per_page;
	$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}cadastro_eventos  $str_conditions  ORDER BY data_inicial ASC limit {$offset}, $rows_per_page",$args));


$url="";
if($result!=null){ ?>
<div class="row container-block-by w-100 d-flex" >
<?php 
	$count=0;
	foreach ($result as $valor){
		$url="#";
		if (isset($valor->post_id) && !empty($valor->post_id)){
			$post_id=$valor->post_id;
			$url=get_permalink($post_id);
		}
		require(get_template_directory() .  '/template-parts/content/event/event-big.php');
		require(get_template_directory() .  '/template-parts/content/event/event-mini.php');
		$count++;
	} 
	$rest=($count%3);
	if($rest>0)
	for($count=$rest;$count<3;$count++){
		require(get_template_directory() .  '/template-parts/content/event/event-none.php');
	}
?>
</div>
<?php 
	$count = 0;
	
	if($total>$rows_per_page){ 
		require(get_template_directory() .  '/template-parts/footer/footer-paginate-system.php');
		$posts = null;
		$count_posts = null;
		//get_template_part('template-parts/footer/footer', 'paginate');
	} 
}
?>			
<script>
	jQuery( ".pagination" ).find("a").click(function( event ) {
		  event.preventDefault();
		  var link = jQuery(this).attr('href');
		  jQuery("#loadResultDataEvent").load(link).done(function(){});
		  event.stopPropagation();
	});	
	jQuery( "*" ).keydown(function( event ) {
		jQuery(".bigContainerScheduleEvent-full").each(function(){
			if(!jQuery(this).hasClass("d-none")){
					if (event.which == 37) {//left
						var index =jQuery(".big-event").index(jQuery(this).find(".big-event"));
						jQuery(".big-event").eq(index).addClass("d-none");
						index--;
						jQuery(".big-event").eq(index).removeClass("d-none");
						loadDimension();
						setTimeout(loadDimension,100);
						setTimeout(loadDimension,200);
					}
					else if(event.which == 38){//up
						
					}
					else if(event.which == 39){//right 
						var index =jQuery(".big-event").index(jQuery(this).find(".big-event"));
						jQuery(".big-event").eq(index).addClass("d-none");
						index++;
						jQuery(".big-event").eq(index).removeClass("d-none");
						loadDimension();
						setTimeout(loadDimension,100);
						setTimeout(loadDimension,200);
					}
					else if(event.which == 40){//down 
						
					}
					else if(event.which == 27){ // esc
						jQuery(this).addClass("d-none");
					}
					event.preventDefault();
			}
		});
	});
	jQuery(".bigContainerScheduleEvent-next").on("click", function(event){
		var index =jQuery(".big-event").index(jQuery(event.target).closest(".big-event"));
		jQuery(".big-event").eq(index).addClass("d-none");
		index++;
		jQuery(".big-event").eq(index).removeClass("d-none");
		loadDimension();
		setTimeout(loadDimension,100);
		setTimeout(loadDimension,200);
	});
	jQuery(".bigContainerScheduleEvent-back").on("click", function(event){
		var index =jQuery(".big-event").index(jQuery(event.target).closest(".big-event"));
		jQuery(".big-event").eq(index).addClass("d-none");
		index--;
		jQuery(".big-event").eq(index).removeClass("d-none");
		loadDimension();
		setTimeout(loadDimension,100);
		setTimeout(loadDimension,200);
	});
	jQuery(".bigContainerScheduleEvent-close").on("click", function(event){
		if(jQuery(event.target).closest(".containerScheduleEvent-container").length==0){
			jQuery(event.target).closest(".big-event").addClass("d-none");
			loadDimension();
			setTimeout(loadDimension,100);
			setTimeout(loadDimension,200);
		}
	});
	 loadDimension=function(){
		$(".height-square").each(function(){
				$(this).height($(this).width());
		});
		$(".dimenssion-parent").each(function(){
			height=($(this).parent().height());
			width=($(this).parent().width());
			$(this).height(height);
			$(this).width(width);
		});
		$(".max-height-parent-first-child").each(function(){
			height=($(this).parent().children(":first").height());
			$(this).css("max-height",height+"px");
		});
		$(".min-height-first-child").each(function(){
			height=($(this).first().height());
			if($(this).css("max-height").replace('px', '')>height)
				$(this).css("min-height",$(this).css("max-height"));
			else
				$(this).css("min-height",height+"px");
		});
		$(".h-80").each(function(){
			$(this).height($(this).parent().height()*0.8);
		});

	}
setTimeout(loadDimension,250);
</script>