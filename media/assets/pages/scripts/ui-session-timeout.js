var SessionTimeout = function () {

    var handlesessionTimeout = function () {
        $.sessionTimeout({
            title: 'Session Timeout Notification',
            message: 'Your session is about to expire.',
            keepAliveUrl: '../demo/timeout-keep-alive.php',
            redirUrl: 'page_user_lock_1.html',
            logoutUrl: 'page_user_login_1.html',
            warnAfter: 3000, //warn after 300 seconds
            redirAfter: 60000, //redirect after 60 secons,
            countdownMessage: 'Redirecting in {timer} seconds.',
            countdownBar: true
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handlesessionTimeout();
        }
    };

}();

jQuery(document).ready(function() {    
   SessionTimeout.init();
});