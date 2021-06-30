<?php

use Adianti\Control\TPage;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TTable;

class PanelGroupView extends TPage
{
  public function __construct()
  {
    parent::__construct();

    $panel = new TPanelGroup('Título do Painel');    
    
    $panel->add(self::genTable());
    $panel->addFooter('rodapé');

    parent::add($panel);
  }

  private static function genTable()
  {
    $table = new TTable;
    $table->border = '1';
    $table->cellpadding = '4';
    $table->style = 'border-collapse: collapse';
    $table->width = '100%';

    $table->addRowSet('A1', 'A2');
    $table->addRowSet('B1', 'B2');
    $table->addRowSet('C1', 'C2');
    
    return $table;
  }
}