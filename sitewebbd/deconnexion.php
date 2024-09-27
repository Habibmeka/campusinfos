<?php
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Détruire complètement la session
session_destroy();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Déconnexion</title>
    <style>
        body {
            display: flex;
            justify-content: center; /* Centre horizontalement */
            align-items: center; /* Centre verticalement */
            height: 100vh; /* Prend toute la hauteur de la fenêtre */
            margin: 0; /* Enlève la marge par défaut */
            font-family: Arial, sans-serif; /* Police de caractères */
            background-color: #f0f0f0; /* Couleur de fond */
        }
        .message {
            text-align: center; /* Centre le texte */
            background-color: white; /* Couleur de fond du message */
            padding: 20px; /* Espacement interne */
            border-radius: 5px; /* Coins arrondis */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Ombre portée */
        }
        a {
            display: inline-block; /* Pour rendre le lien un bloc */
            margin-top: 10px; /* Marge au-dessus du lien */
            padding: 10px 20px; /* Espacement interne du lien */
            background-color: #007BFF; /* Couleur de fond du lien */
            color: white; 
            border-radius: 5px; 
            text-decoration: none; 
        }
        a:hover {
            background-color: #0056b3; 
        }
    </style>
</head>
<body>
    <div class="message">
        <h2>Vous êtes déconnecté</h2>
        <p>Merci d'avoir utilisé notre service.</p>
        <a href="page_connexion.html">Se connecter à nouveau</a>
    </div>
</body>
</html>
