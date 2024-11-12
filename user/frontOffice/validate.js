function verif(ch) {
    test = true;
    ch = ch.toUpperCase();
    for (let i = 0; i < ch.length; i++) {
        if (!(ch.charAt(i) >= "A" && ch.charAt(i) <= "Z") && ch.charAt(i) != " ") {
            test = false;
            break;
        }
    }
    return test;
}

function validate()
{

    let id = document.getElementById("id").value;
    let name1 = document.getElementById("nom").value;
    let name2 = document.getElementById("prenom").value;
    let date = document.getElementById("dateNaissance").value;
    let r1 = document.getElementById("r1").checked;
    let r2 = document.getElementById("r2").checked;
    let email = document.getElementById("email").value;
    let phone = document.getElementById("telephone").value;

    // Validate ID

    if(isNaN(id)){
        alert("ID must be a numeric value!!")
        return false;
    }

    // Validate Name

    if(verif(name1)==false){
        alert("Name should contain only letters!!")
        return false;
    }

    // Validate Last Name

    if(verif(name2)==false){
        alert("Last Name should contain only letters!!")
        return false;
    }

     // Validate Date of Birth
     if (date) {
        let dob = new Date(date)
        if (isNaN(dob.getTime())) {
            alert("Please enter a valid date!!");
            return false;
        }
        else {
            alert("Please enter your date of birth!!");
            return false;
        }
    
    }

    // Validate Type

    if (!r1 && !r2) {
        alert("Please select a type!!")
        return false;
    }

    // Validate Email
    p1 = email.indexOf("@")
    p2 = email.indexOf(".")
    if(p1 == -1 || p2 == -1 || p1>p2){
        alert("Please enter a valid email address!!")
        return false;
    }

    if(isNaN(phone)){
        alert("Please enter a valid phone number!!")
        return false;
    }

} 
