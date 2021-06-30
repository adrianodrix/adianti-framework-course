<?php

use Adianti\Control\TPage;
use Adianti\Control\TWindow;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;

class OnDemandWindowView extends TPage
{
  public function __construct()
  {
    parent::__construct();
    
    try {
      $window = TWindow::create('Janela sob Demanda', 0.8, NULL);
      $html = new THtmlRenderer('app/resources/curso/page.html');
      $replace = [];
      $replace['title'] = 'Título';
      $replace['body'] = 'Text';
      $replace['footer'] = 'Rodapé';

      $html->enableSection('main', $replace); 
      $window->add($html);
      $window->show();      
    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());      
    }    
  }
}