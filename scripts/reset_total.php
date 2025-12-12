<?php
session_start();

session_unset();
session_destroy();

include('./sql-connect.php');
$sql = new SqlConnect();
$players = ['joueur1', 'joueur2'];

foreach ($players as $player) {
    $sql->db->query("UPDATE $player SET checked = 0");
}

$fichier = "../etat_joueurs.json";
if (file_exists($fichier)) {
    file_put_contents($fichier, json_encode(["j1" => null, "j2" => null], JSON_PRETTY_PRINT));
}

header("Location: ../index.php");
exit;
