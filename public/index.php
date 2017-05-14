<?php

const MY_FOLDER = __DIR__;

require "../config/app.php";
require "../app/Utils/Utils.php";
require "../app/Controller/AppController.php";
require "../app/Controller/HomeController.php";
require "../app/Controller/UsersController.php";

$controller = @$_GET['controller'];
$action = @$_GET['action'];

// pagina de inicio em HomeController.
if ($controller == false && $action == false) {

    $init = new HomeController();
    $init->index();
}
//Chama a tela de listagem dos usuarios em UsersController.

if ($controller == "users" && $action == "index") {
    $init = new UsersController();
    $init->index();
}
//Chama a tela de adicionar usuarios em UsersController.
if ($controller == "users" && $action == "add") {
    $init = new UsersController();
    $init->add();
}
if ($controller == "users" && $action == "delete") {
    $init = new UsersController();
    $init->delete();
}
if ($controller == "users" && $action == "edit") {
    $init = new UsersController();
    $init->edit();
}

if ($controller == "users" && $action == "query") {
    $init = new UsersController();
    $init->query();
}

if ($controller == "users" && $action == "view") {
    $init = new UsersController();
    $init->view();
}

// Auth controller
if ($controller == "auth" && $action == "login") {
    $init = new AuthController();
    $init->login();
}
