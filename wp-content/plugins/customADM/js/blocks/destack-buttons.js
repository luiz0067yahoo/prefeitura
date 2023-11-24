wp.blocks.registerBlockType('cms-adm/destack-buttons', {
	title: 'Botões de Destaque',		// Block name visible to user
	icon: 'button',	// Toolbar icon can be either using WP Dashicons or custom SVG
	description : 'Insira seu botão de destack' ,
	example: {
		attributes: {
			backgroundColor: '#000000',
			opacity: 0.8,
			textColor: '#FFFFFF'
		},
	},	
	category: 'design',	// Under which category the block would appear
	supports: {
		multiple: true,
	  },
	attributes: {			// The data this block will be storing
		title: { type: 'array' },			// Notice box title in h4 tag
		url: { type: 'array' },			// Notice box title in h4 tag
		logo: { type: 'array' }			// Notice box title in h4 tag
	},
	edit: function(props) {
		//How our block renders in the editor in edit mode
			if((props.attributes.title===undefined)||(props.attributes.title.length==0)){
				
				props.attributes.title=Array("","","","","");
				
			}
			
			if((props.attributes.url===undefined)||(props.attributes.url.length==0)){
				props.attributes.url=Array("","","","","");
			}

			if((props.attributes.logo===undefined)||(props.attributes.logo.length==0)){
				props.attributes.logo=Array("","","","","");
			}


			function updateLogo( event ) {
				var item=jQuery(event.target).closest(".destack-buttons");
				var All_items=item.closest(".destack-buttons-block").find(".destack-buttons");
				var position=All_items.index(item);
				console.log(item);
				console.log(All_items);
				console.log(position);
				var acc_logo=[...props.attributes.logo];
				gallery_items_frame = wp.media.frames.gallery_items = wp.media({
					// Set the title of the modal.
					title:"Selecione seu anexo",
					button: {
						text: "linkar anexo"
					},
					states: [
						new wp.media.controller.Library({
							title: "linkar anexo",
							filterable: 'all',
							multiple: false
						})
					]
				});
				count=0;
				gallery_items_frame.on('close',function() {
					var selection = gallery_items_frame.state().get('selection');
					selection.each(function(attachment) {
						
						acc_logo[position]= attachment.attributes.url;
						console.log(attachment.attributes.url);
						count++;
					});
					if(selection.length>0){
						props.setAttributes( { logo: acc_logo } );
						
					}
				});
				gallery_items_frame.open();
			}

			function updateTitle( newdata ) {
				var bigButton=jQuery(event.target).closest(".destack-buttons");
				var bigButtons=bigButton.closest(".destack-buttons-block").find(".destack-buttons");
				
				var position=bigButtons.index(bigButton);
				var acc_title= [...props.attributes.title];
				acc_title[position]=newdata;
				props.setAttributes( { title: acc_title } );
			}
			
			function updateURL( event ) {
				var input=jQuery(event.target);
				var inputs=input.closest(".destack-buttons-block").find("input.link");
				
				var position=inputs.index(input);
				var acc_url= [...props.attributes.url];
				acc_url[position]=event.target.value;
				props.setAttributes( { url: acc_url } );
			}
			
			function toggleLinkField( event ) {
				var link_=jQuery(event.target);
				var input=link_.closest(".editor-destack-buttons").find("input.link");
				var inputs=link_.closest(".destack-buttons-block").find("input.link");
				var hidden_link=input.hasClass("hidden");
				inputs.removeClass("hidden");
				inputs.addClass("hidden");
				if (hidden_link) input.removeClass("hidden");
			}
			
			
			function addlinkdata( event ) {
				var bigButton=jQuery(event.target)
				var bigButtons=bigButton.closest(".destack-buttons-block").find("input[value='+']");
				var bigButtons_length=bigButtons.length;
				var position=bigButtons.index(bigButton);
				
				var acc_title= [...props.attributes.title];
				acc_title.splice(position+1,0, "");
				props.setAttributes( { title: acc_title } );
				
				var acc_url= [...props.attributes.url];
				acc_url.splice(position+1,0, "");
				props.setAttributes( { url: acc_url } );
			}
			
			function removelinkdata( event ) {
				var bigButton=jQuery(event.target)
				var bigButtons=bigButton.closest(".destack-buttons-block").find("input[value='-']");
				var bigButtons_length=bigButtons.length;
				if(bigButtons_length>1){
					var position=bigButtons.index(bigButton);
					var acc_title= [...props.attributes.title];
					acc_title.splice( position, 1);
					props.setAttributes( { title: acc_title } );
					
					var acc_url= [...props.attributes.url];
					acc_url.splice( position, 1);					
					props.setAttributes( { url: acc_url } );
				}
		   }
 
		var sizelines=props.attributes.title.length;


	   	var lines_editor=Array();
		for(index=0;index<sizelines;index++){
			lines_editor.push(
				el('a',
					{className:"destack-buttons text-decoration-none"},
					el('button',
						{
							href:"#",
							style:{border:"solid 1px black",position:'absolute',marginTop:'10px',marginLeft:'-125px',width:"30px",cursor:'hand',color:'white',backgroundColor:'#0d6efd',zIndex:10000	},
							onClick:updateLogo,
							className:"link"
						},
						el('i',
							{
								className:"fas fa-camera",
								'aria-hidden':'true',
							},
							""
						)
					),
					el('img',{style:{width:"120px",height:"120px"},src:((props.attributes.logo[index]=="")?"https://novosite.toledo.pr.gov.br/wp-content/themes/cityhalltoledo/images/logotoledo.png":props.attributes.logo[index])},null),					
					el('div',{className:"txt"},
						el(
							wp.editor.RichText,
							{
								tagName: 'div',
								multiline:true,
								onChange: updateTitle,
								value: props.attributes.title[index],
								placeholder: 'Coloque seu texto aqui...'
							},
							""
						)
					)
					
				),
				el('div',
						{	
							className:"editor-destack-buttons",
							style:{float:'left'}
						}
						,
						el(
							'input', 
							{
								type: 'text', 	
								placeholder: 'Coloque seu Link aqui...',
								value: props.attributes.url[index],
								onChange:updateURL,
								className:"link hidden",
								style: { position:'absolute',marginLeft:'-225px',marginTop:'-15px',width: '200px'}
							}
						),
						el('button',
							{
								href:"#",
								style:{position:'absolute',marginTop:'-10px',marginLeft:'-50px',cursor:'hand',color:'white',backgroundColor:'black'},
								onClick:toggleLinkField,
								className:"link"
							},
							el('i',
								{
									className:"fa fa-link",
									'aria-hidden':'true',
								},
								""
							)
						),
						el(
							'input', 
							{
								type: 'button', 							
								ariaLabel:"Remover Linha",
								value: '-',
								onClick: removelinkdata,
								style: { position:'absolute',marginLeft:'-25px',marginTop:'25px',minWidth: '15px',minHeight:'15px',backgroundColor:'black',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px'}
							}
						),
						
						//(sizelines==5)?"":
						el(
							'input', 
							{
								type: 'button', 							
								ariaLabel:"Adiciona Linha",
								value: '+',
								onClick: addlinkdata,
								style: { position:'absolute',marginLeft:'-7px',marginTop:'25px',minWidth: '15px',minHeight:'15px',backgroundColor:'black',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px'}
							}
						)
						
					)
			);
			
		}
		return el('div',
			{className:" destack-buttons-block "},
			
				lines_editor
		);
		/*
		
		*/
	},	// End edit()
	
	save: function(props) {
		// How our block renders on the frontend
       var sizelines=props.attributes.title.length;


	   	var lines_save=Array();
		for(index=0;index<sizelines;index++){
			lines_save.push(				
				el('a',
					{
						className:"destack-buttons text-decoration-none",
						href:props.attributes.url[index]
					}
					,
					el('img',{src:"https://novosite.toledo.pr.gov.br/wp-content/themes/cityhalltoledo/images/logotoledo.png"},null)
					,					
					el('div',
						{className:"txt"},
						window.HTMLReactParser(props.attributes.title[index])
					)
					
				)			
			);
			
		}
		return el('div',
			{className:" destack-buttons-block"},
			lines_save
		);
	}	
});

