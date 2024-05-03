<?php

include 'header-init.php';

if (!isset($_GET['id'])) {
    echo '{"message" : "il n\'y a pas d\'identiant dans l\'URL"}';
    http_response_code(400);
    exit;
}

$idProduit = $_GET["id"];

$json = $_POST['produit'];

// Le convertit en objet PHP
$produit = json_decode($json);

$requete = $connexion->prepare("UPDATE produit SET 
                                    nom = :nom, 
                                    description = :description, 
                                    prix = :prix
                                WHERE id = :id");

$requete->execute([
    "nom" => $produit->nom,
    "description" => $produit->description,
    "prix" =>  $produit->prix,
    "id" => $idProduit
]);

$nouveauNomDeFichier = '';

if(isset($_FILES['image'])){

    $date = date("Y-m-d-H-i-s");

    $nouveauNomDeFichier = $date . '-' . $_FILES['image']['name'];

    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $nouveauNomDeFichier);

    $requete = $connexion->prepare("UPDATE produit SET image = :image WHERE id = :id");

    $requete->execute([
        "image" => $nouveauNomDeFichier,
        "id" => $idProduit
    ]);

}

echo '{"message" : "Le produit a bien été modifié"}';