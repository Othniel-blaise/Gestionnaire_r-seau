<?php
require_once '../config/db.php';
require_once '../includes/header.php';

if (!isset($_GET['id'])) {
    echo "Équipement non trouvé.";
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM Equipements WHERE id = ?");
$stmt->execute([$id]);
$equipement = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$equipement) {
    echo "Équipement introuvable.";
    exit;
}

// Traitement
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $ip_acces = $_POST['ip_acces'];
    $protocole = $_POST['protocole'];
    $port = $_POST['port'];
    $emplacement = $_POST['emplacement'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE Equipements SET nom=?, type=?, ip_acces=?, protocole=?, port=?, emplacement=?, description=? WHERE id=?");
    $stmt->execute([$nom, $type, $ip_acces, $protocole, $port, $emplacement, $description, $id]);

    header("Location: liste.php?projet_id=" . $equipement['projet_id']);
    exit;
}
?>

<div class="container mt-5">
    <h2>Modifier l'équipement : <?= htmlspecialchars($equipement['nom']) ?></h2>
    <form method="post">
        <input type="text" name="nom" class="form-control mb-2" value="<?= $equipement['nom'] ?>" required>
        <input type="text" name="type" class="form-control mb-2" value="<?= $equipement['type'] ?>" required>
        <input type="text" name="ip_acces" class="form-control mb-2" value="<?= $equipement['ip_acces'] ?>" required>
        <input type="text" name="protocole" class="form-control mb-2" value="<?= $equipement['protocole'] ?>" required>
        <input type="number" name="port" class="form-control mb-2" value="<?= $equipement['port'] ?>" required>
        <input type="text" name="emplacement" class="form-control mb-2" value="<?= $equipement['emplacement'] ?>">
        <textarea name="description" class="form-control mb-2"><?= $equipement['description'] ?></textarea>

        <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
        <a href="liste.php?projet_id=<?= $equipement['projet_id'] ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
