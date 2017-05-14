<?php

require_once MY_FOLDER . "/../app/Model/AppModel.php";

class UserModel extends AppModel {

    public $id;
    public $name;
    public $cpf;
    public $email;
    public $password;
    public $exames = [];
    public $errors = [];
    
    public function save() {
        if (empty($this->errors)) {
            $query = $this->connection->prepare(
                "INSERT INTO users(name, cpf, email, password, level) 
                VALUES(:name, :cpf, :email, :password, :level)"
            );
            return $query->execute([
                'name' => $this->name,
                'cpf' => $this->cpf,
                'email' => $this->email,
                'password' => $this->password,
                'level' => 1
            ]);
        }
    }
    
    public function get($id)
    {
        $user           = $this->search("SELECT * from users WHERE id = $id")[0];
        $user->exames   = $this->search("SELECT * from exames WHERE user_id = $id");
        return $user;
    }

    public function delete() {
        $query = $this->connection->prepare("DELETE from users WHERE id= {$this->id}");
        return $query->execute();
    }

    public function edit() {
        if (empty($this->errors)) {
            $query = $this->connection->prepare(""
                . "UPDATE users SET "
                . "name=:name, "
                . "cpf=:cpf, "
                . "email=:email, "
                . "password=:password "
                . "WHERE id= {$this->id}"
            . "");
            return $query->execute(
                [
                    'name' => $this->name, 
                    'cpf' => $this->cpf,
                    'email' => $this->email, 
                    'password' => $this->password
                ]
            );
        }
    }

    public function setName($name) {
        if ($name == "") {
            $this->errors['name'] = "nome vazio";
        } else {
            $this->name = $name;
        }
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    function setCpf($cpf) {
        if ($cpf == "") {
            $this->errors['cpf-1'] = "cpf vazio";
        }
        if (!$this->validar_cpf($cpf)) {
            $this->errors['cpf-2'] = "cpf invalido!";
        } else {
            $this->cpf = $cpf;
        }
    }

    function setEmail($email) 
    {
        // checa se vazio
        if (strlen($email) == 0) 
        {
            $this->errors['email'] = "Email vazio";
        } else 
        {
            // Checa se email já foi utilizado
            $users = $this->search("SELECT * FROM users where email = '$email'");
            // Checa se o email nao foi cadastrada anteriormente
            if (empty($users))
            {
                $this->email = $email;
            }
            else{
                if ($this->id == $users[0]->id) 
                {
                    $this->email = $email;
                } else 
                {
                    $this->errors['email'] = "Email já utilizado";
                }
            }
        }
    }

    function setPassword($password) {
        if (strlen($password) < 6) {
            $this->errors['password'] = "Senha muito curta";
        } else {
            $this->password = $password;
        }
    }

    function validar_cpf($cpf) {
        $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
        // Valida tamanho
        if (strlen($cpf) != 11)
            return false;
        // Calcula e confere primeiro dígito verificador
        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Calcula e confere segundo dígito verificador
        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
    }

}
