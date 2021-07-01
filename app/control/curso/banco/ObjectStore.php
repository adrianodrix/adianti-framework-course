<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjectStore extends TPage
{
  public function __construct()
  {
    try {
      parent::__construct();
      
      TTransaction::open('curso');
      
      $produto = new Produto;
      $produto->descricao = 'GRAVADOR DVD';
      $produto->estoque = 10;
      $produto->preco_venda = 100.15;
      $produto->unidade = 'PC';
      $produto->local_foto = 'https://picsum.photos/200';
      $produto->store();      
      
      TTransaction::close();
       
      new TMessage('info', "Produto $produto->id gravado com sucesso");
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }
}