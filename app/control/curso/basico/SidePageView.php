<?php

use Adianti\Control\TPage;
use Adianti\Widget\Base\TScript;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;

class SidePageView extends TPage
{
  public function __construct()
  {
    parent::__construct();
    parent::setTargetContainer('adianti_right_panel');

    try {
      $html = new THtmlRenderer('app/resources/curso/side.html');
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

  public static function onClose()
  {
    TScript::create('Template.closeRightPanel()');
  }
}