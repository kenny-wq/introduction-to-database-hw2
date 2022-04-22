<?php
session_start();
$_SESSION['Authenticated'] = false;
$dbservername = 'localhost';
$dbname = 'database_hw2';
$dbusername = 'root';
$dbpassword = '';

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

function oneEmpty(){
    return empty($_POST['username'])
    ||empty($_POST['phone_number'])
    ||empty($_POST['account'])
    ||empty($_POST['password'])
    ||empty($_POST['re_type_password'])
    ||empty($_POST['latitude'])
    ||empty($_POST['longitude']);
}

function formatError(){
    return false;
}

try {
    $stmt = $conn->prepare(
        "select account from users where account=:account"
    );
    $stmt->execute(array('account'=>$_POST['account']));
    if (oneEmpty()){
        throw new Exception("欄位空白");
    }
    else if(formatError()){
        throw new Exception("輸入格式不對");
    }
    else if ($stmt->rowCount() != 0){
        throw new Exception("帳號已被註冊");
    }
    else if($_POST['password']!=$_POST['re_type_password']) {
        throw new Exception("密碼驗證 ≠ 密碼");
    }
    else {
        $stmt = $conn->prepare(
            "insert into users(
                account, password, username, phone_number, longitude, latitude
            ) values(
                :account,:password,:username,:phone_number,:longitude,:latitude
            )"
        );
        $stmt->execute(
            array(
                'account' => $_POST['account'],
                'password' => hash('sha256', $_POST['password']),
                'username' => $_POST['username'],
                'phone_number' => $_POST['phone_number'],
                'longitude' => $_POST['longitude'],
                'latitude' => $_POST['latitude']
            )
        );
        echo "<script>
                alert('這是');
                location.href='index.php';
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
        window.location.replace("sign-up.php");
        </script>
        </body>
        </html>
    EOT;
}

?>
