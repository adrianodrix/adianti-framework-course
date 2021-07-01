<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjectCreate extends TPage
{
  public function __construct()
  {
    try {
      parent::__construct();
      
      TTransaction::open('curso');
      
      Produto::create([
        'descricao' => 'CABO HDMI',
        'estoque' => 5,
        'preco_venda' => 25.62,
        'unidade' => 'UN',
        'local_foto' => 'https://picsum.photos/200'
      ]);
      
      TTransaction::close();
       
      new TMessage('info', "Produto gravado com sucesso");
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }
}