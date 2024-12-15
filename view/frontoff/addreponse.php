<?php

include '../../Controller/ReponseC.php';

$error = "";


$reponse = null;


$reponseC = new ReponseC();
if (
    isset($_POST["idrec"]) &&
    isset($_POST["reponse"]) &&
    isset($_POST["date_reponse"]) 
   
) {
    if (
        !empty($_POST['idrec']) &&
        !empty($_POST["reponse"]) &&
        !empty($_POST["date_reponse"]) 

    ) {
        $reponse = new Reponse(
            null,
            $_POST['idrec'],
            $_POST['reponse'],
            new DateTime($_POST['date_reponse'])
        );
        $reponseC->addreponse($reponse);
        header('Location:../backoff/listreclamation.php');
    } else
        $error = "Missing information";
}


?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Display</title>
    <script>
        function verifierreponse() {
            var valeur = document.getElementById("reponse").value.trim();
            var messageElement = document.getElementById("error");

            // Check if the input contains only alphabetic characters or spaces
            if (!/^[a-zA-Z\s]+$/.test(valeur)) {
                messageElement.innerHTML = "Please type a character.";
                messageElement.style.color = "red"; // Set color to red for invalid input
                return false;
            } else {
                messageElement.innerHTML = "acceptable"; // Clear the error message if valid
                messageElement.style.color = "green";
                return true;
            }
        }
        
    </script>
</head>

<body>
    <a href="../backoff/dashboard.html">Back to list </a>
    <hr>

    <div id="error">
        <?php echo $error; ?>
    </div>

    <form action="" method="POST">
        <table border="1" align="center">
        <tr>
                <td>
                    <label for="idrec">id de reclamation:
                    </label>
                </td>
                <td>
                    <input type="number" name="idrec" id="idrec">
                </td>
            </tr>

            <tr>
                <td>
                    <label for="reponse">répondre:
                    </label>
                </td>
                <td><input type="text" name="reponse" id="reponse" oninput="verifierreponse()" ></td>
            </tr>
            <tr>
                <td>
                    <label for="date_reponse">date du réponse:
                    </label>
                </td>
                <td><input type="date" name="date_reponse" id="date_reponse" ></td>
            </tr>
            <tr align="center">
                <td>
                    <input type="submit" value="Save">
                </td>
                <td>
                    <input type="reset" value="Reset">
                </td>
            </tr>
        </table>
    </form>
</body>

</html>