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

var DownloadURL = function(FileURL) {
    result = "";
    try {
        result = "/download.php?file=" + (new URL(FileURL)).pathname
    } catch (e) {
        result = "";
    }
    return result;
}
wp.blocks.registerBlockType('cms-adm/date-title-link-file-upload', {
    title: 'Lista de Arquivos', // Block name visible to user
	
    icon: 'upload', // Toolbar icon can be either using WP Dashicons or custom SVG
	description : 'lista de links de arquivos' ,
	
    category: 'design', // Under which category the block would appear
    supports: {
        multiple: true,
    },
    attributes: { // The data this block will be storing
        caption: { type: 'string' }, // Notice box title in h4 tag
        title: { type: 'array' }, // Notice box title in h4 tag
        url: { type: 'array' }, // row description
        date_link: { type: 'array' },
        mime_type: { type: 'array' }

    },
    edit: function(props) {
        if (
            ((props.attributes.url === undefined) || (props.attributes.url.length == 0)) ||
            ((props.attributes.title === undefined) || (props.attributes.title.length == 0))
        ) {
            var acc_title = Array();
            var acc_url = Array();
            var acc_date_link = Array();
            var acc_mime_type = Array();

            props.attributes.url = Array(1);
            props.attributes.title = Array(1);
            props.attributes.date_link = Array(1);
            props.attributes.mime_type = Array(1);

            gallery_items_frame = wp.media.frames.gallery_items = wp.media({
                // Set the title of the modal.
                title: "Selecione seu anexo",
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
            position = 0;
            count = 0;
            // Select the attachment when the frame opens
            gallery_items_frame.on('close', function() {
                var selection = gallery_items_frame.state().get('selection');
                selection.each(function(attachment) {
                    acc_title.splice(position + count, 0, attachment.attributes.url.split('/').pop());
                    acc_url.splice(position + count, 0, attachment.attributes.url);
                    acc_date_link.splice(position + count, 0, (new Date(attachment.attributes.date)).toLocaleDateString());
                    acc_mime_type.splice(position + count, 0, attachment.attributes.url.split('.').pop());
                    count++;
                });
                if (selection.length > 0) {
                    props.attributes.url = Array(selection.length);
                    props.attributes.title = Array(selection.length);
                    props.attributes.date_link = Array(selection.length);
                    props.setAttributes({ title: acc_title });
                    props.setAttributes({ url: acc_url });
                    props.setAttributes({ date_link: acc_date_link });
                    props.setAttributes({ mime_type: acc_mime_type });
                }
            });
            gallery_items_frame.open();
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
            var acc_title = [...props.attributes.title];
            acc_title[position] = event.target.value;
            props.setAttributes({ title: acc_title });
        }



        function addlinkdata(event) {
            var table = jQuery(event.target).closest("table");
            var lines = table.find(".line-editor");
            var line = jQuery(event.target).closest(".line-editor");
            var position = lines.index(line);

            var acc_title = Array();
            var acc_url = Array();
            var acc_date_link = Array();
            var acc_mime_type = Array();

            acc_url = [...props.attributes.url];
            acc_title = [...props.attributes.title];
            acc_date_link = [...props.attributes.date_link];
            acc_mime_type = [...props.attributes.mime_type];


            gallery_items_frame = wp.media.frames.gallery_items = wp.media({
                // Set the title of the modal.
                title: "Selecione seu anexo",
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

            count = 0;
            gallery_items_frame.on('close', function() {
                var selection = gallery_items_frame.state().get('selection');
                selection.each(function(attachment) {
                    acc_title.splice(position + count + 1, 0, attachment.attributes.url.split('/').pop());
                    acc_url.splice(position + count + 1, 0, attachment.attributes.url);
                    acc_date_link.splice(position + count + 1, 0, (new Date(attachment.attributes.date)).toLocaleDateString());
                    acc_mime_type.splice(position + count + 1, 0, attachment.attributes.url.split('.').pop());
                    count++;
                });
                if (selection.length > 0) {
                    props.setAttributes({ title: acc_title });
                    props.setAttributes({ url: acc_url });
                    props.setAttributes({ date_link: acc_date_link });
                    props.setAttributes({ mime_type: acc_mime_type });
                }
            });
            gallery_items_frame.open();
        }

        function removelinkdata(event) {
            var table = jQuery(event.target).closest("table");
            var lines = table.find(".line-editor");
            var line = jQuery(event.target).closest(".line-editor");
            var position = lines.index(line);
            if (lines.length > 1) {
                var acc_url = [...props.attributes.url];
                var acc_title = [...props.attributes.title];
                var acc_date_link = [...props.attributes.date_link];
                var acc_mime_type = [...props.attributes.mime_type];
                acc_title.splice(position, 1);
                acc_url.splice(position, 1);
                acc_date_link.splice(position, 1);
                acc_mime_type.splice(position, 1);
                props.setAttributes({ title: acc_title });
                props.setAttributes({ url: acc_url });
                props.setAttributes({ date_link: acc_date_link });
                props.setAttributes({ mime_type: acc_mime_type });
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
                         {className:"cell-date-file"},
                        el(
                            'label',
                            null,
                            (props.attributes.date_link[index + 0] == undefined) ? (new Date()).toLocaleDateString() : props.attributes.date_link[index + 0]

                        )
                    ),
                    el('td', { className: "description" },
                        el(
                            'input', {
                                type: 'text',

                                placeholder: 'Coloque o Título do Arquivo',
                                value: props.attributes.title[index + 0],
                                onChange: updateTitle
                            }
                        )
                    ),
                    el('td', {
                            className: "btn-exibir",
                            style: { }
                        },
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
                            className: "btn-exibir",
                            style: { }
                        },
                        el(
                            'a', {
                                href: DownloadURL(props.attributes.url[index + 0]),
                                style: { color: "inherit" }
                            },
                            el(
                                'button', { className: "btn-tab mime-types" },
                                el(
                                    'i', { className: props.attributes.mime_type[index + 0] },
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




        return el('div', {
                className: 'link-file-upload',
            },
            el('table', {
                    className: 'table-link-file-upload-box  table table-striped table-bordered ',
                    style: { width: '100%', textAlign: 'center', marginTop: '30 px', marginBottom: '30 px' }
                },
                el('caption', { onClick: showHideTableContent },
                    el('label',
                        null,
                        el(
                            'input', {
                                type: 'text',
                                placeholder: 'Coloque o Nome da tabela arquivos',
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
                            {className:"cell-date-file"},
                            "Data"
                        ),
                        el('td', { className: "description" },
                            "Documento"
                        ),
                        el('td', { className: "btn-exibir", className: "btn-exibir", style: { } },
                            "Visualizar"
                        ),
                        el('td', { className: "btn-exibir", className: "btn-exibir", style: { } },
                            " Baixar"
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
                el('tfoot',
                    null,
                    el('tr', { className: 'w-100 bg-1', style: { heigth: '15px', border: '1px solid black' } },
                        el('td', { className: 'w-100', style: {}, colspan: '5px' })
                    )
                )
            )
        ); // End return

    }, // End edit()
	
	
	
	
	
    save: function(props) {
        
		var sizelines = Math.round((props.attributes.url.length + props.attributes.title.length) / 2);
		
		
		 var lines_save = null
        lines_save = Array();

        for (index = 0; index < sizelines; index++) {

            lines_save.push(
                el('tr', {
                        className: 'line-editor'

                    },


                    el(
                        'td',
                        {className:"cell-date-file"},
                        el(
                            'label',
                            null,
                            (props.attributes.date_link[index + 0] == undefined) ? (new Date()).toLocaleDateString() : props.attributes.date_link[index + 0]

                        )
                    ),
                    el('td', { className: "description" },
                        props.attributes.title[index + 0]
                    ),
                    el('td', {
                            className: "btn-exibir",
                            style: { }
                        },
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
                            className: "btn-exibir",
                            style: { }
                        },
                        el(
                            'a', {
                                href: DownloadURL(props.attributes.url[index + 0]),
                                style: { color: "inherit" }
                            },
                            el(
                                'button', { className: "btn-tab mime-types" },
                                el(
                                    'i', { className: props.attributes.mime_type[index + 0] },
                                    ""
                                )
                            )
                        )
                    )

                )
            )
        }




        return el('div', {
                className: 'link-file-upload',
            },
            el('table', {
                    className: 'table-link-file-upload-box  table table-striped table-bordered ',
                    style: { width: '100%', textAlign: 'center', marginTop: '30 px', marginBottom: '30 px' }
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
                            {className:"cell-date-file"},
                            "Data"
                        ),
                        el('td', { className: "description" },
                            "Documento"
                        ),
                        el('td', { className: "btn-exibir", className: "btn-exibir", style: { } },
                            "Visualizar"
                        ),
                        el('td', { className: "btn-exibir", className: "btn-exibir", style: { } },
                            " Baixar"
                        )
                    )

                ),

                el('tbody',
                    null,
                    lines_save
                ),
                el('tfoot',
                    null,
                    el('tr', { className: 'w-100 bg-1', style: { heigth: '15px', border: '1px solid black' } },
                        el('td', { className: 'w-100', style: {}, colspan: '5px' })
                    )
                )
            )
        ); // End return
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
    }
});