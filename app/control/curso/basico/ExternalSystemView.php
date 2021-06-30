<?php

use Adianti\Control\TPage;
use Adianti\Widget\Base\TElement;

class ExternalSystemView extends TPage
{
  public function __construct()
  {
    parent::__construct();  
    $obj = new TElement('iframe');
    $obj->width = '100%';
    $obj->height = '600px';
    $obj->src = 'https://getbootstrap.com/docs/4.0/components/card/';
    $obj->frameborder = '0';

    parent::add($obj);
  }
}