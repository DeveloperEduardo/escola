<?php

class HomeController extends AppController
{
        //função dentro de uma classe e um metodo
	public function index()
	{
            //include nao para a aplicação, require para 
            include MY_FOLDER . "/../app/View/Home/index.phtml";
	}
	public function news()
	{
            //include nao para a aplicação, require para 
            include MY_FOLDER . "/../app/View/Home/news.phtml";
	}

}