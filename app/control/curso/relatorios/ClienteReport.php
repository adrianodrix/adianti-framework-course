<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TFilter;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TRadioGroup;
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Widget\Wrapper\TDBUniqueSearch;
use Adianti\Wrapper\BootstrapFormBuilder;

class ClienteReport extends TPage
{
  private $form;

  public function __construct()
  {
    parent::__construct();
    
    $this->form = new BootstrapFormBuilder;
    $this->form->setFormTitle('Clientes');

    $nome = new TEntry('nome');
    $cidade_id = new TDBUniqueSearch('cidade_id', 'curso', Cidade::class, 'id', 'nome');
    $cidade_id->setMask('{nome} <b> {estado->nome} </b>');
    $categoria_id = new TDBCombo('categoria_id', 'curso', Categoria::class, 'id', 'nome');
    $output = new TRadioGroup('output');

    $this->form->addFields([new TLabel('Cliente')], [$nome]);
    $this->form->addFields([new TLabel('Cidade')], [$cidade_id]);
    $this->form->addFields([new TLabel('Categoria')], [$categoria_id]);
    $this->form->addFields([new TLabel('Formato')], [$output]);

    $output->setUseButton();
    $cidade_id->setMinLength(1);

    $output->addItems([
      'html' => 'HTML',
      'pdf' => 'PDF',
      'rtf' => 'WORD',
      'xls' => 'EXCEL'
    ]);

    $output->setValue('pdf');
    $output->setLayout('horizontal');

    $this->form->addAction('Gerar', new TAction([$this, 'onGenerate']), 'fa:download blue');

    parent::add($this->form);    
  }

  public function onGenerate()
  {
    try {
      TTransaction::open('curso');

      $data = $this->form->getData();
      
      $criteria = new TCriteria;
      
      if ($data->nome)
      {
        $criteria->add(new TFilter('nome', 'like', "%{$data->nome}%"));
      }

      if ($data->cidade_id)
      {
        $criteria->add(new TFilter('cidade_id', '=', $data->cidade_id));
      }

      if ($data->categoria_id)
      {
        $criteria->add(new TFilter('categoria_id', '=', $data->categoria_id));
      }

      $repo = new TRepository(Cliente::class);
      $clientes = $repo->load($criteria);

      if ($clientes)
      {
        $widths = [40, 200, 80, 120, 80];
        switch ($data->output) {
          case 'html':
            $table = new TTableWriterHTML($widths);
            break;
          case 'pdf':
            $table = new TTableWriterPDF($widths);
            break;
          case 'rtf':
            $table = new TTableWriterRTF($widths);
            break; 
          case 'xls':
            $table = new TTableWriterXLS($widths);
            break;   
          default:
            $table = new TTableWriterPDF($widths);
            break;
        }

        if (!empty($table))
          {
              $table->addStyle('header', 'Helvetica', '16', 'B', '#ffffff', '#4B5D8E');
              $table->addStyle('title',  'Helvetica', '10', 'B', '#ffffff', '#617FC3');
              $table->addStyle('datap',  'Helvetica', '10', '',  '#000000', '#E3E3E3', 'LR');
              $table->addStyle('datai',  'Helvetica', '10', '',  '#000000', '#ffffff', 'LR');
              $table->addStyle('footer', 'Helvetica', '10', '',  '#2B2B2B', '#B4CAFF');
          }

        $table->setHeaderCallback( function($table) {
            $table->addRow();
            $table->addCell('Clientes', 'center', 'header', 5);
            
            $table->addRow();
            $table->addCell('Código', 'center', 'title');
            $table->addCell('Nome', 'left', 'title');
            $table->addCell('Categoria', 'center', 'title');
            $table->addCell('Email', 'left', 'title');
            $table->addCell('Nascimento', 'center', 'title');
        });
        
        $table->setFooterCallback( function ($table) {
            $table->addRow();
            $table->addCell(date('d/m/Y H:i:s'), 'center', 'footer', 5);
        });

        $colore = false;
        foreach ($clientes as $cliente)
          {
              $style = $colore ? 'datap' : 'datai';
              
              $table->addRow();
              $table->addCell( $cliente->id, 'center', $style);
              $table->addCell( $cliente->nome, 'left', $style);
              $table->addCell( $cliente->categoria->nome, 'center', $style);
              $table->addCell( $cliente->email, 'left', $style);
              $table->addCell( $cliente->nascimento, 'center', $style);
              
              $colore = !$colore;
          } 

        $output = 'app/output/tabular.'.$data->output;
        if (!file_exists($output) | is_writable($output))
          {
              $table->save($output);
              parent::openFile($output);
              
              new TMessage('info', 'Relatório gerado com sucesso');
          }
          else
          {
              throw new Exception('Permissão negada: ' . $output);
          }
        //id, nome, categoria, email, nascimento
      }
      $this->form->setData($data);
      TTransaction::close();
    } catch (\Throwable $th) {
      new TMessage('error', $th->getMessage());
    }
  }
}