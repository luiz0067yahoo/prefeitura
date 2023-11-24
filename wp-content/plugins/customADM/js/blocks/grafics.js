
var el = wp.element.createElement;
var buildGraficsChartData=[];
const defaultColorHexLegend=
Array(
"#f08f86",
"#57a7ed",
"#35cd76",
"#f9a51e",
"#636363",
"#f1c920",
"#f997f9",
"#ee3924",
"#233e95",
"#128e42",
"#e5b624",
"#622d8f",
"#c0de34",
"#e6246d",
"#6ecee9",
"#35449c",
"#c1db70",
"#ffe47c",
"#f6792f",
"#9c6ab2",
"#1693b1",
"#b71d3f",
"#43b376",
"#e8dc1a",
"#0c809f",

//Cores Clara

"#f7c7c2",
"#abd3f6",
"#9ae6ba",
"#fcd28e",
"#b1b1b1",
"#f8e48f",
"#fccbfc",
"#f69c91",
"#919eca",
"#88c6a0",
"#f2da91",
"#b096c7",
"#dfee99",
"#f291b6",
"#b6e6f4",
"#9aa1cd",
"#e0edb7",
"#fff1bd",
"#fabc97",
"#cdb4d8",
"#8ac9d8",
"#db8e9f",
"#a1d9ba",
"#f3ed8c",
"#85bfcf",

//Cores Escuras

"#784843",
"#2c5477",
"#1b673b",
"#7d530f",
"#323232",
"#796510",
"#7d4c7d",
"#771d12",
"#121f4b",
"#094721",
"#735b12",
"#311748",
"#606f1a",
"#731237",
"#376775",
"#1b224e",
"#616e38",
"#80723e",
"#7b3d18",
"#4e3559",
"#0b4a59",
"#5c0f20",
"#225a3b",
"#746e0d",
"#064050"
)

wp.blocks.registerBlockType('cms-adm/build-grafics', {
    title: 'Gráfico pizza', 
    icon: 'chart-pie',
	description : 'Gere seu gráfico de pizza em uma tabela com cores personalizadas' ,
	example: {
		attributes: {
			backgroundColor: '#000000',
			opacity: 0.8,
			textColor: '#FFFFFF'
		},
	},	
    category: 'design', 
    supports: {
        multiple: true
    },
    attributes:{ 
        title:{type:'array'}, 
        subTitle:{type:'array'}, 
        legend:{type:'array'}, 
        dataValue:{type:'array'},
        colorItem:{type:'array'},
		mainBlockId:{type:'array'}
    },
    edit: function(props){
        if((props.attributes.dataValue === undefined) || (props.attributes.dataValue.length == 0))
        {
            props.attributes.dataValue = Array(Array("70","10","20"));
        }
		if((props.attributes.legend === undefined) || (props.attributes.legend.length == 0)){
			props.attributes.legend = Array(Array("legenda1","legenda2","legenda3"));
		}
		if((props.attributes.colorItem === undefined) || (props.attributes.colorItem.length == 0)){
			//randomColorHEX="#"+Math.floor(Math.random()*16777215).toString(16);
            props.attributes.colorItem = Array(defaultColorHexLegend.slice(0, 3));
		}
		if((props.attributes.title === undefined) || (props.attributes.title.length == 0)){
            props.attributes.title = Array("");
		}
		if((props.attributes.subTitle === undefined) || (props.attributes.subTitle.length == 0)){
            props.attributes.subTitle = Array("");
		}
		if((props.attributes.mainBlockId === undefined) || (props.attributes.mainBlockId.length == 0)){
			var mainBlockId= Array("build-grafics-"+(Math.floor(Math.random() * 1000) + 1));
			while(
				document.querySelectorAll("#"+mainBlockId[0]).length!=0
			){
				mainBlockId= Array("build-grafics-"+(Math.floor(Math.random() * 1000) + 1));
			}
			props.attributes.mainBlockId=mainBlockId	;
			
		}
        function updatesubTitle(event) {
			var element_=jQuery(event.target);
			//var item=element_.closest(".line-editor");
			var mainContainer=element_.closest(".grafic-element");
			var topContainer=mainContainer.closest(".all-grafics-element");
			//var all_Itens=mainContainer.find(".line-editor");
			var allContainer=topContainer.find(".grafic-element");
			//var position=all_Itens.index(item);
			var positionContainer=allContainer.index(mainContainer);
			var acc_subTitle = [...props.attributes.subTitle];
			acc_subTitle[positionContainer]=event.target.value;
            props.setAttributes({ subTitle: acc_subTitle });
        }
		function updatetitle(event) {
			var element_=jQuery(event.target);
			//var item=element_.closest(".line-editor");
			var mainContainer=element_.closest(".grafic-element");
			var topContainer=mainContainer.closest(".all-grafics-element");
			//var all_Itens=mainContainer.find(".line-editor");
			var allContainer=topContainer.find(".grafic-element");
			//var position=all_Itens.index(item);
			var positionContainer=allContainer.index(mainContainer);
			var acc_title = [...props.attributes.title];
			acc_title[positionContainer]=event.target.value;
            props.setAttributes({ title: acc_title });
        }
        function updatelegend(event) {
            var element_=jQuery(event.target);
			var item=element_.closest(".line-editor");
			var mainContainer=item.closest("table.edit-grafic-element");
			var topContainer=mainContainer.closest(".all-grafics-element");
			var all_Itens=mainContainer.find(".line-editor");
			var allContainer=topContainer.find("table.edit-grafic-element");
			var position=all_Itens.index(item);
			var positionContainer=allContainer.index(mainContainer);
			var acc_legend = [...props.attributes.legend];
			acc_legend[positionContainer][position]=event.target.value
            props.setAttributes({ legend: acc_legend });
        }
        function updatecolorItem(event) {
            var element_=jQuery(event.target);
			var item=element_.closest(".line-editor");
			var mainContainer=item.closest("table.edit-grafic-element");
			var topContainer=mainContainer.closest(".all-grafics-element");
			var all_Itens=mainContainer.find(".line-editor");
			var allContainer=topContainer.find("table.edit-grafic-element");
			var position=all_Itens.index(item);
			var positionContainer=allContainer.index(mainContainer);
            var acc_colorItem = [...props.attributes.colorItem];
            acc_colorItem[positionContainer][position] = event.target.value;
			(element_).closest("td").find(".divColor").css("background-color",event.target.value);
            props.setAttributes({ colorItem: acc_colorItem });
        }
        function updatedataValue(event) {
			var element_=jQuery(event.target);
			var item=element_.closest(".line-editor");
			var mainContainer=item.closest("table.edit-grafic-element");
			var topContainer=mainContainer.closest(".all-grafics-element");
			var all_Itens=mainContainer.find(".line-editor");
			var allContainer=topContainer.find("table.edit-grafic-element");
			var position=all_Itens.index(item);
			var positionContainer=allContainer.index(mainContainer);
            var acc_dataValue = [...props.attributes.dataValue];
            acc_dataValue[positionContainer][position] = event.target.value;            
            props.setAttributes({ dataValue: acc_dataValue });
        }
        function addlinkdata(event) {
            var element_=jQuery(event.target);
			var item=element_.closest(".line-editor");
			var mainContainer=item.closest("table.edit-grafic-element");
			var topContainer=mainContainer.closest(".all-grafics-element");
			var all_Itens=mainContainer.find(".line-editor");
			var allContainer=topContainer.find("table.edit-grafic-element");
			var position=all_Itens.index(item);
			var positionContainer=allContainer.index(mainContainer);
			
            var acc_dataValue = [...props.attributes.dataValue];
            var acc_legend = [...props.attributes.legend];
            var acc_colorItem = [...props.attributes.colorItem];
			
            acc_legend[positionContainer].splice(position + 1, 0, "");
            acc_colorItem[positionContainer].splice(position + 1, 0, defaultColorHexLegend[position]);
            acc_dataValue[positionContainer].splice(position + 1, 0, 1);
			
			props.setAttributes({ legend: acc_legend });
			props.setAttributes({ colorItem: acc_colorItem });
			props.setAttributes({ dataValue: acc_dataValue });
        }
		function removelinkdata(event) {
			var element_=jQuery(event.target);
			var item=element_.closest(".line-editor");
			var mainContainer=item.closest("table.edit-grafic-element");
			var topContainer=mainContainer.closest(".all-grafics-element");
			var all_Itens=mainContainer.find(".line-editor");
			var allContainer=topContainer.find("table.edit-grafic-element");
			var position=all_Itens.index(item);
			var positionContainer=allContainer.index(mainContainer);
			
            var acc_mainBlockId = [...props.attributes.mainBlockId];
            var acc_title = [...props.attributes.title];
            var acc_subTitle = [...props.attributes.subTitle];
            var acc_dataValue = [...props.attributes.dataValue];
            var acc_legend = [...props.attributes.legend];
            var acc_colorItem = [...props.attributes.colorItem];
			
            if (all_Itens.length > 1) {
				acc_legend[positionContainer].splice(position, 1);
				acc_colorItem[positionContainer].splice(position, 1);
				acc_dataValue[positionContainer].splice(position, 1);
				
				props.setAttributes({ legend: acc_legend });
				props.setAttributes({ colorItem: acc_colorItem });
				props.setAttributes({ dataValue: acc_dataValue });
            }
        }
		
		function addContainerdata(event) {
			var mainBlockId= Array("build-grafics-"+(Math.floor(Math.random() * 1000) + 1));
			while(
				document.querySelectorAll("#"+mainBlockId[0]).length!=0
			){
				mainBlockId= Array("build-grafics-"+(Math.floor(Math.random() * 1000) + 1));
			}
            var element_=jQuery(event.target);
			var mainContainer=element_.closest(".grafic-element");
			var topContainer=mainContainer.closest(".all-grafics-element");
			var allContainer=topContainer.find(".grafic-element");
			var positionContainer=allContainer.index(mainContainer);
			
			var acc_mainBlockId = [...props.attributes.mainBlockId];
            var acc_title = [...props.attributes.title];
            var acc_subTitle = [...props.attributes.subTitle];
            var acc_dataValue = [...props.attributes.dataValue];
            var acc_legend = [...props.attributes.legend];
            var acc_colorItem = [...props.attributes.colorItem];		
			
            acc_mainBlockId.splice(positionContainer + 1, 0, mainBlockId[0]);
			acc_title.splice(positionContainer + 1, 0, "");
            acc_subTitle.splice(positionContainer + 1, 0, "");
            acc_legend.splice(positionContainer + 1, 0, Array("legenda1","legenda2","legenda3"));
            acc_colorItem.splice(positionContainer + 1, 0, defaultColorHexLegend.slice(0, 3));
            acc_dataValue.splice(positionContainer + 1, 0, Array("70","10","20"));
			
			props.setAttributes({ mainBlockId: acc_mainBlockId });
			props.setAttributes({ title: acc_title });
			props.setAttributes({ subTitle: acc_subTitle });
			props.setAttributes({ legend: acc_legend });
			props.setAttributes({ colorItem: acc_colorItem });
			props.setAttributes({ dataValue: acc_dataValue });
        }
		function removeContainerdata(event) {
            var element_=jQuery(event.target);
			var mainContainer=element_.closest(".grafic-element");
			var topContainer=mainContainer.closest(".all-grafics-element");
			var allContainer=topContainer.find(".grafic-element");
			var positionContainer=allContainer.index(mainContainer);
			
			var acc_mainBlockId = [...props.attributes.mainBlockId];
            var acc_title = [...props.attributes.title];
            var acc_subTitle = [...props.attributes.subTitle];
            var acc_dataValue = [...props.attributes.dataValue];
            var acc_legend = [...props.attributes.legend];
            var acc_colorItem = [...props.attributes.colorItem];	
			
            if (allContainer.length > 1) {
				acc_mainBlockId.splice(positionContainer, 1);
				acc_title.splice(positionContainer, 1);
				acc_subTitle.splice(positionContainer, 1);
				acc_legend.splice(positionContainer, 1);
				acc_colorItem.splice(positionContainer, 1);
				acc_dataValue.splice(positionContainer, 1);
				
				props.setAttributes({ mainBlockId: acc_mainBlockId });
				props.setAttributes({ title: acc_title });
				props.setAttributes({ subTitle: acc_subTitle });
				props.setAttributes({ legend: acc_legend });
				props.setAttributes({ colorItem: acc_colorItem });
				props.setAttributes({ dataValue: acc_dataValue });
            }
        }
        
        function showhiddeEditGrafic(event) {
			var element_=jQuery(event.target);
			//var item=element_.closest(".line-editor");
			var mainContainer=element_.closest(".grafic-element");
			var topContainer=mainContainer.closest(".all-grafics-element");
			//var all_Itens=mainContainer.find(".line-editor");
			var allContainer=topContainer.find(".grafic-element");
			//var position=all_Itens.index(item);
			var positionContainer=allContainer.index(mainContainer);
			var hidde_=topContainer.find("table.edit-grafic-element").eq(positionContainer).hasClass("d-none");
			topContainer.find("table.edit-grafic-element").removeClass("d-none").addClass("d-none");
			if(hidde_)
				topContainer.find("table.edit-grafic-element").eq(positionContainer).removeClass("d-none");
		}
		function hiddeEditGrafic(event) {
			var element_=jQuery(event.target);
			//var item=element_.closest(".line-editor");
			var mainContainer=element_.closest(".grafic-element");
			var topContainer=mainContainer.closest(".all-grafics-element");
			//var all_Itens=mainContainer.find(".line-editor");
			var allContainer=topContainer.find(".grafic-element");
			//var position=all_Itens.index(item);
			var positionContainer=allContainer.index(mainContainer);
			topContainer.find("table.edit-grafic-element").removeClass("d-none").addClass("d-none");
		}


        function showEditGrafic(event) {
			var element_=jQuery(event.target);
			//var item=element_.closest(".line-editor");
			var mainContainer=element_.closest(".grafic-element");
			var topContainer=mainContainer.closest(".all-grafics-element");
			//var all_Itens=mainContainer.find(".line-editor");
			var allContainer=topContainer.find(".grafic-element");
			//var position=all_Itens.index(item);
			var positionContainer=allContainer.index(mainContainer);
			topContainer.find("table.edit-grafic-element").removeClass("d-none").addClass("d-none");
			topContainer.find("table.edit-grafic-element").eq(positionContainer).removeClass("d-none");
		}
		function hiddeEditGrafic(event) {
			var element_=jQuery(event.target);
			//var item=element_.closest(".line-editor");
			var mainContainer=element_.closest(".grafic-element");
			var topContainer=mainContainer.closest(".all-grafics-element");
			//var all_Itens=mainContainer.find(".line-editor");
			var allContainer=topContainer.find(".grafic-element");
			//var position=all_Itens.index(item);
			var positionContainer=allContainer.index(mainContainer);
			topContainer.find("table.edit-grafic-element").removeClass("d-none").addClass("d-none");
		}
        
		
		function gerarGraficoPizza(){
			for(positionContainer = 0; positionContainer < props.attributes.mainBlockId.length; positionContainer++){
				var mainBlockId=props.attributes.mainBlockId[positionContainer];
				if (document.querySelectorAll("#"+mainBlockId+"-canvas").length!=0){
					try{
						const mycanvas=jQuery("#"+mainBlockId+"-canvas");
						const ctx = mycanvas.get(0).getContext('2d');
						mycanvas.removeClass("grafics-demo");
						if(buildGraficsChartData.length!=0){
							if(buildGraficsChartData[positionContainer]!=undefined){
								buildGraficsChartData[positionContainer].destroy();
							}
						}
						
						buildGraficsChartData[positionContainer] = new Chart(ctx, {
							type: 'pie',
							data: {
								labels: props.attributes.legend[positionContainer],
								datasets: [{
									label: props.attributes.legend[positionContainer],
									data: props.attributes.dataValue[positionContainer],
									backgroundColor: props.attributes.colorItem[positionContainer]
								}]
							},
							options: {
								
								plugins: {
									  legend: {
										display: false,
										position: 'top',
									  },
									  title: {
										display: false,
										text: props.attributes.title[positionContainer]
									  },
									  subtitle: {
										display: false,
										text: props.attributes.subTitle[positionContainer]
									}
								}
							}
						});
					}catch(e){ }
				}
			}
		}
		gerarGraficoPizza();
		
		function ajustHeightContainerLegends(){
			jQuery(".all-grafics-element").each(function(){
				var containerslegends=[];
				var maxContainerLegendsHeight=0;
				jQuery(this).find(".container-legends").each(function(index){
					containerslegends[index%3]=jQuery(this);
					maxContainerLegendsHeight= (maxContainerLegendsHeight<jQuery(this).height())?jQuery(this).height():maxContainerLegendsHeight;
					if(index%3==2){
						for (var i=0;i<3;i++){
							containerslegends[i].height(maxContainerLegendsHeight);
						}
						maxContainerLegendsHeight=0;
					}
				});
			});
		}
		ajustHeightContainerLegends();
		
		var allGraficsElement=Array();
		var allGraficsTable=Array();
		for(positionContainer = 0; positionContainer < props.attributes.mainBlockId.length; positionContainer++){
			var lines_editor = null
			lines_editor = Array();
			var div_legends= Array();
			var totalDataValue=0;
			if(props.attributes.dataValue[positionContainer]!=undefined){
				for (index = 0; index < props.attributes.dataValue[positionContainer].length; index++) {
					totalDataValue+=1*(props.attributes.dataValue[positionContainer][index]);
				}
				for (index = 0; index < props.attributes.dataValue[positionContainer].length; index++) {
					var id_color=(props.attributes.mainBlockId[positionContainer]+'-color-'+positionContainer+"_"+index);
					var input_hex=jQuery('#'+id_color);
					var div_hex=jQuery('#'+id_color+"-div");
					input_hex.ColorPicker({
						inputDataValueColor:input_hex,
						divDataValueColor:div_hex,
						color: jQuery('#'+id_color).val(),
						onShow: function (colpkr) {
						  jQuery(colpkr).fadeIn(500);
						  return false;
						},
						onHide: function (colpkr) {
						  jQuery(colpkr).fadeOut(500);
						  return false;
						},
						onChange: function (hsb, hex, rgb,inputDataValueColor,divDataValueColor) {
						  jQuery(inputDataValueColor).val('#'+hex);
						  var idStrInputColor=jQuery(inputDataValueColor).attr("id");
						  positionContaineridStrInputColor=idStrInputColor.split("-color-")[1].split("_")[0];
						  indexidStrInputColor=idStrInputColor.split("-color-")[1].split("_")[1];
						  acc_colorItem = [...props.attributes.colorItem];
						  acc_colorItem[positionContaineridStrInputColor][indexidStrInputColor]='#'+hex;
						  props.setAttributes({ colorItem: acc_colorItem });
						  jQuery(divDataValueColor).css('background-color','#' +hex);
						}
					});
					var formatDataValue=parseFloat(100*props.attributes.dataValue[positionContainer][index]/totalDataValue).toFixed(2)+"%";
					div_legends.push(
						el('div', {className:"my-2",
								style:{height:"auto",minWidth:"85px"}
							},
							el('div', {
									className: 'mx-auto d-flex justify-content-center align-items-center rounded-circle bg-0 color-2 text-center',
									style:{height:"80px",width:"80px","border":"2px solid "+props.attributes.colorItem[positionContainer][index]}
								},
								el('h4',{style:{fontSize:"16px"}},formatDataValue)
							),
							el('p', {className:"mb-0",style:{textAlign:"center",color:props.attributes.colorItem[positionContainer][index],}},props.attributes.legend[positionContainer][index])
						)
					);
					lines_editor.push(
						el('tr', {
								className: 'line-editor'
							},
							el(
								'td',
								null,
								el('input', 
									{
										id:id_color,
										type:'text',
										placeholder:'Escolha a cor aqui',
										value:props.attributes.colorItem[positionContainer][index],
										onChange:updatecolorItem,
										style:{float:"left"}
									}
								),
								el('div', 
									{
										className:"divColor",
										id:(id_color+"-div"),
										style:{
											height:"30px",
											width:"30px",
											backgroundColor:props.attributes.colorItem[positionContainer][index],
											"border":"1px solid black",
											float:"left"
										}
									}
								)
							),
							el('td',

								{ className: "description" },

								el(
									'input', {
										type: 'text',
										placeholder: 'Coloque o título aqui',
										value: props.attributes.legend[positionContainer][index + 0],
										onChange: updatelegend
									}
								)
							),
							el('td', {
									className: ' '
								},
								el('input',
									{
										type: 'number',
										style: { width: "50%" },
										placeholder: 'Coloque o valor aqui',
										value: props.attributes.dataValue[positionContainer][index + 0],
										onChange: updatedataValue
									}
								)
							),

							el('td', {
									className: ' '
								},
								el(
									'input', {
										type: 'button',
										ariaLabel: "Remover Linha",
										value: '-',
										onClick: removelinkdata,
										style: { width: '25px', height: '25px', backgroundColor: 'black', color: 'white', paddingLeft: '0px', paddingRight: '0px', paddingTop: '0px', paddingBottom: '0px' }
									}
								),
								el(
									'input', {
										type: 'button',
										ariaLabel: "Adiciona Linha",
										value: '+',
										onClick: addlinkdata,
										style: { width: '25px', height: '25px', backgroundColor: 'black', color: 'white', paddingLeft: '0px', paddingRight: '0px', paddingTop: '0px', paddingBottom: '0px' }
									}
								)
							)

						)
					)
				}
			}
			
			allGraficsElement.push(el('div', {"id":props.attributes.mainBlockId[positionContainer],className:"full-grafic-element d-flex justify-content-center align-items-center"},
				el('table', 
					{
						className: 'edit-grafic-element d-none table table-striped table-bordered bg-0',
						style: {border:'1px solid black', width: '100%', textAlign: 'center',position:"absolute", "z-index":100,marginTop:"30px",marginLeft:((positionContainer%3==0)?"50%":(positionContainer%3==2)?"-50%":"0")}
					},
					el('caption', {className:"w-100 bg-0",style:{"caption-side": "top"}},
						el('label',
							{className:"w-100 bg-0"},
							el(
								'input', {
									type: 'text',
									className:"w-100",
									placeholder: 'Coloque o título do gráfico aqui...',
									value: props.attributes.title[positionContainer],
									onChange: updatetitle
								}
							)
						),
						el('label',
							{className:"w-100 bg-0"},
							el(
								'input', {
									type: 'text',
									className:"w-100 bg-0",
									placeholder: 'Coloque o subtítulo do gráfico aqui...',
									value: props.attributes.subTitle[positionContainer],
									onChange: updatesubTitle
								}
							)
						)
					),
					el('thead',
						null,
						el('tr',
							null,
							el(
								'td',
								null,
								"Cor da legenda"
							),
							el('td', { className: "description" },
								"Legenda"
							),
							el('td', { className: "btn-exibir" },
								"Valor"
							),
							el('td',
								null,
								""
							)
						)
					),
					el('tbody',
						null,
						lines_editor
					),
				),
				el('div', {className:"grafic-element"},
						el('button',
							{
								className:"btn btn-danger ",
								style: {position:"absolute",color:"red",marginLeft:"20px"},
								onClick: removeContainerdata
							},
							el('i',
								{
									className:"fa fa-times",
									'aria-hidden':'true',
								},
								""
							)
						),
						
						
						el('button',
							{
								className:"btn btn-primary color-0",
								style: {position:"absolute",marginLeft:"180px"},
								onClick: showhiddeEditGrafic
							},
							el('i',
								{
									className:"fas fa-edit",
									'aria-hidden':'true',
								},
								""
							)
						),
						el('button',
							{
								className:"btn btn-dark ",
								style: {position:"absolute",marginLeft:"340px"},
								onClick: addContainerdata
							},
							el('i',
								{
									className:"fas fa-plus",
									'aria-hidden':'true',
								},
								""
							)
						),
						
						el('div', {
								className:"flex-wrap d-flex justify-content-center align-items-start",
								style:{minWidth:"280px",maxWidth:"360px", height:"auto"}
							},
							el('h2',{className:"w-100 text-center"},props.attributes.title[positionContainer]), 
							el('div', 
								{
									className:"container-legends w-100 mb-3 d-flex justify-content-between align-items-start"
									,style:{height:"auto"}
								},
								
								(positionContainer%3!=1)?el('div',null):el('div',{className:" align-self-stretch",style:{minHeight:"100px",width:"2px",backgroundColor:"black"}},""),
								
								
								el('div', 
									{
										className:"flex-wrap flex-row  d-flex justify-content-center align-items-start "
										,style:{height:"auto"}
									},
									div_legends
								),
								(positionContainer%3!=1)?el('div',null):el('div',{className:" align-self-stretch",style:{minHeight:"100px",width:"2px",backgroundColor:"black"}},""),
							
							
							),
							el('div', {style:{maxWidth:"200px", height:"auto"}},
								
								el('canvas', 
									{
										className:"canvas-grafic-pie grafics-demo",
										"title":props.attributes.title[positionContainer],
										"subTitle":props.attributes.subTitle[positionContainer],
										"legend":JSON.stringify(props.attributes.legend[positionContainer]),
										"colorItem":JSON.stringify(props.attributes.colorItem[positionContainer]),
										"dataValue":JSON.stringify(props.attributes.dataValue[positionContainer]),
										id:(props.attributes.mainBlockId[positionContainer]+"-canvas"),
										width:"200px", 
										height:"200px",
										style:{
											width:"100%"
										}
									}
								)
							),
							
						)
					)
				
				),
				(positionContainer%3!=2)?"":el('div',{className:" w-100",style:{minHeight:"2px",marginTop:"10px",backgroundColor:"black"}},"")
			); 
		}
		
		return el("div",{className:"all-grafics-element w-100 "},
			el("div",{className:"w-100 flex-wrap d-flex justify-content-center align-items-start"},allGraficsElement)
		);
    }, 
    save: function(props) {
		var allGraficsElement=Array();
		for(positionContainer = 0; positionContainer < props.attributes.mainBlockId.length; positionContainer++){
			var div_legends= Array();
			var totalDataValue=0;
			if(props.attributes.dataValue[positionContainer]!=undefined){
				for (index = 0; index < props.attributes.dataValue[positionContainer].length; index++) {
					totalDataValue+=1*(props.attributes.dataValue[positionContainer][index]);
				}
				for (index = 0; index < props.attributes.dataValue[positionContainer].length; index++) {
					var formatDataValue=parseFloat(100*props.attributes.dataValue[positionContainer][index]/totalDataValue).toFixed(2)+"%";
					div_legends.push(
						el('div', {className:"my-2",
								style:{height:"auto",minWidth:"85px"}
							},
							el('div', {
									className: 'mx-auto d-flex justify-content-center align-items-center rounded-circle bg-0 color-2 text-center',
									style:{height:"80px",width:"80px","border":"2px solid "+props.attributes.colorItem[positionContainer][index]}
								},
								el('h4',{style:{fontSize:"16px"}},formatDataValue)
							),
							el('p', {className:"mb-0",style:{textAlign:"center",color:props.attributes.colorItem[positionContainer][index],}},props.attributes.legend[positionContainer][index])
						)
					);
					
				}
			}
			
			allGraficsElement.push(el('div', {"id":props.attributes.mainBlockId,className:"full-grafic-element d-flex justify-content-center align-items-center"},
				
				el('div', {className:"grafic-element"},
						
						el('div', {
								className:"flex-wrap d-flex justify-content-center align-items-start",
								style:{minWidth:"280px",maxWidth:"360px", height:"auto"}
							},
							el('h2',{className:"w-100 text-center"},props.attributes.title[positionContainer]), 
							el('div', 
								{
									className:" container-legends w-100 mb-3 d-flex justify-content-between align-items-start"
									,style:{height:"auto"}
								},
								
								(positionContainer%3!=1)?el('div',null):el('div',{className:" align-self-stretch",style:{minHeight:"100px",width:"2px",backgroundColor:"black"}},""),
								
								
								el('div', 
									{
										className:"flex-wrap flex-row  d-flex justify-content-center align-items-start "
										,style:{height:"auto"}
									},
									div_legends
								),
								
								
								(positionContainer%3!=1)?el('div',null):el('div',{className:" align-self-stretch",style:{minHeight:"100px",width:"2px",backgroundColor:"black"}},""),
							
							
							),
							el('div', {style:{maxWidth:"200px", height:"auto"}},
								
								el('canvas', 
									{
										className:"canvas-grafic-pie ",
										"title":props.attributes.title[positionContainer],
										"subTitle":props.attributes.subTitle[positionContainer],
										"legend":JSON.stringify(props.attributes.legend[positionContainer]),
										"colorItem":JSON.stringify(props.attributes.colorItem[positionContainer]),
										"dataValue":JSON.stringify(props.attributes.dataValue[positionContainer]),
										id:(props.attributes.mainBlockId[positionContainer]+"-canvas"),
										width:"200px", 
										height:"200px",
										style:{
											width:"100%"
										}
									}
								)
							)
						)
					)
				
				),
				(positionContainer%3!=2)?"":el('div',{className:" w-100",style:{minHeight:"2px",marginTop:"10px",backgroundColor:"black"}},"")				
			); 
		}
		
		return el("div",{className:"all-grafics-element w-100 "},
			el("div",{className:"w-100 flex-wrap d-flex justify-content-center align-items-start"},allGraficsElement)
		);		
    }
});