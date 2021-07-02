<?php

use Adianti\Widget\Form\TEntry;

class TNYEmail extends TEntry
{
  public function __construct($name)
  {
    parent::__construct($name);
    $this->forceLowerCase();
    $this->setInputType('email');
  }
}