<?php
require_once '../config/db.php';
require_once '../includes/header.php';

// Vérifie si l'ID du projet est présent
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='container mt-4'><p class='alert alert-danger'>Projet introuvable.</p></div>";
    require_once '../includes/footer.php';
    exit;
}

$projet_id = $_GET['id'];

// Récupération des infos du projet
$stmt = $pdo->prepare("SELECT p.*, u.nom AS chef FROM Projets p
                       LEFT JOIN Utilisateurs u ON p.chef_projet_id = u.id
                       WHERE p.id = ?");
$stmt->execute([$projet_id]);
$projet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$projet) {
    echo "<div class='container mt-4'><p class='alert alert-danger'>Projet introuvable.</p></div>";
    require_once '../includes/footer.php';
    exit;
}
?>

<div class="container mt-5">
    <h2>Détails du projet : <?= htmlspecialchars($projet['nom']) ?></h2>
    <p><strong>Client :</strong> <?= htmlspecialchars($projet['client']) ?></p>
    <p><strong>Chef de projet :</strong> <?= htmlspecialchars($projet['chef']) ?></p>
    <p><strong>Date de début :</strong> <?= htmlspecialchars($projet['date_debut']) ?></p>
    <p><strong>Statut :</strong> <span class="badge bg-info"><?= $projet['statut'] ?></span></p>
    <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($projet['description'])) ?></p>

    <hr>

    <h4>Modules liés</h4>
    <ul>
        <li><a href="../equipements/liste.php?projet_id=<?= $projet['id'] ?>">📦 Équipements réseau</a></li>
        <li><a href="../plages_ip/liste.php?projet_id=<?= $projet['id'] ?>">🌐 Plages IP</a></li>
        <li><a href="../taches/ajouter.php?projet_id=<?= $projet['id'] ?>">✅ Tâches</a></li>
        <li><a href="../documents/liste.php?projet_id=<?= $projet['id'] ?>">📁 Documents & fichiers</a></li>
        <li><a href="../commentaires/liste.php?projet_id=<?= $projet['id'] ?>">💬 Commentaires / Journal</a></li>
    </ul>

    <a href="../index.php" class="btn btn-secondary mt-3">⬅ Retour au tableau de bord</a>
</div>

<?php require_once '../includes/footer.php'; ?>
