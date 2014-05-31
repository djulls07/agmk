$(document).ready(function() {

	var results = $( "#results" );
	var selectedResult = -1;
	var i = 0;
	var username = '';

	$("form").on('submit', function() {
		if (selectedResult == -1){
			return true;
		}
		return false;
	});



	$ ( "#FriendshipUsername" ).on('keyup', function(e) {
		if ($(this).val() == '') {
			results.empty();
			return;
		}
		e = e || window.event;
		if (e.keyCode == 38 && selectedResult > -1) { //fleche haut
			$( "#"+selectedResult ).css('background-color', 'white');
			selectedResult--;
			$( "#"+selectedResult ).css('background-color', '#aaa');
		} else if (e.keyCode == 40 && selectedResult <= results.size() + 1) { //fleche bas
			if (selectedResult != -1) {
				$( "#"+selectedResult ).css('background-color', 'white');
			}
			selectedResult++;
			$( "#"+selectedResult ).css('background-color', '#aaa');
		} else if (e.keyCode == 13) {
			$(this).val($( "#"+selectedResult ).html());
			results.empty();
		} else {
			$.post( "/users/getusers/" + $( "#FriendshipUsername" ).val()).done(function( data ) {
        		results.empty();
        		i = 0;
        		$.each($.parseJSON(data), function(index, value) {
        			results.append('<div class="mouseListener" id='+(i++)+'>'+value.User.username+'</div>');
        		});

        		$( ".mouseListener").on('mouseover', function() {
        			var id = $(this).attr('id');
        			$( "#"+id ).css('background-color', '#aaa');
        		});

        		$( ".mouseListener").on('mouseout', function() {
        			var id = $(this).attr('id');
        			$( "#"+id ).css('background-color', 'white');
        		});

        		$( ".mouseListener").on('click', function() {
        			var id = $(this).attr('id');
        			$( "#FriendshipUsername" ).val($( "#"+id).html());
        			results.empty();
        		});

    		});
	    }
	});
});