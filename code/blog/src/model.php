<?php
function getPosts() {
    // Connexion BDD
    try {
        $dsn = 'mysql:host=127.0.0.1;port=3307;dbname=blog;charset=utf8';
        $database = new PDO($dsn, 'root', 'root', array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ));
    } catch (Exception $e) {
        // En dev : on stoppe (tu peux logger à la place)
        die('Erreur de connexion : ' . $e->getMessage());
    }

    // Requête
    $sql = "
      SELECT id, titre, contenu,
             DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS date_creation_fr
      FROM billets
      ORDER BY date_creation DESC
      LIMIT 0, 5
    ";
    $statement = $database->query($sql);

    // Construire les données pour la vue
    $posts = array();
    while ($row = $statement->fetch()) {
        $posts[] = array(
            'title'              => $row['titre'],
            'content'            => $row['contenu'],
            'frenchCreationDate' => $row['date_creation_fr'],
        );
    }
    $statement->closeCursor();

    return $posts;
}
