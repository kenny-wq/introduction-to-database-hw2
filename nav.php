<?php
session_start();
if(!isset($_SESSION['register_success'])){
  $_SESSION['register_success'] = false;
}
// tsu part
$mysqli = new mysqli("localhost","root","","database_hw2");
$pwd = $_SESSION['Password'] ; 
$stmt = $mysqli->prepare(" SELECT account , username , phone_number , ST_X(location) , ST_Y(location), password FROM users WHERE password = ? ") ;
$stmt->bind_param("s" , $pwd) ; 
$stmt->execute() ; 
$result = $stmt->get_result(); 
$info = $result->fetch_assoc() ;
$_SESSION['x'] = $info['ST_X(location)'] ; 
$_SESSION['y'] = $info['ST_Y(location)'] ; 
$stmt -> close();
$mysqli -> close();
// tsu part

function print_row($order,$id,$picture_type,$picture,$meal_name,$price,$quantity){
  // echo <img src="data:$row['imgType'];base64, $logodata " />;
  echo<<<EOT
  <tr>
    <th scope="row">{$order}</th>
    <td><img src="data:{$picture_type};base64,{$picture}" width="50%" height="50%" alt="Hamburger"></td>
    
    <td>{$meal_name}</td>

    <td>{$price} </td>
    <td>{$quantity} </td>
    <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#Hamburger-1">
    Edit
    </button></td>
    <!-- Modal -->
        <div class="modal fade" id="Hamburger-1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{$meal_name} Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <!--change_meal form-->
              <form action="change_meal.php" method="post">
                <div class="modal-body">
                  <div class="row" >
                    <div class="col-xs-6">
                      <label for="ex71">price</label>
                      <input name="new_price" class="form-control" id="ex71" type="text">
                    </div>
                    <div class="col-xs-6">
                      <label for="ex41">quantity</label>
                      <input name="new_quantity" class="form-control" id="ex41" type="text">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" name="id{$id}" value="edit" class="btn btn-secondary">
                </div>
              </form>

            </div>
          </div>
        </div>
    <form action="delete_meal.php" method="post">
      <td><input type="submit" name="delete_id{$id}" value="Delete" class="btn btn-danger"><td>
    </form>
  </tr>
EOT;
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>Hello, world!</title>
</head>

<body>
 
  <nav class="navbar navbar-inverse">
    <!-- <div class="container-fluid"> -->
      <div class="navbar-header">
        <a class="navbar-brand " href="#">WebSiteName</a>
      </div>
    <!-- </div> -->
    <div class="pull-right">
        <ul class="nav navbar-nav">
          <form action="logout.php">
            <li><input type="submit" value="Log Out" class="btn navbar-btn"></li>
          </form>
        </ul>     
    </div>
  </nav>
  <div class="container">

    <ul class="nav nav-tabs">
      <li class="active"><a href="#home">Home</a></li>
      <li><a href="#menu1">shop</a></li>


    </ul>

    <div class="tab-content">
      <div id="home" class="tab-pane fade in active">
        <h3>Profile</h3>
        <div class="row">
          <div class="col-xs-12">
          <!-- Accouont: sherry, user, PhoneNumber: 0912345678,  location: 24.786944626633865, 120.99753981198887 -->
          <?php
              echo "Account : " . $info['account'] ;
              echo "<br>" ;
              echo "Username : " . $info['username'] ; 
              echo "<br>" ;
              echo "Phonenumber : " . $info['phone_number'] ;
              echo "<br>" ;
              echo "longitude : " . strval($info['ST_X(location)']) . " ; latitude : " . strval($info['ST_Y(location)']); 
          ?>
            <!--助教新增-->
            <button type="button " style="margin-left: 5px;" class=" btn btn-info " data-toggle="modal"
            data-target="#location">edit location</button>
            <!--  -->
            <div class="modal fade" id="location"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog  modal-sm">
                <div class="modal-content">
                  <form action = 'update_location_and_return.php' method = 'POST'>
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">edit location</h4>
                    </div>
                    <div class="modal-body">
                      <label class="control-label " for="latitude">latitude</label>
                      <input type="text" class="form-control" name="newlatitude" placeholder="enter latitude">
                        <br>
                        <label class="control-label " for="longitude">longitude</label>
                      <input type="text" class="form-control" name="newlongitude" placeholder="enter longitude">
                    </div>
                    <div class="modal-footer">
                      <input type="submit" class="btn btn-default"  value = 'Edit'>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            

            <!--助教新增-->
            walletbalance: 100

            
            <!-- Modal -->
            <button type="button " style="margin-left: 5px;" class=" btn btn-info " data-toggle="modal"
              data-target="#myModal">Add value</button>
            <div class="modal fade" id="myModal"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog  modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add value</h4>
                  </div>
                  <div class="modal-body">
                    <input type="text" class="form-control" id="Meal" placeholder="enter add value">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Add</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- 
                
             -->
        <h3>Search</h3>
        <div class=" row  col-xs-8">
          <form class="form-horizontal" action="action_page.php" method="POST">
            <div class="form-group">
              <label class="control-label col-sm-1" for="Shop">Shop</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" placeholder="Enter Shop name" name="name">
              </div>
              <label class="control-label col-sm-1" for="distance">distance</label>
              <div class="col-sm-5">


                <select class="form-control" id="sel1" name="dist">
                  <option>near</option>
                  <option>medium </option>
                  <option>far</option>

                </select>
              </div>

            </div>

            <div class="form-group">

              <label class="control-label col-sm-1" for="Price">Price</label>
              <div class="col-sm-2">

                <input name="price1" type="text" class="form-control">

              </div>
              <label class="control-label col-sm-1" for="~">~</label>
              <div class="col-sm-2">

                <input name="price2" type="text" class="form-control">

              </div>
              <label class="control-label col-sm-1" for="Meal">Meal</label>
              <div class="col-sm-5">
                <input name="meal" type="text" list="Meals" class="form-control" id="Meal" placeholder="Enter Meal">
                <datalist id="Meals">
                  <option value="Hamburger">
                  <option value="coffee">
                </datalist>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-1" for="category"> category</label>
            
              
                <div class="col-sm-5">
                  <input name="category" type="text" list="categorys" class="form-control" id="category" placeholder="Enter shop category">
                  <datalist id="categorys">
                    <option value="fast food">
               
                  </datalist>
                </div>
                <button type="submit" style="margin-left: 18px;"class="btn btn-primary">Search</button>
              
            </div>
          </form>
        </div>
        <div class="row">
          <div class="  col-xs-8">
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">#</th>
                
                  <th scope="col">shop name</th>
                  <th scope="col">shop category</th>
                  <th scope="col">Distance</th>
               
                </tr>
              </thead>
              <!-- tsu part -->
              <?php
                if(isset($_SESSION['search_info']) and !empty($_SESSION['search_info'])){
                  $GLOBALS['counter'] = 1 ;
                  foreach($_SESSION['search_info'] as $subres){ 
                    echo '<tbody>
                      <tr>
                        <th scope="row">'
                    . strval($GLOBALS['counter']) .
                    "</th>  
                        <td>"
                    .$subres["shopname"]. 
                    "</td>
                        <td>"
                    .$subres["category"].
                    "</td>
                        <td>".$subres["dist"]."</td>
                        <td>
                          <form action = 'get_menu.php' , method = 'POST'>
                            <input name='{$subres['shopname']}' value = 'Open menu' type='submit' class='btn btn-info' data-target = 'macdonald' data-toggle='modal'>
                          </form>
                        </td>" 
                    ."</tr>
                    </tbody>" ;
                    $GLOBALS['counter'] += 1 ;   
                  }
              }
              ?>
              <!-- tsu part -->
            </table>

                <!-- Modal -->
  <div class="modal fade" id="macdonald"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">menu</h4>
        </div>
        <div class="modal-body">
         <!--  -->
  
         <div class="row">
          <div class="  col-xs-12">
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Picture</th>
                 
                  <th scope="col">meal name</th>
               
                  <th scope="col">price</th>
                  <th scope="col">Quantity</th>
                
                  <th scope="col">Order check</th>
                </tr>
              </thead>
              <tbody>
                <!-- tsu part -->
                <?php
                // echo var_dump($_SESSION['menu']);
                if(isset($_SESSION['menu'])){
                  foreach($_SESSION['menu'] as $meal){
                    $pic = $meal['picture'] ; 
                    echo' <tbody>
                    <tr>
                      <th scope="row"></th>
                      <td><img src="data:'.$meal['picture_file_type'].';base64,' . $pic . '" width="50%" height="50%" /> </td>
                      <td>'.$meal['name'].'</td>
                      <td>'.$meal['price'].' </td>
                      <td>'.$meal['quantity'].' </td>
                      <td> <input type="checkbox" id="cbox1"></td> <!-- modified: 把value砍掉-->
                    </tr>' ;
                  }
                }
                
                ?>
                <!-- tsu part -->

              </tbody>
            </table>
          </div>

        </div>
        

         <!--  -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Order</button>
        </div>
      </div>
    </div>
  </div>
          </div>
        </div>
      </div>
      <div id="menu1" class="tab-pane fade">

        <h3> Start a business </h3>
        <!-- shop register -->
        <form class="form-group" action="register_shop.php" method="post">
          <div class="row">
            <div class="col-xs-2">
              <label for="ex5">shop name</label>
              <?php
                if($_SESSION['register_success']==true){
                  echo '<input name="shop_name" class="form-control" id="ex5" value="'.$_SESSION['shop_name'].'" type="text" readonly>';
                }
                else{
                  echo '<input name="shop_name" class="form-control" id="ex5" placeholder="macdonald" type="text">';
                }
              ?>
            </div>
            <div class="col-xs-2">
              <label for="ex5">shop category</label>
              <?php
                if($_SESSION['register_success']==true){
                  echo '<input name="shop_category" class="form-control" id="ex5" value="'.$_SESSION['shop_category'].'" type="text" readonly >';
                }
                else{
                  echo '<input name="shop_category" class="form-control" id="ex5" placeholder="fast food" type="text" >';
                }
              ?>
              
            </div>
            <div class="col-xs-2">
              <label for="ex6">latitude</label>
              <?php
                if($_SESSION['register_success']==true){
                  echo '<input name="shop_latitude" class="form-control" id="ex6" value="'.$_SESSION['shop_latitude'].'" type="text" readonly>';
                }
                else{
                  echo '<input name="shop_latitude" class="form-control" id="ex6" placeholder="121.00028167648875" type="text" >';
                }
              ?>
              
            </div>
            <div class="col-xs-2">
              <label for="ex8">longitude</label>
              <?php
                if($_SESSION['register_success']==true){
                  echo '<input name="shop_longitude" class="form-control" id="ex8" value="'.$_SESSION['shop_longitude'].'" type="text" readonly>';
                }
                else{
                  echo '<input name="shop_longitude" class="form-control" id="ex8" placeholder="24.78472733371133" type="text" >';
                }
              ?>
              
            </div>
          </div>
          <div class=" row" style=" margin-top: 25px;">
            <div class=" col-xs-3">
              <?php
                if($_SESSION['register_success']==true){
                  echo '<input type="submit" value="register" class="btn btn-primary" disabled>';
                }
                else{
                  echo '<input type="submit" value="register" class="btn btn-primary">';
                }
              ?>
              
            </div>
          </div>
        </form>

        <hr>
        <h3>ADD</h3>
        <!-- upload meal -->
        <form action="upload_meal.php" method="post" class="form-group" enctype="multipart/form-data">
          <div class="row">
            <div class="col-xs-6">
              <label for="ex3">meal name</label>
              <input name="name" class="form-control" id="ex3" type="text">
            </div>
          </div>
          <div class="row" style=" margin-top: 15px;">
            <div class="col-xs-3">
              <label for="ex7">price</label>
              <input name="price" class="form-control" id="ex7" type="text">
            </div>
            <div class="col-xs-3">
              <label for="ex4">quantity</label>
              <input name="quantity" class="form-control" id="ex4" type="text">
            </div>
          </div>

          <div class="row" style=" margin-top: 25px;">

            <div class=" col-xs-3">
              <label for="ex12">上傳圖片</label>
              <input id="myFile" type="file" name="myFile" multiple class="file-loading">
            </div>

            <div class=" col-xs-3">
              <input style=" margin-top: 15px;" type="submit" class="btn btn-primary" value="Add">
            </div>

          </div>
        </form>
        <!-- meal list -->
        <div class="row">
          <div class="  col-xs-8">
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Picture</th>
                  <th scope="col">meal name</th>
              
                  <th scope="col">price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Edit</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>
                <?php
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
                  if(isset($_SESSION['shop_name'])){
                    $shop_name = $_SESSION['shop_name'];
                    $stmt = $conn->prepare("select * from food where shop_name=:shop_name");
                    $stmt->execute(
                      array(
                        'shop_name' => $shop_name
                      )
                    );
                    $order = 0;
                    while($row=$stmt->fetch()){
                      $order++;
                      $id = $row['id'];
                      $picture_type = $row['picture_file_type'];
                      $picture = $row['picture'];
                      $meal_name = $row['name'];
                      $price = $row['price'];
                      $quantity = $row['quantity'];
                      print_row($order,$id,$picture_type,$picture,$meal_name,$price,$quantity);
                    }
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  <script>
    $(document).ready(function () {
      $(".nav-tabs a").click(function () {
        $(this).tab('show');
      });
    });
    
    <?php
      if(isset($_SESSION['jump'])&&$_SESSION['jump']==true){
        echo<<<EOT
          $(".nav-tabs a").tab('show');
        EOT;
        $_SESSION['jump'] = false;
      }
      else {
        echo<<<EOT
        $(document).ready(function () {
          $(".nav-tabs a").click(function () {
            $(this).tab('show');
          });
        });
        EOT;
      }
    ?>
    // tsu part
    <?php 
      if(isset($_SESSION['menu'])){
        echo<<<EOT
        $(function(){
            $('#macdonald').modal('show');
          }
        );
        EOT;
        unset($_SESSION['menu']) ; 
      }
    ?>
    // tsu part

  </script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>