
<?php
$bd = mysqli_connect("localhost", "root", "", "read");
if($bd){
  //echo 'database connection established!';
}else{
  echo 'database connection error!';
}

?>

<?php

if (isset($_POST['add_user'])){
    $username = $_POST['username'];
    $useremail = $_POST['useremail'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];
    if(  $password === $re_password ){
      $hass = sha1($password);
      $query = "INSERT INTO userdata(username, useremail, password) VALUES('$username', '$useremail', '$hass')";
      $res = mysqli_query($bd,$query);
         if( $res){
         header('location: index.php');
         }else{
           echo 'your data error!';
         }

    }else{
       echo '<span class="alert alert-danger">Password not matched!</span>';
    }


}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Crud in php</title>
  </head>
  <body>
      <div class="container">
          <h2 class="my-2 text-center ">CRED IN PHP</h2>
          <div class="row">
              <div class="col-md-4 offset-1">
                  <!-- from section -->
                  <form method="POST">

                      <div class="form-group my-3">
                          <input type="text" name="username" placeholder="username" class="form-content" required>
                      </div>
                      <div class="form-group my-3">
                        <input type="email" name="useremail" placeholder="useremail" class="form-content" required>
                      </div>
                      <div class="form-group my-3">
                        <input type="password" name="password" placeholder="password" class="form-content" required>
                      </div>
                      <div class="form-group my-3">
                        <input type="password" name="re_password" placeholder="confirm password" class="form-content" required>
                      </div>
                      <div class="form-group my-3">
                        <input type="submit" name="add_user" value="submit" class="btn btn-1 btn-primary">
                      </div>
                  </form>
             
    <?php
      if(isset($_GET['edit_id'])){
        $edit = $_GET['edit_id'];

       $sql1 = "SELECT * FROM userdata WHERE u_id='$edit'";
       $res4 = mysqli_query($bd,$sql1);

       $row = (mysqli_fetch_assoc($res4));
        $u_id = $row['u_id'];
        $username = $row['username'];
        $useremail = $row['useremail'];
        

       ?>
         <form method="POST">
          <h2>Update Information</h2>
      <div class="form-group my-3">
          <input type="text" name="username" placeholder="username" class="form-content" value="<?php echo $username;?>">
      </div>
      <div class="form-group my-3">
        <input type="email" name="useremail" placeholder="useremail" class="form-content" value="<?php echo $useremail;?>">
      </div>
      <div class="form-group my-3">
        <input type="password" name="password" placeholder="set a new password" class="form-content">
      </div>
      
      <div class="form-group my-3">
        <input type="submit" name="update_user" value="update" class="btn btn-1 btn-primary">
      </div>
      </form>
        <?php
      if(isset($_POST['update_user'])){
        $username  = $_POST['username'];
        $useremail = $_POST['useremail'];
        $password  = $_POST['password'];
        if(!empty($password)){
       
        $sql6 = "UPDATE userdata SET username ='$username', useremail =' $useremail', password =' $password' WHERE u_id='$edit'";
        
        }else{  
        $sql6 = "UPDATE userdata SET username ='$username', useremail =' $useremail', WHERE u_id='$edit'";
       
        }
        $res6 = mysqli_query($bd,$sql6);
        if( $res6){
          header('location: index.php');
          }else{
            echo 'Delete info error!';
          }

      }

    ?> 

       
       <?php
      }
    ?>
              </div>
              <div class="col-md-7">
                  <!-- table section  -->
                  <div class="card my-3">
                      <h3 class=" text-center">All Information</h3>
                      <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">username</th>
      <th scope="col">Email</th>
      <th scope="col">Action</th>
    </tr>

      <?php

  $sql="SELECT * FROM userdata";
  $res=mysqli_query($bd,$sql);
  $serial = 0;
    
  while($row=mysqli_fetch_assoc($res)){

    $id=$row['u_id'];
    $serial++;
    ?>
    <tr>
    <th scope="row"><?php echo $serial;?></th>
    <td><?php echo $row['username'];?></td>
    <td><?php echo $row['useremail'];?></td>
    <td>
      <a href="index.php?edit_id=<?php echo $row['u_id'];?>" class="btn btn-sm btn-warning">Edit</a>
      <a href="index.php?delete_id=<?php echo $row['u_id'];?>" class="btb btn-sm btn-danger">Delete</a>
    </td>
    </tr>
    <?php
  }

  ?>
  </thead>
  <tbody>
   
 
  </tbody>
</table>
                
                  </div>
              </div>
          </div>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- delete opeartion -->
 <?php
  if(isset($_GET['delete_id'])){
    $del_id = $_GET['delete_id'];

    $sql = "DELETE FROM userdata WHERE u_id ='$del_id'";
    $res3 = mysqli_query($bd,$sql);

    if($res3){
      header('Location: index.php');
    }else{
      echo 'Info Delete error!';
    }
  }
 
 ?>
<?php ob_end_flush(); ?>
  </body>
</html>