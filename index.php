<?php
    declare(strict_types= 1);
    require("./src/controler.php");
    getStart();
    if($_SESSION['player']=='cpu'){
        CpuTurn();
    }
    $board=reloadBoard();
?>

<!doctype html>

<html>
<head>
    <meta charset="utf-8">
    <title>BattleShips</title>
    <meta name="Battleship">
    <link rel="icon" href="./src/favicon/battleship.png" type="image/png">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <h1 class="tittle">battleship</h1>
    <?php if(whoWon()):?>
    <div class="win">
        <h2><?php echo 'Wygrał'. ' '.whoWon();?></h2>
    </div>
    <?php endif
    ?>
    <form action="./index.php" method="post">
        <button id=resetGame name='resetGame' type="submit" value="true">Nowa gra</button>
    </form>
    <div class="wrapper">
        <div class="USER">
            <h3 class="player">User</h3>
            <div class="table">
                <div class="row">
                    <?php for ($i=0; $i<11 ; $i++) :?>
                    <div  class="cell th"><?php echo getBoard($i) ?></div>
                    <?php endfor ?>
                </div>
                <?php for ($j=1; $j < 11; $j++) :?>
                <div class="row">
                    <div class="cell th"><?php echo $j ?></div>
                    <?php for ($i=($j-1)*10; $i<($j)*10 ; $i++) :?>
                    <div id="<?php echo $board[$i]['id'] ?>" class="cell <?php echo $board[$i]['clickable'].'_USER'; ?> <?php echo $board[$i]['value'];  ?>"></div>
                    <?php endfor ?>
                </div>
                <?php endfor ?>
            </div>
            <form hidden id="form" action="shot.php" method="post">
                <input name="id" id="id"/>
                <input name='player' id="player" value=<?php echo $_SESSION['player'] ?> />
            </form>
        </div>
        <div class="CPU">
            <h3 class="player">CPU</h3>
            <div class="table">
                <div class="row">
                    <?php for ($i=0; $i<11 ; $i++) :?>
                    <div class="cell th"><?php echo getBoard($i) ?></div>
                    <?php endfor ?>
                </div>
                <?php for ($j=1; $j < 11; $j++) :?>
                <div class="row">
                    <div class="cell th"><?php echo $j ?></div>
                    <?php for ($i=($j-1)*10+100; $i<($j)*10+100 ; $i++) :?>
                    <div id="<?php echo $board[$i]['id'] ?>" class="cell clicable_CPU <?php echo $board[$i]['value'] ?>"></div>
                    <?php endfor ?>
                </div>
                <?php endfor ?>
            </div>
        </div>
    </div>
</body>
<script src="./src/js/script.js"></script>
</html>