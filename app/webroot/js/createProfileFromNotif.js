$(document).ready(function() {

	var games = $( "#ProfileGame" );
	var form = $( "#ProfileCreateFromNotifForm" );
	var game = '';
	//games.append("<option value=\"-1\" selected>None</option>"); 
	var inputPseudo = $( "#ProfilePseudo" );
	var inputLevel = $( "#ProfileLevel" );
	var inputRegion = $( "#ProfileRegion" );
	var divInputsText = $( ".input.text" );
	var region = '';
	var pseudo = '';
	var sc2Id = '';
	var summonerId = '';
	var test = false;
	var dialog = $("#dialog");
	var loading = $("#loading");

	//functions

	function afficheForm() {
		loading.html("Loading...");
		dialog.empty();
		switch(game) {
			case 2: //lol
				dialog.dialog("option", "title", "Profile League of Legends");
				dialog.append('<form action="#" method="POST" id="formPopLoL">');
				dialog.append('Pseudo LoL<input name="pseudo" id="pseudoLoL"></input>');
				dialog.append('Region LoL (euw, eue, kr, na): <input name="regionLoL" id="regionLoL"></input>');
				dialog.append('<input id="submitB" type="submit" value="Send"/></form>');
				dialog.dialog("open");
				$("#submitB").on("click", function() {
					dialog.dialog("close");
					loading.dialog('open');
					majLol(jQuery("#pseudoLoL").val(), jQuery("#regionLoL").val());
					return false;
				});
				break;
			case 3: //sc2
				dialog.dialog("option", "title", "Profile Starcraft 2");
				dialog.append('<form action="#" method="POST" id="formPopSc2">');
				dialog.append("SC2 ID: <input name=\"sc2ID\" id=\"sc2id\"></input");
				dialog.append('Pseudo SC2<input name="pseudo" id="pseudoSc2"></input>');
				dialog.append('Region SC2(eu, us, kr): <input name="regionSc2" id="regionSc2"></input>');
				dialog.append('<input id="submitB" type="submit" value="Send"/></form>');
				dialog.dialog("open");
				$("#submitB").on("click", function() {
					dialog.dialog("close");
					loading.dialog("open");
					majSc2(jQuery("#regionSc2").val(), jQuery("#sc2id").val(), jQuery("#pseudoSc2").val());
					return false;
				});
				break;
			default:
				dialog.dialog("option", "title", "Profile "+jQuery("#ProfileGame").find(":selected").text());
				dialog.append('<form action="#" method="POST" id="formPop">');
				dialog.append('Pseudo<input name="pseudo" id="pseudoDef"></input>');
				dialog.append('Region(eu, us, kr): <input name="region" id="regionDef"></input>');
				dialog.append('Level <input id="levelDef" name="level" type="text"></input>');
				dialog.append('<input id="submitB" type="submit" value="Send"/></form>');
				dialog.dialog("open");
				$("#submitB").on("click", function() {
					dialog.dialog("close");
					inputRegion.val(jQuery("#regionDef").val());
					inputPseudo.val(jQuery("#pseudoDef").val());
					inputLevel.val(jQuery("#levelDef").val());
					form.submit();
					return false;
				});
				break;
		}
	}

	function majLol(pseudo, region) {
		inputLevel.val('Loading data');
	    $.ajax({
	     	url: "https://prod.api.pvp.net/api/lol/"+region+"/v1.4/summoner/by-name/"+pseudo+"?api_key=fe8ad5ae-034e-43eb-944f-83ac6cccc1a1",
	     	type: 'GET',
	      	success: function (data, status) {
	        	$.each(data, function(index, val) {
	          		//on prend que le first.
	          		summonerId = val.id;
	          		$.get('https://prod.api.pvp.net/api/lol/'+region+'/v2.4/league/by-summoner/'+summonerId+'?api_key=fe8ad5ae-034e-43eb-944f-83ac6cccc1a1')
	            	.done(function (data) {
	              		$.each(data, function (index, val){
	                		$.each(val, function (i, v) {
	                  			if (v.queue == "RANKED_SOLO_5x5") {
	                  				test = true;
	                  				inputLevel.val(v.tier);
	                  				inputPseudo.val(pseudo);
	                  				inputRegion.val(region);
	                  				alert('You LoL level is: '+inputLevel.val());
	                  				form.submit();
	                  			}
	                		});
	              		});
	            	});
	            	if (!test) {
		            	inputLevel.val('UNRANKED');
	      				inputPseudo.val(pseudo);
	      				inputRegion.val(region);
	      				alert('You LoL level is: UNRANKED');
	      				form.submit();
	      			}
	        	});
	      	},
	     	error: function() {
	     		//alert("Cant get your level with the informations you give");
	     		$( "#loading" ).html('Cant get your level with the informations you give, please try again');
	     	},
	    	datatype: 'json'
    	});
	}

	function majSc2(region, id, pseudo) {
	    inputLevel.val('Loading data');
	    $.ajax({
	        url: '/profiles/checkSc2',
	        type: 'POST',
	        data: {'region' : region, 'id' : id, 'name' : pseudo},
	        success: function (data) {
	          data = $.parseJSON(data);
	          if (data.status == 'nok') {
	            alert('Pseudo not found in this region');
	            return;
	          }
	          inputLevel.val(data.career.highest1v1Rank);
	          inputPseudo.val(pseudo);
	          inputRegion.val(region);
	          alert('Your SC2 level is: ' + inputLevel.val());
	          form.submit();
	        },
	        error: function() {alert("Cant get your level with the informations you give")},
	        datatype: 'json'
	    });
  	}

	divInputsText.hide();
	dialog.dialog({ autoOpen: false , modal: true, width: 600, show: { effect: "blind", duration: 1300 }});
	loading.dialog(
		{
			autoOpen: false ,
	 		modal: true,
	 		width: 600,
	 		buttons: [{
				text: "OK",
				click: function() {
				$( this ).dialog( "close" );
				}
			}]
	 	}
	);

	games.on('change', function() {
		game = parseInt($(this).val());
		afficheForm();
	});

	games.mousedown(function() {
		divInputsText.hide();
		inputPseudo.val('');
		inputLevel.val('');
	});

	afficheForm();

});