<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'sitewebbd');

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Requête pour récupérer les événements
$sql = "SELECT titre, description, image FROM evenements";
$result = $conn->query($sql);

// Vérifier s'il y a des résultats
if ($result->num_rows > 0) {
    // Boucle pour afficher chaque événement
    while ($row = $result->fetch_assoc()) {
        echo "<h2>" . htmlspecialchars($row['titre']) . "</h2>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        
        // Afficher l'image si elle existe
        if (!empty($row['image'])) {
            echo "<img src='" . htmlspecialchars($row['image']) . "' alt='Image de l'événement' style='max-width:300px;'><br>";
        } else {
            echo "<p>Aucune image disponible pour cet événement.</p>";
        }
    }
} else {
    echo "Aucun événement trouvé.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
