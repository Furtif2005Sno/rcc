<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Change si nécessaire
$password = "";     // Change si nécessaire
$dbname = "RCC-Cars";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier si l'ID de la voiture est passé en paramètre
if (!isset($_GET['id'])) {
    die("ID de voiture manquant.");
}

$voiture_id = intval($_GET['id']);

// Récupérer les informations de la voiture
$sql_voiture = "SELECT * FROM voitures WHERE id = $voiture_id";
$result_voiture = $conn->query($sql_voiture);

if ($result_voiture->num_rows === 0) {
    die("Voiture non trouvée.");
}

$voiture = $result_voiture->fetch_assoc();

// Récupérer les caractéristiques
$sql_caracteristiques = "SELECT nom, valeur FROM caracteristiques_voitures WHERE voiture_id = $voiture_id";
$result_caracteristiques = $conn->query($sql_caracteristiques);

// Récupérer les photos
$sql_photos = "SELECT url FROM photos_voitures WHERE voiture_id = $voiture_id";
$result_photos = $conn->query($sql_photos);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Détails de la voiture</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
<main id="main">
  <section id="portfolio-details" class="portfolio-details">
    <div class="container">
      <div class="row gy-4">
        <!-- Section Carrousel -->
        <div class="col-lg-8">
          <div class="portfolio-details-slider swiper">
            <div class="swiper-wrapper align-items-center">
              <?php while ($photo = $result_photos->fetch_assoc()): ?>
                <div class="swiper-slide">
                  <img src="<?= htmlspecialchars($photo['url']) ?>" alt="Photo de la voiture">
                </div>
              <?php endwhile; ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>

        <!-- Section Informations -->
        <div class="col-lg-4">
          <div class="portfolio-info">
            <h3><?= htmlspecialchars($voiture['marque'] . " " . $voiture['modele']) ?></h3>
            <ul>
              <li><strong>Prix</strong>: <?= number_format($voiture['prix'], 2, ',', ' ') ?> €</li>
              <li><strong>Chevaux</strong>: <?= $voiture['chevaux'] ?> ch</li>
              <li><strong>Couple</strong>: <?= $voiture['couple'] ?> Nm</li>
              <li><strong>Nombre de cylindres</strong>: <?= $voiture['nb_cylindres'] ?></li>
              <?php while ($caracteristique = $result_caracteristiques->fetch_assoc()): ?>
                <li><strong><?= htmlspecialchars($caracteristique['nom']) ?></strong>: <?= htmlspecialchars($caracteristique['valeur']) ?></li>
              <?php endwhile; ?>
            </ul>
          </div>
          <div class="portfolio-description">
            <h2>À propos de cette voiture</h2>
            <p>Voici toutes les informations disponibles sur ce modèle.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script>
  const swiper = new Swiper('.swiper', {
    loop: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
  });
</script>
</body>
</html>

<?php
$conn->close();
?>
