<?php
use Adianti\Control\TPage;
use Adianti\Widget\Template\THtmlRenderer;

class GraficoLinhas extends TPage
{
  public function __construct()
  {
    parent::__construct();
    
    $html = new THtmlRenderer('app/resources/google_line_chart.html');

    $data = [];
    $data[] = ['Dia', 'Leads', 'Assinantes'];
    $data[] = ['1/10', 400, 22];
    $data[] = ['2/10', 321, 32];
    $data[] = ['3/10', 122, 120];

    $html->enableSection('main', [
                                  'data' => json_encode($data),
                                  'width' => '100%',
                                  'height' => '300px',
                                  'title' => 'Acessos por dia',
                                  'uniqid' => uniqid(),
                                  'ytitle' => 'Dias',
                                  'xtitle' => 'Quantidade'
    ]);

    parent::add($html);    
  }
}