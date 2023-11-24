wp.blocks.registerBlockType('cms-adm/buttons-banner', {
	title: 'Botões banner',		// Block name visible to user
	description : 'Quantidade de até 5 botões por linha' ,
	example: {
		attributes: {
			backgroundColor: '#000000',
			opacity: 0.8,
			textColor: '#FFFFFF'
		},
	},
	icon: 'button',	// Toolbar icon can be either using WP Dashicons or custom SVG
	category: 'design',	// Under which category the block would appear
	supports: {
		multiple: true,
	  },
	attributes: {			// The data this block will be storing
		title: { type: 'array' },			// Notice box title in h4 tag
		description: { type: 'array' },		// row description
		url: { type: 'array' },		// row description
		logo: { type: 'array' }		// row description
	},
	edit: function(props) {
		//How our block renders in the editor in edit mode
			if((props.attributes.title===undefined)||(props.attributes.title.length==0)){
				props.attributes.title=Array("","","","","");
			}
			if((props.attributes.description===undefined)||(props.attributes.description.length==0)){
				props.attributes.description=Array("","","","","");
			}
			if((props.attributes.url===undefined)||(props.attributes.url.length==0)){
				props.attributes.url=Array("","","","","");
			}
			
			if((props.attributes.logo===undefined)||(props.attributes.logo.length==0)){
				props.attributes.logo=Array("","","","","");
			}
			


			function updateLogo( event ) {
				var item=jQuery(event.target).closest(".btn-m1");
				var All_items=item.parent().find(".btn-m1");
				var position=All_items.index(item);
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

			function updateTitle( event ) {
				var M1button=jQuery(event.target).closest(".btn-m1");
				var M1buttons=M1button.parent().find(".btn-m1");
				var M1buttons_length=M1buttons.length;
				var position=M1buttons.index(M1button);
				var acc_title= [...props.attributes.title];
				acc_title[position]=event.target.value;
				props.setAttributes( { title: acc_title } );
			}
			
			
			function updateURL_( event ) {
				var input=jQuery(event.target);
				var inputs=input.closest(".buttons-banner").find("input.link");
				var position=inputs.index(input);
				var acc_url= [...props.attributes.url];
				acc_url[position]=event.target.value;
				props.setAttributes( { url: acc_url } );
			}
			function toggleLinkField( event ) {
				var link_=jQuery(event.target);
				var input=link_.closest(".editor-buttons-banner").find("input.link");
				var inputs=link_.closest(".buttons-banner").find("input.link");
				var hidden_link=input.hasClass("hidden");
				inputs.removeClass("hidden");
				inputs.addClass("hidden");
				if (hidden_link) input.removeClass("hidden");
			}
			function updateDescription( newdata ) {
				var M1button=jQuery(event.target).closest(".btn-m1");
				var M1buttons=M1button.parent().find(".btn-m1");
				var M1buttons_length=M1buttons.length;
				var position=M1buttons.index(M1button);
				var acc_description= [...props.attributes.description];	
				acc_description[position]=newdata;
				props.setAttributes( { description: acc_description } );
				
			}
			function addlinkdata( event ) {
				var M1button=jQuery(event.target).closest(".btn-m1");
				var M1buttons=M1button.parent().find(".btn-m1");
				var position=M1buttons.index(M1button);
				var acc_title= [...props.attributes.title];
				var acc_description= [...props.attributes.description];
				var acc_description= [...props.attributes.description];
				var acc_url= [...props.attributes.url];
				acc_description.splice(position+1,0, "");
				acc_title.splice(position+1,0, "");
				acc_url.splice(position+1,0, "");
				props.setAttributes( { description: acc_description } );
				props.setAttributes( { title: acc_title } );
				props.setAttributes( { url: acc_url } );
			}
			function removelinkdata( event ) {
				var M1button=jQuery(event.target).closest(".btn-m1");
				var M1buttons=M1button.parent().find(".btn-m1");
				var M1buttons_length=M1buttons.length;
				var position=M1buttons.index(M1button);
				if(M1buttons_length>1){
					var position=M1buttons.index(M1button);
					var acc_title= [...props.attributes.title];
					var acc_description= [...props.attributes.description];
					var acc_url= [...props.attributes.url];
					acc_description.splice( position, 1);
					acc_title.splice( position, 1);
					acc_url.splice( position, 1);
					props.setAttributes( { description: acc_description } );
					props.setAttributes( { title: acc_title } );
					props.setAttributes( { url: acc_url } );
				}
		   }
 
		var sizelines=Math.round((props.attributes.description.length+props.attributes.title.length)/2);


	   	var lines_editor=Array();
		for(index=0;index<sizelines;index++){
			lines_editor.push(
				el('div',
					{className:"btn-m1"},
					el('div',
					{className:"row"},
						el('div',
							{className:"col-4"},
							el('div',
								{
									className:"img_logo",
									style:{
										backgroundImage:((props.attributes.logo[index]=="")?"":("url('"+props.attributes.logo[index]+"')"))
									}
								},
								el('button',
									{
										href:"#",
										style:{border:"solid 1px black",position:'absolute',marginTop:'10px',marginLeft:'-10px',width:"30px",cursor:'hand',color:'white',backgroundColor:'#0d6efd',zIndex:10000	},
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
								)
							)
						),
						el('div',
							{className:"col-8 text-end"},
							el(
                                wp.editor.RichText,
                                {
									tagName: 'h2',
									style:{
										color: "#ffffff",
										textShadow: "0px 3px 1px rgba(50, 50, 50, 0.3)",
										fontSize: "23px"
									},
									multiline:true,
									onChange: updateDescription,
									value: props.attributes.description[index],
									placeholder: 'Coloque seu texto aqui...'
								},
                                ""
                            )
						),
					),
					el('div',
					{className:"row"},
						el('div',
							{className:"sigla"},
							el('div',
								{className:"sigla-1"},
								el('input',
									{
										type:"text",
										value: props.attributes.title[index],
										placeholder: 'Coloque titulo aqui...',
										onChange: updateTitle 
									}
								)
							)
						)
					),
					
					el(
						'input', 
						{
							type: 'button', 							
							ariaLabel:"Remover Linha",
							value: '-',
							onClick: removelinkdata,
							style: { width: '25px',height:'25px',backgroundColor:'black',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px' }
						}
					),
					el(
						'input', 
						{
							type: 'button', 							
							ariaLabel:"Adiciona Linha",
							value: '+',
							onClick: addlinkdata,
							style: { width: '25px',height:'25px',backgroundColor:'black',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px' }
						}
					)
					
					
				),
				el('div',
					{
						className:"editor-buttons-banner",
						style:{float:'left'}
					},
					el(
						'input', 
						{
							type: 'text', 	
							placeholder: 'Coloque seu Link aqui...',
							value: props.attributes.url[index],
							onChange:updateURL_,
							className:"link hidden",
							style: { position:'absolute',marginLeft:'-225px',marginTop:'130px',width: '200px'}
						}
					),
					el('button',
						{
							href:"#",
							style:{position:'absolute',marginTop:'130px',marginLeft:'-40px',cursor:'hand',color:'white',backgroundColor:'black'},
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
					)
				)				
			);
			
		}
		return el('div',
			{className:"block buttons-banner"},
			
				lines_editor
			
		);
		/*
		
		*/
	},	// End edit()
	
	save: function(props) {
		// How our block renders on the frontend
		var sizelines=Math.round((props.attributes.description.length+props.attributes.title.length)/2);


		var lines_save=Array();
		for(index=0;index<sizelines;index++){
			lines_save.push(
				el('a',
					{className:"btn-m1",href:props.attributes.url[index]},
					el('div',
					{className:"row"},
						el('div',
							{className:"col-4"},
							el('div',
								{
									className:"img_logo",
									style:{
										backgroundImage:(props.attributes.logo!=undefined && (props.attributes.logo[index]!="" && props.attributes.logo[index]!=undefined)?("url('"+props.attributes.logo[index]+"')"):"")
									}
								}
								
							)
						),
						el('div',
							{className:"col-8 text-end"},
							el(
								'h2',
								{
									style:{
										color: "#ffffff",
										textShadow: "0px 3px 1px rgba(50, 50, 50, 0.3)",
										fontSize: "23px"
									},
									className:"rich-text"
								},
								window.HTMLReactParser(props.attributes.description[index]),
								)
						),
					),
					el('div',
					{className:"row"},
						el('div',
							{className:"sigla"},
							el('div',
								{className:"sigla-1",style:{display:"block",minWidth:"190px",height:"26px",textAlign:"center"}},
								window.HTMLReactParser(props.attributes.title[index])
								
							)
						)
					)
					
					
				)
							
			);
			
		}
		return el('div',
			{className:"block buttons-banner"},
			
			lines_save
			
		);
	}
	



	
});