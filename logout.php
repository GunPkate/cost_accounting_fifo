<?php
    session_start();
    session_destroy();
    echo "Log out <meta http-equiv='refresh' content='3;URL=login.php'/>"; //wait 3 sec
?>