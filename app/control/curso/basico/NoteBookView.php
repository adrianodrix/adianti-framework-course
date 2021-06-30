<?php

use Adianti\Control\TPage;
use Adianti\Widget\Container\TNotebook;
use Adianti\Widget\Form\TLabel;

class NoteBookView extends TPage
{
  public function __construct()
  {
    parent::__construct();

    $notebook = new TNotebook;
    
    $notebook->appendPage('Aba 1', new TLabel('Conteúdo 1'));
    $notebook->appendPage('Aba 2', new TLabel('Conteúdo 2'));
    
    parent::add($notebook);
  }
}