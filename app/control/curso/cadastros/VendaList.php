<?php

use Adianti\Base\AdiantiStandardListTrait;
use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Registry\TSession;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Datagrid\TPageNavigation;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TDateTime;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Wrapper\TDBUniqueSearch;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Wrapper\BootstrapFormBuilder;

class VendaList extends TPage
{
  use AdiantiStandardListTrait;

  private $form;
  private $datagrid;
  private $pageNavigation;

  public function __construct()
  {
    parent::__construct();
    
    $this->setDatabase('curso');
    $this->setActiveRecord(Venda::class);
    $this->setDefaultOrder('id', 'asc');
    $this->addFilterField('id', '=', 'id');
    $this->addFilterField('dt_venda', '>=', 'data_de');
    $this->addFilterField('dt_venda', '<=', 'data_ate');
    $this->addFilterField('cliente_id', '=', 'cliente_id');
    
    $this->genFormBusca();
    $this->genDataGrid();
    
    $this->pageNavigation = new TPageNavigation;
    $this->pageNavigation->setAction( new TAction( [$this, 'onReload']) );
    $this->pageNavigation->enableCounters();
    
    $panel = new TPanelGroup;
    $panel->add(new BootstrapDatagridWrapper($this->datagrid));
    $panel->addFooter($this->pageNavigation);

    $vbox = new TVBox;
    $vbox->add($this->form);
    $vbox->add($panel);

    parent::add($vbox);    
  }

  private function genFormBusca()
  {
    
    $id = new TEntry('id');
    $data_de = new TDate('data_de');
    $data_ate = new TDate('data_ate');
    $cliente_id = new TDBUniqueSearch('cliente_id', 'curso', Cliente::class, 'id', 'nome');
    $cliente_id->setMinLength(1);
    
    $id->setSize('50%');
    $data_de->setSize('100%');
    $data_ate->setSize('100%');
    $data_de->setMask('dd/mm/yyyy');    
    $data_ate->setMask('dd/mm/yyyy');
    $data_de->setDatabaseMask('yyyy-mm-dd');
    $data_ate->setDatabaseMask('yyyy-mm-dd');

    $this->form = new BootstrapFormBuilder;
    $this->form->setFormTitle('Vendas');
    
    $this->form->addFields([new TLabel('Código')], [$id]);
    $this->form->addFields([new TLabel('Data (de)')], [$data_de], [new TLabel('Data (até)')], [$data_ate]);
    $this->form->addFields([new TLabel('Cliente')], [$cliente_id]);

    $this->form->setData(TSession::getValue(__CLASS__ . '_filter_data'));

    $this->form->addAction('Buscar', new TAction([$this, 'onSearch']), 'fa:search');
    $this->form->addActionLink('Novo', new TAction([VendaForm::class, 'onEdit']), 'fa:plus green');
  }

  private function genDataGrid()
  {
    $col_id = new TDataGridColumn('id', 'Código', 'center');
    $col_data = new TDataGridColumn('dt_venda', 'Data', 'center');
    $col_cliente = new TDataGridColumn('cliente->nome', 'Cliente', 'left');
    $col_total = new TDataGridColumn('total', 'Total', 'right');

    $col_total->setTransformer(function ($total) {
      if(is_numeric($total)) 
      {
        return number_format($total, 2, ',', '.');
      }
      return $total;
    });

    $col_data->setTransformer(function ($data) {
      $date = new DateTime($data);
      return $date->format('d/m/Y');
    });

    $col_id->setAction(new TAction([$this, 'onReload'], ['order' => 'id']));
    $col_data->setAction(new TAction([$this, 'onReload'], ['order' => 'dt_venda']));

    $action_edit = new TDataGridAction([VendaForm::class, 'onEdit'], ['key' => '{id}']);
    $action_delete = new TDataGridAction([$this, 'onDelete'], ['key' => '{id}']);

    $this->datagrid = new TDataGrid;
    $this->datagrid->width = '100%';

    $this->datagrid->addColumn($col_id);
    $this->datagrid->addColumn($col_data);
    $this->datagrid->addColumn($col_cliente);
    $this->datagrid->addColumn($col_total);
    
    $this->datagrid->addAction($action_edit, 'Editar', 'fa:edit blue');
    $this->datagrid->addAction($action_delete, 'Excluir', 'fa:trash-alt red');

    $this->datagrid->createModel();
  }
}