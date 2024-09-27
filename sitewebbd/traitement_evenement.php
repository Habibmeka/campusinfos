<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'sitewebbd');

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Démarrer la session
session_start(); // Démarrer la session pour pouvoir gérer la déconnexion

// soumission duformulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];

    // Vérifier si un fichier image a été uploadé
    if (!empty($_FILES['image']['name'])) {
        // Chemin pour stocker l'image
        $dossier_images = 'uploads/';
        $nom_image = basename($_FILES['image']['name']);
        $chemin_image = $dossier_images . $nom_image;

        // Vérifier les erreurs de l'upload
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            // Gérer l'erreur ici
        } else {
            // Déplacer l'image uploadée dans le dossier "uploads"
            if (move_uploaded_file($_FILES['image']['tmp_name'], $chemin_image)) {
                echo "L'image a été téléversée avec succès.<br>";
            } else {
                echo "Erreur lors du déplacement de l'image.<br>";
            }
            
        }
    } else {
        $chemin_image = ""; // Pas d'image uploadée, insérer une chaîne vide
    }

    // Préparer la requête SQL pour insérer les données dans la table événements
    $sql = "INSERT INTO evenements (titre, description, image) VALUES (?, ?, ?)";
    
    // Préparer et exécuter la requête avec protection contre les injections SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $titre, $description, $chemin_image);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Message de succès
        echo '<div class="message success">L\'événement a été ajouté avec succès.</div>';
        echo '<a class="deconnexion" href="deconnexion.php">Se déconnecter</a>'; // Lien vers la page de déconnexion
    } else {
        echo '<div class="message error">Erreur : ' . $stmt->error . '</div>';
    }

    // Fermer la requête
    $stmt->close();
}

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'événement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* Couleur de fond */
            padding: 20px; /* Espacement interne */
        }
        .message {
            background-color: #fff; /* Couleur de fond du message */
            padding: 15px; /* Espacement interne */
            border-radius: 5px; /* Coins arrondis */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Ombre portée */
            margin: 20px 0; /* Marge autour du message */
            text-align: center; /* Centre le texte */
        }
        .success {
            border-left: 5px solid #4CAF50; /* Bord gauche pour le succès */
        }
        .error {
            border-left: 5px solid #f44336; /* Bord gauche pour l'erreur */
        }
        .deconnexion {
            display: inline-block; /* Pour rendre le lien un bloc */
            margin-top: 10px; /* Marge au-dessus du lien */
            padding: 10px 20px; /* Espacement interne du lien */
            background-color: #007BFF; /* Couleur de fond du lien */
            color: white; /* Couleur du texte */
            border-radius: 5px; /* Coins arrondis */
            text-decoration: none; /* Enlève le soulignement */
        }
        .deconnexion:hover {
            background-color: #0056b3; /* Couleur de fond au survol */
        }
    </style>
</head>
<body>
</body>
</html>
