$(document).ready(function() {
  var id = 3;
  var sc2Pseudo = $( "#Profile"+id+'Pseudo' );
  var sc2Id = $(  "#sc2Id" );
  var sc2Region = $ ( "#Profile"+id+"Region" );
  var sc2Level = $( "#Profile"+id+"Level" );

  sc2Pseudo.change(function() {
      majSc2();
  });
    sc2Id.change(function() {
      majSc2();
  });
    sc2Region.change(function() {
      majSc2();
  });

  function majSc2() {
    if (sc2Pseudo.val() == '' || sc2Id.val() == '' || sc2Region.val() == '' ) {
      return;
    }
    sc2Level.val('Loading data');
    $.ajax({
        url: '/profiles/checkSc2',
        type: 'POST',
        data: {'region' : sc2Region.val(), 'id' : sc2Id.val(), 'name' : sc2Pseudo.val()},
        success: function (data) {
          data = $.parseJSON(data);
          if (data.status == 'nok') {
            alert(data.message);
            return;
          }
          sc2Level.val(data.career.highest1v1Rank);
        },
        error: function() {sc2Level.val("Cant get your level with the informations you give")
        },
         datatype: 'json'
     });
  }


	var lolId = 2;
  var lolPseudo = $( "#Profile"+lolId+"Pseudo" );
  var lolLevel = $(  "#Profile"+lolId+"Level" );
  var lolRegion = $( "#Profile"+lolId+"Region" );
  var summonerId = -1;

  lolPseudo.change(function() {
    majLol();
  });

  function majLol() {
    if (lolPseudo.val() == '') {
      return;
    }
    lolLevel.val('Loading...');
    $.ajax({
      url: "https://prod.api.pvp.net/api/lol/"+lolRegion.val()+"/v1.4/summoner/by-name/"+lolPseudo.val()+"?api_key=fe8ad5ae-034e-43eb-944f-83ac6cccc1a1",
      type: 'GET',
      success: function (data, status) {
        $.each(data, function(index, val) {
          //on prend que le first.
          summonerId = val.id;
          $.get('https://prod.api.pvp.net/api/lol/'+lolRegion.val()+'/v2.4/league/by-summoner/'+summonerId+'?api_key=fe8ad5ae-034e-43eb-944f-83ac6cccc1a1')
            .done(function (data) {
              $.each(data, function (index, val){
                $.each(val, function (i, v) {
                  if (v.queue == "RANKED_SOLO_5x5")
                    lolLevel.val(v.tier);
                });
              });
            });
        });
      },
      error: function() {lolLevel.val("Cant get your level with the informations you give")
      },
       datatype: 'json'
    });


    /*$.get( "https://prod.api.pvp.net/api/lol/"+lolRegion.val()+"/v1.4/summoner/by-name/"+lolPseudo.val()+"?api_key=fe8ad5ae-034e-43eb-944f-83ac6cccc1a1", function( data ) {
      $.each(data, function(index, val) {
        //on prend que le first.
        summonerId = val.id;
      });      
    });*/
  }	

});