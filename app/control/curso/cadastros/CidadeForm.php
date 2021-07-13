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

class CidadeForm extends TPage
{
  private $form;
  public function __construct()
  {
    try {
      parent::__construct();      
      
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
      $this->form->addActionLink('Voltar', new TAction([$this, 'onBack']), 'fa:backspace blue');
      parent::add($this->form);
    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());
    }
  }

  public function onBack($param)
  {
    AdiantiCoreApplication::loadPage( CidadeList::class );
  }

  public function onSave($param)
  {
    try {
      TTransaction::open('curso');

      $this->form->validate();
      $data = $this->form->getData();

      $cidade = new Cidade;
      $cidade->fromArray((array) $data);
      $cidade->store();

      $this->form->setData($cidade);

      TTransaction::close();

      TToast::show('success', 'Regitro salvo com sucesso', 'top right', 'far:check-circle' );
      AdiantiCoreApplication::loadPage( CidadeList::class );
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }

  public function onEdit($param)
  {
    try {
      TTransaction::open('curso');
      if(isset($param['key']))
      {
        $id = $param['key'];
        $cidade = new Cidade($id);
        $this->form->setData($cidade);
      }
      else
      {
        $this->form->clear(true);
      }

      TTransaction::close();
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }

  public function onClear($param)
  {
      $this->form->clear( true );
  }
}