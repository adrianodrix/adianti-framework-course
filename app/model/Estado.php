<?php

use Adianti\Database\TRecord;

class Estado extends TRecord
{
  const TABLENAME = 'estado';
  const PRIMARYKEY = 'id';
  const IDPOLICY = 'max';

  public function __construct($id = null, $callObjectLoad = TRUE)
  {
    parent::__construct($id, $callObjectLoad);
    parent::addAttribute('nome');
  }
}