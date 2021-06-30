<?php

use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;

class TemplateViewBasico extends TPage
{
  public function __construct()
  {
    parent::__construct();

    try {
      $html = new THtmlRenderer('app/resources/curso/template-basico.html');

      $cliente = new stdClass;
      $cliente->nome = 'John Doe';
      $cliente->foto = 'https://i.pravatar.cc/300';
      $cliente->bio = 'Mussum Ipsum, cacilds vidis litro abertis. Viva Forevis aptent taciti sociosqu ad litora torquent. Copo furadis é disculpa de bebadis, arcu quam euismod magna. Delegadis gente finis, bibendum egestas augue arcu ut est. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.';

      $replaces = [];
      $replaces['cliente'] = $cliente;

      $html->enableSection('main', $replaces);
      $html->enableSection('outros', ['bio' => $cliente->bio]);
      parent::add($html);
    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());      
    }    
  }
}