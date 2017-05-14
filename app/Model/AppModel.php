<?php

class AppModel {

    public $connection;
    public $per_page;
    public $pages;
    public $num_page;
    
    function __construct() {
        $this->connection = new PDO(
                "mysql" .
                ":host=127.0.0.1" .
                ";dbname=escola-1.0" .
                ";charset=UTF8", "root", ""
        );
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    
    public function paginate($sql)
    {
        $total =  $this->search($sql)[0]->num;
        $this->pages = ($total / $this->per_page);
        if($total % $this->per_page)
        {
            $this->pages = (int) ($this->pages + 1);
        }
        
    }

    /*
     * Buscar registro no banco de dados 
     * @parametro $query_sql String 
     * @return registers array
     */
    public function search($query_sql) {
        $query = $this->connection->query($query_sql);
        return $query->fetchALL(PDO::FETCH_OBJ);
    }

}
