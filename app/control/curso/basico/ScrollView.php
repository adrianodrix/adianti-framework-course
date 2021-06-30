<?php

use Adianti\Control\TPage;
use Adianti\Widget\Container\TScroll;
use Adianti\Widget\Container\TTable;
use Adianti\Widget\Form\TEntry;

class ScrollView extends TPage
{
  public function __construct()
  {
    parent::__construct();

    $scroll = new TScroll();
    $scroll->setSize('100%', '300');
    $scroll->add(self::genTable());

    parent::add($scroll);
  }

  private static function genTable()
  {
    $table = new TTable;
    $table->border = '1';
    $table->cellpadding = '4';
    $table->style = 'border-collapse: collapse';
    $table->width = '100%';

    for ($i=1; $i <= 20; $i++) { 
      $obj = new TEntry('field'. $i);
      $table->addRowSet('Field'. $i, $obj);
    }

    return $table;
  }
}