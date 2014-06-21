$(document).ready(function() {

	//vars
	var divChat = $( "#agmk_chat" );
	var contacts = $( "#contacts_chat" );
	var userId = parseInt(divChat.attr("userId"));
	var online = "<span style=\"color:rgba(0,255,0,0.7);\">Online</span>";
	var offline = "<span style=\"color:rgba(255,0,0,0.7);\">Offline</span>";
	var friends = null;
	var barre_action = $( "#barre_action" );
	var teams = $( "#team_chat" );
	var frame = $( "#frame" );
	var menuFrame = $( "#menu_frame" );
	tabFriends = Array();
	tabTeams = Array();

	/* Debut Functions */
	function hideAndShow(bool) {
		if (bool) var elements = $( "li.hideAndShow2" );
		else var elements = $( "li.hideAndShow" );
		var hideOrShow;
		elements.each(function () {
			$(this).on('click', function() {
				hideOrShow = $("#" + $(this).attr('idBalise'));
				if (hideOrShow.css('visibility') == 'hidden') {
					//hideOrShow.show();
					hideOrShow.css("visibility", "visible");
				} else {
					//hideOrShow.hide();
					hideOrShow.css("visibility", "hidden");
				}
			});
		});
	}

	function getFriends() {
		$.get('/friendships/index').done(function(data) {
			contacts.empty();
			friends = $.parseJSON(data);
			contacts.append('<ul>');
			$.each(friends, function (index, val) {
				if (val.User.connected == false) {
					contacts.append("<li userName=\""+val.User.username+"\" userId=\""+val.User.id+"\" class=\"mouseChatListen\"><img src=\"" +val.User.avatar+ "\" style=\"width:20px;\"> "+val.User.username+": "+offline+"</li>");
				} else {
					contacts.append("<li userName=\""+val.User.username+"\" userId=\""+val.User.id+"\" class=\"mouseChatListen\" style=\"margin-top:2px; margin-bottom:2px;\"><img src=\"" +val.User.avatar+ "\" style=\"width:20px;\"> "+val.User.username+": "+online+"</li>");
				}
			});
			contacts.append('</ul>');
			addMouseEvents();
		});
	}

	function addMouseEvents() {
		var ev1 = $( "li.mouseChatListen" );
		ev1.each(function() {
			$(this).on('click', function() {
				newFrameFriend($(this).attr('userId'), $(this).attr('userName'));
			});
		});
	}

	function newFrameFriend(id, name) {
		if (tabFriends[id] != name) {
			tabFriends[id] = name;
			frame.append('<li class="chatFriendFrame" id="chat_friend_'+id+'"></li>');
			menuFrame.append('<li id="menu_chat_friend_'+id+'" class="hideAndShow2" idBalise="chat_friend_'+id+'">'+name+'</li>');
			getMessages(id, name, $( "#chat_friend_"+id ), $( "#menu_chat_friend_"+id ), -1, 20);
		} else {
			$( "#chat_friend_"+id ).remove();
			$( "#menu_chat_friend_"+id ).remove();
			tabFriends[id] = '';
		}
	}

	//on recupere les messages du chat entre User.id = id et "moi"(AuthComp) via ajax
	function getMessages(id, name, myFrame, menuMyFrame, d, nbLignes) {
		var file = "";
		if (userId < id) {
			file = "files/friends/"+userId+"_"+id+"_tchat.txt";
		} else {
			file = "files/friends/"+id+"_"+userId+"_tchat.txt";
		}
		$.post( "/tchats/createFile", {ressource: file} ).done(function( data ) {
			res = $.parseJSON(data);
			if (res.status != "ok") {
				alert('Error while getting chat file');
				return;
			}
		});
		$.post('/tchats/getMessages', { debut: d , nombreLignes: nbLignes, ressource: file}).done(function(data) {
			data = $.parseJSON(data);
			myFrame.empty();
			myFrame.append("<div>");
			$.each(data, function (index, val) {
				myFrame.append('<p>'+val+'</p>');
			});
			myFrame.append("</div>");
			hideAndShow(true);
			return;
		});
	}


	function main() {
		getFriends();
		hideAndShow(false);	
	};
	/* Fin Fonctions*/

	//lancement JS
	main();
	

















	/* Needed Vars */
	/*var tchat = $( "#tchat" );
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
	tchat.css('margin', '2px');*/


	/* Functions needed to ajax tchat */
	/*function create() {
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
	}*/

	/*call functions*/
	/*form.on("submit", function() {
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
	});*/
});