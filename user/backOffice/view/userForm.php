<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User-form</title>
    <link rel="stylesheet" href="user.css">
    <script src="validate.js"></script>
</head>
<body>
    <div class="form-container">
        <h2>Registration Form</h2>
        <form action="../controller/UserController.php" method="POST" >
            <label for="id">ID</label>
            <input type="text" id="id" name="id">

            <label for="nom">Name</label>
            <input type="text" id="nom" name="nom">

            <label for="prenom">Last Name</label>
            <input type="text" id="prenom" name="prenom">

            <label for="dateNaissance">Date of Birth</label>
            <input type="date" id="dateNaissance" name="dateNaissance">

            <div class="radio-group">
                <label>Type</label>
                <label>
                    <input type="radio" id="r1" name="type" value="fermier"> Fermier
                </label>
                <label>
                    <input type="radio" id="r2" name="type" value="client"> Client
                </label>
            </div>

            <label for="email">Email</label>
            <input type="text" id="email" name="email">

            <label for="telephone">Phone</label>
            <input type="tel" id="telephone" name="telephone">

            <button type="submit" name="register">Register</button>
        </form>
    </div>
    <?php
    if (isset($_GET['success_message'])) {
    echo '<p>' . htmlspecialchars($_GET['success_message']) . '</p>';}
    ?>
</body>
</html>
