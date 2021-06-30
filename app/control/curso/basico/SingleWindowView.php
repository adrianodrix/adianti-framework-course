<?php

use Adianti\Control\TWindow;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;

class SingleWindowView extends TWindow
{
  public function __construct()
  {
    parent::__construct();
    parent::setTitle('Janela Simples');
    parent::setSize(0.9, NULL);

    try {
      $html = new THtmlRenderer('app/resources/curso/page.html');
      $replace = [];
      $replace['title'] = 'Título';
      $replace['body'] = 'Text';
      $replace['footer'] = 'Rodapé';

      $html->enableSection('main', $replace);   
      
      parent::add($html);
    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());      
    }    
  }
}