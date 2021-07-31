<script>
$(document).ready(function(){
    setInterval(function(){
        $.ajax({
            url:'auto_notification_conDB.php',
            contentType: "application/json; charset=utf-8",
            success: function(e){
                //return notifyMe();
                if(e != ''){
                    
                    document.addEventListener('DOMContentLoaded', function () {
                     if (!Notification) {
                       alert('Desktop notifications not available in your browser. Try Chromium.'); 
                       return;
                     }

                     if (Notification.permission !== "granted")
                       Notification.requestPermission();
                   });

                   function notifyMe() {
                     if (Notification.permission !== "granted"){
                       Notification.requestPermission();
                    }else {
                        var txt = e.replace('~', ' \n \n ');
                        var b_txt = txt.replace('~', ' \n ');
                       var notification = new Notification('Paymentsystem (Digi)', {
                         icon: '',
                         body: b_txt
                       });

                            /*notification.onclick = function () {
                                window.open("http://paymentsystem.efi.net.ph/user-login/maker/index_new.php?branch=Pampanga");      
                            };*/
                        }
                    };
                    return notifyMe();
                }
            }
        });
    },60000);
});

</script>
