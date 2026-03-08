<?php
require_once 'config/database.php';
include 'includes/header.php';

$message = '';
$error = '';

// Vérifier si l'ID est présent
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];

// Récupérer le produit
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch();

if(!$produit) {
    header('Location: index.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'] ?? '';
    $description = $_POST['description'] ?? '';
    $prix = $_POST['prix'] ?? '';
    $quantite = $_POST['quantite'] ?? '';

    if(empty($nom) || empty($prix) || empty($quantite)) {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        try {
            $sql = "UPDATE produits SET nom = :nom, description = :description, prix = :prix, quantite = :quantite WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nom' => $nom,
                ':description' => $description,
                ':prix' => $prix,
                ':quantite' => $quantite,
                ':id' => $id
            ]);
            
            header('Location: index.php?message=Produit modifié avec succès!');
            exit();
        } catch(PDOException $e) {
            $error = 'Erreur lors de la modification: ' . $e->getMessage();
        }
    }
}
?>

<h1>Modifier le produit</h1>

<?php if($error): ?>
    <div class="alert alert-error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" action="">
    <div class="form-group">
        <label for="nom">Nom *</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($produit['nom']); ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($produit['description']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="prix">Prix (€) *</label>
        <input type="number" id="prix" name="prix" step="0.01" min="0" value="<?php echo $produit['prix']; ?>" required>
    </div>

    <div class="form-group">
        <label for="quantite">Quantité *</label>
        <input type="number" id="quantite" name="quantite" min="0" value="<?php echo $produit['quantite']; ?>" required>
    </div>

    <button type="submit" class="btn">Modifier</button>
    <a href="index.php" class="btn">Annuler</a>
</form>

<?php include 'includes/footer.php'; ?>