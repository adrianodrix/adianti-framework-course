<?php

use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Form\TEntry;

class TNYRequiredEntry extends TEntry
{
  public function __construct($name)
  {
    parent::__construct($name);
    $this->addValidation($name, new TRequiredValidator);
    $this->style = 'border-color: red';
  }
}