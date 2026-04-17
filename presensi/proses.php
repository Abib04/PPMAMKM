<?php
session_start();
include 'koneksi.php';
	
	if(isset($_POST['masuk'])) {
		
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = md5($_POST['password']);
    $acara = $_POST['acara'];
    $ruang = $_POST['ruang'];

    $query = mysqli_query($db, "SELECT * FROM admin WHERE username = '$username' AND password = '$password'");
    $xxx = mysqli_num_rows($query);

    if (empty($username) && empty($password)) {
        header('location: login.php?a=salahl');
    } elseif (empty($ruang) && empty($acara)) {
        header('location:login.php?a=pilihr');
    } else {

        if($xxx > 0)
        {
            $_SESSION['username'] = $username;
        	$_SESSION['ruang'] = $ruang;
            $_SESSION['acara'] = $acara;
            header('location:index.php');
        }
        else
        {
            header('location:login.php?a=salahl');
        }
}
}
?>
