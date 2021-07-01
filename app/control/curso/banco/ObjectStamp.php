<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjectStamp extends TPage
{
  public function __construct()
  {
    try {
      parent::__construct();
      
      TTransaction::open('curso');
      TTransaction::dump();
      
      $cliente = new Cliente;
      $cliente->nome = 'Aba Cel 2';
      $cliente->endereco = 'Rua 1';
      $cliente->telefone = '44 56212 45110';
      $cliente->nascimento = '1981-6-2';
      $cliente->situacao = 'Y';
      $cliente->email = 'abacel@teste.com';
      $cliente->genero = 'M';
      $cliente->categoria_id = 1;
      $cliente->cidade_id = 1;
      $cliente->store();    
      $idDoCliente = $cliente->id;

      new TMessage('info', "Cliente $cliente->id gravado com sucesso.");  
      
      $cliente = new Cliente(39);
      $cliente->situacao = 'N';
      $cliente->store();

      $cliente = new Cliente;
      $cliente->delete($idDoCliente);

      TTransaction::close();
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }
}