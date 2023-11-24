wp.blocks.registerBlockType('cms-adm/panel-title-text', {
	title: 'Painel',		// Block name visible to user
	icon: 'text-page',	// Toolbar icon can be either using WP Dashicons or custom SVG
	description : 'Quantidade de até 5 paineis por linha' ,
	example: {
		attributes: {
			backgroundColor: '#000000',
			opacity: 0.8,
			textColor: '#FFFFFF'
		},
	},
	category: 'common',	// Under which category the block would appear
	supports: {
		multiple: true,
	  },
	attributes: {			// The data this block will be storing
		title: { type: 'array' },			// Notice box title in h4 tag
		description: { type: 'array' }		// row description
	},
	edit: function(props) {
		//How our block renders in the editor in edit mode
			if((props.attributes.title===undefined)||(props.attributes.title.length==0)){
				props.attributes.title=Array("","","","","");
			}
			if((props.attributes.description===undefined)||(props.attributes.description.length==0)){
				props.attributes.description=Array("","","","","");
			}
			
			
			function updateTitle( event ) {
				var M1button=jQuery(event.target).closest(".text-4-bloco");
				var M1buttons=M1button.parent().find(".text-4-bloco");
				var M1buttons_length=M1buttons.length;
				var position=M1buttons.index(M1button);
				var acc_title= [...props.attributes.title];
				acc_title[position]=event.target.value;
				props.setAttributes( { title: acc_title } );
			}
			
			
			
			function updateDescription( newdata ) {
				var M1button=jQuery(event.target).closest(".text-4-bloco");
				var M1buttons=M1button.parent().find(".text-4-bloco");
				var M1buttons_length=M1buttons.length;
				var position=M1buttons.index(M1button);
				var acc_description= [...props.attributes.description];	
				acc_description[position]=newdata;
				props.setAttributes( { description: acc_description } );
				
			}
			function addlinkdata( event ) {
				var M1button=jQuery(event.target).closest(".text-4-bloco");
				var M1buttons=M1button.parent().find(".text-4-bloco");
				var position=M1buttons.index(M1button);
				var acc_title= [...props.attributes.title];
				var acc_description= [...props.attributes.description];
				acc_description.splice(position+1,0, "");
				acc_title.splice(position+1,0, "");
				props.setAttributes( { description: acc_description } );
				props.setAttributes( { title: acc_title } );
			}
			function removelinkdata( event ) {
				var M1button=jQuery(event.target).closest(".text-4-bloco");
				var M1buttons=M1button.parent().find(".text-4-bloco");
				var M1buttons_length=M1buttons.length;
				var position=M1buttons.index(M1button);
				if(M1buttons_length>1){
					var position=M1buttons.index(M1button);
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
					{className:"text-4-bloco"},
					el('div',
						{className:"title"},
						el('input',
							{
								type:"text",
								value: props.attributes.title[index],
								style:{width:"100%",backgroundColor:'inherit',color:'inherit'},
								placeholder: 'Coloque titulo aqui...',
								onChange: updateTitle 
							}
						),
						el(
							'input', 
							{
								type: 'button', 							
								ariaLabel:"Remover Linha",
								value: '-',
								onClick: removelinkdata,
								style: { width: '25px',height:'25px',backgroundColor:'black',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px',position:'absolute', "margin-left":'-25px',"margin-top":'-30px'  }
							}
						),
						el(
							'input', 
							{
								type: 'button', 							
								ariaLabel:"Adiciona Linha",
								value: '+',
								onClick: addlinkdata,
								style: { width: '25px',height:'25px',backgroundColor:'black',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px',position:'absolute',"margin-left":'0px',"margin-top":'-30px' }
							}
						)

					),
					
						
					
					el(
							wp.editor.RichText,
							{
								tagName: 'div',
								className:"text",
								style:{border:"solid 1px gray","min-height":"80%"},
								multiline:true,
								onChange: updateDescription,
								value: props.attributes.description[index],
								placeholder: 'Coloque seu texto aqui...'
							},
							""
					)
					
				),
				
			);
			
		}
		return el('div',
			{className:"text-4-bloco-block"},
			
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
				
				el('div',
					{className:"text-4-bloco"},
					el('div',
						{className:"title"},
						props.attributes.title[index]
					),
					el('div',
						{
							className:"text",
						},
						window.HTMLReactParser(props.attributes.description[index])
					)
					
				),
				
			);
			
		}
		return el('div',
			{className:"text-4-bloco-block"},
			lines_save
		);
		
	}	
});
 