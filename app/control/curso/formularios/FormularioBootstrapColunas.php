<?php
class FormularioBootstrapColunas extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder('meu_form');
        $this->form->setFormTitle('Formulário Bootstrap colunas');
        
        
        $this->form->appendPage('Colunas automáticas');
        
        $this->form->addFields( [new TLabel('2 campos')],
                                [new TEntry('campo1')] );
                                
        $this->form->addFields( [new TLabel('4 campos')],
                                [new TEntry('campo2a')],
                                [new TEntry('campo2b')],
                                [new TEntry('campo2c')] );
        
        $this->form->addFields( [new TLabel('6 campos')],
                                [new TEntry('campo3a')],
                                [new TEntry('campo3b')],
                                [new TEntry('campo3c')],
                                [new TEntry('campo3d')],
                                [new TEntry('campo3e')] );
        
        $this->form->appendPage('Colunas manuais');
        
        $row = $this->form->addFields( [new TLabel('4 campos')],
                                       [new TEntry('campo4a')],
                                       [new TEntry('campo4b')],
                                       [new TEntry('campo4c')] );
        $row->layout = [ 'col-sm-2 control-label', 'col-sm-4', 'col-sm-4', 'col-sm-2' ];
        
        $row = $this->form->addFields( [new TLabel('4 campos')],
                                       [new TEntry('campo5a')],
                                       [new TEntry('campo5b')],
                                       [new TEntry('campo5c')] );
        $row->layout = [ 'col-sm-2 control-label', 'col-sm-2', 'col-sm-6', 'col-sm-2' ];
        
        $row = $this->form->addFields( [new TLabel('4 campos')],
                                       [new TEntry('campo6a')],
                                       [new TEntry('campo6b')],
                                       [new TEntry('campo6c')] );
        $row->layout = [ 'col-sm-2 control-label', 'col-sm-2', 'col-sm-4', 'col-sm-4' ];
        
        $this->form->addAction('Enviar', new TAction( [$this, 'onSend'] ), 'fa:save');
        parent::add( $this->form );
    }
    
    public function onSend($param)
    {
        $data = $this->form->getData();
        $this->form->setData($data);
        
        new TMessage('info', json_encode($data) );
    }
}