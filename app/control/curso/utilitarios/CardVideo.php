<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Base\TScript;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Util\TCardView;

class CardVideo extends TPage
{
  public function __construct()
  {
    parent::__construct();

    $cards = new TCardView();

    $items = [];
    $items[] = (object) ['id' => 1, 'titulo' => 'Item 1', 'origem' => 'lsLS7nvAJ0I'];
    $items[] = (object) ['id' => 2, 'titulo' => 'Item 2', 'origem' => 'P2IaZ9w4E2g'];
    $items[] = (object) ['id' => 3, 'titulo' => 'Item 3', 'origem' => '0oSE0Fr9KSI'];
    $items[] = (object) ['id' => 4, 'titulo' => 'Item 4', 'origem' => 'Dtl-0-cHg-U'];
    $items[] = (object) ['id' => 5, 'titulo' => 'Item 5', 'origem' => '5_-xuX6mt7c'];

    foreach ($items as $item) {
      $cards->addItem($item);
    }

    $cards->setTitleAttribute('titulo');
    $cards->setItemTemplate('<iframe width="100%" height="300px" src="https://www.youtube.com/embed/{origem}"></iframe>');

    $edit = new TAction([$this, 'onEdit'], ['id' => '{id}']);
    $delete = new TAction([$this, 'onDelete'], ['id' => '{id}']);
    $ir = new TAction([$this, 'onGoToVideo'], ['origem' => '{origem}']);

    $cards->addAction($edit, 'Editar', 'fa:edit blue');
    $cards->addAction($delete, 'Excluir', 'fa:trash red');
    $cards->addAction($ir, 'Ver no Youtube', 'fa:share green');

    parent::add($cards);    
  }

  public static function onEdit($param) { new TMessage('info', json_encode($param)); }
  public static function onDelete($param) { new TMessage('error', json_encode($param)); }

  public static function onGoToVideo($param)
  {
    $origem = $param['origem'];
    TScript::create("window.open('https://www.youtube.com/watch?v={$origem}')");
  }
}
