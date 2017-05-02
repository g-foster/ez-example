/*
 * Copyright (C) eZ Systems AS. All rights reserved.
 * For full copyright and license information view LICENSE file distributed with this source code.
 */
// **NOTICE:**
// THIS IS AN AUTO-GENERATED FILE
// DO YOUR MODIFICATIONS IN THE CORRESPONDING .jsx FILE
// AND REGENERATE IT WITH: grunt jsx
// END OF NOTICE
YUI.add('ez-alloyeditor-button-blocktextalignright', function (Y) {
    "use strict";
    /**
     * Provides the block text align right button
     *
     * @module ez-alloyeditor-button-blocktextalignright
     */
    Y.namespace('eZ.AlloyEditorButton');

    var AlloyEditor = Y.eZ.AlloyEditor,
        React = Y.eZ.React,
        ButtonBlockTextAlignRight;

    /**
     * The ButtonBlockTextAlignRight class provides functionality for aligning
     * to the right the text inside a block element.
     *
     * @uses eZ.AlloyEditorButton.ButtonBlockTextAlign
     *
     * @class ButtonBlockTextAlignRight
     * @namespace eZ.AlloyEditorButton
     */
    ButtonBlockTextAlignRight = React.createClass({displayName: "ButtonBlockTextAlignRight",
        mixins: [Y.eZ.AlloyEditorButton.ButtonBlockTextAlign],

        statics: {
            key: 'ezblocktextalignright'
        },

        getDefaultProps: function() {
            return {
                textAlign: 'right',
                classIcon: 'right',
                label: 'Right',
            };
        },

        /**
         * Returns the translated label for the button
         *
         * @method _getLabel
         * @return {String}
         */
        _getLabel: function () {
            return Y.eZ.trans('right', {}, 'onlineeditor');
        },
    });

    AlloyEditor.Buttons[ButtonBlockTextAlignRight.key] = ButtonBlockTextAlignRight;

    Y.eZ.AlloyEditorButton.ButtonBlockTextAlignRight = ButtonBlockTextAlignRight;
});
