<?php

class AppController
{

    function __construct() 
    {
        session_start();
        if(!isset($_SESSION))
        {
            $_SESSION['logged'] = false;
            sheader("Location: /");
        }
    }

}