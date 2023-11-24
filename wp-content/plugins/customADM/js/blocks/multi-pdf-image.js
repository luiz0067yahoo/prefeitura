
var el = wp.element.createElement;
var dataImagefirstPagePDFbyURL;
var loadDimension =function(){
	jQuery(".height-square").each(function(){
			jQuery(this).height(jQuery(this).width());
	});
	jQuery(".dimenssion-parent").each(function(){
		height=($(this).parent().height());
		width=($(this).parent().width());
		jQuery(this).height(height);
		jQuery(this).width(width);
	});
	jQuery(".max-height-parent-first-child").each(function(){
		height=($(this).parent().children(":first").height());
		jQuery(this).css("max-height",height+"px");
	});
	jQuery(".min-height-first-child").each(function(){
		height=($(this).first().height());
		if(jQuery(this).css("max-height").replace('px', '')>height)
			jQuery(this).css("min-height",jQuery(this).css("max-height"));
		else
			jQuery(this).css("min-height",height+"px");
	});
}

createTumbmailPDF =function(canvas,url){
	if(canvas!=null){
		pdfjsLib.getDocument(url).promise.then(function (doc) {
			
		  var pages = []; 
		  var canvas_width=280;
		  var canvas_height=280;
		  
		 
		  if (pages.length < doc.numPages) pages.push(pages.length + 1);
		  return Promise.all(pages.map(function (num) {
			return doc.getPage(num).then(
				function (page) {
					var scale = 1;
					var viewport = page.getViewport({ scale: scale});
					scale = Math.min(canvas_width / viewport.width, canvas_height / viewport.height);
					viewport = page.getViewport({ scale: scale});
					var outputScale = window.devicePixelRatio || 1;
					var context = canvas.getContext('2d');
					canvas.width = Math.floor(viewport.width * outputScale);
					canvas.height = Math.floor(viewport.height * outputScale);
					canvas.style.width = Math.floor(viewport.width) + "px";
					canvas.style.height =  Math.floor(viewport.height) + "px";
					var transform = outputScale !== 1
					  ? [outputScale, 0, 0, outputScale, 0, 0]
					  : null;
					var renderContext = {
					  canvasContext: context,
					  transform: transform,
					  viewport: viewport
					};
					page.render(renderContext);
				}
			)  
		  }));
		}).catch(console.error);
	}
	return canvas;
}

wp.blocks.registerBlockType('cms-adm/multi-pdf', {
	title: 'Lista PDF',		// Block name visible to user
	icon: 'pdf',	// Toolbar icon can be either using WP Dashicons or custom SVG
	description : 'Adcione até 3 pdfs for linha' ,
	
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
		description: { type: 'array' },			// Notice box title in h4 tag
		dateFile: { type: 'array' },			// Notice box title in h4 tag
		url: { type: 'array' },		// row url
		media_id: { type: 'array' },		// row url
		dataImage: { type: 'array' },		// row url
		main_block_id: { type: 'string' }
	},
	edit: function(props) {
		//How our block renders in the editor in edit mode
			if((props.attributes.title===undefined)||(props.attributes.title.length==0)){
				props.attributes.title=Array("");
			}
			if((props.attributes.description===undefined)||(props.attributes.description.length==0)){
				props.attributes.description=Array("");
			}
			if((props.attributes.dateFile===undefined)||(props.attributes.dateFile.length==0)){
				props.attributes.dateFile=Array("");
			}
			if((props.attributes.url===undefined)||(props.attributes.url.length==0)){
				props.attributes.url=Array("");
			}
			if((props.attributes.media_id===undefined)||(props.attributes.media_id.length==0)){
				props.attributes.media_id=Array("");
			}
			if((props.attributes.dataImage===undefined)||(props.attributes.dataImage.length==0)){
				props.attributes.dataImage=Array("");
			}
			if((props.attributes.main_block_id===undefined)||(props.attributes.main_block_id.length==0)){
				var main_block_id="pdf-mini-"+(Math.floor(Math.random() * 1000) + 1);
				if(jQuery("#"+main_block_id).length!=0)
					main_block_id="pdf-mini-"+(Math.floor(Math.random() * 1000) + 1);
				props.attributes.main_block_id=main_block_id;
			}
			dataImagefirstPagePDFbyURL= function(indexDataImage,url){
				if((url!=null)&&(url!=undefined)&&(url.length>0)){  
					var	canvas=document.createElement("CANVAS");
					if(canvas!=null){
						pdfjsLib.getDocument(url).promise.then(function (doc) {
							
						  var pages = []; 
						  var canvas_width=500;
						  var canvas_height=500;
						  
						 
						  if (pages.length < doc.numPages) pages.push(pages.length + 1);
						  return Promise.all(pages.map(function (num) {
							return doc.getPage(num).then(
								function (page) {
									var scale = 1;
									var viewport = page.getViewport({ scale: scale});
									scale = Math.min(canvas_width / viewport.width, canvas_height / viewport.height);
									viewport = page.getViewport({ scale: scale});
									var outputScale = window.devicePixelRatio || 1;
									var context = canvas.getContext('2d');
									canvas.width = Math.floor(viewport.width * outputScale);
									canvas.height = Math.floor(viewport.height * outputScale);
									canvas.style.width = Math.floor(viewport.width) + "px";
									canvas.style.height =  Math.floor(viewport.height) + "px";
									var transform = outputScale !== 1
									  ? [outputScale, 0, 0, outputScale, 0, 0]
									  : null;
									var renderContext = {
									  canvasContext: context,
									  transform: transform,
									  viewport: viewport
									};
									var task=page.render(renderContext);
									task.promise.then(function(){
										if(props.attributes.dataImage[indexDataImage]==undefined)
										props.attributes.dataImage[indexDataImage]=canvas.toDataURL('image/jpeg',0.75);
										/*if(
											props.attributes.dataImage[indexDataImage]==null
											||
											props.attributes.dataImage[indexDataImage]==undefined
											||
											props.attributes.dataImage[indexDataImage].length==0
										)*/
										{
											acc_dataImage=[...props.attributes.dataImage];
											acc_dataImage[indexDataImage]=canvas.toDataURL('image/jpeg',0.75);
											props.setAttributes( { dataImage: acc_dataImage } );
										}
									});
								}
							)  
						  }));
						}).catch(console.error);
					}
				}
				return "";
			}

			function updateDescription( newdata ) {
				var newdatastr=newdata.toString();
				var index=newdatastr.indexOf("<p>");
				newdatastr=newdatastr.substr(index);
				newdatastr=newdatastr.replace(/<\/?[^>]+(>|$)/g, "")
				var item=jQuery(event.target).closest(".pdf-mini-bloco");
				var All_items=item.closest(".pdf-mini-bloco-block").find(".pdf-mini-bloco");
				var All_items_length=All_items.length;
				var position=All_items.index(item);
				var acc_title= [...props.attributes.title];
				var acc_description= [...props.attributes.description];
				var acc_dateFile= [...props.attributes.dateFile];
				if(newdatastr.length<=50){
					acc_description[position]=newdata;
					props.setAttributes( { description: acc_description } );
					jQuery(event.target.closest(".rich-text")).attr("backup",jQuery(event.target.closest(".rich-text")).html());
				}
				else
					jQuery(event.target.closest(".rich-text")).html(jQuery(event.target.closest(".rich-text")).attr("backup"));
			}
			function updateTitle( newdata ) {
				var newdatastr=newdata.toString();
				var index=newdatastr.indexOf("<p>");
				newdatastr=newdatastr.substr(index);
				newdatastr=newdatastr.replace(/<\/?[^>]+(>|$)/g, "")
				var item=jQuery(event.target).closest(".pdf-mini-bloco");
				var All_items=item.closest(".pdf-mini-bloco-block").find(".pdf-mini-bloco");
				var All_items_length=All_items.length;
				var position=All_items.index(item);
				var acc_title= [...props.attributes.title];
				var acc_description= [...props.attributes.description];
				var acc_dateFile= [...props.attributes.dateFile];
				var acc_dataImage= [...props.attributes.dataImage];
				if(newdatastr.length<=50){
					acc_title[position]=newdata;
					props.setAttributes( { title: acc_title } );
					jQuery(event.target.closest(".rich-text")).attr("backup",jQuery(event.target.closest(".rich-text")).html());
				}
				else
					jQuery(event.target.closest(".rich-text")).html(jQuery(event.target.closest(".rich-text")).attr("backup"));
			}
			function updateURl( event ) {
				var item=jQuery(event.target).closest(".pdf-mini-bloco");
				var All_items=item.closest(".pdf-mini-bloco-block").find(".pdf-mini-bloco");
				var position=All_items.index(item);
				var acc_url= [...props.attributes.url];
				var acc_media_id= [...props.attributes.media_id];
				var acc_title= [...props.attributes.title];
				var acc_description= [...props.attributes.description];
				var acc_dateFile= [...props.attributes.dateFile];
				var acc_dataImage= [...props.attributes.dataImage];
				gallery_items_frame = wp.media.frames.gallery_items = wp.media({
					// Set the title of the modal.
					title:"Selecione seu anexo",
					button: {
						text: "linkar anexo"
					},
					states: [
						new wp.media.controller.Library({
							title: "linkar anexo",
							//type: '.pdf',  
							//type: 'document/PDF',  
							//filterable: 'application/pdf',  
							//type: 'application/pdf',  
							//filterable: 'application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-word.document.macroEnabled.12,application/vnd.ms-word.template.macroEnabled.12,application/vnd.oasis.opendocument.text,application/vnd.apple.pages,application/pdf,application/vnd.ms-xpsdocument,application/oxps,application/rtf,application/wordperfect,application/octet-stream',  
							//type:["application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-word.document.macroEnabled.12,application/vnd.ms-word.template.macroEnabled.12,application/vnd.oasis.opendocument.text,application/vnd.apple.pages,application/pdf,application/vnd.ms-xpsdocument,application/oxps,application/rtf,application/wordperfect,application/octet-stream"],
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
						acc_url[position]= attachment.attributes.url;
						acc_media_id[position]= attachment.attributes.attachment_id;
						acc_title[position]= attachment.attributes.title;
						acc_dateFile[position]= attachment.attributes.dateFormatted;
						acc_description[position]= "";
						props.attributes.dataImage[position]= "";
						dataImagefirstPagePDFbyURL(position,attachment.attributes.url);
						setTimeout(function(){ dataImagefirstPagePDFbyURL(position,attachment.attributes.url)},100);
						setTimeout(function(){ dataImagefirstPagePDFbyURL(position,attachment.attributes.url)},200);
						count++;
					});
					if(selection.length>0){
						props.attributes.url=Array(selection.length);
						props.attributes.title=Array(selection.length);
						props.setAttributes( { url: acc_url } );
						props.setAttributes( { media_id: acc_media_id } );
						props.setAttributes( { title: acc_title } );
						props.setAttributes( { dateFile: acc_dateFile } );
						props.setAttributes( { description: acc_description } );
						setTimeout(function(){ props.setAttributes( { dataImage: [...props.attributes.dataImage] } );},300);
						setTimeout(function(){ props.setAttributes( { dataImage: [...props.attributes.dataImage] } );},400);
					}
				});
				gallery_items_frame.open();
				
			}
			function addlinkdata( event ) {
				if(props.attributes.title.length<18){
					var item=jQuery(event.target).closest(".pdf-mini-bloco");
					var All_items=item.closest(".pdf-mini-bloco-block").find(".pdf-mini-bloco");
					var position=All_items.index(item);
					var acc_title= [...props.attributes.title];
					var acc_url= [...props.attributes.url];
					var acc_media_id= [...props.attributes.media_id];
					var acc_description= [...props.attributes.description];
					var acc_dateFile= [...props.attributes.dateFile];
					var acc_dataImage= [...props.attributes.dataImage];
					acc_url.splice(position+1,0,"");
					acc_title.splice(position+1,0,"");
					acc_media_id.splice(position+1,0,"");
					acc_description.splice(position+1,0,"");
					acc_dateFile.splice(position+1,0,"");
					acc_dataImage.splice(position+1,0,"");
					props.setAttributes( { url: acc_url } );
					props.setAttributes( { title: acc_title } );
					props.setAttributes( { media_id: acc_media_id } );
					props.setAttributes( { description: acc_description } );
					props.setAttributes( { dateFile: acc_dateFile } );
					props.setAttributes( { dataImage: acc_dataImage } );
				}
				else{
					alert("Somente 18 itens por Bloco");
				}
			}
			function removelinkdata( event ) {
				var item=jQuery(event.target).closest(".pdf-mini-bloco");
				var All_items=item.closest(".pdf-mini-bloco-block").find(".pdf-mini-bloco");
				var All_items_length=All_items.length;
				var position=All_items.index(item);
				if(All_items_length>1){
					var position=All_items.index(item);
					var acc_title= [...props.attributes.title];
					var acc_url= [...props.attributes.url];
					var acc_media_id= [...props.attributes.media_id];
					var acc_description= [...props.attributes.description];
					var acc_dateFile= [...props.attributes.dateFile];
					var acc_dataImage= [...props.attributes.dataImage];
					acc_url.splice( position, 1);
					acc_title.splice( position, 1);
					acc_media_id.splice( position, 1);
					acc_description.splice( position, 1);
					acc_dateFile.splice( position, 1);
					acc_dataImage.splice( position, 1);
					props.setAttributes( { url: acc_url } );
					props.setAttributes( { title: acc_title } );
					props.setAttributes( { media_id: acc_media_id } );
					props.setAttributes( { description: acc_description } );
					props.setAttributes( { dateFile: acc_dateFile } );
					props.setAttributes( { dataImage: acc_dataImage } );
				}
		   }
 
		var sizelines=Math.round((props.attributes.url.length+props.attributes.title.length)/2);
		var count_block=jQuery(".canvas-pdf-image").length;

	   	var lines_editor=Array();
		for(index=0;index<Math.min(3,sizelines);index++){
			var img_id="img_"+props.attributes.main_block_id+"_"+index;
			
			lines_editor.push(
				
				el('div',
					{
						className:"pdf-mini-bloco block-by-3 p-2 flex-wrap",
					},
					el('div',
						{
							className:"d-flex  w-100",
							style:{height:"30px"}
						},
						
						el('button',
							{
								href:"#",
								style:{position:'absolute',marginTop:'0px',marginLeft:'120px',width:"30px",cursor:'hand',color:'red',backgroundColor:'#FFFFFF',zIndex:10000	},
								onClick:updateURl,
								className:"link"
							},
							el('i',
								{
									className:"fa fa-file-pdf",
									'aria-hidden':'true',
								},
								""
							)
						),
					),
					el('div',
						{
							className:"d-flex align-items-center w-100",
							style:{height:"30px"}
						},

						el(
							'input', 
							{
								type: 'button', 							
								ariaLabel:"Remover Linha",
								value: '-',
								onClick: removelinkdata,
								style: { width: '25px',height:'25px',backgroundColor:'black',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px',position:'absolute', "margin-left":'95px',"margin-top":'0px'  }
							}
						),
						el(
							'input', 
							{
								type: 'button', 							
								ariaLabel:"Adiciona Linha",
								value: '+',
								onClick: addlinkdata,
								style: { width: '25px',height:'25px',backgroundColor:'black',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px',position:'absolute',"margin-left":'120px',"margin-top":'0px' }
							}
						)

					),
					el('a',
						{
							className:"text-decoration-none  d-flex mx-auto height-square w-100 d-block overflow-hidden align-items-center",
							style:{border:"solid 1px #ccc"},
							target:"_blank",
							href:props.attributes.url[index],
						},
						el(
								'img',
								{
									id:img_id,
									className:"rounded mx-auto",
									style:{"max-width":"100%","max-height":"100%"},
									src:props.attributes.dataImage[index]
								}
								
						),
						
						
					),	
					el(
						'div',
						{
							className:"w-100 all-text-pdf",	
							style:{height:"100px"},	
						},
						el('label',
							{
								
								className:"w-100 ",
								style:{textAlign:"left",width:"100%",backgroundColor:'inherit',color:'#999',fontSize:"12px"},
							},
							props.attributes.dateFile[index]
						),
						el(wp.editor.RichText,
							{
								tagName: 'label',
								type:"text",
								multiline:true,
								className:"w-100 color-4",
								value: props.attributes.title[index],
								style:{textAlign:"left",width:"100%",backgroundColor:'inherit',color:'inherit',fontSize:"20px"},
								placeholder: 'Coloque seu texto aqui 50 caracteres...',
								onChange: updateTitle 
							}
						),
						
						
						el(wp.editor.RichText,
							{
								tagName: 'label',
								type:"text",
								multiline:true,
								className:"w-100 ",
								value: props.attributes.description[index],
								style:{textAlign:"left",width:"100%",backgroundColor:'inherit',color:'inherit'},
								placeholder: 'Coloque seu texto aqui 50 caracteres...',
								onChange: updateDescription 
							}
						)
					
					),
				),
				
			);
			
		}
		if((sizelines%3!=0)&&(sizelines<3))
		for(index=0;index<(3-(sizelines%3));index++){
			lines_editor.push(
				el('div',
					{
						className:" block-by-3 p-2 flex-wrap",
					}
				)
			);
		}
		if(sizelines>=3){
			lines_editor.push(el('div',{className:"w-100"},el('hr',{className:"w-50 mx-auto"})));
			for(index=3;index<sizelines;index++){	
				lines_editor.push(
					
					el('div',
						{
							className:"pdf-mini-bloco block-by-3 p-2 flex-wrap",
						},
						el('div',
							{
								className:"d-flex  w-100",
								style:{height:"30px"}
							},
							
							el('button',
								{
									href:"#",
									style:{position:'absolute',marginTop:'0px',marginLeft:'-15px',width:"30px",cursor:'hand',color:'red',backgroundColor:'#FFFFFF',zIndex:10000	},
									onClick:updateURl,
									className:"link"
								},
								el('i',
									{
										className:"fa fa-file-pdf",
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
									style: { width: '25px',height:'25px',backgroundColor:'black',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px',position:'absolute', "margin-left":'15px',"margin-top":'0px'  }
								}
							),
							el(
								'input', 
								{
									type: 'button', 							
									ariaLabel:"Adiciona Linha",
									value: '+',
									onClick: addlinkdata,
									style: { width: '25px',height:'25px',backgroundColor:'black',color:'white', paddingLeft:'0px',paddingRight:'0px',paddingTop:'0px',paddingBottom:'0px',position:'absolute',"margin-left":'45px',"margin-top":'0px' }
								}
							)

						),
						el(
							'a',
							{
								className:"text-decoration-none  container-block-by w-100 all-text-pdf  justify-content-start",	
								style:{"border-bottom":"solid 1px #ccc"},							
								//target:"_blank",
								//href:props.attributes.url[index],	
							},
							el('label',
								{
									
									className:"	",
									style:{textAlign:"left",backgroundColor:'inherit',color:'#999',fontSize:"12px","flex-grow": 0},
								},
								props.attributes.dateFile[index]+" | "
							),
							el(wp.editor.RichText,
								{
									tagName: 'label',
									type:"text",
									multiline:false,
									className:"",
									value: props.attributes.title[index],
									style:{textAlign:"left",backgroundColor:'inherit',color:'#999',fontSize:"12px","padding-left":"5px"},
									placeholder: 'Coloque seu texto aqui 50 caracteres...',
									onChange: updateTitle 
								}
							),
							
							
							el(wp.editor.RichText,
								{
									tagName: 'label',
									type:"text",
									multiline:true,
									className:"w-100 color-1",
									value: props.attributes.description[index],
									style:{textAlign:"left",backgroundColor:'inherit',color:'inherit'},
									placeholder: 'Coloque seu texto aqui 50 caracteres...',
									onChange: updateDescription 
								}
							)
						
						),
					),
					
				);
			}	
		}
		if(sizelines%3!=0)
		for(index=0;index<(3-(sizelines%3));index++){
			lines_editor.push(
				el('div',
					{
						className:" block-by-3 p-2 flex-wrap",
					}
				)
			);
		}		
		setTimeout(loadDimension,250);		
		return el('div',
			{className:"pdf-mini-bloco-block container-block-by  w-100  mb-2"},
			
				lines_editor
			
		);
		/*
		
		*/
	},	// End edit()
	
	save: function(props) {
		var sizelines=Math.round((props.attributes.url.length+props.attributes.title.length)/2);
		var count_block=jQuery(".canvas-pdf-image").length;

	   	var lines_save=Array();
		for(index=0;index<Math.min(3,sizelines);index++){
			var img_id="img_"+props.attributes.main_block_id+"_"+index;
			
			lines_save.push(
				
				el('div',
					{
						className:"pdf-mini-bloco block-by-3 p-2 flex-wrap",
					},
					el('a',
						{
							className:"text-decoration-none  d-flex mx-auto height-square w-100 d-block overflow-hidden align-items-center",
							style:{border:"solid 1px #ccc"},							
							target:"_blank",
							href:props.attributes.url[index],
						},
						el(
							'img',
							{
								id:img_id,
								className:"rounded mx-auto",
								style:{"max-width":"100%","max-height":"100%"},
								src:props.attributes.dataImage[index]
							}
						),
					),
					el(
						'div',
						{
							className:"w-100 all-text-pdf",	
							style:{height:"100px"},	
						},
						el('label',
							{
								
								className:"w-100 ",
								style:{textAlign:"left",width:"100%",backgroundColor:'inherit',color:'#999',fontSize:"12px"},
							},
							props.attributes.dateFile[index]
						),
						el('label',
							{
								className:"w-100 color-4",
								style:{textAlign:"left",width:"100%",backgroundColor:'inherit',color:'inherit',fontSize:"20px"},
							},
							((props.attributes.title[index]==undefined)||(props.attributes.title[index].length==0))?"":window.HTMLReactParser(props.attributes.title[index])
						),
						
						
						el('label',
							{
								className:"w-100 color-1",
								style:{textAlign:"left",width:"100%",backgroundColor:'inherit',color:'inherit'},
							},
							((props.attributes.description[index]==undefined)||(props.attributes.description[index].length==0))?"":window.HTMLReactParser(props.attributes.description[index])
						)
					
					),
				),
				
			);
			
		}
		if((sizelines%3!=0)&&(sizelines<3))
		for(index=0;index<(3-(sizelines%3));index++){
			lines_save.push(
				el('div',
					{
						className:" block-by-3 p-2 flex-wrap",
					}
				)
			);
		}
		if(sizelines>=3){
			lines_save.push(el('div',{className:"w-100"},el('hr',{className:"w-50 mx-auto"})));
			for(index=3;index<sizelines;index++){	
				lines_save.push(
					
					el('div',
						{
							className:"pdf-mini-bloco block-by-3 p-2 flex-wrap",
						},
						el('a',
							{
								className:"text-decoration-none container-block-by w-100 all-text-pdf  justify-content-start",	
								style:{"border-bottom":"solid 1px #ccc"},							
								target:"_blank",
								href:props.attributes.url[index],	
							},
							el('label',
								{
									
									className:"	",
									style:{textAlign:"left",backgroundColor:'inherit',color:'#999',fontSize:"12px","flex-grow": 0},
								},
								props.attributes.dateFile[index]+" | "
							),
							el('label',
								{
									style:{textAlign:"left",backgroundColor:'inherit',color:'#999',fontSize:"12px","padding-left":"5px"},
								},
								((props.attributes.title[index]==undefined)||(props.attributes.title[index].length==0))?"":window.HTMLReactParser(props.attributes.title[index])
							),
							
							
							el('label',
								{
									className:"w-100 color-1",
									style:{textAlign:"left",backgroundColor:'inherit',color:'inherit'},
								},
								((props.attributes.description[index]==undefined)||(props.attributes.description[index].length==0))?"":window.HTMLReactParser(props.attributes.description[index])
							)
						
						),
					),
					
				);
			}	
		}
		if(sizelines%3!=0)
		for(index=0;index<(3-(sizelines%3));index++){
			lines_save.push(
				el('div',
					{
						className:" block-by-3 p-2 flex-wrap",
					}
				)
			);
		}		
		
		return el('div',
			{className:"pdf-mini-bloco-block container-block-by  w-100  mb-2"},
			
				lines_save
			
		);
	}	
});