<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\THtmlEditor;
use Adianti\Wrapper\BootstrapFormBuilder;

class HTMLEditor extends TPage
{
  public function __construct()
  {
    parent::__construct();
    $this->form = new BootstrapFormBuilder('meu_form');
    $this->form->setFormTitle('Editor HTML');

    $html = new THtmlEditor('conteudo_html');
    $html->setSize('100%', 200);
    $html->setOption('placeholder', 'Digite aqui');

    $this->form->addFields([ $html ]);

    $this->form->addAction('Enviar', new TAction([$this, 'onSend']), 'fa:check-circle green');
    parent::add($this->form);    
  }

  public function onSend($param = null)
  {
    $data = $this->form->getData();
    $this->form->setData($data);
    new TMessage('info', $data->conteudo_html);
  }
}