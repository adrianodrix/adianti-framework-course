<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TFieldList;
use Adianti\Wrapper\BootstrapFormBuilder;

class BootstrapFieldList extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder('meu_form');
        $this->form->setFormTitle('Lista de campos');
        
        $combo  = new TCombo('combo[]');
        $texto  = new TEntry('texto[]');
        $numero = new TEntry('valor[]');
        $data   = new TDate('dt_registro[]');
        
        $combo->enableSearch();
        $combo->addItems( [
                            'a' => 'Opção A', 
                            'b' => 'Opção B',
                            'c' => 'Opção C',
                            'd' => 'Opção D',
                            'e' => 'Opção E',
                          ] );
        $combo->setSize('100%');
        $texto->setSize('100%');
        $numero->setNumericMask(2, ',', '.', true);
        $numero->setSize('100%');
        $numero->style = 'text-align:right';
        $data->setSize('100%');
        
        
        $fieldlist = new TFieldList;
        $fieldlist->generateAria();
        $fieldlist->width = '100%';
        $fieldlist->addField( '<b>Combo</b>',  $combo,  [ 'width' => '25%'] );
        $fieldlist->addField( '<b>Texto</b>',  $texto,  [ 'width' => '25%'] );
        $fieldlist->addField( '<b>Data</b>',   $data,   [ 'width' => '25%'] );
        $fieldlist->addField( '<b>Número</b>', $numero, [ 'width' => '25%', 'sum' => true] );        
        
        $fieldlist->enableSorting();
        
        
        $obj = new stdClass;
        $obj->combo = 'a';
        $obj->texto = 'teste';
        $obj->valor = 100;
        $obj->dt_registro = date('Y-m-d');        
        
        $fieldlist->addHeader();
        $fieldlist->addDetail( $obj );
        $fieldlist->addDetail( new stdClass );
        $fieldlist->addDetail( new stdClass );
        $fieldlist->addDetail( new stdClass );
        $fieldlist->addDetail( new stdClass );
        $fieldlist->addCloneAction();
        
        $this->form->addField( $combo );
        $this->form->addField( $numero );
        $this->form->addField( $data );
        $this->form->addField( $texto );
        
        $this->form->addContent( [$fieldlist] );
        
        $this->form->addAction('Enviar', new TAction( [$this, 'onSend'] ), 'fa:save');
        
        parent::add( $this->form );
    }
    
    public static function onSend($param)
    {
        echo '<pre>';
        var_dump($param);
        echo '</pre>';
    }
}