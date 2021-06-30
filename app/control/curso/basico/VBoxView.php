<?php
use Adianti\Control\TPage;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Container\THBox;
use Adianti\Widget\Container\TNotebook;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Util\TXMLBreadCrumb;

class VBoxView extends TPage
{
  public function __construct()
  {
    parent::__construct();
    
    $body = new TElement('body');
    
    $notebook1 = new TNotebook;    
    $notebook1->appendPage('Aba 1', new TLabel('Conteúdo 1'));
    $notebook1->appendPage('Aba 2', new TLabel('Conteúdo 2'));

    $notebook2 = new TNotebook;    
    $notebook2->appendPage('Aba 1', new TLabel('Conteúdo 1'));
    $notebook2->appendPage('Aba 2', new TLabel('Conteúdo 2'));

    $boxBreadCrum = new TVBox;
    $boxBreadCrum->add(new TXMLBreadCrumb('menu.xml', __CLASS__));

    $vbox = new THBox;
    $vbox->style = 'width: 100%';
    $vbox->add($notebook1);
    $vbox->add($notebook2);

    $body->add($boxBreadCrum);
    $body->add($vbox);
    parent::add($body);
  }
}