<?php
$dbserver = "localhost";
$dblocation = "root";
$dbpassword = "Dilshan@1234";
$dbname = "waterbills";

$dbms = new mysqli($dbserver,$dblocation,$dbpassword,$dbname,"3306");

$fullname = filter_var(trim($_POST["fullname"]), FILTER_SANITIZE_STRING);
$accountno = filter_var(trim($_POST["accountno"]), FILTER_SANITIZE_NUMBER_INT);
$address = filter_var(trim($_POST["address"]), FILTER_SANITIZE_STRING);
$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
$username = filter_var(trim($_POST["username"]), FILTER_SANITIZE_STRING);
$password = filter_var(trim($_POST["password"]), FILTER_SANITIZE_STRING);

if(empty($fullname)){
    echo "Please Enter Your Full Name First";
}elseif(strlen($fullname) >= 50){
    echo "You Name length is too long.";
}elseif(empty($accountno)){
    echo "Please Enter Your Account No";
}elseif(strlen($accountno) > 10){
    echo "You Account No length is too long.";
}elseif(empty($address)){
    echo $address."Please Enter Your Address hiii";
}elseif(strlen($address) >= 50){
    echo "You Address length is too long.";
}elseif(empty($email)){
    echo "Please Enter Your Email";
}elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo "Your Email is not Validated. Type a Correct One";
}elseif(strlen($email) > 30){
    echo "your email length is exceed the limit.";
}elseif(empty($password)){
    echo "Your Password field is Empty";
}elseif((strlen($password) < 5)||(strlen($password) > 15)){
    echo "Your Password length is not applicable. It must be 5-15 characters";
}elseif(empty($username)){
    echo "Your Username field is Empty";
}elseif(strlen($username) > 15){
    echo "You Username length is too long.";
}else{
    
    $query ="SELECT `username` FROM customer WHERE `username` = '$username';";
    $resultset = $dbms -> query($query);
    if($resultset->num_rows > 0){
        echo "User with the same username is already exsist! Choose another one !";
    }else{
        $query ="INSERT INTO customer(`username`,`name`,`address`,`email`,`waterbill`,`password`) VALUES('".$username."','".$fullname."','".$address."','".$email."','".$accountno."','".$password."');";
        $dbms -> query($query);
        echo "Success";
    }
}
?>