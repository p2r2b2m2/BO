/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */


CKEDITOR.editorConfig = function(config) {
    config.removePlugins = 'iframe';
    config.contentsLangDirection = 'ltr';
    config.allowedContent = true;
    config.enterMode = CKEDITOR.ENTER_BR;
    config.forcePasteAsPlainText = false; // default so content won't be manipulated on load
    config.basicEntities = true;
    config.entities = true;
    config.entities_latin = false;
    config.entities_greek = false;
    config.entities_processNumerical = false;
    config.fillEmptyBlocks = function (element) {
            return true; // DON'T DO ANYTHING!!!!!
    };

    CKEDITOR.config.allowedContent = true;
};
