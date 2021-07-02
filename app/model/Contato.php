<?php

use Adianti\Database\TRecord;

class Contato extends TRecord
{
  const TABLENAME = 'contato';
  const PRIMARYKEY = 'id';
  const IDPOLICY = 'max';

  public function __construct($id = null, $callObjectLoad = TRUE)
  {
    parent::__construct($id, $callObjectLoad);
    parent::addAttribute('tipo');
    parent::addAttribute('valor');
    parent::addAttribute('cliente_id');
  }
}