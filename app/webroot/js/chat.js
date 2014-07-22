jQuery(document).ready(function() {
	
	/* Setting needed variables */
	
	/* vars jQuery */
	var agmk_chat = jQuery('#agmk_chat');
	var content = jQuery('#content_agmk_chat');
	var menu = jQuery('#menu_agmk_chat');
	var form = jQuery('#form_agmk_chat');
	var input = jQuery('#input_form_agmk_chat');
	var onglets = jQuery('#onglets_agmk_chat');
	var liste_onglets = jQuery('#liste_onglets_agmk_chat');
	var lth = null;
	var hideable = null;
	var button_new_onglet = jQuery('#new_onglet_agmk_chat');
	var button_close = jQuery('#close_agmk_chat');
	var agmk_chat_min = jQuery("#agmk_chat_min");
	var hideable = jQuery('.hideable');
	var button_max_agmk_chat = jQuery("#max_agmk_chat");
	var button_min_agmk_chat = jQuery("#min_agmk_chat");
	
	/* vars jQueryUI*/
	var agmk_chat_ui = $('#agmk_chat');
	var onglets_ui = $('#onglets_agmk_chat');
	var liste_onglets_ui = $('#liste_onglets_agmk_chat');
	
	/* var javascript classic */
	var nombreOnglets = 0;
	var first = true;
	var argsRun = null;
	var tampon = "";
	var isBig = false;
	
	/* le array d'onglets contient pour chaque entree ->1 objet/array avec tous les channels de l'onglet */
	var ongletsArray = Array();
	var ongletActuel = 1;
	var channelActuel = Array();
	
	/* Objet javascript contenant la liste des commandes et leur methodes */
	var listeCommandes = 
	{
			/* Commande /help */
			'/help': 
			{
				'run': function() 
				{
					var str = "";
					for (key in listeCommandes) 
					{
						str += listeCommandes[key]['description']+'<br /><br />';
					}
					ongletsArray['onglet-'+ongletActuel+'_agmk_chat']['content'].append('<p class="command_help">' + str + '</p>');
				},
				'description': 'Command /help, usage: /help --> Show all commands descriptions',
				'noserver': function() 
				{
					listeCommandes['/help']['run']();
				}
			},
			/* Commande /w */
			'/w':
			{
				'run': function() 
				{
					
				},
				'description': 'Command /w, usage: /w Name Message --> Send a private message to Name'
			},
			/* Commande /join */
			'/join':
			{
				'run': function()
				{
					jQuery.each(argsRun, function(index, value) {
						//alert(value.channel);
						if(ongletsArray['onglet-'+ongletActuel+'_agmk_chat'][value.channel] == null)
							ongletsArray['onglet-'+ongletActuel+'_agmk_chat'][value.channel] = Array();
						ongletsArray['onglet-'+ongletActuel+'_agmk_chat'][value.channel]['ligne'] = -1;
						ongletsArray['onglet-'+ongletActuel+'_agmk_chat']['content'].append('<p class="systeme">'+(value.message)+'</p>');
						ongletsArray['onglet-'+ongletActuel+'_agmk_chat']['actual'] = "none";
						ongletsArray['onglet-'+ongletActuel+'_agmk_chat']['ligne'] = -1
					});
				},
				'description': '<span class="command_key_words"> Command </span> <span class="command_name"> /join </span> <span class="commandKeyWords"> Usage: </span> <span class="command_name"> /join </span> blabla --> Join a channel named blabla'
			},
			'/talk':
			{
				'description': '<span class="command_key_words"> Command </span> <span class="command_name"> /talk </span> <span class="commandKeyWords"> Usage: </span> <span class="command_name">/talk chan message </span>--> write message in channel named chan (you should /join channel first)',
				'run': function()
				{
					if (argsRun.status == 'ok') {
						/* on peut améliorer en parcourant le tab des channels et ecrire dans le bon 
						 * ( ceci dit normalement ongletactuel contient le bon channel si le user a pas changer pendant que le serveur repondait ),
						 * on pourrai aussi bloquer le change d'onglet avant que le serveur reponde (plus safe et moins de ressource que 
						 * parcourir un tableau.
						 * Best sol : remplacer ongletArray par ongletObj un objet contenant pour chaque onglet un array channel=>ligne ou qqch comme ça.
						 * 
						 * Ici version simplifiée pour test rapide du chat et serveur.
						 * */
						ecrireOngletActuel("["+argsRun.channel+"] "+argsRun.message);
						ongletsArray['onglet-'+ongletActuel+'_agmk_chat'][argsRun.channel]['ligne'] = argsRun.ligne;
						//read();
					} else {
						alert(argsRun.message);
					}
				}
			},
			'/link':
			{
				'description': '<span class="command_key_words"> Command </span> <span class="command_name">/link </span> <span class="commandKeyWords"> Usage: </span> <span class="command_name">/link chan </span> --> link you with the channel named chan, will allow you to write into chan without using /talk command everytime (you should /join channel first)',
				'run': function()
				{
					
				},
				'noserver': function() 
				{
					var inp = input.val();
					var regex = /\/[a-z]+ [a-zA-Z_-]+/;//interdit surtout ;,et% use par serveur comme delimiter
					tampon = ""+regex.exec(input.val());
					tampon = tampon.substring(6, tampon.lenght);
					if (ongletsArray['onglet-'+ongletActuel+"_agmk_chat"][tampon] != null) 
					{
						ongletsArray['onglet-'+ongletActuel+"_agmk_chat"]['actual'] = tampon;
						writeLinkOngletActuel();
					} else 
					{
						ecrireOngletActuel("Cant link to a channel if you are not in the right frame");
					}
				}
			}
	}
	
	function writeLinkOngletActuel() {
		ecrireOngletActuel("<p class=\"systeme\">You are link channel --> "+ongletsArray['onglet-'+ongletActuel+'_agmk_chat']['actual']+"</p><br />");
		actuFrame();
	}
	
	/* fonction qui envoi le message avec la command */
	function checkCommand(command) {
		/* premier check js pour certaine commandes like help */
		if (listeCommandes[command]['noserver'] == null) {
			jQuery.ajax({
				type: "POST",
				url: '/chats/checkCommand',
				data: {message: input.val(), onglet: ongletActuel},
				success: function(data) {
					argsRun = data;
					listeCommandes[command]['run']();
				},
				dataType: 'json'
			});
		} else {
			listeCommandes[command]['noserver']();
		}
	}
	
	/* fonction qui analyse l'inut et lance fonction adaptée selon message/command */
	function analyseMessage() {
		var isCommand = false;
		if (input.val().substring(0,1) == '/') isCommand = true;
		/* Maintenant on sait si command ou simple message */
		if (isCommand) {
			/* on a une command */
			var regex = /\/[a-z]+/;
			var command = regex.exec(input.val());
			
			//on regarde si la commande existe
			if (listeCommandes[command] == null) {
				alert('commande introuvable');
			} else {
				checkCommand(command);
			}
		}
		else {
			/* On a un message */
			/* si le user ne s'est link a aucun channel, on ne sait pas ou ecrire donc on lui demande de use /talk channel message ou bien /link channel
			 * et ensuite ecrire dans messages dans le channel sans avoir a use /talk. Il est link au channel. /unlink pour se delink du channel.
			 * */
			if (ongletsArray['onglet-'+ongletActuel+"_agmk_chat"]['actual'] == "none") {
				ecrireOngletActuel(listeCommandes['/talk']['description']+'<br />'+listeCommandes['/link']['description']);
			} else {
				//input contient aucune command et on est link donc on talk
				input.val("/talk "+ongletsArray['onglet-'+ongletActuel+"_agmk_chat"]['actual']+" "+input.val());
				checkCommand("/talk");
			}
		}
	}
	
	function ecrireOngletActuel(msg) {
		ongletsArray['onglet-'+ongletActuel+'_agmk_chat']['content'].append('<p>'+msg+'</p>');
		actuFrame();
	}
	
	function actuFrame() {
		return;
	}
	
	function read() {
		jsonStr = "";
		var line = -1;
		//serialize a la main
		for ($i=1;$i<=nombreOnglets; $i++) {
			for (key in ongletsArray['onglet-'+$i+'_agmk_chat']) {
				if (key != "actual" && key != "content") {
					if (ongletsArray['onglet-'+$i+'_agmk_chat'][key]['ligne'] == null)
						line = -1;
					else
						line = ongletsArray['onglet-'+$i+'_agmk_chat'][key]['ligne'];
					jsonStr = jsonStr.concat(line+":"+key, ",");
				}
			}
		}
		jQuery.ajax({
			type: "POST",
			url: '/chats/read',
			data: {arr: jsonStr},
			success: function(data) {
				if (data == "" || data == "[]") return;
				traitementReadChannels(data);
			},
			dataType: 'text'
		});
	}
	
	function traitementReadChannels(data) {
		//return;
		//alert(data); //return;
		var msg = Array();
		data = JSON.parse(data);
		jQuery.each(data, function(index, value) {
			var channel = index;
			//alert(channel);
			var messages = value.messages;
			var ligne = value.ligne;
			//alert(ligne);
			for (var i=1;i<=nombreOnglets; i++) {
				if (ongletsArray['onglet-'+i+'_agmk_chat'][channel] != null) {
					jQuery.each(messages, function(index2, value2) {
						ongletsArray['onglet-'+i+'_agmk_chat']['content'].append('<span>['+channel+']</span> <span>'+value2+'</span><br />');
					});
					ongletsArray['onglet-'+i+'_agmk_chat'][channel]['ligne'] = ligne;
				}		
			}
		});
	}
	
	function onInputFocus() {
		input.on('focus', function() {
			input.val('');
		});
	}
	
	function onInputFocusOut() {
		input.focusout(function() {
			if (input.val() == '') {
				input.val('type messages/commands here');
			}
		});
	}
	
	function formSubmit() {
		form.on('submit', function () {
			analyseMessage();
			input.val('');
			return false;
		});
	}
	
	
	
	
	
	function getOngletsChannels() {
		jQuery.ajax({
			type: "POST",
			url: '/chats/channels',
			data: null,
			success: function(d) {
				//prevoir si pas d'onglet
				if (d.reponse == "null") {
					ongletsArray['onglet-1_agmk_chat'] = Array();
					ongletsArray['onglet-1_agmk_chat']['content'] = jQuery('#onglet-1_agmk_chat');
					nombreOnglets = 1;
					ongletActuel = 1;
					return;
				}
				var data = d.reponse;
				nombreOnglets = data.nb_onglets;
				liste_onglets.empty();
				jQuery.each(data.ongletsChan, function(index, onglet) {
					liste_onglets.append('<li> <a numOnglet="'+(index+1)+'" class="linktohide" href="onglet-'+(index+1)+'_agmk_chat"> Onglet '+(index+1)+'</a></li>');
					onglets.append('<div class="hideable" id="onglet-'+(index+1)+'_agmk_chat"> </div>');
					ongletsArray['onglet-'+(index+1)+'_agmk_chat'] = Array();
					ongletsArray['onglet-'+(index+1)+'_agmk_chat']['content'] = jQuery('#onglet-'+(index+1)+'_agmk_chat');
					ongletsArray['onglet-'+(index+1)+'_agmk_chat']['actual'] = "none";
					jQuery.each(onglet, function(index2, channel) {
						if (channel != "" && channel != " ") {
							ongletsArray['onglet-'+(index+1)+'_agmk_chat'][channel] = Array();
							ongletsArray['onglet-'+(index+1)+'_agmk_chat']['content'].append('<p class="systeme">You join channel: '+channel+'</p>');
						}
					});
				});
			},
			complete: function() {
				makeCoolUI();
				read();
				actuFrame();
			},
			dataType: 'json'
		});
	}
	
	/* fonction qui rend le agmk_chat resizable/draggable/creer le systeme d'onglets etc etc make it cool ! (jqueryUI) */
	function makeCoolUI() {
		onglets_ui.tabs( "destroy");
		lth = jQuery('.linktohide');
		hideable = jQuery('.hideable');
		agmk_chat_ui.resizable( { animate: true, ghost: true, aspectRatio: false, alsoResize: '#content_agmk_chat'} );
		agmk_chat_ui.resizable( "option", "alsoResize", "#menu_agmk_chat" );
		agmk_chat_ui.resizable( "option", "alsoResize", "#form_agmk_chat" );
		agmk_chat_ui.draggable( {addClasses: false} );
		onglets_ui.tabs();
		jQuery.each(lth, function() {
			jQuery(this).on('click', function() {
				hideAllExcept(jQuery(this).attr('href'));
				ongletActuel = jQuery(this).attr('numOnglet');
			});
		});
		hideAllExcept('onglet-'+ongletActuel+'_agmk_chat');
	}
	
	/* Cache les onglets non select car UI marche mal avec Jq*/
	function hideAllExcept(idDiv) {
		
		if (first) {
			for(key in ongletsArray) {
				ongletsArray[key]['content'].hide();
			}
			first = false;
		}
		ongletsArray['onglet-'+ongletActuel+'_agmk_chat']['content'].hide();
		ongletsArray[idDiv]['content'].show();
	}
	
	/* Fonction qui link des evenements aux boutons */
	function putButtonsEvents() {
		button_new_onglet.click(function() {
			nombreOnglets++;
			liste_onglets.append('<li> <a numOnglet="'+nombreOnglets+'" class="linktohide" href="onglet-'+nombreOnglets+'_agmk_chat"> Onglet '+nombreOnglets+'</a></li>');
			onglets.append('<div class="hideable" id="onglet-'+nombreOnglets+'_agmk_chat"> </div>');
			ongletsArray['onglet-'+nombreOnglets+'_agmk_chat'] = Array();
			ongletsArray['onglet-'+nombreOnglets+'_agmk_chat']['content'] = jQuery('#onglet-'+nombreOnglets+'_agmk_chat');
			makeCoolUI();
		});
		
		 button_max_agmk_chat.click(function() {
			 if (!isBig) {
				 agmk_chat.css("width","80%");
				 agmk_chat.css("height", "90%");
				 isBig = true;
			 } else { 
				 agmk_chat.css("width","300px");
				 agmk_chat.css("height", "400px");
				 isBig = false;
			 }
		 });
		
		button_close.click(function() {
			jQuery.ajax({
				type: "POST",
				url: '/chats/close',
				data: null,
				success: function(data) {
					if (data.status!="ok"){
						alert('error chat');
					}
				},
				dataType: 'json'
			});
			agmk_chat.hide();
			agmk_chat_min.show();
		});
		
		agmk_chat_min.click(function() {
			jQuery.ajax({
				type: "POST",
				url: '/chats/open',
				data: null,
				success: function(data) {
					if (data.status!="ok"){
						alert('error chat');
					}
				},
				dataType: 'json'
			});
			jQuery(this).hide();
			agmk_chat.show();
		});
	}
	
	/* Function a run avant tout ( premier appel dans run() ) */	
	function preRunFunc() {
		onglets_ui.tabs();
		getOngletsChannels();
		onInputFocus();
		onInputFocusOut();
		formSubmit();
		putButtonsEvents();
	}

	/* Fonction principale */
	function run() {
		/* fonction qui va mettre les premier event indispensable */
		preRunFunc();
		if (agmk_chat.attr('state') == 'open') agmk_chat.show();
		else agmk_chat_min.show();
		
		/*var links = jQuery('a');
		jQuery.each(links, function() {
			jQuery(this).on('click', function() {
				//TODO: finir CA!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				jQuery.get(jQuery(this).attr('href'), function (data) {
					alert(data);
				});
				//return false;
			});
		});*/
	}
	
	
	
	
	/* run program */
	run();
	setInterval(function() {
		//actualise les messsages.
		read();
	}, 5000);
});