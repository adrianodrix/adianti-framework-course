<?php
use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TExpression;
use Adianti\Database\TFilter;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ContagemColecoes extends TPage
{
  public function __construct()
  {
    try {
      parent::__construct();
      TTransaction::open('curso');
      TTransaction::dump();
      
      $criteria = new TCriteria;
      $criteria->add(new TFilter('situacao', '=', 'Y'));
      $criteria->add(new TFilter('genero', '=', 'F'));

      $repository = new TRepository(Cliente::class);
      $count = $repository->count($criteria);

      new TMessage('info', "Registros: $count");

      TTransaction::close();
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }
}
