<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>Erreur - Le blog de l'AVBN</title>
  <link href="style.css" rel="stylesheet" />
  <style>
    .error-box {
      background: #ffe8e8;
      border: 1px solid #ffb3b3;
      padding: 16px;
      border-radius: 6px
    }

    .error-box h2 {
      margin: 0 0 8px 0;
      color: #b30000
    }
  </style>
</head>

<body>
  <h1>Le super blog de l'AVBN !</h1>

  <div class="error-box">
    <h2>Oups, une erreur est survenue</h2>
    <p><?= htmlspecialchars(isset($errorMessage) ? $errorMessage : 'Erreur inconnue', ENT_QUOTES, 'UTF-8') ?></p>
  </div>

  <p>
    <a href="/mvc-php/code/blog/index.php?action=listPosts">← Retour à la liste des billets</a>
  </p>

</html>