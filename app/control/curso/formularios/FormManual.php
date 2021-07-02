<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Container\TNotebook;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TTable;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TButton;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TForm;
use Adianti\Widget\Form\TLabel;

class FormManual extends TPage
{
  private $form;

  public function __construct()
  {
    parent::__construct();
    
    $this->form = new TForm('meu_form');

    $notebook = new TNotebook;
    $this->form->add($notebook);

    $table1 = new TTable;
    $table2 = new TTable;

    $table1->width = '100%';
    $table2->width = '100%';

    $table1->style = 'padding: 10px;';
    $table2->style = 'padding: 10px;';

    $notebook->appendPage('Pàgina 1', $table1);
    $notebook->appendPage('Pàgina 2', $table2);

    $field1 = new TEntry('field1');
    $field2 = new TEntry('field2');
    $field3 = new TEntry('field3');
    $field4 = new TEntry('field4');

    $table1->addRowSet(new TLabel('Campo 1'), $field1);
    $table1->addRowSet(new TLabel('Campo 2'), $field2);
    $table2->addRowSet(new TLabel('Campo 3'), $field3);
    $table2->addRowSet(new TLabel('Campo 4'), $field4);

    $botao = new TButton('enviar');
    $botao->setAction(new TAction([$this, 'onSend']), 'Enviar');
    $botao->setImage('fa:save');

    $this->form->setFields([$field1, $field2, $field3, $field4, $botao]);

    $panel = new TPanelGroup('Formulário Manual');
    $panel->add($this->form);
    $panel->addFooter($botao);

    parent::add($panel);    
  }

  public function onSend($param = null)
  {
    $data = $this->form->getData();
    $this->form->setData($data);

    print_r($data);
    new TMessage('info', $data->field1);
  }
}