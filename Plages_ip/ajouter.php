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

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $type_reseau = $_POST['type_reseau'];
    $plage_ip = $_POST['plage_ip'];
    $passerelle = $_POST['passerelle'];
    $masque = $_POST['masque'];
    $description = $_POST['description'];

    $sql = "INSERT INTO Plages_Adresses (projet_id, type_reseau, plage_ip, passerelle, masque, description)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$projet_id, $type_reseau, $plage_ip, $passerelle, $masque, $description]);

    header("Location: ../projets/details.php?id=" . $projet_id);
    exit;
}
?>

<div class="container mt-5">
    <h2>Ajouter une plage d'adresses IP</h2>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="type_reseau" class="form-label">Type de réseau</label>
            <select name="type_reseau" class="form-select" required>
                <option value="LAN">LAN</option>
                <option value="WAN">WAN</option>
                <option value="VPN">VPN</option>
                <option value="DMZ">DMZ</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="plage_ip" class="form-label">Plage IP (ex : 192.168.1.0/24)</label>
            <input type="text" name="plage_ip" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="passerelle" class="form-label">Passerelle</label>
            <input type="text" name="passerelle" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="masque" class="form-label">Masque</label>
            <input type="text" name="masque" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Ajouter la plage</button>
        <a href="../projets/details.php?id=<?= $projet_id ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
