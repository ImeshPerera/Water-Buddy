<?php
    session_start();

    $dbserver = "localhost";
    $dblocation = "root";
    $dbpassword = "Dilshan@1234";
    $dbname = "waterbills";
    
    $dbms = new mysqli($dbserver,$dblocation,$dbpassword,$dbname,"3306");

    $username = filter_var(trim($_POST["username"]), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST["password"]), FILTER_SANITIZE_STRING);
    $remember = $_POST["remember"];

    $query ="SELECT `username` FROM customer WHERE `username` = '$username';";
    $result = $dbms -> query($query);
    $userin = $result->num_rows;

    $query ="SELECT * FROM customer WHERE `username` = '$username' AND `password` = '".$password."';";
    $resultset = $dbms -> query($query);
    $n = $resultset->num_rows;

    if(empty($username)){
    echo "Please Enter Your Username";
    }elseif(strlen($username) > 15){
        echo "You Username length is too long.";
    }elseif($userin != 1){
        echo "Your Username is not Existed! Please Register";
    }elseif(empty($password)){
        echo "Your Password field is Empty";
    }elseif((strlen($password) < 5)||(strlen($password) > 15)){
        echo "Your Password length is not applicable";
    }elseif($n == 1){
        echo "Success";
        $data = $resultset->fetch_assoc();
        $_SESSION["user"] = $data;
        if($remember == "true"){
            setcookie("u",$username,time()+(60*60*24*365),"/");
            setcookie("p",$password,time()+(60*60*24*365),"/");
        }else{
            setcookie("u","",-1,"/");
            setcookie("p","",-1,"/");
        }
    }else{
        echo "Probably your password is Incorrect";
    }
?>