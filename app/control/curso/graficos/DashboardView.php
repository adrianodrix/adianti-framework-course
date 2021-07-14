<?php
use Adianti\Control\TPage;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Template\THtmlRenderer;

class DashboardView extends TPage
{
  public function __construct()
  {
    parent::__construct();
    
    $div = new TElement('div');
    $div->class = 'row';

    $indicator1 = new THtmlRenderer('app/resources/info-box.html');
    $indicator2 = new THtmlRenderer('app/resources/info-box.html');
    $indicator3 = new THtmlRenderer('app/resources/info-box.html');

    $indicator1->enableSection('main', [
      'title' => 'Acessos',
      'icon' => 'sign-in-alt',
      'background' => 'green',
      'value' => 100
    ]);

    $indicator2->enableSection('main', [
      'title' => 'Clientes',
      'icon' => 'user',
      'background' => 'blue',
      'value' => 222
    ]);

    $indicator3->enableSection('main', [
      'title' => 'Vendas',
      'icon' => 'comment-dollar',
      'background' => 'orange',
      'value' => 'R$ 1.254.200,52'
    ]);

    $div->add($i1 = TElement::tag('div', $indicator1));
    $div->add($i2 = TElement::tag('div', $indicator2));
    $div->add($i3 = TElement::tag('div', $indicator3));

    $div->add($g1 = new GraficoBarras);
    $div->add($g2 = new GraficoLinhas);
    $div->add($g3 = new GraficoColunas);
    $div->add($g4 = new GraficoPizza);    

    $i1->class = 'col-sm-4';
    $i2->class = 'col-sm-4';
    $i3->class = 'col-sm-4';

    $g1->class = 'col-sm-6';
    $g2->class = 'col-sm-6';
    $g3->class = 'col-sm-6';
    $g4->class = 'col-sm-6';

    parent::add($div);    
  }
}
