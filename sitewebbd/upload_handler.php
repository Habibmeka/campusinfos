<?php
// Démarrer la session pour vérifier l'authentification de l'utilisateur
session_start();

// Vérifier si l'utilisateur est connecté (redirection si non connecté)
if (!isset($_SESSION['utilisateurs'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'sitewebbd'); // Remplace 'nom_de_la_base' par le nom de ta base

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if (isset($_POST['ajouter'])) {
    // Récupérer les données du formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $fichier = $_FILES['fichier']['name'];
    $tmp_fichier = $_FILES['fichier']['tmp_name'];

    // Définir le répertoire où enregistrer le fichier
    $dossier = 'uploads/';
    // Générer le chemin complet du fichier
    $chemin_fichier = $dossier . basename($nom_fichier);

    // Déplacer le fichier uploadé dans le répertoire 'uploads'
    if (move_uploaded_file($tmp_fichier, $chemin_fichier)) {
        // Insérer les informations dans la base de données
        $sql = "INSERT INTO evenements (titre, description, fichier) VALUES ('$titre', '$description', '$chemin_fichier')";

        // Exécuter la requête
        if ($conn->query($sql) === TRUE) {
            echo "Les informations ont été ajoutées avec succès.";
        } else {
            echo "Erreur : " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Erreur lors de l'upload du fichier.";
    }
}

// Fermer la connexion
$conn->close();
?>
