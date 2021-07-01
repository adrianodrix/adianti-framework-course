<?php
use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TExpression;
use Adianti\Database\TFilter;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class AlterarColecoes extends TPage
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
      
      $data = [];
      $data['telefone'] = '44 3522-4444';
      $repository = new TRepository(Cliente::class);
      $repository->update($data, $criteria);
      
      TTransaction::close();
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }
}
