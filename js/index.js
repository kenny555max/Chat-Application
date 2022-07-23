console.log("Live reload enabled!");

const showPassword = document.getElementById("showPassword");
const password = document.getElementById("password");

showPassword.addEventListener("click", e => {
    let element = e.target;
    
   if (password.type === "password") {
        element.className = "fa fa-eye-slash";
        password.type = "text";
    }else{
        element.className = "fa fa-eye";
       password.type = "password";
   }
});