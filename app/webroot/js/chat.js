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
	var tabFriends = Array();
	var tabTeams = Array();
	var focus = "";
	var chatState = divChat.attr('chatState').split(";");

	/* Debut Functions */
	function hideAndShow(bool) {
		if (bool == true) var elements = $( "li.hideAndShow2" );
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
					contacts.append("<li type=\"friend\" userName=\""+val.User.username+"\" userId=\""+val.User.id+"\" class=\"mouseChatListen\"><img src=\"" +val.User.avatar+ "\" style=\"width:20px;\"> "+val.User.username+": "+offline+"</li>");
				} else {
					contacts.append("<li type=\"friend\" userName=\""+val.User.username+"\" userId=\""+val.User.id+"\" class=\"mouseChatListen\" style=\"margin-top:2px; margin-bottom:2px;\"><img src=\"" +val.User.avatar+ "\" style=\"width:20px;\"> "+val.User.username+": "+online+"</li>");
				}
			});
			contacts.append('</ul>');
			addMouseEvents();
		});
	}

	function getTeams() {
		$.get('/teams/index').done(function(data) {
			data = $.parseJSON(data);
			teams.append('<ul>')
			$.each(data, function (index, val) {
				teams.append('<li type="team" class="mouseChatListen" teamId="'+val.Team.id+'" >'+val.Team.name+'</li>');
			});
			teams.append('</ul>')
			addMouseEvents();
		});
	}

	function addMouseEvents() {
		var ev1 = $( "li.mouseChatListen" );
		ev1.each(function() {
			$(this).on('click', function() {
				if ($(this).attr('type') == 'friend') newFrameFriend($(this).attr('userId'), $(this).attr('userName'));
				else if ($(this).attr('type') == 'team') newFrameTeam($(this).attr('teamId'), $(this).html());
				saveChatState();
			});
		});
	}

	function newFrameTeam(id, name) {
		if (tabTeams[id] != name) {
			var file = 'files/teams/'+id+'_tchat.txt';
			tabTeams[id] = name;
			frame.append('<li id="chat_team_'+id+'" class="chatFriendFrame" ><div id="team_messages_'+id+'" ></div><form class="forms_chat" id="form_team_'+id+'" ><input id="inputMessageTeam_'+id+'"></input></form></li>');
			menuFrame.append('<li id="menu_chat_team_'+id+'" class="hideAndShow2" idBalise="chat_team_'+id+'">'+name+'</li>');
			$( "#form_team_"+id ).on('submit', function () {
				writeMessageTeam(file, $( "#inputMessageTeam_"+id ), id);
				return false;
			});
			getMessagesTeam(id, $("#team_messages_"+id), -1, 20);
			var sF = document.getElementById('chat_team_'+id);
			$('#chat_team_'+id).scrollTop(sF.scrollHeight);

			$( "#menu_chat_team_"+id ).on("click", function () {
				var e = $("#chat_team_"+id);
				e.remove();
				$(this).remove();
				tabTeams[id] = "";
			});
		} else {
			$('#chat_team_'+id).remove();
			$('#menu_chat_team_'+id).remove();
			tabTeams[id] = "";
		}
	}

	function getMessagesTeam(id, divMessages, d, nbLignes) {
		var file = 'files/teams/'+id+'_tchat.txt';
		$.post( "/tchats/createFile", {ressource: file} ).done(function( data ) {
			res = $.parseJSON(data);
			if (res.status != "ok") {
				alert('Error while getting chat file');
				return;
			}
		});
		$.post('/tchats/getMessages', { debut: d , nombreLignes: nbLignes, ressource: file}).done(function(data) {
			data = $.parseJSON(data);
			if (focus == "inputMessageTeam_"+id) {
				var messSave = $( "#inputMessageTeam_"+id ).val();
			}
			divMessages.empty();
			$.each(data, function (index, val) {
				divMessages.append('<p><small>'+val+'</small></p>');
			});

			if (focus == "inputMessageTeam_"+id) {
				setFocus();
				$( "#inputMessageTeam_"+id ).val(messSave);
			}

			$( "#inputMessageTeam_"+id ).focus(function() {
				focus = "inputMessageTeam_"+id;
			});
			var sF = document.getElementById('chat_team_'+id);
			$('#chat_team_'+id).scrollTop(sF.scrollHeight);
			return;
		});
	}

	function newFrameFriend(id, name) {
		if (tabFriends[id] != name) {
			tabFriends[id] = name;
			frame.append('<li class="chatFriendFrame" id="chat_friend_'+id+'"></li>');
			menuFrame.append('<li id="menu_chat_friend_'+id+'" class="hideAndShow2" idBalise="chat_friend_'+id+'">'+name+'</li>');
			getMessages(id, name, $( "#chat_friend_"+id ), $( "#menu_chat_friend_"+id ), -1, 20);
			//ajout event cache frame si clic menu
			$( "#menu_chat_friend_"+id ).on("click", function () {
				e = $("#chat_friend_"+id);
				/*if (e.css('visibility') == "visible") {
					e.css('visibility', 'hidden');
				} else {
					e.css('visibility', 'visible');
				}*/
				e.remove();
				$(this).remove();
				tabFriends[id] = "";
			});
			//hideAndShow(true);
		} else {
			$( "#chat_friend_"+id ).remove();
			$( "#menu_chat_friend_"+id ).remove();
			tabFriends[id] = "";
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
			if (focus == "inputMessage_"+id) {
				var messSave = $( "#inputMessage_"+id ).val();
			}
			myFrame.empty();
			myFrame.append("<div>");
			$.each(data, function (index, val) {
				myFrame.append('<p><small>'+val+'</small></p>');
			});

			myFrame.append("</div>");
			myFrame.append('<form class="forms_chat" id="form_'+id+'" action="/tchats/writeMessage" method="POST"><input id="inputMessage_'+id+
				'" idDest="'+id+'"></input></form></li>');

			if (focus == "inputMessage_"+id) {
				setFocus();
				$( "#inputMessage_"+id ).val(messSave);
			}

			$( "#inputMessage_"+id ).focus(function() {
				focus = "inputMessage_"+id;
			});

			$( "#form_"+id ).on('submit', function () {
				writeMessage(file, $( "#inputMessage_"+id ), id);
				return false;
			});
			var sF = document.getElementById('chat_friend_'+id);
			$('#chat_friend_'+id).scrollTop(sF.scrollHeight);
			return;
		});
	}

	function writeMessage(file, message, id) {
		if (message.val() == "") return;
		$.post( "/tchats/writeMessage", {ressource: file, message: message.val()} ).done(function( data ) {
			res = $.parseJSON(data);
			if (res.status == "ok") {
				getMessages(id, name, $( "#chat_friend_"+id ), $( "#menu_chat_friend_"+id ), -1, 20);
				message.val('');
				return;
			} else {
				//status ko
				return;
			}
		});
	}
	function writeMessageTeam(file, message, id) {
		if (message.val() == "") return;
		$.post( "/tchats/writeMessage", {ressource: file, message: message.val()} ).done(function( data ) {
			res = $.parseJSON(data);
			if (res.status == "ok") {
				getMessagesTeam(id, $("#team_messages_"+id), -1, 20);
				message.val('');
				return;
			} else {
				//status ko
				return;
			}
		});
	}

	function majMessages() {
		getFriends();
		if (friends == null) return;
		$.each(friends, function (index, val) {
			if ($( "#chat_friend_"+val.User.id ).length) {
				myFrame = $( "#chat_friend_"+val.User.id );
				menuMyFrame = $( "#menu_chat_friend_"+val.User.id );
				getMessages(val.User.id, val.User.name, myFrame, menuMyFrame, -1, 20);
			}
			//getNewMessages(val.User.id, val.User.name);
		});
	}

	function getNewMessages() {
		//TODO;
	}

	function setFocus() {

		document.getElementById(focus).focus();

		return false;
	}

	function setChatState() {
		$.each(chatState, function(index, val) {
			//alert("comptons")
			newFrameFriend(val.split(",")[0], val.split(",")[1]);
		});
	}

	function saveChatState() {
		var state = "";
		$.each(friends, function (index, val) {
			if (tabFriends[val.User.id] == val.User.username) {
				state += val.User.id+","+val.User.username+";";
			}
		});
		state = state.substr(0, state.length -1);
		$.post("/users/saveChatState", {chatState: state}).done(function(data) {
		});
	}

	function main() {
		getFriends();
		getTeams();
		hideAndShow(false);
		setChatState();
		setInterval(function() {
			//actualise les messsages.
			majMessages();
		}, 10000);
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