<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Container\THBox;
use Adianti\Widget\Form\TCheckList;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Wrapper\TDBUniqueSearch;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormularioCheckList extends TPage
{
    private $form;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder('meu_form');
        $this->form->setFormTitle('Check list');
        
        $customer  = new TDBUniqueSearch('cliente_id', 'curso', Cliente::class, 'id', 'nome');
        $lista = new TCheckList('lista_produtos');
        
        $lista->addColumn( 'id',          'Código',  'center',  '10%');
        $lista->addColumn( 'descricao',   'Produto', 'left',    '50%');
        $lista->addColumn( 'preco_venda', 'Preço',   'right',   '40%');
        $lista->setHeight(250);
        $lista->makeScrollable();
        
        $input = new TEntry('busca');
        $input->placeholder = 'Busca...';
        $input->setSize('100%');
        
        $lista->enableSearch($input, 'id, descricao');
        
        $hbox = new THBox;
        $hbox->style = 'border-bottom:1px solid gray; padding-bottom:10px';
        $hbox->add( new TLabel('Produtos') );
        $hbox->add($input)->style = 'float:right; width:30%';
        
        $this->form->addFields( [ new TLabel('Cliente')], [$customer] );
                
        $this->form->addContent( [$hbox] );
        $this->form->addFields( [ new TLabel('Produtos')],  [$lista] );
        
        /*
        TTransaction::open('curso');
        $produtos = Produto::all();
        TTransaction::close();
        */
        
        
        $lista->addItems( Produto::allInTransaction('curso') );
        
        $this->form->addAction( 'Enviar', new TAction( [$this, 'onSend'] ), 'fa:save');
        
        parent::add( $this->form );
    }
    
    public function onSend($param)
    {
        $data = $this->form->getData();
        $this->form->setData($data);
        
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}