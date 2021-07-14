<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Control\TWindow;
use Adianti\Database\TTransaction;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TText;
use Adianti\Wrapper\BootstrapFormBuilder;

class CodigoBarras extends TPage
{
    private $form;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('Código de barras');
        
        $metodo    = new TCombo('metodo');
        $template  = new TText('template');
        
        $metodo->addItems( [ 'C39' => 'C39', 'C39+' => 'C39+', 'C39E' => 'C39E', 'C39E+' => 'C39E+', 'C93' => 'C93', 'S25' => 'S25', 'S25+' => 'S25+', 'I25' => 'I25', 'I25+' => 'I25+', 'C128' => 'C128', 'C128A' => 'C128A', 'C128B' => 'C128B', 'C128C' => 'C128C', 'EAN2' => 'EAN2', 'EAN5' => 'EAN5', 'EAN8' => 'EAN8', 'EAN13' => 'EAN13', 'UPCA' => 'UPCA', 'UPCE' => 'UPCE', 'MSI' => 'MSI', 'MSI+' => 'MSI+', 'POSTNET' => 'POSTNET', 'PLANET' => 'PLANET', 'RMS4CC' => 'RMS4CC', 'KIX' => 'KIX', 'IMB' => 'IMB', 'CODABAR' => 'CODABAR', 'CODE11' => 'CODE11', 'PHARMA' => 'PHARMA', 'PHARMA2T' => 'PHARMA2T'] );
        
        $this->form->addFields( [new TLabel('Método')], [$metodo] );
        $this->form->addFields( [new TLabel('Template')], [$template] );
        
        $template->setSize('100%', 100);
        
        $modelo = "\n";
        $modelo .= '<b> Código</b> {$id}'. "\n";
        $modelo .= '<b> Descrição</b> {$descricao}'. "\n";
        $modelo .= "#barcode#" . "\n";
        $modelo .= '{$barcode}';
        
        $template->setValue($modelo);
        $metodo->setValue('EAN13');
        
        $this->form->addAction('Gerar', new TAction([$this, 'onGenerate']), 'far:check-circle green');

        parent::add($this->form);
    }
    
    public function onGenerate($param)
    {
        try
        {
            $data = $this->form->getData();
            $this->form->setData($data);
            
            $properties['barcodeMethod'] = $data->metodo;
            $properties['leftMargin']    = 12;
            $properties['topMargin']     = 12;
            $properties['labelWidth']    = 64;
            $properties['labelHeight']   = 54;
            $properties['spaceBetween']  = 4;
            $properties['rowsPerPage']   = 5;
            $properties['colsPerPage']   = 3;
            $properties['fontSize']      = 12;
            $properties['barcodeHeight'] = 15;
            $properties['imageMargin']   = 0;
            
            $generator = new AdiantiBarcodeDocumentGenerator;
            $generator->setProperties( $properties );
            $generator->setLabelTemplate( $data->template );
            
            TTransaction::open('curso');
            
            $produtos = Produto::all();
            
            foreach ($produtos as $produto)
            {
                $produto->barcode = str_pad($produto->id, 10, '0', STR_PAD_LEFT);
                $produto->descricao = substr($produto->descricao,0,15);
                
                $generator->addObject($produto);
            }
            
            $generator->setBarcodeContent('barcode');
            $generator->generate();
            $generator->save('app/output/barcodes.pdf');
            
            
            $window = TWindow::create('Códigos de barra', 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = 'app/output/barcodes.pdf';
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();
            
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}