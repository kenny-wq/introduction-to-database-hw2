<?php

session_start();
$dbservername = 'localhost';
$dbname = 'database_hw2';
$dbusername = 'root';
$dbpassword = '';

//連結MySQL Server
$conn = new PDO(
    "mysql:host=$dbservername;dbname=$dbname",
    $dbusername,
    $dbpassword
);
# set the PDO error mode to exception
$conn->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);

$stmt = $conn->prepare("select * from food");
$stmt->execute();
$rowNumber = $stmt->rowCount();
$meal_id = -1;
for($i=1;$i<=$rowNumber;$i++){
    $submitName = "delete_id".strval($i);
    if(isset($_POST[$submitName])){
        $meal_id = $i;
        break;
    }
}

$stmt = $conn->prepare(
    " delete from food
    where id=:id"
);
$stmt->execute(array(
    'id'=>$meal_id
));
$_SESSION['jump'] = true;
header("Location: nav.php");
?>