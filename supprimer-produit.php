<?php

include 'header-init.php';
include 'jwt-helper.php';

if (!isset($_GET['id'])) {
    echo '{"message" : "il n\'y a pas d\'identiant dans l\'URL"}';
    http_response_code(400);
    exit;
}

$idProduit = $_GET['id'];

$requete = $connexion->prepare("SELECT * FROM produit WHERE id = ?");
$produit = $requete->fetch();

if(!$produit)
{
    http_response_code(404);
    echo '{"message" : "Ce produit n\'existe pas"}';
    exit;
}

$utilisateurConnecte = extractJwtBody();
if(!$utilisateurConnecte->admin && $utilisateurConnecte->id != $produit['id_utilisateur'])
{
    http_response_code(403);
    echo '{"message" : "Vous n\'êtes pas administrateur, ni créateur du produit"}';
    exit();
}

$idProduit = $_GET['id'];

$requete = $connexion->prepare("DELETE FROM produit WHERE id = ?");

$requete->execute([$idProduit]);

echo '{"message" : "le produit a bien été supprimé"}';