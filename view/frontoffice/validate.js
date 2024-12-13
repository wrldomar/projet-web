function verif(ch) {
    test = true;
    ch = ch.toUpperCase();
    for (let i = 0; i < ch.length; i++) {
        if (!(ch.charAt(i) >= "A" && ch.charAt(i) <= "Z")) {
            test = false;
            break;
        }
    }
    return test;
}

function verif2(ch) {
    test = true;
    ch = ch.toUpperCase();
    for (let i = 0; i < ch.length; i++) {
        if (!(ch.charAt(i) >= "A" && ch.charAt(i) <= "Z") && 
            !(ch.charAt(i) >= "0" && ch.charAt(i) <= "9")) {
            test = false;
            break;
        }
    }
    return test;
}

function validate() {
    let id = document.getElementById("id").value.trim();
    if (id === '' || isNaN(id)) {
        alert("ID must be a numeric value!!");
        return false;
    }

    let name1 = document.getElementById("nom").value;
    if (verif(name1) === false) {
        alert("Name should contain only letters!!");
        return false;
    }

    let name2 = document.getElementById("prenom").value;
    if (verif(name2) === false) {
        alert("Last Name should contain only letters!!");
        return false;
    }

    let r1 = document.getElementById("r1").checked;
    let r2 = document.getElementById("r2").checked;
    if (!r1 && !r2) {
        alert("Please select a type!!");
        return false;
    }

    let email = document.getElementById("email").value;
    p1 = email.indexOf("@");
    p2 = email.lastIndexOf(".");
    if (p1 == -1 || p2 == -1 || p1 > p2 || p2 - p1 < 2 || email.slice(p2 + 1).length < 2) {
        alert("Please enter a valid email address!!");
        return false;
    }

    let phone = document.getElementById("telephone").value;
    let phoneWithoutSpaces = phone.replace(/\s+/g, '');
    if (phoneWithoutSpaces === '' || !/^\+?[0-9]+$/.test(phoneWithoutSpaces)) {
        alert("Please enter a valid phone number!!");
        return false;
    }

    let pass = document.getElementById("pass").value;
    let conf = document.getElementById("conf").value;
    
    if (verif2(pass) === false) {
        alert("Invalid password!!");
        return false;
    }

    if (pass != conf) {
        alert("Check your password!!");
        return false;
    }

    return true;
}
