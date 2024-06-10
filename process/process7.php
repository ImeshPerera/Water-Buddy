<?php

// Sign Out Process is Here

session_start();

if(isset($_SESSION["myuser"])){
    $_SESSION["myuser"] = null;
    session_destroy();
    echo "Success";
}
if(isset($_SESSION["myadmin"])){
    $_SESSION["myadmin"] = null;
    session_destroy();
    echo "Success";
}

?>