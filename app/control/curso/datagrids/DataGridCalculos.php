<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Control\TWindow;
use Adianti\Database\TTransaction;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Wrapper\BootstrapDatagridWrapper;

class DataGridCalculos extends TPage
{
  private $datagrid;

  public function __construct()
  {
    try {
      parent::__construct();
      
      $this->datagrid = new TDataGrid;
      $this->datagrid->style = 'width: 100%';

      $col_id      = new TDataGridColumn('id',          'Código',    'center');
      $col_desc    = new TDataGridColumn('descricao',   'Descrição', 'left');
      $col_estoque = new TDataGridColumn('estoque',     'Estoque',   'right');
      $col_preco   = new TDataGridColumn('preco_venda', 'Preço',     'right');
      $col_subtotal= new TDataGridColumn('={estoque} * {preco_venda}', 'SubTotal', 'right');

      $formataValor = function($data) {
        return (is_numeric($data))
              ? number_format($data, 2, ',', '.')
              : $data;
      };

      $col_preco->setTransformer($formataValor);
      $col_subtotal->setTransformer($formataValor);
      $col_subtotal->setTotalFunction(function($values) {
        return array_sum((array) $values);
      });

      $col_estoque->setTransformer(function($data) {
        $formatado = $data;
        if(is_numeric($data))
        {
          if($data > 10) {$formatado = '<span class="badge badge-success">'. $data .'</span>';};
          if($data <  3) {$formatado = '<span class="badge badge-danger">'. $data .'</span>';};
        }
        return $formatado;
      });
      $col_estoque->setTotalFunction(function($values) {
        return array_sum((array) $values);
      });
      
      $col_desc->setTotalFunction(function($values) {
        return count((array) $values);
      });

      $this->datagrid->addColumn($col_id);
      $this->datagrid->addColumn($col_desc);
      $this->datagrid->addColumn($col_estoque);
      $this->datagrid->addColumn($col_preco);
      $this->datagrid->addColumn($col_subtotal);

      $action1 = new TDataGridAction([$this, 'onView'], ['foto' => 'https://picsum.photos/200', 'id' => '{id}']);
      $this->datagrid->addAction($action1, 'Visualizar', 'fa:search blue'); 

      $this->datagrid->createModel();

      $panel = new TPanelGroup('DataGrid com Cálculos');
      $panel->add(new BootstrapDatagridWrapper($this->datagrid));
      $panel->addHeaderActionLink('Salvar PDF', new TAction([$this, 'exportaPDF'], ['register_state' => 'false']), 'fa:file-pdf red');
      $panel->addHeaderActionLink('Salvar Excel', new TAction([$this, 'exportaExcel'], ['register_state' => 'false']), 'fa:file-excel green');

      parent::add($panel);
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }
  public function exportaPDF($param)
  {
    try {
      $html = clone $this->datagrid;
      $content = file_get_contents('app/resources/styles-print.html'). $html->getContents();

      $dompdf = new \Dompdf\Dompdf;
      $dompdf->loadHtml($content);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();

      $file = 'app/output/datagrid-exporta.pdf';
      file_put_contents($file, $dompdf->output());

      $obj = new TElement('object');
      $obj->data = $file;
      $obj->type = 'application/pdf';
      $obj->style = 'width: 100%; height: calc(100% - 10px);';

      $win = TWindow::create('Exportação', 0.5, 0.8);      
      $win->add($obj);
      $win->show();

    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());
    }
  }

  public function exportaExcel($param)
  {
    try {
      $data = $this->datagrid->getOutputData();
      if($data)
      {
        $file = 'app/output/data-grid-exporta.csv';
        $handler = fopen($file, 'w');
        foreach ($data as $row) {
          fputcsv($handler, $row);
        }
        fclose($handler);

        parent::openFile($file);
      }
    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());
    }
  }

  public static function onView($param)
  {
    new TMessage('info', '<img src="'. $param['foto'] .'"/>');
  }

  public function onReload()
  {
    $this->datagrid->clear();
    try {
      TTransaction::open('curso');
      $this->datagrid->addItems(Produto::all());
      TTransaction::close();
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }

  public function show()
  {
    $this->onReload();
    parent::show();
  }
}
