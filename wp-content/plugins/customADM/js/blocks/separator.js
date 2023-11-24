/*// ES Modules
import parse from 'html-react-parser';

// CommonJS
const parse = require('html-react-parser');*/
var el = wp.element.createElement;


wp.blocks.registerBlockType('cms-adm/separator', {
	title: 'Separador',		// Block name visible to user
	icon: 'minus',	// Toolbar icon can be either using WP Dashicons or custom SVG
	category: 'common',	// Under which category the block would appear
	supports: {
		multiple: true,
	},
	description : 'O separador divide os conteúdos em por uma linha' ,
	example: {
		attributes: {
			backgroundColor: '#000000',
			opacity: 0.8,
			textColor: '#FFFFFF'
		},
	},
	attributes: {			// The data this block will be storing
		
		
		
	},
	edit: function(props) {
		
		return el
		( 'div', 
			{ 
				className: 'separator-green',
			},
			''
		); 

	},	
	
	
	save: function(props) {
		return el
		( 'div', 
			{ 
				className: 'separator-green',
			},
			''
		); 
	}	
});


/*

		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>

*/