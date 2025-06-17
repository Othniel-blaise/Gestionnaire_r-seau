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
$stmt = $pdo->prepare("SELECT e.*, p.nom AS nom_projet FROM Equipements e
                       JOIN Projets p ON e.projet_id = p.id
                       WHERE e.id = ?");
$stmt->execute([$equipement_id]);
$equipement = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$equipement) {
    echo "<div class='container mt-4'><p class='alert alert-danger'>Équipement introuvable.</p></div>";
    require_once '../includes/footer.php';
    exit;
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $interfaces = $_POST['interfaces'];
    $vlan = $_POST['vlan'];
    $description = $_POST['description'];

    $sql = "INSERT INTO Interfaces (equipement_id, interfaces, vlan, description)
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$equipement_id, $interfaces, $vlan ?: null, $description]);

    header("Location: ../equipements/liste.php?projet_id=" . $equipement['projet_id']);
    exit;
}
?>

<div class="container mt-5">
    <h2>Ajouter des interfaces – <?= htmlspecialchars($equipement['nom']) ?> (Projet : <?= htmlspecialchars($equipement['nom_projet']) ?>)</h2>

    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="interfaces" class="form-label">Interfaces (ex: Fa0/1, Gi0/1–Gi0/2)</label>
            <input type="text" name="interfaces" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="vlan" class="form-label">VLAN (optionnel)</label>
            <input type="number" name="vlan" class="form-control">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Ajouter l'interface</button>
        <a href="../equipements/liste.php?projet_id=<?= $equipement['projet_id'] ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
