function valider() {
    let mail = document.getElementById("email").value;
    let pass = document.getElementById("password").value;

    if(mail == "") {
        alert("Mail required!!");
        return false;
    }

    if(pass == "") {
        alert("Password required!!");
        return false; 
    }

    return true; 
}
