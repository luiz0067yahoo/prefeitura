var el = wp.element.createElement;
wp.blocks.registerBlockType('cms-adm/menu-accordion', {
	title: 'Menu Retratíl',		// Block name visible to user
	icon: 'menu',	// Toolbar icon can be either using WP Dashicons or custom SVG
	category: 'design',	// Under which category the block would appear
	description : 'Menu retrátil é ideal para dividir conteúdos em Tópicos' ,
	example: {
		attributes: {
			backgroundColor: '#000000',
			opacity: 0.8,
			textColor: '#FFFFFF'
		},
	},
	supports: {
		multiple: true,
	  },
	attributes: {			// The data this block will be storing
		title1: { type: 'array array' },			// Notice box title in h4 tag
		description1: { type: 'array array' }		// row description
	},
	edit: function(props) {
		//How our block renders in the editor in edit mode
			if((props.attributes.title===undefined)||(props.attributes.title.length==0)){
				props.attributes.description=Array("","");
				props.attributes.title=Array("","");
			}
			
			function updateTitle( event ) {
				var accordion=jQuery(event.target).closest(".accordion-item");
				var accordions=accordion.parent().find(".accordion-item");
				var accordions_length=accordions.length;
				var position=accordions.index(accordion);
				var acc_title= [...props.attributes.title];
				acc_title[position]=event.target.value;
				props.setAttributes( { title: acc_title } );
			}
			
			
	
			function updateDescription( newdata ) {
				var accordion=jQuery(event.target).closest(".accordion-item");
				var accordions=accordion.parent().find(".accordion-item");
				var accordions_length=accordions.length;
				var position=accordions.index(accordion);
				var acc_description= [...props.attributes.description];	
				acc_description[position]=newdata;
				props.setAttributes( { description: acc_description } );
				
			}
			function addlinkdata( event ) {
				var accordion=jQuery(event.target).closest(".accordion-item");
				var accordions=accordion.parent().find(".accordion-item");
				var position=accordions.index(accordion);
				var acc_title= [...props.attributes.title];
				var acc_description= [...props.attributes.description];
				acc_description.splice(position+1,0, "");
				acc_title.splice(position+1,0, "");
				props.setAttributes( { description: acc_description } );
				props.setAttributes( { title: acc_title } );
			}
			function removelinkdata( event ) {
				var accordion=jQuery(event.target).closest(".accordion-item");
				var accordions=accordion.parent().find(".accordion-item");
				var accordions_length=accordions.length;
				if(accordions_length>1){
					var position=accordions.find(".accordion-item").index(accordion);
					var acc_title= [...props.attributes.title];
					var acc_description= [...props.attributes.description];
					acc_description.splice( position, 1);
					acc_title.splice( position, 1);
					props.setAttributes( { description: acc_description } );
					props.setAttributes( { title: acc_title } );
				}
		   }
 
		var sizelines=Math.round((props.attributes.description.length+props.attributes.title.length)/2);
	   	var lines_editor=Array();
		for(index=0;index<sizelines;index++){
			
			lines_editor.push(
                el('div',
                    {className:"accordion-item accordion-flush bg-3 "},
					el('h2',
                        {className:"accordion-header accordion  "},
                        el('button',
                            {type:"button",className:"accordion-button collapsed bg-3 color-1","data-bs-toggle":"collapse","data-bs-target":"#collapse_"+index},
                            el('input',
                                {
									type:"text",
									value: props.attributes.title[index],
									placeholder: 'Coloque titulo aqui...',
									className:"  color-1 w-100 bg-3",
									onChange: updateTitle 
								}
                            )
                        )  
					),
                    el('div',
	                 {className:"accordion-collapse collapse border",id:"collapse_"+index,"data-bs-parent":"#accordionSection_"+jQuery("accordion").size()},
                        el('div',
                            {className:"accordion-body bg-0"},
                            el(
                                wp.editor.RichText,
                                {
									tagName: 'div',
									multiline:true,
									onChange: updateDescription,
									value: props.attributes.description[index],
									placeholder: 'Coloque seu texto aqui...'
								},
                                ""
                            )
                        )
                    ),
                    el( 'div', 
					{ 
						style:{position:"absolute",zIndex:"1000"}
					},
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
					)
                )
			);
			
		}
		



		return el('div',
			{
				className:'accordion-single accordion w-100 ',
				id:("accordionSection_"+jQuery("accordion").lenght)
			},lines_editor);
	},	// End edit()
	
	
	save: function(props) {
		var sizelines=Math.round((props.attributes.description.length+props.attributes.title.length)/2);
	   	var lines_save=Array();
		for(index=0;index<sizelines;index++){
			
			lines_save.push(
                el('div',
                    {className:"accordion-item accordion-flush bg-3 "},
					el('h2',
                        {className:"accordion-header accordion  "},
                        el('button',
                            {type:"button",className:"accordion-button collapsed bg-3 color-1","data-bs-toggle":"collapse","data-bs-target":"#collapse_"+index},
                            props.attributes.title[index]
                        )  
					),
                    el('div',
	                 {className:"accordion-collapse collapse border",id:"collapse_"+index,"data-bs-parent":"#accordionSection_"+jQuery("accordion").size()},
                        el('div',
                            {className:"accordion-body bg-0"},
                            window.HTMLReactParser(props.attributes.description[index])
                        )
                    )
                    
                )
			);
			
		}
		

		

		return el('div',
			{
				className:'accordion-single accordion w-100 ',
				id:("accordionSection_"+jQuery("accordion").lenght)
			},
			lines_save
		);
		
	}	
});