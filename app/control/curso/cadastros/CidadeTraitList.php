<?php

use Adianti\Base\AdiantiStandardListTrait;
use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Core\AdiantiCoreApplication;
use Adianti\Database\TCriteria;
use Adianti\Database\TFilter;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Registry\TSession;
use Adianti\Widget\Container\TPanel;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Datagrid\TPageNavigation;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Dialog\TQuestion;
use Adianti\Widget\Dialog\TToast;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Util\TXMLBreadCrumb;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Wrapper\BootstrapFormBuilder;

class CidadeTraitList extends TPage
{
  use AdiantiStandardListTrait;

  private $form;
  private $datagrid;
  private $pageNav;
  
  public function __construct()
  {
    try {
      parent::__construct();

      $this->setDatabase('curso');
      $this->setActiveRecord(Cidade::class);
      $this->setDefaultOrder('id', 'asc');
      $this->addFilterField('nome', 'like', 'nome');      

      $this->form = new BootstrapFormBuilder;
      $this->form->setFormTitle('Cidades');

      $nome = new TEntry('nome');
      $nome->setValue(TSession::getValue(__CLASS__ . '_filter_data'));
      $nome->placeholder = 'Busca';
      $nome->type = 'search';
           
      $this->form->addFields([ $nome ]);      
      $this->form->addAction('Buscar', new TAction([$this, 'onSearch']), 'fa:search blue');
      $this->form->addActionLink('Novo', new TAction([CidadeForm::class, 'onClear']), 'fa:plus-circle');
      
      $this->datagrid = new TDataGrid;
      $this->datagrid->width = '100%';     
      
      $col_nome   = new TDataGridColumn('nome', 'Nome', 'left', '80%');
      $col_estado = new TDataGridColumn('estado->nome', 'Estado', 'left', '20%');

      $col_nome->setAction(new TAction([$this, 'onReload'], ['order' => 'nome']));
      
      $this->datagrid->addColumn($col_nome);
      $this->datagrid->addColumn($col_estado);

      $actionEdit = new TDataGridAction([CidadeForm::class, 'onEdit'], ['key' => '{id}']);
      $actionDelete = new TDataGridAction([$this, 'onDelete'], ['key' => '{id}']);

      $this->datagrid->addAction($actionEdit, 'Editar', 'fa:edit');
      $this->datagrid->addAction($actionDelete, 'Excluir', 'fa:trash');

      $this->datagrid->createModel();

      $this->pageNav = new TPageNavigation;
      $this->pageNav->setAction(new TAction([$this, 'onReload']));

      $panel = new TPanelGroup;
      $panel->add(new BootstrapDatagridWrapper($this->datagrid));
      $panel->addFooter($this->pageNav);

      $vbox = new TVBox;
      $vbox->style = 'width:100%';
      $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
      $vbox->add($this->form);
      $vbox->add($panel);
      parent::add($vbox);
    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());
    }
  }
}