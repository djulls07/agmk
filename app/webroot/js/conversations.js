$(document).ready(function() {

	var tchat = $( "#tchat" );
	var form = $( "#conversationForm" );
	var file = form.attr("ressource");

	$.post( "/tchats/getMessages/"+file ).done(function( data ) {
		alert(data); return;
		res = $.parseJSON(data);
		$.each(res, function(index, value) {
			conversation.append("<p class=\"tchat\">"+value+"</p>");
		});
	});

	

	form.on("submit", function() {
		//appel ajax
		return false;
	});
	

});