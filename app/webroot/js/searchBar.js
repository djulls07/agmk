//il s'agit d'un fichier qui cherche les id de types searchBar, si il existe
//on creer une autocomplétion selon les attr conttroller et action.
// on affiche les resultats dans la div d'id resultsSearchBar
$(document).ready(function() {

	//on recupere la bar a autocomplete, ainsi que le controller a appelé et sa method
	var searchBar = $( "#searchBar" );
	var results = $( "#resultsSearchBar" );
	var controller = searchBar.attr('controller');
	var action = searchBar.attr('action');
	var callType = searchBar.attr('callType'); //get or post
	var callUrl = '/' + controller + '/' + action + '/';

	searchBar.on('keyup', function(e) {
		e = e || window.event;
		switch(e.keyCode) {
			case 38:
				
				break;
			default: 
				callAjax();
		}
	});
	

	function callAjax() {
		if (callType == 'get') {
			$.get( callUrl + searchBar.val()).done(function( data ) {
				handleResults(data);
			});
		} else {
			$.post(callUrl + searchBar.val()).done(function( data ) {
				handleResults(data);
			});
		}
	}

	function handleResults(data) {
		alert(data);
		$.each(data, function () {

		});
	}


});
