//il s'agit d'un fichier qui cherche les id de types searchBar, si il existe
//on creer une autocomplétion selon les attr conttroller et action.
// on affiche les resultats dans la div d'id resultsSearchBar
$(document).ready(function() {

	//on recupere la bar a autocomplete, ainsi que le controller a appelé et sa method

	var form = $( 'form' );

	$.each(form, function () {

		var searchBar = $( "#"+$(this).attr('id') + " .searchBar" );
		if (searchBar == null) 
			return;
		var results = $( "#"+$(this).attr('id') + " .resultsSearchBar" );
		var controller = searchBar.attr('controller');
		var action = searchBar.attr('action');
		var callType = searchBar.attr('callType'); //get or post
		var callUrl = '/' + controller + '/' + action + '/';
		var tabResults = new Array();
		var handler = searchBar.attr('handler');
		var selectedResult = -1;
		var inputAdd = $( "#"+$(this).attr('id') + " .inputAdd" );

		//objet a completé contenant le nom des functions handler a lancer.
		var myHandlers = {
			'getUsersHandler' : function(data) {
				getUsersHandler(data);
			}
		};

		form.on('submit', function() {
			if (inputAdd.val()!= ''){
				return true;
			}
			return false;
		});

		searchBar.on('keyup', function(e) {
			e = e || window.event;
			switch(e.keyCode) {
				case 38:
					if (selectedResult > -1) {
						$( "#"+selectedResult ).css('background', 'white');
						selectedResult--;
						$( "#"+selectedResult ).css('background', '#aaa');
					} else if (selectedResult == -1) {
						selectedResult = results.size()+2;
						$( "#"+selectedResult ).css('background', '#aaa');
					}
					break;
				case 40 :
					if (selectedResult < (results.size() +3)) {
						if (selectedResult != -1)
							$( "#"+selectedResult ).css('background', 'white');
						selectedResult++;
						$( "#"+selectedResult ).css('background', '#aaa');
					} else if (selectedResult == (results.size() + 2)) {
						$( "#"+selectedResult ).css('background', 'white');
						selectedResult = 0;
					}
					break;
				case 13 :
					if (selectedResult != -1 && selectedResult < results.size()+3) {
						searchBar.val($( "#"+selectedResult ).html());
						inputAdd.val($( "#"+selectedResult ).attr('value'));
						results.empty();
					}
					break;
				default: 
					callAjax();
			}
		});
		

		function callAjax() {
			if (searchBar.val() == '') {
				results.empty();
				return;
			}
			if (callType == 'get') {
				$.get( callUrl + searchBar.val()).done(function( data ) {
					myHandlers[handler](data);
				});
			} else {
				$.post(callUrl + searchBar.val()).done(function( data ) {
					myHandlers[handler](data);
				});
			}
		}


		//fonctions correspondant aux diff handlers
		function getUsersHandler(data) {
			var i = 0;
			jsonData = $.parseJSON(data);
			results.empty();
			
			$.each(jsonData, function (index, obj) {
				results.append("<div value=\""+obj.User.id+"\" class=\"mouseListener\" userId=\""+obj.User.id+"\" username=\""+obj.User.username+"\" id=\""+(i++)+"\">"+obj.User.username+"</div>");
			});
			addMouseEvents();
		}

		function addMouseEvents() {
			$( ".mouseListener" ).on('mouseover', function(e) {
				selectedResult = $(this).attr('id');
				$(this).css('background', '#aaa');
			});

			$( ".mouseListener" ).on('mouseout', function(e) {
				selectedResult = $(this).attr('id');
				$(this).css('background', 'white');
			});

			$( ".mouseListener" ).on('click', function(e) {
				searchBar.val($(this).html());
				inputAdd.val($( "#"+selectedResult ).attr('value'));
				selectedResults = -1;
				results.empty();
			});
		}
	});

});
