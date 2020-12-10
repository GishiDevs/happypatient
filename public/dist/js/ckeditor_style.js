$(function () {

    'use strict'


    CKEDITOR.replace('content', {
        toolbar: [{
            name: 'clipboard',
            items: ['Undo', 'Redo']
            },
            {
            name: 'basicstyles',
            items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'Subscript', 'Superscript']
            },
            {
            name: 'paragraph',
            items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
            },
            {
            name: 'insert',
            items: ['Table']
            },
            '/',

            {
            name: 'styles',
            items: ['Format', 'Font', 'FontSize']
            },
            {
            name: 'colors',
            items: ['TextColor', 'BGColor', 'CopyFormatting']
            },
            {
            name: 'align',
            items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
            },
            {
            name: 'document',
            items: ['PageBreak']
            }
        ],

        // Enabling extra plugins, available in the full-all preset: https://ckeditor.com/cke4/presets
        extraPlugins: 'colorbutton,font,justify,print,tableresize,uploadimage,pastefromword,liststyle,pagebreak',
        // Make the editing area bigger than default.
        height: 500,
        width: 980,

        // An array of stylesheets to style the WYSIWYG area.
        // Note: it is recommended to keep your own styles in a separate file in order to make future updates painless.
        contentsCss: [
            'http://cdn.ckeditor.com/4.15.1/full-all/contents.css',
            'https://ckeditor.com/docs/ckeditor4/4.15.1/examples/assets/css/pastefromword.css'
        ],

        // This is optional, but will let us define multiple different styles for multiple editors using the same CSS file.
        bodyClass: 'document-editor',

        // Reduce the list of block elements listed in the Format dropdown to the most commonly used.
        //format_tags: 'p;h1;h2;h3;pre',

        // Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
        removeDialogTabs: 'image:advanced;link:advanced',

        // Define the list of styles which should be available in the Styles dropdown list.
        // If the "class" attribute is used to style an element, make sure to define the style for the class in "mystyles.css"
        // (and on your website so that it rendered in the same way).
        // Note: by default CKEditor looks for styles.js file. Defining stylesSet inline (as below) stops CKEditor 4 from loading
        // that file, which means one HTTP request less (and a faster startup).
        // For more information see https://ckeditor.com/docs/ckeditor4/latest/features/styles
        stylesSet: [
            /* Inline Styles */
            {
            name: 'Marker',
            element: 'span',
            attributes: {
                'class': 'marker'
            }
            },
            {
            name: 'Cited Work',
            element: 'cite'
            },
            {
            name: 'Inline Quotation',
            element: 'q'
            },

            /* Object Styles */
            {
            name: 'Special Container',
            element: 'div',
            styles: {
                padding: '5px 10px',
                background: '#eee',
                border: '1px solid #ccc'
            }
            },
            {
            name: 'Compact table',
            element: 'table',
            attributes: {
                cellpadding: '5',
                cellspacing: '0',
                border: '1',
                bordercolor: '#ccc'
            },
            styles: {
                'border-collapse': 'collapse'
            }
            },
            {
            name: 'Borderless Table',
            element: 'table',
            styles: {
                'border-style': 'hidden',
                'background-color': '#E6E6FA'
            }
            },
            {
            name: 'Square Bulleted List',
            element: 'ul',
            styles: {
                'list-style-type': 'square'
            }
            }
        ]
    });

})
