<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ConexaoPrepare extends TPage
{
  public function __construct()
  {
    parent::__construct();
    try {
      TTransaction::open('curso');
      
      $conn = TTransaction::get();

      self::clientes($conn);
      
      // BUSCAR USAR Environment PARA SETAR DADOS SENSIVEIS DE CONEXAO
      print "PHP_VERSION: ". getenv("PHP_VERSION");
      
      TTransaction::close();
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }

  public static function clientes($conn)
  {
    $statement = $conn->prepare('SELECT id, nome FROM cliente WHERE id >= ? AND id <= ?');
    $statement->execute([3, 12]);
    $result = $statement->fetchAll();
      foreach ($result as $row) {
        print $row['id'] . ' - ' .
              $row['nome'] . "</br>\n";
      }
  }

  public static function estados($conn)
  {
    $result = $conn->query('SELECT id, nome FROM estado ORDER BY id');
      foreach ($result as $row) {
        print $row['id'] . ' - ' .
              $row['nome'] . "</br>\n";
      }
  }
}