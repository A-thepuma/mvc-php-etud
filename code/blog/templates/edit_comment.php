<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Modifier le commentaire</title>
  <link href="style.css" rel="stylesheet" />
</head>
<body>
  <h1>Modifier le commentaire</h1>

  <form method="post" action="index.php?action=updateComment">
    <input type="hidden" name="id" value="<?= (int)$comment->id ?>">
    <input type="hidden" name="post_id" value="<?= (int)$comment->postId ?>">

    <p>
      <label>Auteur<br>
        <input type="text" name="author" value="<?= htmlspecialchars($comment->author, ENT_QUOTES, 'UTF-8') ?>">
      </label>
    </p>
    <p>
      <label>Commentaire<br>
        <textarea name="comment" rows="6" cols="60"><?= htmlspecialchars($comment->comment, ENT_QUOTES, 'UTF-8') ?></textarea>
      </label>
    </p>

    <p>
      <button type="submit">Enregistrer</button>
      <a href="index.php?action=post&id=<?= (int)$comment->postId ?>">Annuler</a>
    </p>
  </form>
</body>
</html>
