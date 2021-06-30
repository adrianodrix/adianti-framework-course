<?php

use Adianti\Control\TPage;
use Adianti\Widget\Base\TElement;

class EmbbedPDFView extends TPage
{
  public function __construct()
  {
    parent::__construct();  
    $obj = new TElement('iframe');
    $obj->width = '100%';
    $obj->height = '600px';
    $obj->src = 'https://www.adianti.com.br/framework_files/adianti_framework.pdf';
    $obj->type = 'application/pdf';

    parent::add($obj);
  }
}