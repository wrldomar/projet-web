<?php

include '../../Controller/ReclamationC.php';

$error = "";
$reclamation = null;
$reclamationC = new ReclamationC();
if (
    isset($_POST["id_rec"]) &&
    isset($_POST["sujet"]) &&
    isset($_POST["date"]) &&
    isset($_POST["description"])
    
) {
    if (
        !empty($_POST["id_rec"]) &&
        !empty($_POST['sujet']) &&
        !empty($_POST["date"]) &&
        !empty($_POST["description"])
        
    ) {
        $reclamation = new Reclamation(
            $_POST['id_rec'],
            $_POST['sujet'],
            new DateTime($_POST['date']),
            $_POST['description']
        );
        $reclamationC->updatereclamation($reclamation, $_POST["id_rec"]);
        header('Location:listreclamation.php');
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
        function verifiersujet() {
            var location = document.getElementById("sujet").value;
            var inputField = document.getElementById("sujet");

            // Check if input is empty
            if (location.length === 0) {
                inputField.classList.add('input-error');
                inputField.classList.remove('input-success');
                inputField.placeholder = "Location: Cannot be empty.";
                return false;
            } 
            // Check if input contains a number
            else if (/\d/.test(location)) {
                inputField.classList.add('input-error');
                inputField.classList.remove('input-success');
                inputField.placeholder = "Location: Must not contain numbers.";
                return false;
            } else {
                inputField.classList.remove('input-error');
                inputField.classList.add('input-success');
                inputField.placeholder = "";
                return true;
            }
        }
        function verifierdescription() {
            
            var valeur = document.getElementById("description").value.trim();
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
        function validateForm() {
            return (
                verifiersujet()
                
            );
        }
    </script>
</head>

<body>
    <hr>

    <div id="error">
        <?php echo $error; ?>
    </div>

    <?php
    if (isset($_POST['id_rec'])) {
        $reclamation = $reclamationC->showreclamation($_POST['id_rec']);

    ?>

        <form action="" method="POST" onsubmit="return validateForm();">
            <table border="1" align="center">
                <tr>
                    <td>
                        <label for="id_rec">Id reclamation:
                        </label>
                    </td>
                    <td><input type="number" name="id_rec" id="id_rec"  value="<?php echo $reclamation['id_rec']; ?>" ></td>
                </tr>
                <tr>
                    <td>
                        <label for="sujet">sujet:
                        </label>
                    </td>
                    <td><input type="text" name="sujet" id="sujet" onblur=" verifiersujet()" value="<?php echo $reclamation['sujet']; ?>" ></td>
                </tr>
                <tr>
                    <td>
                        <label for="date">date de réclamation:
                        </label>
                    </td>
                    <td>
                        <input type="date" name="date" id="date" value="<?php echo date('Y-m-d', strtotime($reclamation['date'])); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="description">description:
                        </label>
                    </td>
                    <td><input type="text" name="description" id="description" oninput=" verifierdescription()" value="<?php echo $reclamation['description']; ?>"></td>
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