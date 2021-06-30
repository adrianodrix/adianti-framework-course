<?php

use Adianti\Control\TPage;
use Adianti\Widget\Base\TElement;

class EmbbedVideoView extends TPage
{
  public function __construct()
  {
    parent::__construct();  
    $obj = new TElement('iframe');
    $obj->width = '100%';
    $obj->height = '600px';
    $obj->src = 'https://www.youtube.com/embed/Cc7Ofruts4M';
    $obj->frameborder = '0';
    $obj->allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';

    parent::add($obj);
  }
}