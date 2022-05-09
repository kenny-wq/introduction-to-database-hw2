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
    $submitName = "id".strval($i);
    if(isset($_POST[$submitName])){
        $meal_id = $i;
        break;
    }
}

$stmt = $conn->prepare(
    "update food
    set  price=:price, quantity=:quantity
    where id=:id"
);
$stmt->execute(array(
    'price'=>$_POST['new_price'],
    'quantity'=>$_POST['new_quantity'],
    'id'=>$meal_id
));
header("Location: nav.php");
?>