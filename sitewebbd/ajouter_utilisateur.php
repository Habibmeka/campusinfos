<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'sitewebbd'); // 
// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Les informations de l'utilisateur à insérer
$nom_utilisateur = ""; // Le nom d'utilisateur
$mot_de_passe = ""; // Le mot de passe

//  pour la sécurité Hasher le mot de passe
$mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

// Insérer les données dans la table
$sql = "INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe) VALUES ('$nom_utilisateur', '$mot_de_passe_hash')";

if ($conn->query($sql) === TRUE) {
    echo "Nouvel utilisateur ajouté avec succès.";
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
