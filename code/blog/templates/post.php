<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Le blog de l'AVBN</title>
    <link href="style.css" rel="stylesheet" />
</head>

<body>
    <h1>Le super blog de l'AVBN !</h1>
    <p><a href="index.php">Retour à la liste des billets</a></p>
    <div class="news">
        <h3>
            <?= htmlspecialchars($post['title']) ?>
            <em>le <?= $post['french_creation_date'] ?> </em>
        </h3>
        <p>
            <?= nl2br(htmlspecialchars($post['content'])) ?>
        </p>
    </div>
    <h2>Commentaires</h2>
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <p>
                <strong><?= htmlspecialchars($comment['author'], ENT_QUOTES, 'UTF-8') ?></strong>
                le <?= htmlspecialchars($comment['french_creation_date'], ENT_QUOTES, 'UTF-8') ?>
            </p>
            <p><?= nl2br(htmlspecialchars($comment['comment'], ENT_QUOTES, 'UTF-8')) ?></p>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun commentaire pour le moment.</p>
    <?php endif; ?>
</body>

</html>