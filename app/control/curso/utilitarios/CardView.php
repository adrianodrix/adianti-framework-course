<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Util\TCardView;

class CardView extends TPage
{
  public function __construct()
  {
    parent::__construct();

    $cards = new TCardView();

    $items = [];
    $items[] = (object) ['id' => 1, 'titulo' => 'Item 1', 'conteudo' => 'conteudo do item 1'];
    $items[] = (object) ['id' => 2, 'titulo' => 'Item 2', 'conteudo' => 'conteudo do item 2'];
    $items[] = (object) ['id' => 3, 'titulo' => 'Item 3', 'conteudo' => 'conteudo do item 3'];
    $items[] = (object) ['id' => 4, 'titulo' => 'Item 4', 'conteudo' => 'conteudo do item 4'];
    $items[] = (object) ['id' => 5, 'titulo' => 'Item 5', 'conteudo' => 'conteudo do item 5'];

    foreach ($items as $item) {
      $cards->addItem($item);
    }

    $cards->setTitleAttribute('titulo');
    $cards->setItemTemplate('conteudo');

    $edit = new TAction([$this, 'onEdit'], ['id' => '{id}']);
    $delete = new TAction([$this, 'onDelete'], ['id' => '{id}']);

    $cards->addAction($edit, 'Editar', 'fa:edit blue');
    $cards->addAction($delete, 'Excluir', 'fa:trash red');

    parent::add($cards);    
  }

  public static function onEdit($param) { new TMessage('info', json_encode($param)); }
  public static function onDelete($param) { new TMessage('error', json_encode($param)); }
}