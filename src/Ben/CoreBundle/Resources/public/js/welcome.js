/**
 * Weclome js
 *
 * This JS builds and updates (on window resizing) the welcome page
 *
 * @author Zboubidoo <zboubidoo@nxtelevision.com>
 * @version 1.0
 */

// CONTENT CONSTANTS
var FIRST_NAME_RATIO        = 4.7;
var LAST_NAME_RATIO         = 7.4;
var FONT_RATIO              = 1.3;
var SCROLL_HEIGHT_RATIO     = 0.9;
var SCROLL_OFFSET           = 2;

// HTML BINDINGS CONSTANTS
var TOP_WRAPPER_SELECTOR    = "#top-wrapper"
var WHITE_MASK_SELECTOR     = "#white-mask";
var NAME_CONTAINER_SELECTOR = "#name-container";
var FIRST_NAME_SELECTOR     = ".name.first";
var LAST_NAME_SELECTOR      = ".name.last";
var FIRST_NAME_TEXT         = ".name.first > span";
var LAST_NAME_TEXT          = ".name.last > span";
var TRIANGLE_SELECTOR       = "#triangle";

// EVENTS BINDINGS
$(document).ready(function() {
    var nameContainer  = $(NAME_CONTAINER_SELECTOR);
    var whiteMask      = $(WHITE_MASK_SELECTOR);
    var firstName      = $(FIRST_NAME_SELECTOR);
    var lastName       = $(LAST_NAME_SELECTOR);
    var firstNameText  = $(FIRST_NAME_TEXT);
    var lastNameText   = $(LAST_NAME_TEXT); 
    var triangle       = $(TRIANGLE_SELECTOR);
    var topWrapper     = $(TOP_WRAPPER_SELECTOR);
    
    updateSize(nameContainer, whiteMask, firstName, lastName, firstNameText, lastNameText, triangle);
    updateScroll(topWrapper);
    
    $(window).resize(function() {
        updateSize(nameContainer, whiteMask, firstName, lastName, firstNameText, lastNameText, triangle);
        updateScroll(topWrapper);
    });
    
    $(window).scroll(function() {
        updateScroll(topWrapper);
    });
});

// METHODS

// Update scroll
function updateScroll(topWrapper) {
    var adjustedHeight = $(window).height() * SCROLL_HEIGHT_RATIO;
    var scrollTop = $(window).scrollTop() - SCROLL_OFFSET;
    
    if (scrollTop > adjustedHeight) {
        topWrapper.css({
            'top': adjustedHeight - scrollTop
        });
    } else {
        topWrapper.css({
            'top': 0
        });
    }
}


// Update size
function updateSize(nameContainer, whiteMask, firstName, lastName, firstNameText, lastNameText, triangle) {

    var windowWidth     = $(window).width();
    var windowHeight    = $(window).height();
    var squareWidth     = Math.pow(windowWidth, 2);
    var squareDiagonal  = squareWidth + Math.pow(windowHeight, 2);
    var diagonal        = Math.sqrt(squareDiagonal);
    var lambda          = squareWidth / squareDiagonal;
    var shiftedRotation = Math.atan(windowHeight / windowWidth);
    var rotation        = shiftedRotation - Math.PI / 2
    var smallDiagonal   = Math.sqrt(squareWidth - Math.pow(lambda, 2) * squareDiagonal);

    var topSide   = lambda * diagonal;
    var rightSide = (1 - lambda) * diagonal;
    var lambdaPointW = windowWidth * lambda;
    var lambdaPointH = windowHeight * lambda;

    if (windowWidth < windowHeight) {
    
        var firstNameCalc = FIRST_NAME_RATIO * rightSide;
        var firstNameLength = (firstNameCalc * smallDiagonal) / (firstNameCalc + smallDiagonal);
        var firstNameHeight = firstNameLength / FIRST_NAME_RATIO;
        
        var lastNameCalc1   = rightSide - firstNameHeight;
        var lastNameCalc2   = LAST_NAME_RATIO * firstNameLength;
        var lastNameLength  = (lastNameCalc1 * lastNameCalc2) / (lastNameCalc1 + lastNameCalc2); 
        var lastNameHeight  = lastNameLength / LAST_NAME_RATIO;
    
        transformation.apply(nameContainer, [
            rightSide, rightSide,
            lambdaPointW, lambdaPointH,
            rotation,
            'left'
        ]);
        transformation.apply(whiteMask, [
            smallDiagonal, smallDiagonal,
            lambdaPointW, lambdaPointH,
            rotation - Math.PI / 2
        ]);
        transformation.apply(firstName, [
            firstNameLength, firstNameHeight,
            0, 0,
            0
        ]);
        transformation.apply(lastName, [
            lastNameLength, lastNameHeight,
            (lastNameHeight - lastNameLength) / 2, firstNameHeight + (lastNameLength - lastNameHeight) / 2,
            Math.PI / 2
        ]);
        
    } else {
    
        var lastNameCalc   = LAST_NAME_RATIO * topSide;
        var lastNameLength = (lastNameCalc * smallDiagonal) / (lastNameCalc + smallDiagonal);
        var lastNameHeight = lastNameLength / LAST_NAME_RATIO;
        
        var firstNameCalc1   = topSide - lastNameHeight;
        var firstNameCalc2   = FIRST_NAME_RATIO * lastNameLength;
        var firstNameLength  = (firstNameCalc1 * firstNameCalc2) / (firstNameCalc1 + firstNameCalc2); 
        var firstNameHeight  = firstNameLength / FIRST_NAME_RATIO;
    
        var lastNamePositionCalc = (lastNameHeight - lastNameLength) / 2; 
    
        transformation.apply(nameContainer, [
            topSide, topSide,
            lambdaPointW, lambdaPointH,
            rotation - Math.PI / 2,
            'top'
        ]);
        transformation.apply(whiteMask, [
            smallDiagonal, smallDiagonal,
            lambdaPointW, lambdaPointH,
            rotation
        ]);
        transformation.apply(firstName, [
            firstNameLength, firstNameHeight,
            lastNameHeight, 0,
            Math.PI
        ]);
        transformation.apply(lastName, [
            lastNameLength, lastNameHeight,
            lastNamePositionCalc, -lastNamePositionCalc,
            Math.PI / 2
        ]);
    } 
    
    firstNameText.css({
        'font-size': firstNameHeight * FONT_RATIO
    }); 
    lastNameText.css({
        'font-size': lastNameHeight * FONT_RATIO
    });
    
    
    setBackgroundGradient.apply(triangle, [shiftedRotation, "rgba(255, 255, 255, 1)", "50", "rgba(0, 0, 0, 0)", "50"]);
}


// Set background gradient
function setBackgroundGradient(angle, startColor, startPercent, endColor, endPercent) {
    var arguments = angle + "rad, " + startColor + " " + startPercent + "%, " + endColor + " " + endPercent + "%";

    $(this).css("background", "-webkit-linear-gradient(" + arguments + ")").css(
                "background",      "-o-linear-gradient(" + arguments + ")").css(
                "background",    "-moz-linear-gradient(" + arguments + ")").css(
                "background",         "linear-gradient(" + arguments + ")");
}


// Set the transformation of an element
function transformation(width, height, x, y, angle, displayedBorder) {
    styles = {
        'width'  : width  + 'px',
        'height' : height + 'px',
        '-webkit-transform': 'translate(' + x + 'px, ' + y + 'px) rotate(' + angle + 'rad)',
        '-moz-transform'   : 'translate(' + x + 'px, ' + y + 'px) rotate(' + angle + 'rad)',
        '-ms-transform'    : 'translate(' + x + 'px, ' + y + 'px) rotate(' + angle + 'rad)',
        'transform'        : 'translate(' + x + 'px, ' + y + 'px) rotate(' + angle + 'rad)'
    };
    
    if (displayedBorder == 'top') {
        styles['border-top-style']  = 'solid'
        styles['border-left-style'] = 'none'
    
    } else if (displayedBorder == 'left') {
        styles['border-left-style'] = 'solid'
        styles['border-top-style']  = 'none'
    } 

    $(this).css(styles);
}


