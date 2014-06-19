$(document).ready(function() {

	var conversation = $( "#conversation" );

	var form = $( "#ConversationForm" );

	var action = form.attr('myaction');

	var message = $( "#messageInput" );

	var idTeam = form.attr('idTeam');

	var res;
	alert('ok');

	/*$.post( "/teams/readTchat/" + idTeam ).done(function( data ) {
		res = $.parseJSON(data);
		$.each(res, function(index, value) {
			conversation.append("<p class=\"tchat\">"+value+"</p>");
		});
	});

	$( ".tchat" ).show();

	form.on("submit", function() {
		//appel ajax
		$.post( action+"/" + idTeam , {message: message.val()}).done(function( data ) {
			res = $.parseJSON(data);
			conversation.empty();
			$.each(res, function(index, value) {
				conversation.append("<p class=\"tchat\">"+value+"</p>");
			});
		});
		message.val('');
		return false;
	});*/
	

});