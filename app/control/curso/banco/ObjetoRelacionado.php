<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjetoRelacionado extends TPage
{
  public function __construct()
  {
    try {
      parent::__construct();
      TTransaction::open('curso');
      TTransaction::dump();
      
      $cliente = Cliente::find(1);
      $contatos = $cliente->hasMany(Contato::class);
      $habilidades = $cliente->belongsToMany(Habilidade::class);
      echo '<pre>';
      var_dump($contatos);
      var_dump($habilidades);
      echo '</pre>';
      
      TTransaction::close();
      parent::add(NULL);    
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }
}