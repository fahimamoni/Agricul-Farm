<?php

include 'config.php';

if(isset($_POST['submit'])){
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$birthday = $_POST['date'];
	$address = mysqli_real_escape_string($conn, $_POST['address']);
	$gender = $_POST['gender'];
	// $image = $_POST['image'];
	$pass = md5($_POST['password']);
	$cpass = md5($_POST['cpassword']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
	$select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";
	$check =  "SELECT * FROM user_form WHERE email = '$email'";
	$result = mysqli_query($conn, $select);
	$result_check = mysqli_query($conn, $check);


	if(mysqli_num_rows($result) > 0){

		$error[] = 'user already exists!';

	}elseif(mysqli_num_rows($result_check) > 0){

		$error[] = 'this email already used!';

	}else{

		if($pass != $cpass){
			$error[] = 'password didnot matched!';
		}else{
			$insert = "INSERT INTO user_form(name, email, birthday, address, gender, password, image)
			 VALUES('$name', '$email','$birthday', '$address','$gender', '$pass','$image')";
			 mysqli_query($conn, $insert);
			 header('location:login.php');
		}
	}
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/login_style.css">

</head>
<style>
   body {
            background-image: url('images/background.webp');
            background-size: cover;
            justify-content: left;
        }
</style>
<body>
   
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>register now</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="text" name="name" placeholder="enter username" class="box" required>
      <input type="email" name="email" placeholder="enter email" class="box" required>
      <input type="date" name="date" placeholder="date of birth" class="box" required>
      <input type="text" name="address" placeholder="address here" class="box" required>
      <p> <i class="fa-solid fa-person"></i> select your gender </p>
		<div id="Gender">
			<label for="Gender"></label>
			<input type="radio" name="gender" value="Male" required> <i>male</i>
			<input type="radio" name="gender" value="Female" required><i>female</i>
			<input type="radio" name="gender" value="Others" required><i>others</i>
		</div>
      <input type="password" name="password" placeholder="enter password" class="box" required>
      <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>
</div>

</body>
</html>