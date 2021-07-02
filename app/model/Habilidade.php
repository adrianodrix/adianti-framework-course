<?php

use Adianti\Database\TRecord;

class Habilidade extends TRecord
{
  const TABLENAME = 'habilidade';
  const PRIMARYKEY = 'id';
  const IDPOLICY = 'max';

  public function __construct($id = null, $callObjectLoad = TRUE)
  {
    parent::__construct($id, $callObjectLoad);
    parent::addAttribute('nome');
  }
}