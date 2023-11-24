var el = wp.element.createElement;


wp.blocks.registerBlockType('cms-adm/image-only', {
	title: 'Imagem Única',		// Block name visible to user
	icon: 'admin-media',	// Toolbar icon can be either using WP Dashicons or custom SVG
	description : 'Apenas uma imagem por linha' ,
	
	category: 'media',	// Under which category the block would appear
	supports: {
		multiple: true,
	},
	attributes: {			// The data this block will be storing
		url: { type: 'string' },			// row description
	},
	edit: function(props) {
		if
		(
			((props.attributes.url===undefined)||(props.attributes.url.length==0))
		
		)
		{	
			var acc_url=""	;
			props.attributes.url="";
			
			
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
			position=0;
			count=0;
			// Select the attachment when the frame opens
			gallery_items_frame.on('close',function() {
				var selection = gallery_items_frame.state().get('selection');
				selection.each(function(attachment) {
                    if(count==0){
                        acc_url=attachment.attributes.url;
                    }
					count++;
				});
				if(selection.length>0){
					props.setAttributes( { url: acc_url } );
				}
			});
			gallery_items_frame.open();
		}
 
		
      	
		function updateURl( event ) {
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
                    if(count==0){
                        acc_url= attachment.attributes.url;
                    }
					count++;
				});
				if(selection.length>0){
					props.setAttributes( { url: acc_url } );
					
				}
			});
			gallery_items_frame.open();
		}
		
        
		
		return el( 'div', {className:"w-100 only-image-block "},
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
			el( 'img', {className:"rounded", src:props.attributes.url,style:{minWidth:"280px", width:"100%",height:"auto",marginLeft:"auto",marginRight:"auto",marginBottom:"20px"}})
		); 

	},	
	
	
	
	
	
	
	save: function(props) {
		
		return el( 'div', {className:"w-100 only-image-block "},
			el( 'img', {className:"rounded ", src:props.attributes.url,style:{minWidth:"280px", width:"100%",height:"auto",marginLeft:"auto",marginRight:"auto",marginBottom:"20px"}})
		); 
	}	
});


