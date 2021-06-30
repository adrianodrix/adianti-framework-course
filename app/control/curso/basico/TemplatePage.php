<?php

use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;

class TemplatePage extends TPage
{
  public function __construct()
  {
    parent::__construct();

    try {
      $html = new THtmlRenderer('app/resources/learn.html');

      $html->enableSection('main', []);      
      parent::add($html);
    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());      
    }    
  }
}