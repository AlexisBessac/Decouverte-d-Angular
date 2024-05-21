<?php

include 'header-init.php';
include 'produit-helper.php';
include 'jwt-helper.php';

$utilisateurConnecte = extractJwtBody();


// Si l'utilisateur n'est pas administrateur
// if(!$utilisateurConnecte->admin)
// {
//     http_response_code(403);
//     echo '{"message" : "Vous n\'êtes pas administrateur"}';
//     exit();
// }


// Prend les données brutes de la requête
// $json = file_get_contents('php://input');

$json = $_POST['produit'];

$nouveauNomDeFichier = '';

if(isset($_FILES['image'])){

    $nouveauNomDeFichier = upload();

}

// Le convertit en objet PHP
$produit = json_decode($json);

$requete = $connexion->prepare("INSERT INTO produit(nom, description, prix, image, id_utilisateur) VALUES (:nom, :description, :prix, :image, :id_utilisateur)");

$requete->bindValue("nom", $produit->nom);
$requete->bindValue("description", $produit->description);
$requete->bindValue("prix", $produit->prix);
$requete->bindValue("image", $nouveauNomDeFichier);
$requete->bindValue("id_utilisateur", $utilisateurConnecte->id);

$requete->execute();

echo'{"message" : "Le produit à bien été ajouté"}';

