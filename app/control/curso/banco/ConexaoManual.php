<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ConexaoManual extends TPage
{
  public function __construct()
  {
    parent::__construct();
    try {
      TTransaction::open('curso');
      
      $conn = TTransaction::get();

      self::estados($conn);
      self::clientes($conn);

      TTransaction::close();
    } catch (\Throwable $th) {
      TTransaction::rollback();
      new TMessage('error', $th->getMessage());
    }
  }

  public static function clientes($conn)
  {
    $result = $conn->query('SELECT id, nome FROM cliente ORDER BY id');
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