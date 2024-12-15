<?php

include '../../Controller/ReponseC.php';

$error = "";
$reponse = null;
$reponseC = new ReponseC();
if (
    isset($_POST["id_rep"]) &&
    isset($_POST["idrec"]) &&
    isset($_POST["reponse"]) &&
    isset($_POST["date_reponse"])
    
) {
    if (
        !empty($_POST["id_rep"]) &&
        !empty($_POST['idrec']) &&
        !empty($_POST["reponse"]) &&
        !empty($_POST["date_reponse"])
        
    ) {
        $reponse = new Reponse(
            $_POST['id_rep'],
            $_POST['idrec'],
            $_POST['reponse'],
            new DateTime($_POST['date_reponse'])
        );
        $reponseC->updatereponse($reponse, $_POST["id_rep"]);
        header('Location:dashindex.php');
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
    <hr>

    <div id="error">
        <?php echo $error; ?>
    </div>

    <?php
    if (isset($_POST['id_rep'])) {
        $reponse = $reponseC->showreponse($_POST['id_rep']);

    ?>

        <form action="" method="POST">
            <table border="1" align="center">
                <tr>
                    <td>
                        <label for="id_rep">Id reponse:
                        </label>
                    </td>
                    <td><input type="number" name="id_rep" id="id_rep" value="<?php echo $reponse['id_rep']; ?>" ></td>
                </tr>
                <tr>
                    <td>
                        <label for="idrec">id reclamation:
                        </label>
                    </td>
                    <td><input type="number" name="idrec" id="idrec" value="<?php echo $reponse['idrec']; ?>" ></td>
                </tr>
                <tr>
                    <td>
                        <label for="reponse">réponse:
                        </label>
                    </td>
                    <td><input type="text" name="reponse" id="reponse" oninput="verifierreponse()" value="<?php echo $reponse['reponse']; ?>"></td>
                </tr>
                <tr>
                    <td>
                        <label for="date_reponse">date de réponse:
                        </label>
                    </td>
                    <td>
                        <input type="date" name="date_reponse" id="date_reponse" value="<?php echo date('Y-m-d', strtotime($reponse['date_reponse'])); ?>">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Update">
                    </td>
                    <td>
                        <input type="reset" value="Reset">
                    </td>
                </tr>
            </table>
        </form>
    <?php
    }
    ?>
</body>

</html>