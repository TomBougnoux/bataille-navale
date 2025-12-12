<?php
session_start();
include('./scripts/sql-connect.php');

$sql = new SqlConnect();

$query_player = 'SELECT * FROM '.$_SESSION["role"];
$req_player = $sql->db->prepare($query_player);
$req_player->execute();
$player_rows = $req_player->fetchAll(PDO::FETCH_ASSOC);

$letters = ["A","B","C","D","E","F","G","H","I","J"];

function displayGrid($rows, $letters, $editable = false) {
    $index = 0;

    for ($row = 0; $row < 10; $row++) {
        echo '<div>';
        echo '<div style="display:inline-block; width:30px; text-align:center;">'.$letters[$row].'</div>';

        for ($col = 0; $col < 10; $col++) {
            $case = $rows[$index];
            $index++;

            $color = 'grey';
            if ($case['boat'] > 0) $color = 'green'; // bateau placé

            $idgrid = $case['idgrid'];

            echo '<div style="display:inline-block;">';
            if ($editable) {
                echo '<form method="post" action="./scripts/place_boat.php" style="display:inline;">';
                echo '<select>';
                echo '<option type="text" name="boat" value="0">0<option/>';
                echo '<option type="text" name="boat" value="0">1<option/>';
                echo '<option type="text" name="boat" value="2">2<option/>';
                echo '<option type="text" name="boat" value="3">3<option/>';
                echo '<option type="text" name="boat" value="4">4<option/>';
                echo '<option type="text" name="boat" value="5">5<option/>';
                echo '</select>';
                echo '<button type="submit" name="boat_cell" value="'.$idgrid.'" 
                        style="display:none; width:30px; height:30px; margin:0; padding:0; border:1px solid black; background-color:'.$color.';">
                      </button>';
                echo '</form>';
            } else {
                echo '<div style="width:30px; height:30px; background-color:'.$color.'; border:1px solid black;"></div>';
            }
            echo '</div>';
        }

        echo '</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bataille Navale</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <h2>Phase de préparation</h2>
    <p>Placez vos bateaux sur votre grille.</p>
    <?php displayGrid($player_rows, $letters, true); ?>

    <form method="post" action="./game.php">
        <button type="submit" name="launch_game">Lancer la partie</button>
    </form>
    <form method="post" action="./scripts/reset_total.php">
        <button type="submit" name="reset_total">❌ Fin de partie (RESET)</button>
    </form>

</body>
</html>
