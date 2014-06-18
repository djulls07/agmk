$(document).ready(function() {

	var conversation = $( "#conversation" );

	var form = $( "#ConversationForm" );

	var action = form.attr('myaction');

	var message = $( "#messageInput" );

	var idTeam = form.attr('idTeam');

	$( ".tchat" ).show();

	form.on("submit", function() {
		//appel ajax
		alert(action+"/" + idTeam + "/" + message.val());
		$.post( action+"/" + idTeam + "/" + message.val()).done(function( data ) {
			alert(data);
			res = $.parseJSON(data);
		});
		return false;
	});
	

});