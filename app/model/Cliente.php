<?php

use Adianti\Database\TRecord;

class Cliente extends TRecord
{
  const TABLENAME = 'cliente';
  const PRIMARYKEY = 'id';
  const IDPOLICY = 'max';
  const CREATEDAT = 'created_at';
  const UPDATEDAT = 'updated_at';

  private $cidade;
  private $categoria;

  public function __construct($id = null, $callObjectLoad = TRUE)
  {
    parent::__construct($id, $callObjectLoad);

    parent::addAttribute('nome');
    parent::addAttribute('endereco');
    parent::addAttribute('telefone');
    parent::addAttribute('nascimento');
    parent::addAttribute('situacao');
    parent::addAttribute('email');
    parent::addAttribute('genero');
    parent::addAttribute('categoria_id');
    parent::addAttribute('cidade_id');
    parent::addAttribute('created_at');
    parent::addAttribute('updated_at');
  }

  public function set_category(Categoria $categoria)
  {
    $this->categoria = $categoria; // armazena o objeto
    $this->categoria_id = $categoria->id; // armazena o ID do objeto
  }

  public function get_categoria()
  {
    if(empty($this->categoria)) {
      $this->categoria = new Categoria($this->categoria_id);
    }
    return $this->categoria;
  }

  public function get_cidade()
  {
    if(empty($this->cidade)) {
      $this->cidade = new Cidade($this->cidade_id);
    }
    return $this->cidade;
  }

  public function onBeforeLoad($id)
  {
    echo __CLASS__ . ": Antes de carregar o registro $id </br>";
  }

  public function onAfterLoad($object)
  {
    echo __CLASS__ . ": Depois de carregar o registro </br>";
    echo json_encode($object);
    echo '</br>';
  }

  public function onBeforeStore($object)
  {
    echo __CLASS__ . ": Antes de gravar o registro </br>";
    echo json_encode($object);
    echo '</br>';
  }

  public function onAfterStore($object)
  {
    echo __CLASS__ . ": Depois de gravar o registro </br>";
    echo json_encode($object);
    echo '</br>';
  }

  public function onBeforeDelete($object)
  {
    echo __CLASS__ . ": Antes de excluir o registro </br>";
    echo json_encode($object);
    echo '</br>';
  }

  public function onAfterDelete($object)
  {
    echo __CLASS__ . ": Depois de Excluir o registro </br>";
    echo json_encode($object);
    echo '</br>';
  }
}