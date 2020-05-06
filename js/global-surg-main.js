//Check if logged in user and do stuff

window.addEventListener('DOMContentLoaded', checkLoggedInUser);

function checkLoggedInUser () {
    if(document.body.classList.contains( 'logged-in' )) {
        console.log("yep, logged in");
        if(document.getElementById("register")) {
            document.getElementById("register").className = "register-hide";
        }
        if(document.getElementById("login")) {
            document.getElementById("login").className = "login-hide";
        }
        if(document.getElementById("register-message")) {
            document.getElementById("register-message").className = "register-hide";
        }
     } else {
          /* redirect */}
}
