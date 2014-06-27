jQuery(document).ready(function($) {

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
	var userUsername = divChat.attr("userUsername");

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
					$("#agmk_chat_frame").show();
					hideOrShow.css("visibility", "visible");
				} else {
					//hideOrShow.hide();
					hideOrShow.css("visibility", "hidden");
					$("#agmk_chat_frame").hide();
				}
			});
		});
	}

	function getFriends(bool) {
		$.get('/friendships/index', function(data) {
			contacts.empty();
			friends = $.parseJSON(data);
			contacts.append('<ul>');
			$.each(friends, function (index, val) {
				if (bool) tabFriends[val.User.id] = "";
				if (val.User.connected == false) {
					contacts.append("<li type=\"friend\" userName=\""+val.User.username+"\" userId=\""+val.User.id+"\" class=\"mouseChatListen\"><img src=\"" +val.User.avatar+ "\" style=\"width:20px;\"> "+val.User.username+": "+offline+"</li>");
				} else {
					contacts.append("<li type=\"friend\" userName=\""+val.User.username+"\" userId=\""+val.User.id+"\" class=\"mouseChatListen\" style=\"margin-top:2px; margin-bottom:2px;\"><img src=\"" +val.User.avatar+ "\" style=\"width:20px;\"> "+val.User.username+": "+online+"</li>");
				}
			});
			contacts.append('</ul>');
			//addMouseEvents();
		});
	}

	function getTeams() {
		$.get('/teams/index', function(data) {
			data = $.parseJSON(data);
			teams.append('<ul>')
			$.each(data, function (index, val) {
				teams.append('<li type="team" class="mouseChatListenTeams" teamId="'+val.Team.id+'" >'+val.Team.name+'</li>');
			});
			teams.append('</ul>')
			addMouseEventsTeams();
		});
	}

	function addMouseEventsTeams() {
		var ev1 = $( "li.mouseChatListenTeams" );
		ev1.each(function() {
			$(this).on('click', function() {
				newFrameTeam($(this).attr('teamId'), $(this).html());			
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
				$("#chat_team_"+id).remove();
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
		$.post('/tchats/getMessages', { debut: d , nombreLignes: nbLignes, ressource: file}).done(function(data) {
			data = $.parseJSON(data);
			if (focus == "inputMessageTeam_"+id) {
				var messSave = $( "#inputMessageTeam_"+id ).val();
			}
			divMessages.empty();
			$.each(data, function (index, val) {
				if (val == "none") {
					divMessages.append('<small>No message</small><br />');
				} else {
					divMessages.append('<small>'+val+'</small><br />');
				}
			});

			if (focus == "inputMessageTeam_"+id) {
				setFocus();
				$( "#inputMessageTeam_"+id ).val(messSave);
			}

			$( "#inputMessageTeam_"+id ).focus(function() {
				focus = "inputMessageTeam_"+id;
			});
			var sF = document.getElementById('chat_team_'+id);
			if (sF != null) $('#chat_team_'+id).scrollTop(sF.scrollHeight);
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
				saveChatState();
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
		var len = 0;
		var tmp = "";
		var pseudo = "";
		if (userId < id) {
			file = "files/friends/"+userId+"_"+id+"_tchat.txt";
		} else {
			file = "files/friends/"+id+"_"+userId+"_tchat.txt";
		}
		$.ajax({
		  	type: 'POST',
		  	url: '/tchats/getMessages',
		 	data: { debut: d , nombreLignes: nbLignes, ressource: file},
		  	success: function(data) {
		  		data = $.parseJSON(data);
				if (focus == "inputMessage_"+id) {
					var messSave = $( "#inputMessage_"+id ).val();
				}
				myFrame.empty();
				myFrame.append("<div>");
				$.each(data, function (index, val) {
					tmp = String(val);
					if (tmp == "none") {
						myFrame.append('<small>No message</small><br />');
						return;
					}
					pseudo = tmp.split(">")[1].split("<")[0];
					pseudo = pseudo.substr(0, pseudo.length - 2);
					if (pseudo == userUsername) {
						val = tmp.split('<a')[0] + '<a href="/users/view/'+userId+'">Me: </a>'+tmp.split(pseudo+": </a>")[1];
					}
					myFrame.append('<small>'+val+'</small><br />');
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
				if (sF == null) return;
				$('#chat_friend_'+id).scrollTop(sF.scrollHeight);
				return;
		  	},
		  	dataType: 'text',
		  	async:true
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
		return;
		getFriends(false);
		if (friends == null) return;
		$.each(friends, function (index, val) {
			if ($( "#chat_friend_"+val.User.id ).length) {
				myFrame = $( "#chat_friend_"+val.User.id );
				menuMyFrame = $( "#menu_chat_friend_"+val.User.id );
				getMessages(val.User.id, val.User.name, $( "#chat_friend_"+val.User.id ), $( "#menu_chat_friend_"+val.User.id ), -1, 20);
			}
			//getNewMessages(val.User.id, val.User.name);
		});
	}

	function getNewMessages() {
		//TODO;
	}

	function setFocus() {

		if (document.getElementById(focus) != null)
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
		$.post("/users/saveChatState", {chatState: state});
	}

	function main() {
		$("#agmk_chat_frame").hide();
		//divChat.hide();
		getFriends(true);
		getTeams();
		hideAndShow(false);
		//setChatState();
		//divChat.show();
		setInterval(function() {
			//actualise les messsages.
			majMessages();
		}, 10000);
	};
	/* Fin Fonctions*/

	//lancement JS
	main();
	

});