<?php /** @var \App\Model\Comment $comment */ ?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Modifier le commentaire #<?= htmlspecialchars((string) $comment->id) ?></title>
</head>

<body>
    <h1>Modifier le commentaire</h1>
    <p>Créé le : <?= htmlspecialchars($comment->frenchCreationDate) ?></p>

    <form action="index.php?action=updateComment" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $comment->id) ?>">
        <div>
            <label>Auteur</label><br>
            <input type="text" name="author" value="<?= htmlspecialchars($comment->author) ?>" required>
        </div>
        <div>
            <label>Commentaire</label><br>
            <textarea name="comment" rows="6" required><?= htmlspecialchars($comment->comment) ?></textarea>
        </div>
        <button type="submit">Enregistrer</button>
        <a href="index.php?action=post&id=<?= htmlspecialchars((string) $comment->postId) ?>">Annuler</a>
    </form>
</body>

</html>