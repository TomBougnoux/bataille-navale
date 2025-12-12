<?php
session_start();

include('./scripts/sql-connect.php');

$sql = new SqlConnect();

$_SESSION['game_started'] = true;
$launch = true;

$player = $_SESSION["role"] === 'joueur1' ?  'joueur2' : 'joueur1';
$query = 'SELECT * FROM '.$player;

$req = $sql->db->prepare($query);
$req->execute();
$rows = $req->fetchAll(PDO::FETCH_ASSOC);

$letters = ["A","B","C","D","E","F","G","H","I","J"];

function displayGrid($rows, $letters) {
    $index = 0;

    echo '<div>';
    echo '<div class="empty-cell"></div>'; 

    for ($col = 1; $col <= 10; $col++) {
        echo '<div class="header-cell">'.$col.'</div>';
    }
    echo '</div>';

    for ($row = 0; $row < 10; $row++) {
        echo '<div>';
        echo '<div class="header-cell">'.$letters[$row].'</div>';

        for ($col = 0; $col < 10; $col++) {

            $case = $rows[$index];
            $index++;

            $color = $case['checked'] == 1 ? 'blue' : 'grey';
            if ($case['checked'] == 1 && $case['boat'] > 0) {
                $color = 'red';
            }

            $idgrid = $case['idgrid'];

            echo '<div class="cell-wrapper">';
            echo '<form method="post" action="../scripts/click_case.php">';
            echo '<button 
                    type="submit" 
                    name="cell" 
                    value="'.$idgrid.'" 
                    class="grid-button" 
                    style="background-color:'.$color.';">
                  </button>';
            echo '</form>';
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
    <title>Game</title>

    <!-- CSS global -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- CSS spécifique à cette page -->
    <link rel="stylesheet" href="../css/game.css">

</head>
<body>

<h2>Phase de combat</h2>

<div class="game-container">

    <div class="legend">
        <h4 class="legend-title">Bateaux à couler</h4>

        <div class="legend-item">
            <div class="legend-item-title">1 porte avion</div>
            <div class="legend-boxes">
                <div class="legend-box"></div><div class="legend-box"></div>
                <div class="legend-box"></div><div class="legend-box"></div>
                <div class="legend-box"></div>
            </div>
            <div class="legend-text">5 cases</div>
        </div>

        <div class="legend-item">
            <div class="legend-item-title">1 croiseur</div>
            <div class="legend-boxes">
                <div class="legend-box"></div><div class="legend-box"></div>
                <div class="legend-box"></div><div class="legend-box"></div>
            </div>
            <div class="legend-text">4 cases</div>
        </div>

        <div class="legend-item">
            <div class="legend-item-title">2 sous-marins</div>
            <div class="legend-boxes">
                <div class="legend-box"></div><div class="legend-box"></div>
                <div class="legend-box"></div>
            </div>
            <div class="legend-text">3 cases + 3 cases</div>
        </div>

        <div class="legend-item">
            <div class="legend-item-title">1 torpilleur</div>
            <div class="legend-boxes">
                <div class="legend-box"></div><div class="legend-box"></div>
            </div>
            <div class="legend-text">2 cases</div>
        </div>
    </div>

    <div>
        <h3 class="board-title">Plateau adverse</h3>
        <?php displayGrid($rows, $letters); ?>
    </div>
</div>

<form method="post" action="../scripts/reset_total.php" class="reset-form">
    <button type="submit" name="reset_total" class="reset-btn">❌ Fin de partie (RESET)</button>
</form>

</body>
</html>
