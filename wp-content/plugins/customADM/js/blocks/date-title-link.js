/*// ES Modules
import parse from 'html-react-parser';

// CommonJS
const parse = require('html-react-parser');*/
var el = wp.element.createElement;

showHideTableContent = function(event) {
    var table = jQuery(event.target).closest("table");
    table.find("tbody").toggle();
    table.find("caption").find("i").toggleClass("fa-chevron-down fa-chevron-up");
    table.find("thead").toggle();
    if (table.find("caption").find("i").hasClass("fa-chevron-down")) {
        var tables = jQuery(".table-link-file-upload-box");
        tables.each(function(index) {
            var position = tables.index(table);
            if (position != index) {
                jQuery(this).find("tbody").hide();
                jQuery(this).find("thead").hide();
                jQuery(this).find("caption").find("i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
            }
        });
        tables = jQuery(".table-link-box");
        tables.each(function(index) {
            var position = tables.index(table);
            if (position != index) {
                jQuery(this).find("tbody").hide();
                jQuery(this).find("thead").hide();
                jQuery(this).find("caption").find("i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
            }
        });
    }
}

wp.blocks.registerBlockType('cms-adm/date-title-link-external', {
    title: 'Lista de links', // Block name visible to user
    icon: 'admin-links', // Toolbar icon can be either using WP Dashicons or custom SVG
	description : 'lista de links de páginas' ,
	example: {
		attributes: {
			backgroundColor: '#000000',
			opacity: 0.8,
			textColor: '#FFFFFF'
		},
	},	
    category: 'design', // Under which category the block would appear
    supports: {
        multiple: true,
    },
    attributes: { // The data this block will be storing
        caption: { type: 'string' }, // Notice box title in h4 tag
        title: { type: 'array' }, // Notice box title in h4 tag
        url: { type: 'array' }, // row description
        date_link: { type: 'array' } // row description

    },
    edit: function(props) {
        //How our block renders in the editor in edit mode



        if (
            ((props.attributes.url === undefined) || (props.attributes.url.length == 0)) ||
            ((props.attributes.title === undefined) || (props.attributes.title.length == 0))
        ) {
            var quantidade_de_link = 5; //prompt("quantos links precisa?");
            props.attributes.url = Array(5);
            props.attributes.title = Array(5);
            props.attributes.date_link = Array(5);
        }

        var sizelines = Math.round((props.attributes.url.length + props.attributes.title.length) / 2);


        function updateCaption(event) {
            props.setAttributes({ caption: event.target.value });
        }

        function updateTitle(event) {
            var table = jQuery(event.target).closest("table");
            var lines = table.find(".line-editor");
            var line = jQuery(event.target).closest(".line-editor");
            position = lines.index(line);
            var acc_title = Array();
            var acc_date_link = Array();
            acc_title = [...props.attributes.title];
            acc_date_link = [...props.attributes.date_link];
            acc_title[position] = event.target.value;
            acc_date_link[position] = (acc_date_link[position] == undefined) ? (new Date()).toLocaleDateString() : acc_date_link[position];
            props.setAttributes({ title: acc_title });
            props.setAttributes({ date_link: acc_date_link });
        }

        function updateUrl(event) {
            jQuery(event.target).closest(".line-editor").find("a").attr("href", event.target.value);
            var table = jQuery(event.target).closest("table");
            var lines = table.find(".line-editor");
            var line = jQuery(event.target).closest(".line-editor");
            position = lines.index(line);
            var acc_url = Array();
            var acc_date_link = Array();
            acc_url = [...props.attributes.url];
            acc_date_link = [...props.attributes.date_link];
            acc_url[position] = event.target.value;
            acc_date_link[position] = (acc_date_link[position] == undefined) ? (new Date()).toLocaleDateString() : acc_date_link[position];
            props.setAttributes({ url: acc_url });
            props.setAttributes({ date_link: acc_date_link });
        }

        function addlinkdata(event) {
            var table = jQuery(event.target).closest("table");
            var lines = table.find(".line-editor");
            var line = jQuery(event.target).closest(".line-editor");
            position = lines.index(line);

            var acc_title = Array();
            var acc_url = Array();
            var acc_date_link = Array();

            acc_url = [...props.attributes.url];
            acc_title = [...props.attributes.title];
            acc_date_link = [...props.attributes.date_link];
            acc_title.splice(position + 1, 0, "");
            acc_url.splice(position + 1, 0, "");
            acc_date_link.splice(position + 1, 0, (new Date()).toLocaleDateString());
            props.setAttributes({ title: acc_title });
            props.setAttributes({ url: acc_url });
            props.setAttributes({ date_link: acc_date_link });
        }

        function removelinkdata(event) {
            var table = jQuery(event.target).closest("table");
            var lines = table.find(".line-editor");
            var line = jQuery(event.target).closest(".line-editor");
            var position = lines.index(line);
            if (lines.length > 1) {
                var acc_title = Array();
                var acc_url = Array();
                var acc_date_link = Array();

                acc_url = [...props.attributes.url];
                acc_title = [...props.attributes.title];
                acc_date_link = [...props.attributes.date_link];
                acc_title.splice(position, 1);
                acc_url.splice(position, 1);
                acc_date_link.splice(position, 1);
                props.setAttributes({ title: acc_title });
                props.setAttributes({ url: acc_url });
                props.setAttributes({ date_link: acc_date_link });
            }
        }




        var lines_editor = null
        lines_editor = Array();

        for (index = 0; index < sizelines; index++) {

            lines_editor.push(
                el('tr', {
                        className: 'line-editor'

                    },


                    el(
                        'td',
                        null,
                        el(
                            'label',
                            null,
                            (props.attributes.date_link[index + 0] == undefined) ? (new Date()).toLocaleDateString() : props.attributes.date_link[index + 0]

                        )
                    ),
                    el('td',

                        { className: "description" },

                        el(
                            'input', {
                                type: 'text',

                                placeholder: 'Coloque o Título do link',
                                value: props.attributes.title[index + 0],
                                onChange: updateTitle
                            }
                        )
                    ),
                    el('td', {
                            className: ' '
                        },
                        el(
                            'input', {
                                type: 'text',
                                style: { width: "50%" },
                                placeholder: 'Coloque o link',
                                value: props.attributes.url[index + 0],
                                onChange: updateUrl
                            }
                        ),
                        el(
                            'a', {
                                href: props.attributes.url[index + 0],
                                style: { color: "inherit" },
                                target: "_blank"
                            },
                            el(
                                'button', { className: "btn-tab" },
                                el(
                                    'i', { className: "fa fa-search" },
                                    ""
                                )
                            )
                        )
                    ),

                    el('td', {
                            className: ' '
                        },
                        el(
                            'input', {
                                type: 'button',
                                ariaLabel: "Remover Linha",
                                value: '-',
                                onClick: removelinkdata,
                                style: { width: '25px', height: '25px', backgroundColor: 'black', color: 'white', paddingLeft: '0px', paddingRight: '0px', paddingTop: '0px', paddingBottom: '0px' }
                            }
                        ),
                        el(
                            'input', {
                                type: 'button',
                                ariaLabel: "Adiciona Linha",
                                value: '+',
                                onClick: addlinkdata,
                                style: { width: '25px', height: '25px', backgroundColor: 'black', color: 'white', paddingLeft: '0px', paddingRight: '0px', paddingTop: '0px', paddingBottom: '0px' }
                            }
                        )
                    )

                )
            )
        }




        return el('table', {
                className: 'table-link-box  table table-striped table-bordered ',
                style: { width: '100%', textAlign: 'center' }
            },
            el('caption', { onClick: showHideTableContent },
                el('label',
                    null,
                    el(
                        'input', {
                            type: 'text',
                            placeholder: 'Coloque o Nome da tabela links',
                            value: props.attributes.caption,
                            onChange: updateCaption
                        }
                    )
                ),

                el(
                    'i', { className: "fas fa-chevron-up" },
                    ""
                )
            ),
            el('thead',
                null,
                el('tr',
                    null,
                    el(
                        'td',
                        null,
                        "Data"
                    ),
                    el('td', { className: "description" },
                        "Documento"
                    ),
                    el('td', { className: "btn-exibir" },
                        "Visualizar"
                    ),
                    el('td',
                        null,
                        ""
                    )
                )
            ),
            el('tbody',
                null,
                lines_editor
            ),
            el('tr', {
                    className: ''

                }



            )


        ); // End return

    }, // End edit()
    save: function(props) {
        // How our block renders on the frontend
        var lines_save = Array();
        var sizelines = Math.round((props.attributes.url.length + props.attributes.title.length) / 2)
        for (index = 0; index < sizelines; index++) {
            lines_save.push(
                el('tr',
                    null,
                    el(
                        'td',
                        null,
                        props.attributes.date_link[index + 0]
                    ),
                    el(
                        'td', { className: "description" },
                        props.attributes.title[index + 0]
                    ),
                    el('td', { className: "btn-exibir" },
                        el(
                            'a', {
                                href: props.attributes.url[index + 0],
                                style: { color: "inherit" }
                            },
                            el(
                                'button', { className: "btn-tab" },
                                el(
                                    'i', { className: "fa fa-search" },
                                    ""
                                )
                            )
                        )
                    )
                )
            )
        }
        return el('table', {
                className: 'table-link-box  table table-striped table-bordered'

            },
            el('caption', { onClick: showHideTableContent },
                el('label',
                    null,
                    props.attributes.caption
                ),
                el(
                    'i', { className: "fas fa-chevron-up" },
                    ""
                )
            ),
            el('thead',
                null,
                el('tr',
                    null,
                    el(
                        'td',
                        null,
                        "Data"
                    ),
                    el('td', { className: "description" },
                        "Documento"
                    ),
                    el('td', { className: "btn-exibir" },
                        "Visualizar"
                    )

                )
            ),
            el('tbody',
                null,
                lines_save
            )


        );
    }
});



//###############################################################################################################################################################