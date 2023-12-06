<?php 
    declare(strict_types= 1);
    require("./src/connect.php");
    function getStart(): void {
        global $mysqli;
        session_start();
        if (!isset($_SESSION['startGame'])) {
            getShips();
            $_SESSION['startGame'] = true;
            $_SESSION['player'] = 'user';
        }
        if(isset($_POST['resetGame']) && $_POST['resetGame']== 'true'){
            resetGame();
        };
            whoWon();
    }
    function whoWon() {
        global $mysqli;
        $userResult= $mysqli->query('SELECT id FROM board WHERE value = "ship" AND player = "USER"');
        $cpuResult= $mysqli->query('SELECT id FROM board WHERE value = "ship" AND player = "CPU"');
        if($userResult->fetch_all()==[]){
            $sql = "UPDATE board SET clickable = 'non-clickable' ";
            $result=$mysqli->query($sql);
            return "Użytkownik!";
        }elseif($cpuResult->fetch_all()==[]){
            $sql = "UPDATE board SET clickable = 'non-clickable' ";
            $result=$mysqli->query($sql);
            return "Komputer!";
        }
    }
    function CpuTurn() :void {
        global $mysqli; 
        $randomNum = rand(101, 200);
        $sql= "SELECT value FROM board WHERE id=$randomNum";
        $result=$mysqli->query($sql);
        $shot = $result->fetch_row();
        if($shot[0] =='shot' || $shot[0] =='hit' ){
            CpuTurn();
        }else {
            switch ($shot[0]) {
                case 'empty':
                    $sql="UPDATE board SET value='shot' 
                    WHERE id=$randomNum";
                break;
                case 'ship':
                    $sql="UPDATE board SET value='hit' 
                    WHERE id=$randomNum";
                break;
                }
            $result=$mysqli->query($sql);
        }
        $_SESSION['player']='user';
    }
    function getShips():void{
        global $mysqli;
        $userRange=range(1,100);
        $userShips =array_rand($userRange,5);
        $cpuRange=range(101,200);
        $cpuShips =array_rand($cpuRange,5);
        $sql = "UPDATE board SET clickable = 'clickable' ";
        $result=$mysqli->query($sql);
        foreach ($userShips as $ship) {
            $sql = "UPDATE board SET value ='ship' 
            WHERE id = $userRange[$ship]";
            $result=$mysqli->query($sql);
        }
        foreach ($cpuShips as $ship) {
            $sql = "UPDATE board SET value ='ship' 
            WHERE id = $cpuRange[$ship]";
            $result=$mysqli->query($sql);
        }
    }
    function reloadBoard():array{
        global $mysqli;
        $sqlShot="SELECT id,value,clickable FROM board";
        $result=$mysqli->query($sqlShot);
        $board = $result->fetch_all(MYSQLI_ASSOC);
        return $board;
    }
    function shot(int $id): void {
        global $mysqli;
        session_start();
        if($_SESSION['player']=='user'){
            $_SESSION['player']='cpu';
        } else {
            $_SESSION['player']='user';
        }
        $sql= "SELECT id,value FROM board 
        WHERE id=$id";
        $result=$mysqli->query($sql);
        $shot = $result->fetch_all(MYSQLI_ASSOC);
        switch ($shot[0]['value']) {
            case 'empty':
                $sql1="UPDATE board SET value='shot', clickable = 'non-clickable' 
                WHERE id=$id";
            break;
            case 'ship':
                $sql1="UPDATE board SET value='hit', clickable = 'non-clickable'  
                WHERE id=$id";
            break;
        }
        $result1=$mysqli->query($sql1);
        $shot1 = $result->fetch_all(MYSQLI_ASSOC);
        header ('Location: ./index.php');
    }
    function resetGame():void{
        session_destroy();
        global $mysqli;
        $sql="UPDATE board SET value = 'empty', clickable = 'clickable'";
        $result=$mysqli->query($sql);
        header('Location: ./index.php');
    }
    function getBoard(int $i) : string {
        $letter = ['X','A','B','C','D','E','F','G','H','I','J'];
        return $letter[$i];
    }

?>