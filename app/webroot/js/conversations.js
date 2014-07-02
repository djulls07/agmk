$(document).ready(function() {

	/* Needed Vars */
	var tchat = $( "#tchat" );
	var form = $( "#conversationForm" );
	var file = form.attr("ressource");
	var message = $( "#inputMessage" );
	var messages = $( "#messages" );
	var bouton = $( "#submitForm" );
	var messScroll = document.getElementById("messages");
	var compt = 20;


	//a retirer
	messages.css("overflow", "auto");
	messages.css("height", "300px");
	messages.css("margin", "3px");

	tchat.css('border', '1px inset black');
	tchat.css('margin', '2px');



	/* Functions needed to ajax tchat */
	function create() {
		$.post( "/tchats/createFile", {ressource: file} ).done(function( data ) {
			res = $.parseJSON(data);
			if (res.status == "ok") {
				tchat.show();
				getMessages(-1, 20, false);
			}
		});
	}

	function getMessages(d, nbLignes, fromScroll) {
		$.post( "/tchats/getMessages", {ressource: file, debut: d, nombreLignes: nbLignes} ).done(function( data ) {
			res = $.parseJSON(data);
			messages.html('');
			$.each(res, function (index, val) {
				messages.append("<p>" + val + "</p>");
			});
			if (!fromScroll) messages.scrollTop(messScroll.scrollHeight);
			else messages.scrollTop(1);
		});
	}

	function writeMessage() {
		if (message.val() == "") return;
		$.post( "/tchats/writeMessage", {ressource: file, message: message.val()} ).done(function( data ) {
			message.val('');
			res = $.parseJSON(data);
			if (res.status == 'ok') {
				getMessages(-1, 20, false);
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

	messages.on('scroll', function() {
		if ($(this).scrollTop() > 0) {
			return;
		} else {
			messages.html('Loading previous messages....');
			compt += 20;
			setTimeout(function(){getMessages(-1, compt, true);}, 500);
		}
	});
});