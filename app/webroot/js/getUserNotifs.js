$('document').ready(function() {

    var messagesNotif = $(".home_barre_bouton3 a");
    var notifsNotif = $( ".home_barre_bouton2 a" );
    var home3 = $(".home_barre_bouton3");
    var home2 = $(".home_barre_bouton2");
    var messages = -1;
    var notifications = -1;

    function loop() {
        $.post( "/users/getusernotifs").done(function( data ) {
            //alert(data); return;
            data = $.parseJSON(data);
            if (messages == data.User.messages && notifications == data.User.notifications) {
                return;
            }
            if (data.User.messages != messages) {
                messages = data.User.messages;
                messagesNotif.html(messages);
                if (data.User.messages > 0) {
                    home3.addClass('home_barre_boutons_plop');
					home3.addClass('home_barre_boutons_plop_mail');
                } else {
                    home3.removeClass('home_barre_boutons_plop');
					home3.removeClass('home_barre_boutons_plop_mail');
                }
            }
            if (data.User.notifications != notifications) {
                notifications = data.User.notifications;
                notifsNotif.html(notifications);
                if (data.User.notifications > 0) {
                    home2.addClass('home_barre_boutons_plop');
					home2.addClass('home_barre_boutons_plop_notif');
                } else {
                    home2.removeClass('home_barre_boutons_plop');
					home2.removeClass('home_barre_boutons_plop_notif');
                }
            }
        });
    }
    loop();
    setInterval(loop, 10000);
});