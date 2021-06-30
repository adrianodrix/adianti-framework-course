<?php

use Adianti\Control\TPage;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;
use Adianti\Widget\Util\TXMLBreadCrumb;

class SinglePageView extends TPage
{
  public function __construct()
  {
    parent::__construct();

    try {
      $html = new THtmlRenderer('app/resources/curso/page.html');
      $replace = [];
      $replace['title'] = 'Título';
      $replace['body'] = 'Text';
      $replace['footer'] = 'Rodapé';

      $html->enableSection('main', $replace);   
      
      $vbox= new TVBox;
      $vbox->style = 'width: 100%';
      $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
      $vbox->add($html);

      parent::add($vbox);
    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());      
    }    
  }
}