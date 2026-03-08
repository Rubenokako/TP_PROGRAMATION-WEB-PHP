<?php
require_once 'config/database.php';

// Vérifier si l'ID est présent
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];

try {
    // Vérifier si le produit existe
    $stmt = $pdo->prepare("SELECT id FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    
    if($stmt->rowCount() > 0) {
        // Supprimer le produit
        $stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
        $stmt->execute([$id]);
        
        // Redirection avec message de succès
        header('Location: index.php?message=Produit supprimé avec succès!');
        exit();
    } else {
        // Produit non trouvé
        header('Location: index.php?message=Produit non trouvé&type=error');
        exit();
    }
} catch(PDOException $e) {
    // En cas d'erreur, rediriger avec un message d'erreur
    header('Location: index.php?message=Erreur lors de la suppression: ' . urlencode($e->getMessage()) . '&type=error');
    exit();
}
?>