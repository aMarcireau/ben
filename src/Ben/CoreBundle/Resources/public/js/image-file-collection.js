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

jQuery(document).ready(function() {
    
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
}
