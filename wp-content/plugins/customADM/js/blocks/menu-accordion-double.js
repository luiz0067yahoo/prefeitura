function getRandomArbitrary(min, max) {
    return Math.random() * (max - min) + min;
}

wp.blocks.registerBlockType('cms-adm/menu-accordion-double', {
    title: 'Menu Retratíl Duplo', // Block name visible to user
    icon: 'menu', // Toolbar icon can be either using WP Dashicons or custom SVG
	description : 'Menu retrátil é ideal para dividir conteúdos em Tópicos' ,
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
        title: { type: 'array' }, // Notice box title in h4 tag
        description: { type: 'array' }, // row description
        timenumber: { type: 'array' } // row description
    },
    edit: function(props) {
        //How our block renders in the editor in edit mode
        if ((props.attributes.title === undefined) || (props.attributes.title.length == 0)) {
            props.attributes.title = [
                ["", ""],
                ["", ""]
            ];
            var col1 = jQuery(".menu-accordion-double-block").size() + "_left";
            var col2 = jQuery(".menu-accordion-double-block").size() + "_right";
            props.attributes.timenumber = [col1, col2]
        } else if ((props.attributes.title[0] === undefined) || (props.attributes.title[0].length == 0)) {
            props.attributes.title[0] = ["", ""];
            var col1 = jQuery(".menu-accordion-double-block").size() + "_left";
            var col2 = jQuery(".menu-accordion-double-block").size() + "_right";
            props.attributes.timenumber = [col1, col2]
        }
        if ((props.attributes.description === undefined) || (props.attributes.description.length == 0)) {
            props.attributes.description = [
                ["", ""],
                ["", ""]
            ];
            var col1 = jQuery(".menu-accordion-double-block").size() + "_left";
            var col2 = jQuery(".menu-accordion-double-block").size() + "_right";
            props.attributes.timenumber = [col1, col2]

        } else if ((props.attributes.description[0] === undefined) || (props.attributes.description[0].length == 0)) {
            props.attributes.description[0] = ["", ""];
            var col1 = jQuery(".menu-accordion-double-block").size() + "_left";
            var col2 = jQuery(".menu-accordion-double-block").size() + "_right";
            props.attributes.timenumber = [col1, col2]
        }

        function updateTitle(event) {
            var element_ = jQuery(event.target);
            var item = element_.closest(".accordion-item");
            var mainContainer = element_.closest(".accordion-col");
            var topContainer = mainContainer.closest(".menu-accordion-double-block");
            var all_Itens = mainContainer.find(".accordion-item");
            var allContainer = topContainer.find(".accordion-col");
            var position = all_Itens.index(item);
            var positionContainer = allContainer.index(mainContainer);
            var acc_description = [...props.attributes.description];
            var acc_title = [...props.attributes.title];
            var acc_position_title = [...props.attributes.title[positionContainer]];

            acc_position_title[position] = event.target.value;
            acc_title[positionContainer] = acc_position_title;
            props.setAttributes({ title: acc_title });

        }

        function updateDescription(newdata) {
            var element_ = jQuery(event.target);
            var item = element_.closest(".accordion-item");
            var mainContainer = element_.closest(".accordion-col");
            var topContainer = mainContainer.closest(".menu-accordion-double-block");
            var all_Itens = mainContainer.find(".accordion-item");
            var allContainer = topContainer.find(".accordion-col");
            var position = all_Itens.index(item);
            var positionContainer = allContainer.index(mainContainer);
            var acc_description = [...props.attributes.description];
            var acc_position_title = [...props.attributes.title[positionContainer]];
            var acc_position_description = [...props.attributes.description[positionContainer]];
            acc_position_description[position] = newdata;
            acc_description[positionContainer] = acc_position_description;
            props.setAttributes({ description: acc_description });


        }

        function addlinkdata(event) {
            var element_ = jQuery(event.target);
            var item = element_;
            var mainContainer = element_.closest(".accordion-col");
            var topContainer = mainContainer.parent();
            var masterTopContainer = mainContainer.closest(".menu-accordion-double-block");
            var all_Itens = topContainer.find('input[type="button"][ value="+"]');
            var allContainer = masterTopContainer.find(".accordion-col");
            var position = all_Itens.index(item);
            var positionContainer = allContainer.index(mainContainer);

            var acc_title = [...props.attributes.title];
            var acc_position_title = [...props.attributes.title[positionContainer]];
            acc_position_title.splice(position + 1, 0, "");
            acc_title[positionContainer] = acc_position_title;
            props.setAttributes({ title: acc_title });

            var acc_description = [...props.attributes.description];
            var acc_position_description = [...props.attributes.description[positionContainer]];
            acc_position_description.splice(position + 1, 0, "");
            acc_description[positionContainer] = acc_position_description;
            props.setAttributes({ description: acc_description });


        }

        function removelinkdata(event) {
            var element_ = jQuery(event.target);
            var item = element_;
            var mainContainer = element_.closest(".accordion-col");
            var topContainer = mainContainer.parent();
            var masterTopContainer = mainContainer.closest(".menu-accordion-double-block");
            var all_Itens = topContainer.find('input[type="button"][ value="-"]');
            if (all_Itens.length > 1) {
                var allContainer = masterTopContainer.find(".accordion-col");
                var position = all_Itens.index(item);
                var positionContainer = allContainer.index(mainContainer);

                var acc_title = [...props.attributes.title];
                var acc_position_title = [...props.attributes.title[positionContainer]];
                acc_position_title.splice(position, 1);
                acc_title[positionContainer] = acc_position_title;
                props.setAttributes({ title: acc_title });

                var acc_description = [...props.attributes.description];
                var acc_position_description = [...props.attributes.description[positionContainer]];
                acc_position_description.splice(position, 1);
                acc_description[positionContainer] = acc_position_description;
                props.setAttributes({ description: acc_description });


            }
        }



        var sizecols = Math.round((props.attributes.description.length + props.attributes.title.length) / 2);
        var cols_edit = Array();
        for (index_col = 0; index_col < sizecols; index_col++) {
            var timenumber = props.attributes.timenumber[index_col];
            var lines_editor = Array();
            var idAccordionSection = "accordionSection_" + timenumber + "_" + index_col;
            var selectorIdAccordionSection = "#accordionSection_" + timenumber + "_" + index_col;
            var sizelines = Math.round((props.attributes.description[index_col].length + props.attributes.title[index_col].length) / 2);
            for (index = 0; index < sizelines; index++) {
                lines_editor.push(
                    el('div', { className: "accordion-item accordion-flush  bg-3" },
                        el('h2', { className: "accordion-header accordion" },
                            el('button', { type: "button", className: "accordion-button collapsed bg-3 color-1", "data-bs-toggle": "collapse", "data-bs-target": "#collapse_" + index_col + "_" + index },
                                el('input', {
                                    type: "text",
                                    value: props.attributes.title[index_col][index],
                                    placeholder: 'Coloque titulo aqui...',
                                    className: " bg-3 color-1 w-100 bg-3 color-1",
                                    onChange: updateTitle
                                })
                            )
                        ),
                        el('div', { className: "accordion-collapse collapse border", id: "collapse_" + index_col + "_" + index, "data-bs-parent": selectorIdAccordionSection },
                            el('div', { className: "accordion-body bg-0 color-1" },
                                el(
                                    wp.editor.RichText, {
                                        tagName: 'div',
                                        multiline: true,
                                        onChange: updateDescription,
                                        value: props.attributes.description[index_col][index],
                                        placeholder: 'Coloque seu texto aqui...'
                                    },
                                    ""
                                )
                            )
                        )

                    ),
                    el('div', {
                            style: { position: "absolute", zIndex: "1000" }
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
                );
            }
            cols_edit.push(
                el('div', { className: ((index_col == 0) ? "w-50  ps-0 pe-2" : "w-50 ps-2 pe-0") },
                    el('div', {
                            className: 'accordion w-100 accordion-col',
                            id: idAccordionSection
                        },
                        lines_editor
                    )
                )
            );
        }

        return el('div', { className: 'row menu-accordion-double-block w-100 d-flex' },
            cols_edit
        );
    }, // End edit()


    save: function(props) {
        if ((props.attributes.title === undefined) || (props.attributes.title.length == 0)) {
            props.attributes.title = [
                ["", ""],
                ["", ""]
            ];
        } else if ((props.attributes.title[0] === undefined) || (props.attributes.title[0].length == 0)) {
            props.attributes.title[0] = ["", ""];
        }
        if ((props.attributes.description === undefined) || (props.attributes.description.length == 0)) {
            props.attributes.description = [
                ["", ""],
                ["", ""]
            ];
        } else if ((props.attributes.description[0] === undefined) || (props.attributes.description[0].length == 0)) {
            props.attributes.description[0] = ["", ""];
        }
        var sizecols = 2;
        var cols_save = Array();
        var lines_save = Array();

        for (index_col = 0; index_col < sizecols; index_col++) {
            lines_save = Array();
            var timenumber = props.attributes.timenumber[index_col];
            var idAccordionSection = "accordionSection_" + timenumber + "_" + index_col;
            var selectorIdAccordionSection = "#accordionSection_" + timenumber + "_" + index_col;
            var sizelines = Math.round((props.attributes.description[index_col].length + props.attributes.title[index_col].length) / 2);
            for (index = 0; index < sizelines; index++) {
                lines_save.push(
                    el('div', { className: "accordion-item accordion-flush  bg-3" },

                        el('h2', { className: "accordion-header accordion text-uppercase" },
                            el('button', { type: "button", className: "accordion-button collapsed bg-3 color-1", "data-bs-toggle": "collapse", "data-bs-target": "#collapse_" + index_col + "_" + index },
                                props.attributes.title[index_col][index]
                            )
                        ),
                        el('div', { className: "accordion-collapse collapse border", id: "collapse_" + index_col + "_" + index, "data-bs-parent": selectorIdAccordionSection },
                            el('div', { className: "accordion-body bg-0 color-1" },
                                window.HTMLReactParser(props.attributes.description[index_col][index])
                            )
                        )

                    )
                );
            }
            var colClassName = "w-50" + ((index_col == 0) ? " ps-0 pe-2" : " ps-2 pe-0");

            cols_save.push(
                el('div', { className: colClassName },
                    el('div', {
                            className: 'accordion w-100 accordion-col',
                            id: idAccordionSection
                        },
                        lines_save
                    )
                )
            );
        }
        return el('div', { className: 'row menu-accordion-double-block w-100 d-flex' },
            cols_save
        );

    }
});