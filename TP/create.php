<?php
require_once 'config/database.php';
include 'includes/header.php';

$message = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'] ?? '';
    $description = $_POST['description'] ?? '';
    $prix = $_POST['prix'] ?? '';
    $quantite = $_POST['quantite'] ?? '';

    if(empty($nom) || empty($prix) || empty($quantite)) {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        try {
            $sql = "INSERT INTO produits (nom, description, prix, quantite) VALUES (:nom, :description, :prix, :quantite)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nom' => $nom,
                ':description' => $description,
                ':prix' => $prix,
                ':quantite' => $quantite
            ]);
            
            header('Location: index.php?message=Produit ajouté avec succès!');
            exit();
        } catch(PDOException $e) {
            $error = 'Erreur lors de l\'ajout du produit: ' . $e->getMessage();
        }
    }
}
?>

<h1>Ajouter un produit</h1>

<?php if($error): ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" action="">
    <div class="form-group">
        <label for="nom">Nom *</label>
        <input type="text" id="nom" name="nom" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description"></textarea>
    </div>

    <div class="form-group">
        <label for="prix">Prix (€) *</label>
        <input type="number" id="prix" name="prix" step="0.01" min="0" required>
    </div>

    <div class="form-group">
        <label for="quantite">Quantité *</label>
        <input type="number" id="quantite" name="quantite" min="0" required>
    </div>

    <button type="submit" class="btn">Ajouter</button>
    <a href="index.php" class="btn">Annuler</a>
</form>

<?php include 'includes/footer.php'; ?>