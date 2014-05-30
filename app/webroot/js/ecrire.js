$(document).ready(function(){	

	var res;
	var tabUsernames = new Array();
	var tabIds = new Array();
	var nbResults = 0;
	var selectedResult = -1;
	var tabUsernamesCourant = new Array();
	var tabIdsCourant = new Array();

	$("form").on('submit', function() {
		if ($("#dest_id").val()!= ''){
			return true;
		}
		return false;
	});

	$.get('/friendships/myfriends/'+$(this).val(), {}, function(data) {
		res = $.parseJSON(data);
		$.each(res, function (i, item) {
			tabUsernames.push(item.User.username);
			tabIds.push(item.User.id);
		});
	});


	$( "#MessageTo" ).on('keyup', function(e) {
		e = e || window.event;
		var results = document.getElementById('results');
		//var divs = results.getElementsByTagName('div');
		if (e.keyCode == 38 && selectedResult > -1) { // Si la touche pressée est la flèche « haut »

		    $( "#result"+selectedResult ).css('background', 'white');
		    selectedResult--;

		    if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
		        //divs[selectedResult].cssText('color:red;'); // On applique une classe à l'élément actuellement sélectionné
		    	$( "#result"+selectedResult ).css('background', '#aaa');
		    }
		} else if (e.keyCode == 38 && selectedResult == -1) {
			selectedResult = tabUsernamesCourant.length - 1;
			$( "#result"+selectedResult ).css('background', '#aaa');
		} else if (e.keyCode == 40 && selectedResult < tabUsernamesCourant.length - 1) { // Si la touche pressée est la flèche « bas »
		    if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
		        $( "#result"+selectedResult ).css('background', 'white');
		    }
		    selectedResult++;
		    $( "#result"+selectedResult ).css('background', '#aaa');
		} else if(e.keyCode == 13) {
			$( "#dest_username").val(tabUsernamesCourant[selectedResult]);
			$( "#dest_id").val(tabIdsCourant[selectedResult]);
			$( "#MessageTo" ).val(tabUsernamesCourant[selectedResult]);
			$( "#results" ).html('');
		} else {
			majResults(tabUsernames, $(this).val());
			selectedResult = -1;
		}
	});

	function majResults(res, input) {
		//met a jour les div results avec les results et fai un tri avt

		if (input == "") {
			$( "#results" ).empty();
			return;
		}

		tabUsernamesCourant = new Array();
		tabIdsCourant = new Array();

		var regExp = new RegExp('^(.*)('+input+'){1}(.*)$', "i");

		for (var i=0; i<tabUsernames.length; i++) {
			//compare les chaine et choisi dajouter ou non
			if (regExp.test(tabUsernames[i])) {
				tabUsernamesCourant.push(tabUsernames[i]);
				tabIdsCourant.push(tabIds[i]);
			}
		}
		$( "#results" ).html('');
		for (var j=0; j<tabUsernamesCourant.length; j++) {
			$ ( "#results" ).append("<div id=\"result"+j+"\">"+tabUsernamesCourant[j]+"</div>");
		}
	}
});
