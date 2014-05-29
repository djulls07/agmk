$(document).ready(function(){	

	var res;
	var tabUsernames = new Array();
	var nbResults = 0;
	var divs;
	var selectedResult = -1;

	$.get('/friendships/myfriends/'+$(this).val(), {}, function(data) {
		res = $.parseJSON(data);
		$.each(res, function (i, item) {
			tabUsernames.push(item.User.username);
		});
	});


	$( ".MessageTo" ).on('keyup', function(e) {
		majResults(tabUsernames, $(this).val());
		e = e || window.event;
		var results = document.getElementById('results');
		var divs = results.getElementsByTagName('div');
		if (e.keyCode == 38 && selectedResult > -1) { // Si la touche pressée est la flèche « haut »

		    divs[selectedResult--].cssText('color:black;'); // On retire la classe de l'élément inférieur et on décrémente la variable « selectedResult »
		    
		    if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
		        divs[selectedResult].cssText('color:red;'); // On applique une classe à l'élément actuellement sélectionné
		    }

		} else if (e.keyCode == 40 && selectedResult < divs.length - 1) { // Si la touche pressée est la flèche « bas »
		  
		    if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
		        divs[selectedResult].cssText('color:black;');
		    }

		    divs[++selectedResult].cssText('color:red;');
		}
	});

	function majResults(res, input) {
		//met a jour les div results avec les results et fai un tri avt

		if (input == "") {
			$( "#results" ).empty();
			return;
		}

		var tabUsernamesCourant = new Array();

		var regExp = new RegExp('^(.*)('+input+'){1}(.*)$', "i");

		for (var i=0; i<tabUsernames.length; i++) {
			//compare les chaine et choisi dajouter ou non
			if (regExp.test(tabUsernames[i])) {
				tabUsernamesCourant.push(tabUsernames[i]);
			}
		}
		$( "#results" ).html('');
		for (var j=0; j<tabUsernamesCourant.length; j++) {
			$ ( "#results" ).append("<div class=\"result\">"+tabUsernamesCourant[j]+"</div>");
		}
	}
});
