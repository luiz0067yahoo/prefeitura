var el = wp.element.createElement;

wp.blocks.registerBlockType('cms-adm/big-button', {
	title: 'Botões Grande',		// Block name visible to user
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
		url: { type: 'array' }			// Notice box title in h4 tag
	},
	edit: function(props) {
		//How our block renders in the editor in edit mode
			if((props.attributes.title===undefined)||(props.attributes.title.length==0)){
				
				props.attributes.title=Array("","","","");
				
			}
			
			if((props.attributes.url===undefined)||(props.attributes.url.length==0)){
				props.attributes.url=Array("","","","");
			}
			function updateTitle( newdata ) {
				var bigButton=jQuery(event.target).closest(".btn-btn");
				var bigButtons=bigButton.closest(".big-button").find(".btn-btn");
				var bigButtons_length=bigButtons.length;
				var position=bigButtons.index(bigButton);
				var acc_title= [...props.attributes.title];
				acc_title[position]=newdata;
				props.setAttributes( { title: acc_title } );
			}
			
			function updateURL( event ) {
				var input=jQuery(event.target);
				var inputs=input.closest(".big-button").find("input.link");
				var inputs_length=inputs.length;
				var position=inputs.index(input);
				var acc_url= [...props.attributes.url];
				acc_url[position]=event.target.value;
				props.setAttributes( { url: acc_url } );
			}
			
			function toggleLinkField( event ) {
				var link_=jQuery(event.target);
				var input=link_.closest(".editor-big-button").find("input.link");
				var inputs=link_.closest(".big-button").find("input.link");
				var hidden_link=input.hasClass("hidden");
				inputs.removeClass("hidden");
				inputs.addClass("hidden");
				if (hidden_link) input.removeClass("hidden");
			}
			
			
			function addlinkdata( event ) {
				var bigButton=jQuery(event.target)
				var bigButtons=bigButton.closest(".big-button").find("input[value='+']");
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
				var bigButtons=bigButton.closest(".big-button").find("input[value='-']");
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
					{className:"btn-btn"}
					,
					
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
					
				),
				el('div',
						{	
							className:"editor-big-button",
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
								style:{position:'absolute',marginTop:'-10px',marginLeft:'-50px',cursor:'hand',color:'white',backgroundColor:'black'	},
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
			{className:"block big-button"},
			
				lines_editor
		);
		/*
		
		*/
	},	// End edit()
	
	save: function(props) {
		var sizelines=props.attributes.title.length;
	   	var lines_save=Array();
		for(index=0;index<sizelines;index++){
			lines_save.push(
				

				
				
				el('a',
					{className:"btn-btn",href:props.attributes.url[index]},
					el('div',
						{className:"rich-text"},
						window.HTMLReactParser(props.attributes.title[index])
					)
				)
				
			);
			
		}
		return el('div',
			{className:"block big-button"},
			
				lines_save
		);
	}	
});
