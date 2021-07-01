<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjetoAssociado extends TPage
{
  public function __construct()
  {
    try {
      parent::__construct();
      TTransaction::open('curso');
      TTransaction::dump();
      
      $cliente = Cliente::find(2);
      if($cliente instanceof Cliente) {
        echo "Nome: ". $cliente->nome;
        echo '</br>';
        echo "Categoria: ". $cliente->categoria->nome;
        echo '</br>';
        echo "Cidade: ". $cliente->cidade->nome . "/" . $cliente->cidade->estado->nome;
        echo '</br>';
        echo $cliente->render('O cliente ({id}) - {nome}, nasceu em {nascimento}');

        echo '<pre>';
        var_dump($cliente->toArray());        
        echo '</pre>';

        echo '<pre>';
        echo $cliente->toJson();
        echo '</pre>';
      } else {
        new TMessage('error', 'Cliente não foi encontrado');
      }


      TTransaction::close(); 
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }
}
