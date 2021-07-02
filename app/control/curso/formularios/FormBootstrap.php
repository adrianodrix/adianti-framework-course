<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TColor;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TDateTime;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TNumeric;
use Adianti\Widget\Form\TPassword;
use Adianti\Widget\Form\TSpinner;
use Adianti\Widget\Form\TText;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormBootstrap extends TPage
{
  private $form;

  public function __construct()
  {
    parent::__construct();
    
    $this->form = new BootstrapFormBuilder('meu_form');
    $this->form->setFormTitle('Formulário Bootstrap');
    $this->form->setFieldSizes('100%');

    $id = new TEntry('id');
    $descricao = new TEntry('descricao');
    $senha = new TPassword('senha');
    $dtCriacao = new TDateTime('dtCriacao');
    $dtExpiracao = new TDate('dtExpiracao');
    $valor = new TNumeric('valor', 2, ',', '.');
    $cor = new TColor('cor');
    $peso = new TSpinner('peso');
    $tipo = new TCombo('tipo');
    $obs = new TText('obs');

    $endereco = new TEntry('endereco');
    $numero = new TNumeric('numero', 0, '', '');
    $bairro = new TEntry('bairro');
    $cidade = new TEntry('cidade');
    $uf = new TCombo('uf');
    $uf->addItems([
      'PR' => 'PR',
      'SP' => 'SP'
    ]);

    $id->setEditable(false);
    $id->setValue(100);

    $dtCriacao->setMask('dd/mm/yyyy hh:ii');
    $dtCriacao->setDatabaseMask('yyyy-mm-dd hh:ii');
    $dtCriacao->setValue(date('Y-m-d H:i'));
    
    $dtExpiracao->setMask('dd/mm/yyyy');
    $dtExpiracao->setDatabaseMask('yyyy-mm-dd');
    $date = date('Y-m-d', strtotime(date('Y-m-d'). ' + 30 days'));
    $dtExpiracao->setValue($date);   

    $tipo->addItems([
                      'a' => 'Opção A',
                      'b' => 'Opção B',
                      'c' => 'Opção C',
                    ]);

    $peso->setRange(1,100,0.1);
    $peso->setTip('Valor máximo aceito será de 100');

    $descricao->placeholder = 'Digite aqui sua descrição';

    $this->form->appendPage('Cadastro');
    $this->form->addFields([new TLabel('Código')], [$id]);
    $this->form->addFields([new TLabel('Descrição')], [$descricao]);
    $this->form->addFields([new TLabel('Senha')], [$senha]);
    $this->form->addFields([new TLabel('Dt. Criação')], [$dtCriacao], [new TLabel('Dt. Expiração')], [$dtExpiracao]);
    $this->form->addFields([new TLabel('Valor')], [$valor], [new TLabel('Cor')], [$cor]);
    $this->form->addFields([new TLabel('Peso')], [$peso], [new TLabel('Tipo')], [$tipo]);

    $this->form->appendPage('Observações');
    $this->form->addFields([$obs]);

    $this->form->appendPage('Endereço');
    $row = $this->form->addFields([new TLabel('Endereço')], [$endereco],
                           [new TLabel('Número')], [$numero]
                          );
    $row->layout = ['col-sm-2 control-label', 'col-sm-6', 'col-sm-2 control-label', 'col-sm-2'];
    
    $row = $this->form->addFields([new TLabel('Bairro')], [$bairro]);                          
    $row->layout = ['col-sm-2 control-label', 'col-sm-10'];
    
    $row = $this->form->addFields([new TLabel('Cidade')], [$cidade],
                           [new TLabel('UF')], [$uf]
                          );
    $row->layout = ['col-sm-2 control-label', 'col-sm-6', 'col-sm-2 control-label', 'col-sm-2'];                          

    $this->form->addAction('Enviar', new TAction([$this, 'onSend']), 'fa:save');
    parent::add($this->form);    
  }

  public function onSend($param = null)
  {
    $data = $this->form->getData();
    $this->form->setData($data);

    new TMessage('info', str_replace(',', '</br>', json_encode($data)));
  }
}
