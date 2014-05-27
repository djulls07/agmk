$(document).ready(function(){	

	var res;

	$.get('/friendships/myfriends/'+$(this).val(), {}, function(data) {
		res = data;
	});


	$( ".MessageTo" ).on('keyup', function() {
		majResults(res, $(this).val());
		return false;
	});

	function majResults(res, input) {
		//met a jour les div results avec les results et fai un tri avt
		
	}
});
