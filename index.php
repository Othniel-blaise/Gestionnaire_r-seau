
<?php
require_once 'config/db.php';
require_once 'includes/header.php';

// Récupérer les projets
$stmt = $pdo->query("SELECT p.id, p.nom, p.client, p.date_debut, p.statut, u.nom AS chef FROM Projets p
                     LEFT JOIN Utilisateurs u ON p.chef_projet_id = u.id
                     ORDER BY p.date_debut DESC");
$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2 class="mb-4">Tableau de bord – Projets Réseau</h2>
    <a href="projets/ajouter.php" class="btn btn-primary mb-3">+ Nouveau projet</a>

    <?php if (count($projets) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom du projet</th>
                    <th>Client</th>
                    <th>Chef de projet</th>
                    <th>Date de début</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projets as $projet): ?>
                    <tr>
                        <td><?= htmlspecialchars($projet['nom']) ?></td>
                        <td><?= htmlspecialchars($projet['client']) ?></td>
                        <td><?= htmlspecialchars($projet['chef']) ?></td>
                        <td><?= htmlspecialchars($projet['date_debut']) ?></td>
                        <td><span class="badge bg-secondary"><?= $projet['statut'] ?></span></td>
                        <td>
                            <a href="projets/details.php?id=<?= $projet['id'] ?>" class="btn btn-sm btn-info">Détails</a>
                            <a href="equipements/liste.php?projet_id=<?= $projet['id'] ?>" class="btn btn-sm btn-dark">Équipements</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun projet trouvé. <a href="projets/ajouter.php">Créer le premier projet</a>.</p>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
