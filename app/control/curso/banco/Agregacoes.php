<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class Agregacoes extends TPage
{
  public function __construct()
  {
    try {
      parent::__construct();
      TTransaction::open('curso');
      TTransaction::dump();
      
      $total = Venda::sumBy('total');
      var_dump($total); echo '</br>';

      $total = Venda::countDistinctBy('total');
      var_dump($total); echo '</br>';

      $rows = Venda::groupBy('dt_venda, cliente_id')
              ->orderBy('dt_venda')
              ->sumBy('total');
              
      echo '<pre>'; var_dump($rows); echo '</pre>';

      $rows = Venda::where('dt_venda', '>', '2015-03-15')
              ->groupBy('dt_venda, cliente_id')
              ->sumBy('total');
      echo '<pre>'; var_dump($rows); echo '</pre>';

      $rows = Venda::where('dt_venda', '>', '2015-03-12')
              ->groupBy('dt_venda')
              ->maxBy('total');
      foreach ($rows as $item) {
        echo 'Data: '; Print $item->dt_venda; 
        echo ' | Total: ';Print $item->total; echo '</br>';
      }

      TTransaction::close();
      parent::add(NULL);    
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }
}