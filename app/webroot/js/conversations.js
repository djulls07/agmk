$(document).ready(function() {

	/* Needed Vars */
	var tchat = $( "#tchat" );
	var form = $( "#conversationForm" );
	var file = form.attr("ressource");
	var message = $( "#inputMessage" );
	var messages = $( "#messages" );

	messages.css("overflow", "auto");
	messages.css("height", "300px");


	/* Functions needed to ajax tchat */
	function create() {
		$.post( "/tchats/createFile", {ressource: file} ).done(function( data ) {
			res = $.parseJSON(data);
			if (res.status == "ok") {
				tchat.show();
				getMessages(-1, 20);
			}
		});
	}

	function getMessages(d, nbLignes) {
		$.post( "/tchats/getMessages", {ressource: file, debut: d, nombreLignes: nbLignes} ).done(function( data ) {
			res = $.parseJSON(data);
			messages.html('');
			$.each(res, function (index, val) {
				messages.append("<p>" + val + "</p>");
			});
		});
	}

	function writeMessage() {
		if (message.val() == "") return;
		$.post( "/tchats/writeMessage", {ressource: file, message: message.val()} ).done(function( data ) {
			message.val('');
			res = $.parseJSON(data);
			if (res.status == 'ok') {
				getMessages(-1, 20);
			} else {
				//status ko
			}
		});
	}

	/*call functions*/
	form.on("submit", function() {
		//appel ajax
		writeMessage();
		return false;
	});
	create();
});