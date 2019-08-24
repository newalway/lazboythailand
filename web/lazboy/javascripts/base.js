$(function () {
    $("a[href^='#'].link-click").click(function(e) {
    	e.preventDefault();

    	var position = $($(this).attr("href")).offset().top;

    	$("body, html").animate({
    		scrollTop: position - 75
    	}, 800 );
    });
});


function openDomWindow() {
  // $('#loadingContent').show();
  jQuery.openDOMWindow({
    height:0,
    width:0,
    modal:true,
    overlayOpacity:0,
    borderColor:0,
    windowPadding:0,
  });
}

function closeDomWindow() {
  // $('#loadingContent').hide();
  jQuery.closeDOMWindow();
}
