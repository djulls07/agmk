$(document).ready(function() {

	var games = $( "#ProfileGame" );
	var form = $( "#ProfileCreateFromNotifForm" );
	var game = '';
	games.append("<option value=\"-1\" selected>None</option>"); 
	var inputPseudo = $( "#ProfilePseudo" );
	var inputLevel = $( "#ProfileLevel" );
	var inputRegion = $( "#ProfileRegion" );
	var divInputsText = $( ".input.text" );
	var region = '';
	var pseudo = '';
	var sc2Id = '';
	var summonerId = '';
	var test = false;

	//functions

	function afficheForm() {
		switch(game) {
			case 2: //lol
				//divInputsText.show('slow');
				var compt = 0;
				while(($.inArray(region, Array('na', 'kr', 'ru', 'euw', 'eune'))) < 0 && compt < 2) {
					compt++;
					region = prompt('Enter your region ( na, kr, ru, euw, eune )', 'euw');
				}
				pseudo = prompt('Enter you League of legends pseudo: ', 'Your-lol-pseudo ( summoner name )');
				majLol(pseudo, region);
				break;
			case 3: //sc2
				//divInputsText.show('slow');
				//inputSc2IdSpan.show();
				sc2Id = prompt('Enter your SC2 ID : ', 'Your-Sc2-Id');
				pseudo = prompt('Enter your SC2 pseudo', 'You-Sc2-Pseudo');
				var compt = 0;
				while(($.inArray(region, Array('eu', 'kr', 'us'))) < 0 && compt < 2) {
					compt++;
					region = prompt('Enter your region ( eu, us, kr )', 'eu');
				}
				majSc2(region, sc2Id, pseudo);
				break;
			case 4: //DOTA2

				break;
			default:
				break;
		}
	}

	function majLol(pseudo, region) {
		inputLevel.val('Loading data');
		$( "#loading" ).html('LOADING...LOADING...LOADING...');
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
	    $( "#loading" ).html('LOADING...LOADING...LOADING...')
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

	games.on('change', function() {
		game = parseInt($(this).val());
		afficheForm();
	});

	games.mousedown(function() {
		divInputsText.hide();
		inputPseudo.val('');
		inputLevel.val('');
	});

});