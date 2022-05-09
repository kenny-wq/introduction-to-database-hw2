<?php
session_start();
//$_SESSION['Authenticated'] = false;
$dbservername = 'localhost';
$dbname = 'database_hw2';
$dbusername = 'root';
$dbpassword = '';

//開啟圖片檔
$file = fopen($_FILES["myFile"]["tmp_name"], "rb");
// 讀入圖片檔資料
$fileContents = fread($file, filesize($_FILES["myFile"]["tmp_name"])); 
//關閉圖片檔
fclose($file);
//讀取出來的圖片資料必須使用base64_encode()函數加以編碼：圖片檔案資料編碼
$picture = base64_encode($fileContents);
//read img file type
$picture_file_type=$_FILES["myFile"]["type"];

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
//組合查詢字串
$id = -1;
$stmt = $conn->prepare("select * from food");
$stmt->execute();

if($stmt->rowCount()==0){
    $id = 1;
}
else{
    $stmt = $conn->prepare("select max(id) from food");
    $stmt->execute();
    $row = $stmt->fetch();
    $id = $row['max(id)']+1;
}


$stmt = $conn->prepare("INSERT INTO food (id,name,price,quantity,picture,picture_file_type) 
                        VALUES (:id,:name,:price,:quantity,:picture,:picture_file_type)");

$stmt->execute(array(
    'id' => $id,
    'name'=>$_POST['name'],
    'price'=>$_POST['price'],
    'quantity'=>$_POST['quantity'],
    'picture'=>$picture,
    'picture_file_type'=>$picture_file_type
));
//$sql="INSERT INTO speechPost (img,imgType) VALUES ('$fileContents','$imgType')";

header("Location: nav.php");

?>