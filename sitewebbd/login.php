<?php
session_start();

// Vérification des messages d'erreur
$error_message = '';
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Supprime le message d'erreur après l'affichage
}

// Traitement de la connexion
if (isset($_POST['login'])) {
    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'sitewebbd');

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Requête pour vérifier si l'utilisateur existe
    $sql = "SELECT * FROM utilisateurs WHERE nom_utilisateur='$nom_utilisateur'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // L'utilisateur existe
        $row = $result->fetch_assoc();
        if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
            // Mot de passe correct, démarre la session
            $_SESSION['utilisateur'] = $nom_utilisateur;
            header("Location: ajouter_evenement.php"); // page de gestion des événements
            exit();
        } else {
            // Mot de passe incorrect, définir le message d'erreur
            $_SESSION['error_message'] = "Mot de passe incorrect.";
            header("Location: login.php"); // Renvoyer à la page de connexion
            exit();
        }
    } else {
        // Utilisateur non trouvé
        $_SESSION['error_message'] = "Utilisateur non trouvé.";
        header("Location: login.php"); // Renvoyer à la page de connexion
        exit();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><h1>Connexion</h1></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Couleur de fond douce */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Prend toute la hauteur de la fenêtre */
            margin: 0; /* Supprime les marges */
        }

        h1 {
            color: #333; /* Couleur du titre */
        }

        form {
            background-color: white; /* Fond blanc pour le formulaire */
            padding: 20px; /* Espacement interne */
            border-radius: 8px; /* Coins arrondis */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Ombre portée */
        }

        label {
            display: block; /* Affiche chaque label sur une nouvelle ligne */
            margin-bottom: 5px; /* Marge en bas des labels */
            color: #555; /* Couleur des labels */
        }

        input[type="text"], input[type="password"] {
            width: 100%; /* Prend toute la largeur du formulaire */
            padding: 10px; /* Espacement interne */
            margin-bottom: 15px; /* Marge en bas des champs */
            border: 1px solid #ccc; /* Bord gris clair */
            border-radius: 4px; /* Coins arrondis */
            box-sizing: border-box; /* Inclut le padding dans la largeur */
        }

        input[type="submit"] {
            background-color: #007BFF; /* Couleur de fond du bouton */
            color: white; /* Couleur du texte du bouton */
            border: none; /* Pas de bordure */
            padding: 10px; /* Espacement interne */
            border-radius: 4px; /* Coins arrondis */
            cursor: pointer; /* Curseur de main */
            transition: background-color 0.3s; /* Transition pour le survol */
        }

        input[type="submit"]:hover {
            background-color: #0056b3; /* Couleur de fond au survol */
        }

        p {
            color: red; /* Couleur du texte des messages d'erreur */
            text-align: center; /* Centre le message d'erreur */
        }
    </style>
</head>
<body>

<title><h1>Connexion</h1></title>
    <form method="post" action="login.php">
        <label for="nom_utilisateur">Nom d'utilisateur:</label>
        <input type="text" name="nom_utilisateur" required>

        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" name="mot_de_passe" required>

        <input type="submit" name="login" value="Connexion">
    </form>

    <!-- Affichage du message d'erreur -->
    <?php if (!empty($error_message)): ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
</body>
</html>
