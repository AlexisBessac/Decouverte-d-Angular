<?php

include 'header-init.php';

$requete = $connexion->query("SELECT * FROM produit" );
$listeProduit = $requete->FetchAll();

echo json_encode($listeProduit);