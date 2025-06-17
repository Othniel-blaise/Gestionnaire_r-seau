<?php
require_once '../config/db.php';
require_once '../includes/header.php';

// Vérifie la présence de l’ID du projet
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

// Récupère les équipements liés à ce projet
$stmt = $pdo->prepare("SELECT * FROM Equipements WHERE projet_id = ?");
$stmt->execute([$projet_id]);
$equipements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Équipements – Projet : <?= htmlspecialchars($projet['nom']) ?></h2>
    <a href="ajouter.php?projet_id=<?= $projet_id ?>" class="btn btn-primary mb-3">+ Ajouter un équipement</a>
    <a href="modifier.php?projet_id=<?= $projet_id ?>" class="btn btn-sm btn-warning">Modifier</a>
    



    <?php if (count($equipements) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    
                    <th>Nom</th>
                    <th>Type</th>
                    <th>IP d’accès</th>
                    <th>Protocole</th>
                    <th>Port</th>
                    <th>Emplacement</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipements as $e): ?>
                    <tr>
                        <td><?= htmlspecialchars($e['nom']) ?></td>
                        <td><?= htmlspecialchars($e['type']) ?></td>
                        <td><code><?= $e['ip_acces'] ?></code></td>
                        <td><?= $e['protocole'] ?></td>
                        <td><?= $e['port'] ?></td>
                        <td><?= htmlspecialchars($e['emplacement']) ?></td>
                        <td><?= nl2br(htmlspecialchars($e['description'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun équipement enregistré pour ce projet.</p>
    <?php endif; ?>

    <a href="../projets/details.php?id=<?= $projet_id ?>" class="btn btn-secondary mt-3">⬅ Retour au projet</a>
</div>

<?php require_once '../includes/footer.php'; ?>
, 