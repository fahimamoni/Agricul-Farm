<?php
// create connection with MySQL server
$conn = mysqli_connect('localhost', 'root');

// check connection
if ($conn) {
    echo "Connection successful";
} else {
    echo "No Connection";
}

// select database for the connection
mysqli_select_db($conn, 'agricul_farm');

// user input ids = POST attribute of contact
$user = $_POST['user'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$comment = $_POST['comment'];

// insert data into contact table 
$query = "insert into contact (user, email, mobile, comment) values('$user', '$email', '$mobile', '$comment')";

// executes the given query on selected database
mysqli_query($conn, $query);

// after successfully send the msg, go back to home page 
header('location:home.php');
