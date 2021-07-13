<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Core\AdiantiCoreApplication;
use Adianti\Database\TTransaction;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Dialog\TAlert;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Dialog\TToast;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\THidden;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Wrapper\BootstrapFormBuilder;

class CidadeTraiForm extends TPage
{
  use Adianti\Base\AdiantiStandardFormTrait;

  private $form;

  public function __construct()
  {
    try {
      parent::__construct();
      $this->setDatabase('curso');
      $this->setActiveRecord(Cidade::class);
      
      $this->form = new BootstrapFormBuilder;
      $this->form->setFormTitle('Cidade');
      $this->form->setClientValidation(true);

      $id = new THidden('id');
      $nome = new TNYRequiredEntry('nome');
      $estado = new TDBCombo('estado_id', 'curso', Estado::class, 'id', 'nome', 'nome');
      $estado->addValidation('Estado', new TRequiredValidator);

      $this->form->addFields([$id]);
      $this->form->addFields([new TLabel('Nome')], [$nome]);
      $this->form->addFields([new TLabel('Estado')], [$estado]);

      $this->form->addAction('Salvar', new TAction([$this, 'onSave']), 'fa:save green');
      parent::add($this->form);
    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());
    }
  }
}