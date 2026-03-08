<?php
require_once 'config/database.php';
include 'includes/header.php';

// Récupérer tous les produits
$stmt = $pdo->query("SELECT * FROM produits ORDER BY date_creation DESC");
$produits = $stmt->fetchAll();
?>

<h1>Gestion des Produits| tp de MAZAMBI OKAKO Ruben</h1>

<a href="create.php" class="btn btn-add">Ajouter un produit</a>

<?php if(isset($_GET['message'])): ?>
    <div class="alert alert-success">
        <?php echo htmlspecialchars($_GET['message']); ?>
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix (€)</th>
            <th>Quantité</th>
            <th>Date création</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($produits) > 0): ?>
            <?php foreach($produits as $produit): ?>
                <tr>
                    <td><?php echo $produit['id']; ?></td>
                    <td><?php echo htmlspecialchars($produit['nom']); ?></td>
                    <td><?php echo htmlspecialchars($produit['description']); ?></td>
                    <td><?php echo number_format($produit['prix'], 2); ?> €</td>
                    <td><?php echo $produit['quantite']; ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($produit['date_creation'])); ?></td>
                    <td class="actions">
                        <a href="edit.php?id=<?php echo $produit['id']; ?>" class="btn btn-edit">Modifier</a>
                        <a href="delete.php?id=<?php echo $produit['id']; ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">Aucun produit trouvé</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>