<?php

include 'header-init.php';

// Prend les données brutes de la requête
// $json = file_get_contents('php://input');

$json = $_POST['produit'];

$nouveauNomDeFichier = '';

if(isset($_FILES['image'])){

    $date = date("Y-m-d-H-i-s");

    $nouveauNomDeFichier = $date . '-' . $_FILES['image']['name'];

    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $nouveauNomDeFichier);
}

// Le convertit en objet PHP
$produit = json_decode($json);

$requete = $connexion->prepare("INSERT INTO produit(nom, description, prix, image) VALUES (:nom, :description, :prix, :image)");

$requete->bindValue("nom", $produit->nom);
$requete->bindValue("description", $produit->description);
$requete->bindValue("prix", $produit->prix);
$requete->bindValue("image", $nouveauNomDeFichier);

$requete->execute();

echo'{"message" : "Le produit à bien été ajouté"}';

