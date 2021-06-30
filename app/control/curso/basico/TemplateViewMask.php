<?php

use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;

class TemplateViewMask extends TPage
{
  public function __construct()
  {
    parent::__construct();

    try {
      $html = new THtmlRenderer('app/resources/curso/template_masks.html');
      $replace = [];
      $replace['date'] = date('Y-m-d');
      $replace['datetime'] = date('Y-m-d H:i:s');
      $replace['number'] = 123456.78;
      $replace['value1'] = 10;
      $replace['value2'] = 20;
      $replace['value3'] = 30;

      $html->enableSection('main', $replace);

      parent::add($html);
    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());      
    }    
  }
}