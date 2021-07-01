<?php

use Adianti\Database\TRecord;

class Cidade extends TRecord
{
  const TABLENAME = 'cidade';
  const PRIMARYKEY = 'id';
  const IDPOLICY = 'max';

  private $estado;

  public function __construct($id = null, $callObjectLoad = TRUE)
  {
    parent::__construct($id, $callObjectLoad);
    parent::addAttribute('nome');
    parent::addAttribute('estado_id');
  }

  public function get_estado()
  {
    if(empty($this->estado)) {
      $this->estado = new Estado($this->estado_id);
    }
    return $this->estado;
  }
}