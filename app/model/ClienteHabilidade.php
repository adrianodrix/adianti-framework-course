<?php

use Adianti\Database\TRecord;

class ClienteHabilidade extends TRecord
{
  const TABLENAME = 'cliente_habilidade';
  const PRIMARYKEY = 'id';
  const IDPOLICY = 'max';

  public function __construct($id = null, $callObjectLoad = TRUE)
  {
    parent::__construct($id, $callObjectLoad);
    parent::addAttribute('cliente_id');
    parent::addAttribute('habilidade_id');
  }
}