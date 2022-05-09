<?php
session_start();
$_SESSION['register_success'] = false;
$dbservername = 'localhost';
$dbname = 'database_hw2';
$dbusername = 'root';
$dbpassword = '';

$conn = new PDO(
    "mysql:host=$dbservername;dbname=$dbname",
    $dbusername,
    $dbpassword
);

$conn->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);

function oneEmpty(){
    return empty($_POST['shop_name'])
    ||empty($_POST['shop_category'])
    ||empty($_POST['shop_latitude'])
    ||empty($_POST['shop_longitude']);
}

function formatError(){
    return false;
}
try{
    if(!isset($_POST['shop_name'])||!isset($_POST['shop_category'])||!isset($_POST['shop_latitude'])||!isset($_POST['shop_longitude'])){
        header("Location: nav.php");
        exit();
    }
    if(oneEmpty()){
        throw new Exception('欄位空白');
    }
    else if(formatError()){
        throw new Exception("輸入格式不對");
    }
    $stmt = $conn->prepare(
        "select * from shops where name=:name"
    );
    $stmt->execute(array('name'=> $_POST['shop_name']));
    if($stmt->rowCount()!=0){
        throw new Exception("店名已被註冊");
    }
    else{
        $stmt = $conn->prepare(
            "insert into shops(
                name, category, latitude, longitude
            )values(
                :name,:category,:latitude,:longitude
            )"
        );
        $stmt->execute(
            array(
                'name' => $_POST['shop_name'],
                'category' => $_POST['shop_category'],
                'latitude' => $_POST['shop_latitude'],
                'longitude' => $_POST['shop_longitude']
            )
        );
        $_SESSION['register_success'] = true;
        $_SESSION['shop_name'] = $_POST['shop_name'];
        $_SESSION['shop_category'] = $_POST['shop_category'];
        $_SESSION['shop_latitude'] = $_POST['shop_latitude'];
        $_SESSION['shop_longitude'] = $_POST['shop_longitude'];
        echo "<script>
                alert('註冊成功');
                location.href='nav.php';
             </script>";
        exit();
    }
}
catch(Exception $e){
    $msg = $e->getMessage();
    session_unset();
    session_destroy();
    echo <<<EOT
        <!DOCTYPE html>
        <html>
        <body>
        <script>
        alert("$msg");
        window.location.replace("nav.php");
        </script>
        </body>
        </html>
    EOT;
}
?>