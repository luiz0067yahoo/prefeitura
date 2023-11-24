var el = wp.element.createElement;
wp.blocks.registerBlockType('cms-adm/topic-title-text', {
	title: 'Bloco Texto',		// Block name visible to user
	description : 'Insirar aqui seu bloco de texto' ,
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
		title: { type: 'array'},			// Notice box title in h4 tag
		description: { type: 'array'}		// row description
	},
	edit: function(props) {
		//How our block renders in the editor in edit mode
			if((props.attributes.title===undefined)||(props.attributes.title.length==0)){
				props.attributes.title=Array("","");
			}
			if((props.attributes.description===undefined)||(props.attributes.description.length==0)){
				props.attributes.description=Array(
					window.HTMLReactParser("<p></p>")
				);
			}
			function updateTitle( event ) {
				var element_=jQuery(event.target);
				var mainContainer=element_.closest(".topic-text-block");
				var itemContainer=element_.closest(".text-block");
				var allItemsContainers=mainContainer.find(".text-block");
				var position=allItemsContainers.index(itemContainer);
				var acc_title= [...props.attributes.title];
				acc_title[position]=event.target.value;				
				props.setAttributes( { title: acc_title } );
			}
			function updateDescription( newdata ) {
				
				var newdatastr=newdata.toString();
				var index=newdatastr.indexOf("<p>");
				newdatastr=newdatastr.substr(index);
				
				var element_=jQuery(event.target);
				var mainContainer=element_.closest(".topic-text-block");
				var itemContainer=element_.closest(".text-block");
				var allItemsContainers=mainContainer.find(".text-block");
				var position=allItemsContainers.index(itemContainer);		
				var acc_description= [...props.attributes.description];
				acc_description[position]=window.HTMLReactParser(newdata);
				
				props.setAttributes( { description: acc_description } );
				
			}
			function addlinkdata( event ) {
				var element_=jQuery(event.target);
				var mainContainer=element_.closest(".topic-text-block");
				var itemContainer=element_.closest(".text-block");
				var allItemsContainers=mainContainer.find(".text-block");
				var position=allItemsContainers.index(itemContainer);
				var acc_title= [...props.attributes.title];
				var acc_description= [...props.attributes.description];
				console.log(mainContainer);
				console.log(itemContainer);
				console.log(allItemsContainers);
				console.log(position);
				acc_description.splice(position+1,0, window.HTMLReactParser("<p></p>"));
				acc_title.splice(position+1,0, "");
				props.setAttributes( { description: acc_description } );
				props.setAttributes( { title: acc_title } );
			}
			function removelinkdata( event ) {
				var element_=jQuery(event.target);
				var mainContainer=element_.closest(".topic-text-block");
				var itemContainer=element_.closest(".text-block");
				var allItemsContainers=mainContainer.find(".text-block");
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
                    {className:"text-block w-100 "},
					el('h4',
                        null,
						el('input',
							{
								type:"text",
								value: props.attributes.title[index],
								placeholder: 'Coloque o titulo aqui...',
								onChange: updateTitle ,
								style:{color:'inherit',backgroundColor:'inherit',border:'none',width:'100%'}
							}
						)
					),
                    el("div",
						{clasName:"w-100 d-block",style:{border:"1px solid black"}},
						el(
							wp.editor.RichText,
							{
								tagName: 'label',
								multiline:true,
								onChange: updateDescription,
								value:  wp.element.renderToString(props.attributes.description[index]),
								
								placeholder: 'Coloque seu texto aqui...'
							},""						
						)
					),
					
					el("div",{className:"w-100",style:{height:"25px"}},
						el(
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
						)
					)
                ),
				
			);
			
		}
		



		return el('div',
			{
				className:'topic-text-block w-100 ',
				
			},lines_editor);
	},	
	
	
	save: function(props) {
        var sizelines=props.attributes.title.length;
	    var lines_save=Array();
		for(index=0;index<sizelines;index++){
			/*var description_html=el("p",null,"");
			try{
				description_html=window.HTMLReactParser(props.attributes.description[index])
			}
			catch(e){}*/
			  
			lines_save.push(
                el('div',
                    {className:"text-block"},
					((props.attributes.title[index]===undefined)||(props.attributes.title[index].length==0))?"":
					el('h4',
                        null,
						props.attributes.title[index]
					),
					((props.attributes.description!=undefined)&&(props.attributes.description[index]!=undefined)&&(props.attributes.description[index].length!=0))?
                    el('label',
						null,
						props.attributes.description[index]
                    ):"",
                )
			
			);
		}
		return el('div',
            {className:"topic-text-block"},
            lines_save
        );
		
	}	
});