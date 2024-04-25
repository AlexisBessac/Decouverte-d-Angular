<?php

header("Access-Control-Allow-Origin: *");

$listeProduit = [
    ["nom" => "premier produit", "description" => "description 1er produit"],
    ["nom" => "deuxieme produit", "description" => "description 2eme produit"],
    ["nom" => "troisieme produit", "description" => "description 3eme produit"],
];

echo json_encode($listeProduit);