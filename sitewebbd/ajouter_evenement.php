<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header("Location: login.php"); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    exit();
}

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'sitewebbd'); // Remplace 'nom_de_la_base' par le nom de ta base

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Traitement du formulaire pour ajouter un événement
if (isset($_POST['ajouter'])) {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_event = $_POST['date_event'];
    $image_nom = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    // Définir le chemin pour stocker l'image
    $dossier = 'uploads/';
    $chemin_image = $dossier . basename($image_nom);

    // Déplacer l'image uploadée dans le dossier
    if (move_uploaded_file($image_tmp, $chemin_image)) {
        // Insérer les données dans la base
        $sql = "INSERT INTO evenements (titre, description, image, date_event) VALUES ('$titre', '$description', '$chemin_image', '$date_event')";

        if ($conn->query($sql) === TRUE) {
            echo "Événement ajouté avec succès.";
        } else {
            echo "Erreur : " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Erreur lors de l'upload de l'image.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un événement</title>
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
        form {
            background-color: white; /* Couleur de fond du formulaire */
            padding: 20px; /* Espacement interne */
            border-radius: 5px; /* Coins arrondis */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Ombre portée */
            width: 600px; /* Largeur du formulaire */
        }
        h2 {
            text-align: center; /* Centre le titre */
        }
        input[type="text"], input[type="date"], input[type="file"], textarea {
            width: 100%; /* Prend toute la largeur du formulaire */
            padding: 10px; /* Espacement interne */
            margin: 10px 0; /* Marge verticale */
            border: 1px solid #ccc; /* Bordure */
            border-radius: 5px; /* Coins arrondis */
        }
        input[type="submit"] {
            background-color: #007BFF; /* Couleur de fond du bouton */
            color: white; /* Couleur du texte */
            border: none; /* Enlève la bordure */
            padding: 10px; /* Espacement interne */
            border-radius: 5px; /* Coins arrondis */
            cursor: pointer; /* Curseur pointer */
            width: 100%; /* Prend toute la largeur du formulaire */
        }
        input[type="submit"]:hover {
            background-color: #0056b3; /* Couleur de fond au survol */
        }
    </style>
</head>
<body>
    <form action="traitement_evenement.php" method="post" enctype="multipart/form-data">
        <h2>Ajouter un événement</h2>
        <label for="titre">Titre de l'événement :</label>
        <input type="text" id="titre" name="titre" required><br>
        
        <label for="description">Description de l'événement :</label>
<textarea id="description" name="description" required rows="10" cols="50"></textarea><br>

        <label for="date">Date de l'événement :</label>
        <input type="date" name="date_event" required><br>
        
        <label for="image">Image (optionnel) :</label>
        <input type="file" id="image" name="image" accept="image/*"><br>
        
        <input type="submit" name="ajouter" value="Ajouter l'événement">
    </form>
</body>
</html>
