<?php

use Adianti\Database\TRecord;

class Venda extends TRecord
{
  const TABLENAME = 'venda';
  const PRIMARYKEY = 'id';
  const IDPOLICY = 'max';

  private $cliente;

  public function __construct($id = null, $callObjectLoad = TRUE)
  {
    parent::__construct($id, $callObjectLoad);
    parent::addAttribute('dt_venda');
    parent::addAttribute('total');
    parent::addAttribute('cliente_id');
    parent::addAttribute('obs');
  }

  public function get_cliente()
  {
    if(empty($this->cliente)) {
      $this->cliente = new Cliente($this->cliente_id);
    }
    return $this->cliente;
  }
}