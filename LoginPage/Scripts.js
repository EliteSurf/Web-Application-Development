// JavaScript
var model_signin = document.getElementById('Index_Model_SignIn');
var model_signup = document.getElementById('Index_Model_SignUp');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == model_signin) {
        index_signin.style.display = "none";
    }

    if (event.target == model_signup) {
        index_signup.style.display = "none";
    }
}