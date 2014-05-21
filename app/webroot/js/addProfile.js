var n = 2;
function addprofile() {

	$.ajax({
		url: '/Agamek/games/getgames/',
		dataType: 'text',
		success: function (data) {
			addProfile(data, n);
		},
		error: function() {
			alert('Error while getting list of the games. Please try again later.');
		}
	}) ;

}

function addProfile(data, num) {
	//alert(data);
	var form = '<div class="edit_profile">';
	var names = new Array();
	var ids = new Array();
	data = $.parseJSON(data);
	$.each(data, function(key, val) {
		$.each(val, function(key2, val2) {
			$.each(val2, function(key3, val3) {
				if (key3 == 'id') {
					ids.push(val3);
				}
				else if (key3 == 'name') {
					names.push(val3);
				}
			});
		});
	});
	form += '<div class="input text">' +
			'<label for="Profile'+num+'Pseudo"> Pseudo </label>' + 
			'<input type="text" name="data[Profile]['+num+'][Pseudo]" id="Profile'+num+'Pseudo"/>' +
			'</div>' +
			'<div class="input text">' +
			'<label for="Profile'+num+'Level"> Level </label>' + 
			'<input type="text" name="data[Profile]['+num+'][Level]" id="Profile'+num+'Level"/>' +
			'</div>' +  
			'<div class="input text">' +
			'<label for="Profile'+num+'game_id"> Game </label>' + 
			'<SELECT id="Profile'+num+'game_id" name="data[Profile]['+num+'][game_id]">';
			for (var i=0; i<names.length; i++) {
				form += '<option value="'+ids[i]+'">'+names[i]+'</option>';
			}

			form +='</SELECT></div></div>';

			$( "#edit_profiles" ).append(form);
			n++;
}