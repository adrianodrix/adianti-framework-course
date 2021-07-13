<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Form\TSortList;
use Adianti\Widget\Wrapper\TDBSortList;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormSortList extends TPage
{
  private $form;

  public function __construct()
  {
    parent::__construct();
    
    $this->form = new BootstrapFormBuilder;
    $this->form->setFormTitle('Lista de Ordenação');

    //$list1 = new TSortList('list1');
    $list1 = new TDBSortList('list1', 'curso', Categoria::class, 'id', 'nome');
    $list2 = new TSortList('list2');

    $list1->setSize(150,200);
    $list2->setSize(150,200);

    $list1->connectTo($list2);
    $list2->connectTo($list1);

    // $list1->addItems(['a' => 'Opção A', 'b' => 'Opção B', 'c' => 'Opção C']);

    $this->form->addFields([$list1, $list2]);
    $this->form->addAction('Enviar', new TAction([$this, "onSend"]), 'far:check-circle');
    parent::add($this->form);    
  }

  public function onSend($param)
  {
    $data = $this->form->getData();
    $this->form->setData($data);

    echo '<pre>';
    var_dump($param['list1']);
    var_dump($param['list2']);
    echo '</pre>';
  }
}