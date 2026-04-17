<?php
 define('HOST','localhost');
 define('USER','ppm_2016');
 define('PASS','Y%1%QI7am(9M');
 define('DB','ppm_2016');

 $con = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect');
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 //Getting values
 $username = $_POST['username'];
 $password = md5($_POST['password']);

 //Creating sql query
 $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";

 //executing query
 $result = mysqli_query($con,$sql);

 //fetching result
 $check = mysqli_fetch_array($result);

 //if we got some result
 if(isset($check)){
 //displaying success
 echo "success";
 }else{
 //displaying failure
 echo "failure";
 }
 mysqli_close($con);
 }
?>
