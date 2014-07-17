$(document).ready(function(){	

	var res;
	var tabFriends = Array();
	var nbResults = 0;
	var selectedResult = -1;
	var results = $("#results");
	var tabUsers = Array();

	$("form").on('submit', function() {
		if ($("#dest_id").val()!= ''){
			return true;
		}
		return false;
	});

	$.get('/friendships/myfriends/'+$(this).val(), {}, function(data) {
		var friends = $.parseJSON(data);
		$.each(friends, function (i, item) {
			tabFriends[item.User.id] = item.User.username;
		});
	});


	$( "#MessageTo" ).on('keyup', function(e) {
		$( "#dest_id").val('');
		e = e || window.event;
		//var divs = results.getElementsByTagName('div');
		if (e.keyCode == 38 && selectedResult > -1) { // Si la touche pressée est la flèche « haut »

		    $( "#result"+selectedResult ).css('background', 'white');
		    selectedResult--;

		    if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
		        //divs[selectedResult].cssText('color:red;'); // On applique une classe à l'élément actuellement sélectionné
		    	$( "#result"+selectedResult ).css('background', '#aaa');
		    }
		} else if (e.keyCode == 38 && selectedResult == -1) {
			selectedResult = results.size();
			$( "#result"+selectedResult ).css('background', '#aaa');
		} else if (e.keyCode == 40 && selectedResult <= results.size()+1) { // Si la touche pressée est la flèche « bas »
		    if (selectedResult > -1) { // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
		        $( "#result"+selectedResult ).css('background', 'white');
		    }
		    selectedResult++;
		    $( "#result"+selectedResult ).css('background', '#aaa');
		} else if(e.keyCode == 13) {
			var result = $( "#result"+selectedResult );
			$( "#dest_username").val(result.html());
			$( "#dest_id").val(result.attr('userid'));
			$( "#MessageTo" ).val(result.html());
			results.html('');
		} else {
			if ($(this).val() == '') {
				results.empty();
				return;
			}
			$.post( "/users/getusers/" + $( this ).val()).done(function( data ) {
				res = $.parseJSON(data);
				majResults();
				selectedResult = -1;
			});
		}
	});

	function majResults() {
		//met a jour les div results avec les results et fai un tri avt

		results.html('');
		var tmp;
		var compt = 0;
		tabUsers = Array();
		$.each(res, function (i, item) {
			tmp = tabFriends[item.User.id];
			if (tmp == null) {
				tabUsers.unshift("userid=\""+item.User.id+"\" class=\"mouseListener\">"+item.User.username+"</div>");
			} else {
				tabUsers.push("style=\"font-weight:bold;\" userid=\""+item.User.id+"\" class=\"mouseListener\">"+item.User.username+"</div>");
			}
		});
		for (var i=tabUsers.length -1; i>=0; i--) {
			tmp = '<div id="result'+(compt++)+'" ' + tabUsers[i];
			results.append(tmp);
		}

		$( ".mouseListener" ).on('mouseover', function(e) {
			var tmp = new String($(this).attr('id'));
			var id = tmp.substring(tmp.length-1, tmp.length);
			selectedResult = id;
			$( "#result"+selectedResult ).css('background', '#aaa');
		});

		$( ".mouseListener" ).on('mouseout', function(e) {
			var tmp = new String($(this).attr('id'));
			var id = tmp.substring(tmp.length-1, tmp.length);
			selectedResult = id;
			$( "#result"+selectedResult ).css('background', 'white');
		});

		$( ".mouseListener" ).on('click', function(e) {
			var tmp = new String($(this).attr('id'));
			var id = tmp.substring(tmp.length-1, tmp.length);
			selectedResult = id;
			$( "#dest_username").val($(this).html());
			$( "#dest_id").val($(this).attr('userid'));
			$( "#MessageTo" ).val($(this).html());
			results.html('');
		});

	}
});
