<!--<html>-->
<!--<body>-->

<!--<form action="http://ppmapi.amikom.ac.id/api/auth" method="POST">-->
<!--Email/HP: <input type="text" name="UserId"><br>-->
<!--Pass: <input type="text" name="UserPwd"><br>-->
<!--<input type="submit">-->
<!--</form>-->

<!--</body>-->
<!--</html>-->
<?php

    $url="http://ppmapi.amikom.ac.id/api/auth";
    $param=array('UserId' => 'mnuraminuddin@gmail.com', 'UserPwd' => 'wKkXAt7');
     
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    
    echo $response;
