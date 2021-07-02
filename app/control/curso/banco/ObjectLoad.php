<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Dialog\TToast;
use Adianti\Widget\Form\TLabel;

class ObjectLoad extends TPage
{
  public function __construct()
  {
    try {
      parent::__construct();
      
      TTransaction::open('curso');
      TTransaction::dump();
      
      $produto = new Produto(1);      
      TTransaction::close();
       
     TToast::show('show', $produto->descricao .
                          ' tem estque total de '. 
                          $produto->evaluate('= {preco_venda} * {estoque}')
                          , 'top right', 'fa:check-circle-o'); 
      
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }
}