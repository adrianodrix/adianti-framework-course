<?php
use Adianti\Control\TPage;
use Adianti\Widget\Template\THtmlRenderer;

class GraficoPizza extends TPage
{
  public function __construct()
  {
    parent::__construct();
    
    $html = new THtmlRenderer('app/resources/google_pie_chart.html');

    $data = [];
    $data[] = ['Pessoa', 'Valor'];
    $data[] = ['Pedro', 400];
    $data[] = ['Pedro', 321];
    $data[] = ['Pedro', 122];

    $html->enableSection('main', [
                                  'data' => json_encode($data),
                                  'width' => '100%',
                                  'height' => '300px',
                                  'title' => 'Acessos por dia',
                                  'uniqid' => uniqid()
    ]);

    parent::add($html);    
  }
}