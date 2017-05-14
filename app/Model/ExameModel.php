<?php

require_once MY_FOLDER . "/../app/Model/appModel.php";

class ExameModel extends AppModel {

    public $value;
    public $user_id;
    public $errors = [];

    public function setValue($value) {

        if ($value > 10 || $value < 0) {
            $this->errors['value'] = "Valor tem que está entre 0 e 10";
        } else {
            $this->value = $value;
        }
    }

}
