<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormularioMascaras extends TPage
{
    public function __construct()
    {
        parent::__construct();
        

        $this->form = new BootstrapFormBuilder('meu_form');
        $this->form->setFormTitle('Máscaras de digitação');
        
        $element1 = new TEntry('element1');
        $element2 = new TEntry('element2');
        $element3 = new TEntry('element3');
        $element4 = new TEntry('element4');
        $element5 = new TEntry('element5');
        $element6 = new TEntry('element6');
        $element7 = new TEntry('element7');
        $element8 = new TEntry('element8');
        $element9 = new TEntry('element9');
        $element10= new TEntry('element10');
        $element11= new TEntry('element11');
        $element12= new TEntry('element12');
        $element13= new TEntry('element13');
        $element14= new TEntry('element14');
        $element15= new TNYEmail('element15');
        
        
        $element1->setMask('99.999-999');
        $element2->setMask('99.999-999', true);
        $element3->setMask('99.999.999/9999-99');
        $element4->setMask('99.999.999/9999-99', true);
        $element5->setMask('A!');
        $element6->setMask('AAA');
        $element7->setMask('S!');
        $element8->setMask('SSS');
        $element9->setMask('9!');
        $element10->setMask('999');
        $element11->setMask('SSS-9A99');
        $element12->forceUpperCase();
        $element13->forceLowerCase();
        $element14->setNumericMask(2, ',', '.', true);
        
        $this->form->addFields( [new TLabel('CEP')], [$element1] );
        $this->form->addFields( [new TLabel('CEP 2')], [$element2] );
        $this->form->addFields( [new TLabel('CNPJ')], [$element3] );
        $this->form->addFields( [new TLabel('CNPJ 2')], [$element4] );
        $this->form->addFields( [new TLabel('Letras e Nùmeros')], [$element5] );
        $this->form->addFields( [new TLabel('Limitado')], [$element6] );
        $this->form->addFields( [new TLabel('Apenas Letras')], [$element7] );
        $this->form->addFields( [new TLabel('Limitado 2')], [$element8] );
        $this->form->addFields( [new TLabel('Somente Nùmeros')], [$element9] );
        $this->form->addFields( [new TLabel('Limitado 2')], [$element10] );
        $this->form->addFields( [new TLabel('Placa de Carro')], [$element11] );
        $this->form->addFields( [new TLabel('Upper Case')], [$element12] );
        $this->form->addFields( [new TLabel('Lower Case')], [$element13] );
        $this->form->addFields( [new TLabel('Valor')], [$element14] );
        $this->form->addFields( [new TLabel('Email')], [$element15] );
        
        
        $this->form->addAction( 'Enviar', new TAction( [$this, 'onSend'] ), 'fa:save');
        
        parent::add( $this->form );
    }
    
    public function onSend($param)
    {
        $data = $this->form->getData();
        $this->form->setData($data);
        
        new TMessage('info', str_replace(',', '<br>', json_encode($data)));
    }
}
