//Check if logged in user and do stuff
//Make fields read-only

window.addEventListener('DOMContentLoaded', () => {
    checkLoggedInUser();
    makeReadOnlyFields();
});

function checkLoggedInUser () {
    if(document.body.classList.contains( 'logged-in' )) {
        console.log("yep, you're logged in");
        if(document.getElementById("register")) {
            document.getElementById("register").className = "register-hide";
        }
        if(document.getElementById("login")) {
            document.getElementById("login").className = "login-hide";
        }
        if(document.getElementById("register-message")) {
            document.getElementById("register-message").className = "register-hide";
        }
        if(document.getElementById("site-header")) {
            if(document.getElementById("units-bar")) {
                document.getElementById("site-header")
                .appendChild(document.getElementById("units-bar"));
            }
        }
     } else {
        if(document.getElementById("units-bar")) {
            document.getElementById("units-bar").className = "login-hide";
        }
    }
}

function makeReadOnlyFields () {
    if (document.querySelector('.gform_footer input[type="submit"]')) {
        jQuery(document).ready(function(){
            /* apply only to a input with a class of gf_readonly */
            jQuery("li.gf_readonly input").attr("readonly","readonly");
        });
    }
}