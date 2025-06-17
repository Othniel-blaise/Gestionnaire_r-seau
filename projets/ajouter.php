<?php
require_once '../config/db.php';
require_once '../includes/header.php';

// Récupérer la liste des utilisateurs pour le chef de projet
$stmt = $pdo->query("SELECT id, nom FROM Utilisateurs");
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'];
    $client = $_POST['client'];
    $chef_projet_id = $_POST['chef_projet_id'];
    $date_debut = $_POST['date_debut'];
    $statut = $_POST['statut'];
    $description = $_POST['description'];

    $sql = "INSERT INTO Projets (nom, client, chef_projet_id, date_debut, statut, description)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $client, $chef_projet_id, $date_debut, $statut, $description]);

    header("Location: ../index.php");
    exit;
}
?>

<div class="container mt-5">
    <h2>Créer un nouveau projet réseau</h2>
    <form method="post" class="mt-4">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du projet</label>
            <input type="text" class="form-control" name="nom" required>
        </div>

        <div class="mb-3">
            <label for="client" class="form-label">Client</label>
            <input type="text" class="form-control" name="client" required>
        </div>

        <div class="mb-3">
            <label for="chef_projet_id" class="form-label">Chef de projet</label>
            <select name="chef_projet_id" class="form-select" required>
                <option value="">-- Sélectionner --</option>
                <?php foreach ($utilisateurs as $user): ?>
                    <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_debut" class="form-label">Date de début</label>
            <input type="date" class="form-control" name="date_debut" required>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" class="form-select">
                <option value="en cours">En cours</option>
                <option value="terminé">Terminé</option>
                <option value="en pause">En pause</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description du projet</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Créer le projet</button>
        <a href="../index.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
