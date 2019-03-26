addLoadListener(equalHeight);

function equalHeight() {
	
var myLeftHeight = myLeftColumn.offsetHeight;
var myRightHeight = myRightColumn.offsetHeight;

var myLeftBorderTopPixels = retrieveComputedStyle(myLeftColumn, "borderTopWidth");
var myLeftBorderBottomPixels = retrieveComputedStyle(myLeftColumn, "borderBottomWidth");
var myLeftPaddingTopPixels = retrieveComputedStyle(myLeftColumn, "paddingTop");
var myLeftPaddingBottomPixels = retrieveComputedStyle(myLeftColumn, "paddingBottom");

var myRightBorderTopPixels = retrieveComputedStyle(myRightColumn, "borderTopWidth");
var myRightBorderBottomPixels = retrieveComputedStyle(myRightColumn, "borderBottomWidth");
var myRightPaddingTopPixels = retrieveComputedStyle(myRightColumn, "paddingTop");
var myRightPaddingBottomPixels = retrieveComputedStyle(myRightColumn, "paddingBottom");

var myLeftBorderNumber = Number(myLeftBorderTopPixels.replace("px", "")) + Number(myLeftBorderBottomPixels.replace("px", ""));
var myLeftPaddingNumber = Number(myLeftPaddingTopPixels.replace("px", "")) + Number(myLeftPaddingBottomPixels.replace("px", ""));
var myLeftExtras = myLeftBorderNumber + myLeftPaddingNumber;

var myRightBorderNumber = Number(myRightBorderTopPixels.replace("px", "")) + Number(myRightBorderBottomPixels.replace("px", ""));
var myRightPaddingNumber = Number(myRightPaddingTopPixels.replace("px", "")) + Number(myRightPaddingBottomPixels.replace("px", ""));
var myRightExtras = myRightBorderNumber + myRightPaddingNumber;

	if (myLeftHeight > myRightHeight) {
		myRightColumn.style.height = (myLeftHeight - myRightExtras) + "px";
	}
	
	else {
		myLeftColumn.style.height = (myRightHeight - myLeftExtras) + "px";
	}
	
}

function retrieveComputedStyle(element, styleProperty)
{
		var computedStyle = null;
		
		if (typeof element.currentStyle != "undefined")
		{
			computedStyle = element.currentStyle;
		}
		else
		{
			computedStyle = document.defaultView.getComputedStyle(element, null);
		}
		return computedStyle[styleProperty];
}

function addLoadListener(fn)
{
	if (typeof window.addEventListener != 'undefined')
	{
	window.addEventListener('load', fn, false);
}
else if (typeof document.addEventListener != 'undefined')
{
	document.addEventListener('load', fn, false);
}
else if (typeof window.attachEvent != 'undefined')
{
	window.attachEvent('onload', fn);
}
else
{
	var oldfn = window.onload;
	if (typeof window.onload != 'function')
	{
	window.onload = fn;
	}
	else
	{
	window.onload = function()
	{
	oldfn();
	fn();
	};
	}
	}
}