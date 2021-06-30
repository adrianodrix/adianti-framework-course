<?php

use Adianti\Control\TPage;

class TesteView extends TPage
{
  public function __construct()
  {
    parent::__construct();
    echo 'constructor</br>';
  }

  public function onEvento($param)
  {
    echo 'evento </br>';
    if (array_key_exists('nome', $param))
    {
      echo '<h1>';
      echo $param['nome'];
      echo '</h1>';
    }

    echo '<pre>';
    var_dump($param);
    echo '</pre>';
  }

  public static function onEventoEstatico()
  {
    echo 'evento estatico </br>';
  }

  public function show()
  {
    parent::show();
    echo 'show</br>';
  }
}