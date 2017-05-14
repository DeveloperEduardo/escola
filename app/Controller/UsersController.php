<?php

require_once MY_FOLDER . "/../app/Model/UserModel.php";

class UsersController extends AppController{

    public function index() 
    {
        $user           = new UserModel();
        $user->per_page = 10;
        
        $user->paginate("SELECT COUNT(id) num FROM users");
        $pages = $user->pages;
        $user->num_page = (@$_GET['page'] > 0) ? $_GET['page'] : 1;
        
        $offset = 0;
        if($user->num_page > 1){
            $offset = (($user->num_page -1) * $user->per_page) +1;
        }
        
        $users = $user->search(
            "SELECT * FROM users "
            . "ORDER BY id ASC "
            . "LIMIT {$user->per_page} OFFSET {$offset}"
        );
        
        include MY_FOLDER . "/../app/View/Users/index.phtml";
    }
    
    public function view()
    {
        $user       = new UserModel();
        $user_exame = $user->get(14);
        $months     = [
            'Jan',
            'Fev',
            'Mar',
            'Abr',
            'Mai',
            'Jun',
            'Jul',
            'Ago',
            'Set',
            'Out',
            'Nov',
            'Dez'
        ];
        $notes = [];
        for($i = 0; $i < count($user_exame->exames); $i++){
            $notes[$i]['label'] =  $months[$i];
            $notes[$i]['y'] = (int) $user_exame->exames[$i]->value;
        }
        //echo json_encode($notes);
        //exit;        

        include MY_FOLDER . "/../app/View/Users/view.phtml";
    }

    public function query()
    {
        $user = new UserModel();
        $users = $user->search(""
            . "select * FROM users "
            . "WHERE "
            . "name LIKE '%{$_GET['q']}%' OR "
            . "cpf LIKE '%{$_GET['q']}%' OR "
            . "email LIKE '%{$_GET['q']}%'"
        );
        include MY_FOLDER . "/../app/View/Users/index.phtml";
    }

    public function add() {
        $errors = [];
        if (!empty($_POST)) {
            $user = new UserModel();
            $user->setName($_POST['name']);
            $user->setCpf($_POST['cpf']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            if ($user->save()) {
                header("Location: /?controller=users&action=index&ok=Cadastrado com sucesso!");
            }
            //print_r($user->errors);
            $errors = $user->errors;
        }
        include MY_FOLDER . "/../app/View/Users/add.phtml";
    }

    public function edit() {
        $errors = [];
        
        $user = new UserModel();

        $tmp_user = $user->search("SELECT * FROM users WHERE id = {$_GET["id"]}")[0];

        if (!empty($_POST)) {
            $user->setId($_POST['id']);
            $user->setName($_POST['name']);
            $user->setCpf($_POST['cpf']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            if ($user->edit()) {
                header("Location: /?controller=users&action=index&ok=Alterado com sucesso!");
            }
            //print_r($user->errors);
            $errors = $user->errors;
        }
        include MY_FOLDER . "/../app/View/Users/edit.phtml";
    }

    public function delete() {
        $user = new UserModel();
        $user->id = $_GET['id'];
        if ($user->delete()) {
            header("Location: /?controller=users&action=index&ok=Deletado com sucesso");
        }
    }

}
