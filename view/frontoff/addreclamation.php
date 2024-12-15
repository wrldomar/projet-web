<?php

include '../../Controller/ReclamationC.php';

$error = "";
$reclamation = null;
$reclamationC = new ReclamationC();

if (
    isset($_POST["sujet"]) &&
    isset($_POST["date"]) &&
    isset($_POST["description"]) 
   
) {
    if (
        !empty($_POST['sujet']) &&
        !empty($_POST["date"]) &&
        !empty($_POST["description"]) 
    ) {
        $reclamation = new Reclamation(
            null,
            $_POST['sujet'],
            new DateTime($_POST['date']),
            $_POST['description']
        );
        $reclamationC->addreclamation($reclamation);
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
    
    <!-- Embedding CSS styles -->
    <style>
        /* General Body Style */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8f0; /* Light greenish background */
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Header and Title Styling */
        h1 {
            text-align: center;
            color: #4CAF50; /* Green color for agricultural theme */
            font-size: 2em;
            margin-top: 50px;
        }

        /* Table and Form Styling */
        table {
            width: 60%;
            margin: 50px auto;
            border-collapse: collapse;
            background-color: #fff;
            border: 1px solid #4CAF50;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table td {
            padding: 10px;
            font-size: 1em;
        }

        table th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: left;
        }

        input[type="text"], input[type="date"], textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #4CAF50;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 1em;
        }

        input[type="submit"], input[type="reset"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 1.1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        label {
            font-weight: bold;
            color: #333;
        }

        /* Error Message Styling */
        #error {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.2em;
            color: red;
        }

        /* Success message for validation */
        #success {
            color: green;
            text-align: center;
        }

        /* Back link Styling */
        a {
            color: #4CAF50;
            text-decoration: none;
            font-size: 1.2em;
            padding-left: 20px;
            display: inline-block;
            margin-top: 20px;
        }

        a:hover {
            color: #45a049; /* Darker green on hover */
        }

        /* Input Validation Message Styling */
        #error {
            color: red;
            font-size: 0.9em;
            text-align: center;
        }
    </style>

    <script>
         function verifierAlphabetique() {
            var valeur = document.getElementById("sujet").value.trim();
            var messageElement = document.getElementById("error");

            // Check if the input contains only alphabetic characters or spaces
            if (!/^[a-zA-Z\s]+$/.test(valeur)) {
                messageElement.innerHTML = "Please type a character.";
                messageElement.style.color = "red"; // Set color to red for invalid input
                return false;
            } else {
                messageElement.innerHTML = "acceptable"; // Clear the error message if valid
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
    </script>
    
</head>

<body>
    <a href="dashboard.html">Back to list </a>
    <hr>

    <div id="error">
        <?php echo $error; ?>
    </div>

    <form action="" method="POST" >
        <table border="1" align="center">
            <tr>
                <td>
                    <label for="sujet">Sujet:</label>
                </td>
                <td>
                    <input type="text" name="sujet" id="sujet" oninput="verifierAlphabetique()">
                </td>
            </tr>

            <tr>
                <td>
                    <label for="date">Date:</label>
                </td>
                <td><input type="date" name="date" id="date" ></td>
            </tr>

            <tr>
                <td>
                    <label for="description">Description:</label>
                </td>
                <td><input type="text" name="description" id="description" oninput="verifierdescription()" ></td>
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
