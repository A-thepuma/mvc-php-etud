<?php
// Connexion à la base de données
try {
    $dsn = 'mysql:host=127.0.0.1;port=3307;dbname=blog;charset=utf8';
    $database = new PDO($dsn, 'root', 'root', [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ]);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// On récupère les 5 derniers billets
$sql = "
  SELECT id, titre, contenu,
         DATE_FORMAT(date_creation, '%d/%m/%Y à %Hh%imin%ss') AS date_creation_fr
  FROM billets
  ORDER BY date_creation DESC
  LIMIT 0, 5
";
$statement = $database->query($sql);

$posts = [];
while ($row = $statement->fetch()) {
    $posts[] = [
        'title'              => $row['titre'],
        'content'            => $row['contenu'],
        'frenchCreationDate' => $row['date_creation_fr'],
    ];
}
$statement->closeCursor();

// Appel du template 
require_once __DIR__ . '/templates/homepage.php';
