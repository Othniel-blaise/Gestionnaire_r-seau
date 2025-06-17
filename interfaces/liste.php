<?php
require_once '../config/db.php';
require_once '../includes/header.php';

// Vérifie que l'ID de l'équipement est fourni
if (!isset($_GET['equipement_id']) || empty($_GET['equipement_id'])) {
    echo "<div class='container mt-4'><p class='alert alert-danger'>Équipement non spécifié.</p></div>";
    require_once '../includes/footer.php';
    exit;
}

$equipement_id = $_GET['equipement_id'];

// Récupère les infos de l’équipement
$stmtEquipement = $pdo->prepare("SELECT e.*, p.nom AS nom_projet FROM Equipements e
                                 JOIN Projets p ON e.projet_id = p.id
                                 WHERE e.id = ?");
$stmtEquipement->execute([$equipement_id]);
$equipement = $stmtEquipement->fetch(PDO::FETCH_ASSOC);

if (!$equipement) {
    echo "<div class='container mt-4'><p class='alert alert-danger'>Équipement introuvable.</p></div>";
    require_once '../includes/footer.php';
    exit;
}

// Récupère les interfaces liées à cet équipement
$stmt = $pdo->prepare("SELECT * FROM Interfaces WHERE equipement_id = ?");
$stmt->execute([$equipement_id]);
$interfaces = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Interfaces – <?= htmlspecialchars($equipement['nom']) ?> (Projet : <?= htmlspecialchars($equipement['nom_projet']) ?>)</h2>
    <a href="ajouter.php?equipement_id=<?= $equipement_id ?>" class="btn btn-primary mb-3">+ Ajouter une interface</a>

    <?php if (count($interfaces) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Interfaces</th>
                    <th>VLAN</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($interfaces as $i): ?>
                    <tr>
                        <td><code><?= htmlspecialchars($i['interfaces']) ?></code></td>
                        <td><?= $i['vlan'] !== null ? htmlspecialchars($i['vlan']) : '-' ?></td>
                        <td><?= nl2br(htmlspecialchars($i['description'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune interface configurée pour cet équipement.</p>
    <?php endif; ?>

    <a href="../equipements/liste.php?projet_id=<?= $equipement['projet_id'] ?>" class="btn btn-secondary mt-3">⬅ Retour aux équipements</a>
</div>

<?php require_once '../includes/footer.php'; ?>
