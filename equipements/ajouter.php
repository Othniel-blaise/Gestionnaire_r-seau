<?php
require_once '../config/db.php';
require_once '../includes/header.php';

// Vérifie que l'ID du projet est présent
if (!isset($_GET['projet_id']) || empty($_GET['projet_id'])) {
    echo "<div class='container mt-4'><p class='alert alert-danger'>Projet non spécifié.</p></div>";
    require_once '../includes/footer.php';
    exit;
}

$projet_id = $_GET['projet_id'];

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $ip_acces = $_POST['ip_acces'];
    $protocole = $_POST['protocole'];
    $port = $_POST['port'];
    $emplacement = $_POST['emplacement'];
    $description = $_POST['description'];

    $sql = "INSERT INTO Equipements (projet_id, nom, type, ip_acces, protocole, port, emplacement, description)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$projet_id, $nom, $type, $ip_acces, $protocole, $port, $emplacement, $description]);

    header("Location: liste.php?projet_id=" . $projet_id);
    exit;
}
?>

<div class="container mt-5">
    <h2>Ajouter un équipement réseau</h2>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="nom" class="form-label">Ajouter l'adresse IP de  l'équipement ou le Nom  de  l'équipement </label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type (Switch, Routeur, ASA...)</label>
            <input type="text" name="type" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="ip_acces" class="form-label">Adresse IP d'accès</label>
            <input type="text" name="ip_acces" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="protocole" class="form-label">Protocole</label>
            <select name="protocole" class="form-select">
                <option value="SSH">SSH</option>
                <option value="Telnet">Telnet</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="port" class="form-label">Port (défaut : 22)</label>
            <input type="number" name="port" class="form-control" value="22" required>
        </div>

        <div class="mb-3">
            <label for="emplacement" class="form-label">Emplacement (localisation physique)</label>
            <input type="text" name="emplacement" class="form-control">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Ajouter l’équipement</button>
        <a href="liste.php?projet_id=<?= $projet_id ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
