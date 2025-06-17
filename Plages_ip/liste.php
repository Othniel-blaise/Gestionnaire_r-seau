<?php
require_once '../config/db.php';
require_once '../includes/header.php';

// Vérifie que le projet_id est fourni
if (!isset($_GET['projet_id']) || empty($_GET['projet_id'])) {
    echo "<div class='container mt-4'><p class='alert alert-danger'>Projet non spécifié.</p></div>";
    require_once '../includes/footer.php';
    exit;
}

$projet_id = $_GET['projet_id'];

// Récupère le nom du projet
$stmtProjet = $pdo->prepare("SELECT nom FROM Projets WHERE id = ?");
$stmtProjet->execute([$projet_id]);
$projet = $stmtProjet->fetch(PDO::FETCH_ASSOC);

// Récupère les plages IP
$stmt = $pdo->prepare("SELECT * FROM Plages_Adresses WHERE projet_id = ?");
$stmt->execute([$projet_id]);
$plages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Plages d'adresses IP – Projet : <?= htmlspecialchars($projet['nom']) ?></h2>
    <a href="ajouter.php?projet_id=<?= $projet_id ?>" class="btn btn-primary mb-3">+ Ajouter une plage IP</a>

    <?php if (count($plages) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Plage IP</th>
                    <th>Passerelle</th>
                    <th>Masque</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plages as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['type_reseau']) ?></td>
                        <td><code><?= htmlspecialchars($p['plage_ip']) ?></code></td>
                        <td><code><?= htmlspecialchars($p['passerelle']) ?></code></td>
                        <td><?= htmlspecialchars($p['masque']) ?></td>
                        <td><?= nl2br(htmlspecialchars($p['description'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune plage IP enregistrée pour ce projet.</p>
    <?php endif; ?>

    <a href="../projets/details.php?id=<?= $projet_id ?>" class="btn btn-secondary mt-3">⬅ Retour au projet</a>
</div>

<?php require_once '../includes/footer.php'; ?>
