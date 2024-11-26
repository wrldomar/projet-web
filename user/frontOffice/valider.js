function valider()

{
    let name1 = document.getElementById("n1").value;
    let name2 = document.getElementById("n2").value;
    if(name1 == "")
    {
        alert("First Name required!!")
        return false
    }
    if(name2 == "")
    {
        alert("Last Name required!!")
        return false
     }

}
