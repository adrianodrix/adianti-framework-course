<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridActionGroup;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Wrapper\BootstrapDatagridWrapper;

class DataGridBootstrap extends TPage
{
  private $datagrid;

  public function __construct()
  {
    try {
      parent::__construct();
      
      $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
      $this->datagrid->width = '100%';
      $this->datagrid->enablePopover('Detalhes', '<b>ID</b> {id} <br/> <b>NOME</b> {nome}<br/> <b>RESIDENCIA</b> {cidade}/{estado} - {pais}');
      $this->datagrid->disableDefaultClick();

      $col_id         = new TDataGridColumn('id',          'Código',     'center', '10%');      
      $col_nome       = new TDataGridColumn('nome',        'Nome',       'left',   '40%');
      $col_nascimento = new TDataGridColumn('nascimento',  'Nascimento', 'left',   '10%');
      $col_cache      = new TDataGridColumn('cache',       'Cache',      'right',   '10%');
      $col_cidade     = new TDataGridColumn('cidade',      'Cidade',     'left',   '20%');
      $col_estado     = new TDataGridColumn('estado',      'Estado',     'left',   '10%');

      $col_id->title = 'Clique nesta coluna para ação';
      $col_cidade->enableAutoHide(800);
      $col_estado->enableAutoHide(1000);

      $col_nome->setTransformer(function($nome, $obj, $row) {
        if($nome)
        {
          $icon = '<i class="fas fa-search"></i>';
          return "<a target=newwindow href='https://www.google.com/search?q=$nome'>$icon $nome</a>";
        }
        return $nome;
      });

      $col_cache->setDataProperty('style', 'font-weight: bold;');
      $col_cache->setTransformer([$this, 'formatCache']);
      $col_nascimento->setTransformer([$this, 'formatDate']);

      $this->datagrid->addColumn($col_id, new TAction([$this, 'onColAction'], ['coluna' => 'id']));      
      $this->datagrid->addColumn($col_nome);
      $this->datagrid->addColumn($col_nascimento);
      $this->datagrid->addColumn($col_cache);
      $this->datagrid->addColumn($col_cidade);
      $this->datagrid->addColumn($col_estado);

      $action1 = new TDataGridAction([$this, 'onView'], ['id' => '{id}', 'nome' => '{nome}', 'teste' => 'teste5']);
      $action2 = new TDataGridAction([$this, 'onDelete'], ['id' => '{id}', 'nome' => '{nome}', 'teste' => 'teste5']);
      $action3 = new TDataGridAction([$this, 'onPrint'], ['id' => '{id}', 'nome' => '{nome}', 'teste' => 'teste5']);
      $action4 = new TDataGridAction([$this, 'onViewMap'], ['id' => '{id}', 'nome' => '{nome}', 'teste' => 'teste5']);

      $action1->setUseButton(true);
      $action2->setDisplayCondition([$this, 'displayCondition']);

      $action2->setLabel('Excluir');
      $action2->setImage('fa:trash red');

      $action3->setLabel('Visualiza');
      $action3->setImage('fa:print');
      
      $action4->setLabel('Imprimir');
      $action4->setImage('fa:map');
      
      $action_group = new TDataGridActionGroup('Ações', 'fa:th');
      $action_group->addHeader('Ações Principais');
      $action_group->addAction($action2);
      $action_group->addHeader('Ações Secundárias');
      $action_group->addAction($action3);      
      $action_group->addAction($action4);

      $this->datagrid->addAction($action1, 'Visualizar', 'fa:search blue');            
      $this->datagrid->addActionGroup($action_group);
      
      //após definir colunas, e ações .... criar a estrutura
      $this->datagrid->createModel();

      $input_busca = new TEntry('input_busca');
      $input_busca->placeholder = 'Busca...';      

      $this->datagrid->enableSearch($input_busca, 'id, nome, cidade, estado');
      
      $panel = new TPanelGroup('Data Grid');
      $panel->addHeaderWidget($input_busca);
      $panel->add($this->datagrid);
      parent::add($panel);    
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }
  
  public function displayCondition($obj)
  {
    return ($obj->status != 'N');
  }

  public static function onViewMap($param)
  {
    new TMessage('info', 'ID: '. $param['id'] . ' - NOME: '. $param['nome']);
  }

  public static function onPrint($param)
  {
    new TMessage('info', 'ID: '. $param['id'] . ' - NOME: '. $param['nome']);
  }

  public static function onView($param)
  {
    new TMessage('info', 'ID: '. $param['id'] . ' - NOME: '. $param['nome']);
  }

  public static function onDelete($param)
  {
    new TMessage('error', 'ID: '. $param['id'] . ' - NOME: '. $param['nome']);
  }

  public function onReload()
  {
    $this->datagrid->clear();

    $item = new stdClass;
    $item->id = 1;
    $item->nome = 'Jonh Doe';
    $item->cidade = 'Maringá';
    $item->estado = 'Paraná';
    $item->pais = 'Brasil';
    $item->status = 'S';
    $item->nascimento = '1981-2-3';
    $item->cache = 456.23;
    $this->datagrid->addItem($item);

    $item = new stdClass;
    $item->id = 2;
    $item->nome = 'Mary Silva';
    $item->cidade = 'Piracicaba';
    $item->estado = 'São Paulo';
    $item->pais = 'Brasil';
    $item->status = 'S';
    $item->nascimento = '1946-11-5';
    $item->cache = 19874.55;
    $this->datagrid->addItem($item);

    $item = new stdClass;
    $item->id = 3;
    $item->nome = 'João dos Santos';
    $item->cidade = 'Bonito';
    $item->estado = 'Mato Grusso';
    $item->pais = 'Brasil';
    $item->status = 'N';
    $item->nascimento = '2008-5-2';
    $item->cache = 5632.22;
    $this->datagrid->addItem($item);
  }

  public function show()
  {
    $this->onReload();
    parent::show();
  }

  public static function onColAction($param)
  {
    new TMessage('info', 'Coluna Clicada: '. $param['coluna']);
  }

  public function formatCache($cache, $obj, $row)
  {
    $formatado = number_format($cache, 2, ',', '.');
    if($obj->status == 'N')
    {
      $row->style = 'background: #FFF9A7';
    }

    if($cache > 10000)
    {
      $formatado = "<span style='color:green'>$formatado</span>";
    }
    return ($formatado);
  }

  public function formatDate($data, $obj, $row)
  {
    $date = new DateTime($data);
    $formatado = $date->format('d/m/Y');
    $idade = (string) $date
                        ->diff(new DateTime(date('Y-m-d')))
                        ->format('%Y anos');
    return "$formatado ($idade)";
  }
}
