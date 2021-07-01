<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TLabel;

class ObjectFind extends TPage
{
  public function __construct()
  {
    try {
      parent::__construct();
      
      TTransaction::open('curso');
      TTransaction::dump();

      // CRUD COMPLETO

      // CREATE
      $produto = new Produto;
      $produto->descricao = 'GRAVADOR DVD';
      $produto->estoque = 10;
      $produto->preco_venda = 100.15;
      $produto->unidade = 'PC';
      $produto->local_foto = 'https://picsum.photos/200';
      $produto->store();   
      
      // READ
      $produto = Produto::find($produto->getLastID());
      if($produto instanceof Produto) {
        // UPDATE
        $produto->descricao = 'GRAVADOR DE CD-R';
        $produto->unidade = 'UN';
        $produto->store();

        // DELETE
        $produto->delete();
      } else {
        new TMessage('error', 'Produto não encontrado');
      }

      TTransaction::close();
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }
}