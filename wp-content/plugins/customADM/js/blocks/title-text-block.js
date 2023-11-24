var el = wp.element.createElement;


wp.blocks.registerBlockType('cms-adm/title-text', {
	title: 'Título',		// Block name visible to user
	description : 'Insira aqui seu Título' ,
	example: {
		attributes: {
			backgroundColor: '#000000',
			opacity: 0.8,
			textColor: '#FFFFFF'
		},
	},
	icon: 'text',	// Toolbar icon can be either using WP Dashicons or custom SVG
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
				props.attributes.title=Array("");
			}
			if((props.attributes.description===undefined)||(props.attributes.description.length==0)){
				props.attributes.description=Array("");
			}
			function updateTitle( event ) {
				var element_=jQuery(event.target);
				var mainContainer=element_.closest(".text-data-block");
				var itemContainer=element_.closest(".title-text-block");
				var allItemsContainers=mainContainer.find(".title-text-block");
				var position=allItemsContainers.index(itemContainer);
				var acc_title= [...props.attributes.title];
				acc_title[position]=event.target.value;				
				props.setAttributes( { title: acc_title } );
			}
			function updateDescription( newdata ) {
				var newdatastr=newdata.toString();
				var index=newdatastr.indexOf("<p>");
				newdatastr=newdatastr.substr(index);
				newdatastr=newdatastr.replace(/<\/?[^>]+(>|$)/g, "");
				var element_=jQuery(event.target);
				var mainContainer=element_.closest(".text-data-block");
				var itemContainer=element_.closest(".title-text-block");
				var allItemsContainers=mainContainer.find(".title-text-block");
				var position=allItemsContainers.index(itemContainer);
				var acc_description= [...props.attributes.description];
				acc_description[position]=newdata;
				props.setAttributes( { description: acc_description } );
				
			}
			function addlinkdata( event ) {
				var element_=jQuery(event.target);
				var mainContainer=element_.closest(".text-data-block");
				var itemContainer=element_.closest(".title-text-block");
				var allItemsContainers=mainContainer.find(".title-text-block");
				var position=allItemsContainers.index(itemContainer);
				var acc_title= [...props.attributes.title];
				var acc_description= [...props.attributes.description];
				acc_description.splice(position+1,0, "");
				acc_title.splice(position+1,0, "");
				props.setAttributes( { description: acc_description } );
				props.setAttributes( { title: acc_title } );
			}
			function removelinkdata( event ) {
				var element_=jQuery(event.target);
				var mainContainer=element_.closest(".text-data-block");
				var itemContainer=element_.closest(".title-text-block");
				var allItemsContainers=mainContainer.find(".title-text-block");
				var position=allItemsContainers.index(itemContainer);
				var acc_title= [...props.attributes.title];
				var acc_description= [...props.attributes.description];
				if(allItemsContainers.length>1){
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
                    {className:"title-text-block"},
					el('h2',
                        {className:"p-0 m-0"},
						el('input',
							{
								className:"p-0 m-0",
								type:"text",
								value: props.attributes.title[index],
								placeholder: 'Coloque o titulo aqui...',
								onChange: updateTitle ,
								style:{color:'inherit',backgroundColor:'inherit',border:'none',width:'100%'}
							}
						)
					),
                    el(wp.editor.RichText,
						{
							tagName: 'label',
							className:"text-center",
							multiline:true,
							type:"text",
							value: props.attributes.description[index],
							placeholder:'Coloque a descrição aqui...',
							onChange: updateDescription,
							style:{color:'inherit',backgroundColor:'inherit',border:'none',width:'100%'}
						}
                    ),
					/*el(
						'input', 
						{
							type: 'button', 							
							ariaLabel:"Remover Linha",
							value: '-',
							onClick: removelinkdata,
							style: {position:'absolute', width: '25px',height:'25px',backgroundColor:'black',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px' }
						}
					),
					el(
						'input', 
						{
							type: 'button', 							
							ariaLabel:"Adiciona Linha",
							value: '+',
							onClick: addlinkdata,
							style: {marginLeft:'25px',position:'absolute', width: '25px',height:'25px',backgroundColor:'black',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px' }
						}
					)*/
					
                )
			);
			
		}
		



		return el('div',
			{
				className:'text-data-block',
				
			},lines_editor);
	},	// End edit()
	
	
	save: function(props) {
		// How our block renders on the frontend
        var sizelines=Math.round((props.attributes.description.length+props.attributes.title.length)/2);
	    var lines_save=Array();
		for(index=0;index<sizelines;index++){
			
			lines_save.push(
                el('div',
                    {className:"title-text-block"},
					el('h2',
						{className:"p-0 m-0"},
						 props.attributes.title[index]
					),
                    el('label',
						{className:"text-center w-100"},
						(
							(props.attributes.description[index]!=null )
							&& 
							(props.attributes.description[index].lenght!=0)
						)
						?window.HTMLReactParser(props.attributes.description[index])
						:""
                    )	
                   
                )
			
			);
		}
		return el('div',
            {className:"text-data-block"},
            lines_save
        );
		
	}	
});