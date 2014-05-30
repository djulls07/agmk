$('document').ready(function() {
    var messagesNotif = $(".home_barre_bouton3 a");
    $.post( "/users/getusernotifs")
        .done(function( data ) {
        messagesNotif.html(data);
        if (data > 0) {
            $(".home_barre_bouton3").addClass('home_barre_boutons_plop');
        } else {
            $(".home_barre_bouton3").removeClass('home_barre_boutons_plop');
        }
    });
});