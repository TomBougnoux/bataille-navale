<?php
session_start();
include('./sql-connect.php');

$sql = new SqlConnect();

$currentPlayer = $_SESSION["role"];
$cell = intval($_POST["boat_cell"]);

// Place un bateau
$query = "UPDATE $currentPlayer SET boat = 1 WHERE idgrid = ?";
$req = $sql->db->prepare($query);
$req->execute([$cell]);

// Retour propre vers la page du jeu
header("Location: ../game.php");
exit;
