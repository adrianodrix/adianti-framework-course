<?php

use Adianti\Control\TWindow;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;

class ModalWindowView extends TWindow
{
  public function __construct()
  {
    parent::__construct();
    parent::setSize(0.6, NULL);
    parent::disableScrolling();
    parent::removePadding();
    parent::removeTitleBar();
    parent::disableEscape();    

    try {
      $html = new THtmlRenderer('app/resources/curso/modal.html');

      $html->enableSection('main', []);      
      parent::add($html);
    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());      
    }    
  }
}