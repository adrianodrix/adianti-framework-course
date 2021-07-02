<?php

use Adianti\Database\TRecord;

class Venda extends TRecord
{
  const TABLENAME = 'venda';
  const PRIMARYKEY = 'id';
  const IDPOLICY = 'max';

  public function __construct($id = null, $callObjectLoad = TRUE)
  {
    parent::__construct($id, $callObjectLoad);
    parent::addAttribute('dt_venda');
    parent::addAttribute('total');
    parent::addAttribute('cliente_id');
    parent::addAttribute('obs');
  }
}