<?php

use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;

class TemplateViewRepeat extends TPage
{
  public function __construct()
  {
    parent::__construct();

    try {
      $html = new THtmlRenderer('app/resources/curso/template-repeat.html');

      $replace   = [];
      $replace[] = ['id' => 1, 'nome' => 'Jowh Doe', 'endereco' => 'Rua 1'];
      $replace[] = ['id' => 2, 'nome' => 'Peter', 'endereco' => 'Rua 2'];
      $replace[] = ['id' => 3, 'nome' => 'Mary', 'endereco' => 'Rua 3'];

      $html->enableSection('main', []);      
      $html->enableSection('details', $replace, true);
      
      parent::add($html);
    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());      
    }    
  }
}