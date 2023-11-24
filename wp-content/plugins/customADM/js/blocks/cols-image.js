var el = wp.element.createElement;


wp.blocks.registerBlockType('cms-adm/cols-image', {
	title: 'Imagem em colunas',		// Block name visible to user
	icon: 'slides',	// Toolbar icon can be either using WP Dashicons or custom SVG
	category: 'media',	// Under which category the block would appear
	description : 'Quantidade de até 3 Imagens por linha' ,
	
	supports: {
		multiple: true,
	},
	attributes: {			// The data this block will be storing
		
		url: { type: 'array' },			// row description
		title: { type: 'array' },			// Notice box title in h4 tag
		description: { type: 'array' }			// row description
	
		
	},
	edit: function(props) {
		if
		(
			((props.attributes.url===undefined)||(props.attributes.url.length==0))
			||
			((props.attributes.title===undefined)||(props.attributes.title.length==0))
		)
		{	
			var acc_title=Array();
			var acc_url=Array();
			var acc_description=Array();
		
				
			props.attributes.url=Array(1);
			props.attributes.title=Array(1);
			props.attributes.description=Array(1);
			
			
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
						multiple: true
					})
				]
			});
			position=0;
			count=0;
			// Select the attachment when the frame opens
			gallery_items_frame.on('close',function() {
				var selection = gallery_items_frame.state().get('selection');
				selection.each(function(attachment) {
					acc_title.splice(position+count, 0, attachment.attributes.title);
					acc_url.splice(position+count, 0, attachment.attributes.url);
					var description_value=attachment.attributes.caption;
					if(description_value==undefined)
						description_value="";
					acc_description.splice(position+count, 0, description_value);
					count++;
				});
				if(selection.length>0){
					props.attributes.url=Array(selection.length);
					props.attributes.title=Array(selection.length);
					props.setAttributes( { title: acc_title } );
					props.setAttributes( { url: acc_url } );
					props.setAttributes( { description: acc_description } );
					
				}
			});
			gallery_items_frame.open();
		}
 
		var sizelines=Math.round((props.attributes.url.length+props.attributes.title.length)/2);

      	
		function updateURl( event ) {
			var item=jQuery(event.target).closest(".col-image");
			var All_items=item.closest(".cols-image").find(".col-image");
			var position=All_items.index(item);
			var acc_url= [...props.attributes.url];
			var acc_title= [...props.attributes.title];
			var acc_description= [...props.attributes.description];
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
			//position=0;
			count=0;
			// Select the attachment when the frame opens
			gallery_items_frame.on('close',function() {
				var selection = gallery_items_frame.state().get('selection');
				selection.each(function(attachment) {
					acc_title[position]=attachment.attributes.title;
					acc_url[position]= attachment.attributes.url;
					var description_value=attachment.attributes.caption;
					if(description_value==undefined)
						description_value="";
					acc_description[position]=description_value;
					count++;
				});
				if(selection.length>0){
					props.attributes.url=Array(selection.length);
					props.attributes.title=Array(selection.length);
					props.setAttributes( { title: acc_title } );
					props.setAttributes( { url: acc_url } );
					props.setAttributes( { description: acc_description } );
					
				}
			});
			gallery_items_frame.open();
		}
		
		function updateTitle( event ) {
			if(event.target.value.length<=50){
				var item=jQuery(event.target).closest(".col-image");
				var All_items=item.closest(".cols-image").find(".col-image");
				var position=All_items.index(item);
				var acc_title= [...props.attributes.title];
				acc_title[position]=event.target.value;
				props.setAttributes( { title: acc_title } );
			}
		}
		
		function updateDescription( newdata ) {
			var newdatastr=newdata.toString();
			var index=newdatastr.indexOf("<p>");
			newdatastr=newdatastr.substr(index);
			newdatastr=newdatastr.replace(/<\/?[^>]+(>|$)/g, "")
			var item=jQuery(event.target.closest(".rich-text")).closest(".col-image");
			var All_items=item.closest(".cols-image").find(".col-image");
			var position=All_items.index(item);
			var acc_description= [...props.attributes.description];
			
			if(newdatastr.length<=100){
				acc_description[position]=newdata;
				props.setAttributes( { description: acc_description } );
				jQuery(event.target.closest(".rich-text")).attr("backup",jQuery(event.target.closest(".rich-text")).html());
				console.log(jQuery(event.target.closest(".rich-text")).attr("backup"));
			}
			else
				jQuery(event.target.closest(".rich-text")).html(jQuery(event.target.closest(".rich-text")).attr("backup"));
		}
		
		if(jQuery(".cols-image").find(".col-image").find(".rich-text").attr("bindPaste")!=true)
		jQuery(".cols-image").find(".col-image").find(".rich-text").bind("paste", function(e){
				
				var newdata=jQuery(this).html();
				var pastedData = e.originalEvent.clipboardData.getData('text');
				var newdatastr=newdata.toString();
				
				var index=newdatastr.indexOf("<p>");
				//newdatastr=newdatastr.substr(index);
				//console.log("aaaaaaaaaaaaaaa: "+index+"  "+newdatastr);
				newdatastr=newdatastr.replace(/<\/?[^>]+(>|$)/g, "")
				var item=jQuery(this).closest(".col-image");
				var All_items=item.closest(".cols-image").find(".col-image");
				var position=All_items.index(item);
				var acc_description= [...props.attributes.description];
				if(newdatastr.length<=100){
					acc_description[position]=newdata;
					props.setAttributes( { description: acc_description } );
					jQuery(this).attr("backup",jQuery(this).html());
				}
				else
					jQuery(event.target).html(jQuery(event.target).attr("backup"));
				console.log("copia: "+pastedData);
		});
		jQuery(".col-image").find(".cols-image").find(".col-image").find(".rich-text").attr("bindPaste",true);
		function addlinkdata( event ) {
			var item=jQuery(event.target).closest(".col-image");
			var All_items=item.closest(".cols-image").find(".col-image");
			var position=All_items.index(item);
			var acc_url= [...props.attributes.url];
			var acc_title= [...props.attributes.title];
			var acc_description= [...props.attributes.description];
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
							multiple: true
						})
					]
				});
				//position=0;
				count=1;
				// Select the attachment when the frame opens
				gallery_items_frame.on('close',function() {
					var selection = gallery_items_frame.state().get('selection');
					selection.each(function(attachment) {
						acc_title.splice(position+count, 0, attachment.attributes.title);
						acc_url.splice(position+count, 0, attachment.attributes.url);
						var description_value=attachment.attributes.caption;
						if(description_value==undefined)
							description_value="";
						acc_description.splice(position+count, 0, description_value);
						count++;	
					});
					if(selection.length>0){
						props.attributes.url=Array(selection.length);
						props.attributes.title=Array(selection.length);
						props.setAttributes( { title: acc_title } );
						props.setAttributes( { url: acc_url } );
						props.setAttributes( { description: acc_description } );
						
					}
				});
				gallery_items_frame.open();
			
		}
			
		
		function removelinkdata( event ) {
			var item=jQuery(event.target).closest(".col-image");
			var All_items=item.closest(".cols-image").find(".col-image");			
			if(All_items.length>1){
				var position=All_items.index(item);
				
				var acc_description= [...props.attributes.description];
				acc_description.splice( position, 1);
				props.setAttributes( { acc_description: acc_description } );
				
				var acc_title= [...props.attributes.title];
				acc_title.splice( position, 1);
				props.setAttributes( { title: acc_title } );
				
				var acc_url= [...props.attributes.url];
				acc_url.splice( position, 1);
				props.setAttributes( { url: acc_url } );				
			}
		}
		
		
		
		
		
		
		var sizelines=Math.round((props.attributes.url.length+props.attributes.title.length)/2)
		var photos_editor=Array();
		
		
		
		
		
		
		
		
		
		for(index=0;index<sizelines;index++){  
			richTextDescription=el(wp.editor.RichText,
				{
					tagName: 'div',
					className: 'color-1 w-100 text-end text-break',
					multiline:true,
					onChange: updateDescription,
					onkeypress: updateDescription,
					value: props.attributes.description[index],
					placeholder: 'Coloque seu texto aqui 100 caracteres...',
					style:{color:"white",textShadow:" 2px 2px 10px #000000", backgroundColor:"inherit"}
				}							
			);
			
			var _backgroundImage=("url("+props.attributes.url[index]+")");
			photos_editor.push(
				el( 'div',{className:'col-image block-by-3 p-2'},
					el('button',
						{
							href:"#",
							style:{position:'absolute',marginTop:'40px',marginLeft:'10px',width:"30px",cursor:'hand',color:'white',backgroundColor:'#0d6efd',zIndex:10000	},
							onClick:updateURl,
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
					el(
						'input', 
						{
							type: 'button', 							
							ariaLabel:"Remover Linha",
							value: '-',
							onClick: removelinkdata,
							style: { position:'absolute',marginTop:'10px',marginLeft:'10px',minWidth: '15px',minHeight:'15px',backgroundColor:'red',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px',zIndex:10000}
						}
					),
					el(
						'input', 
						{
							type: 'button', 							
							ariaLabel:"Adiciona Linha",
							value: '+',
							onClick: addlinkdata,
							style: { position:'absolute',marginTop:'10px',marginLeft:'25px',minWidth: '15px',minHeight:'15px',backgroundColor:'black',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px',zIndex:10000}
						}
					),
					el( 'div',
						{ 
							className: 'top-image rounded w-100',
							style:{paddingTop:"50%","background-image":_backgroundImage,"background-size":"Cover","background-position": "center center"}
						},
						
					),
					el('h4', 
						{
							className: 'color-1 w-100 text-break',
							style:{textShadow:" 2px 2px 10px #000000"}
						},
						el('input',
							{	className: 'color-1 w-100 text-start ',
								onChange: updateTitle,
								style:{color:"inherit", backgroundColor:"inherit"},
								value:props.attributes.title[index],
								placeholder: 'Coloque seu título aqui até 50 caracteres...'
							}
						)
					),
					richTextDescription
				)
			)
		}
		if(sizelines%3!=0)
		for(index=0;index<3-sizelines%3;index++){
			photos_editor.push(el( 'div',{className:'block-by-3 p-2',style:{"min-height":"1px"}},""));
		}
		return el( 'div', {className:"cols-image w-100 container-block-by"},
			photos_editor
		); 

	},	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	save: function(props) {
		var sizelines=Math.round((props.attributes.url.length+props.attributes.title.length)/2)
		var photos_editor=Array();
		for(index=0;index<sizelines;index++){  
			var _backgroundImage=("url("+props.attributes.url[index]+")");
			photos_editor.push(
				el( 'div',
					{ 
						className: 'col-image rounded ',
						style:{width:"100%",height:"100%","background-image":_backgroundImage,"background-size":"Cover","background-position": "center center"}
					},
					el( 
						'div', 
						{ 
							className: 'carousel-caption color-1 w-100',
							style:{"top":"calc(100% - 25px)",right:"10px",left:"auto"}
						},
						el('h4', 
							
							{
								className: 'color-1 w-100  text-break',
								style:{textShadow:" 2px 2px 10px #000000"}
							},
							props.attributes.title[index]
							
						),
						el('div',
							{
								className: 'color-1 w-100  text-break',
								style:{color:"white",textShadow:" 2px 2px 10px #000000", backgroundColor:"inherit"}
							},
							window.HTMLReactParser(props.attributes.description[index])
						)
					)
				)
			)
		}
		if(sizelines%3!=0)
		for(index=0;index<3-sizelines%3;index++){
			photos_editor.push(el( 'div',{className:'block-by-3 p-2',style:{"min-height":"1px"}},""));
		}
		return el( 'div', {className:"cols-image w-100 container-block-by "},
			photos_editor
		);  
	}	
});


