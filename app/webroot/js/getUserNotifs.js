$('document').ready(function() {

    var messagesNotif = $(".home_barre_bouton3 a");
    var notifsNotif = $( ".home_barre_bouton2 a" );
    var home3 = $(".home_barre_bouton3");
    var home2 = $(".home_barre_bouton2");
    var messages = 0;
    var notifications = 0;

    function loop() {
        $.post( "/users/getusernotifs").done(function( data ) {
            //alert(data); return;
            data = $.parseJSON(data);
            if (messages == data.User.messages && notifications == data.User.notifications) {
                return;
            }
            if (data.User.messages != messages) {
                messages = data.User.messages;
                if (data.User.messages > 0) {
                    home3.addClass('home_barre_boutons_plop');
                } else {
                    home3.removeClass('home_barre_boutons_plop');
                }
            }
            if (data.User.notifications != notifications) {
                notifications = data.User.notifications;
                if (data.User.notifications > 0) {
                    home2.addClass('home_barre_boutons_plop');
                } else {
                    home2.removeClass('home_barre_boutons_plop');
                }
            }
        });
    }
    loop();
    setInterval(loop, 10000);
});