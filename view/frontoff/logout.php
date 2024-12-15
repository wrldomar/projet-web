<?php
// Démarrer ou récupérer la session existante
session_start();

// Détruire toutes les variables de session
$_SESSION = [];

// Détruire le cookie de session s'il existe
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Afficher l'alerte et rediriger via JavaScript
echo '<script>
    alert("You have disconnected from your account");
    window.location.href = "home.html";
</script>';
exit();
?>
