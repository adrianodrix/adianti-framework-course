<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Control\TWindow;
use Adianti\Database\TTransaction;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TText;
use Adianti\Wrapper\BootstrapFormBuilder;

class CodigoQRCode extends TPage
{
    private $form;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('QR Code');
        
        $template  = new TText('template');
        
        $this->form->addFields( [new TLabel('Template')], [$template] );
        
        $template->setSize('100%', 100);
        
        $modelo = "\n";
        $modelo .= '<b> Código</b> {$id}'. "\n";
        $modelo .= '<b> Descrição</b> {$descricao}'. "\n";
        $modelo .= "#qrcode#" . "\n";
        $modelo .= '{$barcode}';
        
        $template->setValue($modelo);
        
        $this->form->addAction('Gerar', new TAction([$this, 'onGenerate']), 'far:check-circle green');

        parent::add($this->form);
    }
    
    public function onGenerate($param)
    {
        try
        {
            $data = $this->form->getData();
            $this->form->setData($data);
            
            $properties['leftMargin']    = 12;
            $properties['topMargin']     = 12;
            $properties['labelWidth']    = 64;
            $properties['labelHeight']   = 54;
            $properties['spaceBetween']  = 4;
            $properties['rowsPerPage']   = 5;
            $properties['colsPerPage']   = 3;
            $properties['fontSize']      = 12;
            $properties['barcodeHeight'] = 20;
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
            
            $generator->setBarcodeContent('{id} - {descricao}');
            $generator->generate();
            $generator->save('app/output/qrcodes.pdf');
            
            
            $window = TWindow::create('QR Code', 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = 'app/output/qrcodes.pdf';
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