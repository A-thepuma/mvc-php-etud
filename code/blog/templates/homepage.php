<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <title>Le blog de l'AVBN</title>
  <link href="style.css" rel="stylesheet" />
</head>
<body>
  <h1>Le super blog de l'AVBN !</h1>
  <p>Derniers billets du blog :</p>

  <?php foreach ($posts as $post): ?>
    <div class="news">
      <h3>
        <?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>
        <em>le <?= htmlspecialchars($post['frenchCreationDate'], ENT_QUOTES, 'UTF-8') ?></em>
      </h3>
      <p>
        <?= nl2br(htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8')) ?>
        <br />
        <em><a href="#">Commentaires</a></em>
      </p>
    </div>
    <hr>
  <?php endforeach; ?>
</body>
</html>
