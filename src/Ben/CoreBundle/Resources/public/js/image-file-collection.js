/**
 * Image file collection js
 *
 * This JS implements a collection form interface
 *
 * @author Zboubidoo <zboubidoo@nxtelevision.com>
 * @version 1.0
 */

// CONSTANTS
var COLLECTION_HOLDER_SELECTOR = "#image-files-list";
var ADD_BUTTON_SELECTOR        = "#add-image-file-field";
var DELETE_BUTTON_SELECTOR     = ".delete-image-file-field" 
var LIST_CLASS                 = "image-file-container";
var ERROR_CLASS                = "has-error";

jQuery(document).ready(function() {
    
    // Replace file input frames
    $('.' + LIST_CLASS).find('input:file').each(function() {
        var name = $(this).parent().parent().parent().find('input:text').val();
        var hasError = $(this).parent().parent().hasClass(ERROR_CLASS);
        
        if (name && !hasError) {
            name = name + '.jpeg';
        } else {
            name = "";
        }
        
        replaceFileInput($(this), name); 
    });
    
    // Add button click listener
    $(ADD_BUTTON_SELECTOR).on('click', function(e) {
        e.preventDefault();
        addImageFileForm($(COLLECTION_HOLDER_SELECTOR));
    });
    
    // Bind delete events
    bindDeleteListener($(DELETE_BUTTON_SELECTOR));
});

// Bind listeners to all the delete buttons
function bindDeleteListener(element) {
    
    element.on('click', function(e) {
        e.preventDefault();
        $(this).parent().parent().parent().remove();
    });
}

// Add an image file form to the collection holder
function addImageFileForm(collectionHolder) {
    var listElementPrototype = $('<li></li>').addClass(LIST_CLASS).append(collectionHolder.data('prototype'));
    var deleteButton = $(
        '<div class="row">' +
            '<div class="col-sm-3 col-sm-offset-7">' +
                '<a class="btn btn-danger btn-block delete-image-file-field">Supprimer</a>' +
            '</div>' +
        '</div>'
    );
    
    listElementPrototype.append(deleteButton).appendTo(collectionHolder);
    bindDeleteListener(deleteButton.find('a'));
    replaceFileInput(listElementPrototype.find('input:file'));
}

function replaceFileInput(fileInput, displayedName) {
    fileInput.addClass('hide');
    
    var customInput = $(
        '<div class="row">' +
            '<div class="col-xs-5">' +
                '<a class="btn btn-default btn-block">Choisir une image</a>' +
            '</div>' +
            '<div class="col-xs-7">' +
                '<span class="image-file-name"></span>' +
            '</div>' +
        '</div>'
    );
    
    fileInput.parent().prepend(customInput);
    
    // Display name
    if (displayedName) {
        customInput.find('.image-file-name').html(displayedName);
    }
    
    // Trigger input when the button is clicked
    customInput.find('a').on('click', function(e) {
        e.preventDefault();
        fileInput.click();
    });
    
    // Update name on file input change
    fileInput.change (function() {
        var file = this.files[0];
    
        customInput.find('span').html(file.name);
    });
}
