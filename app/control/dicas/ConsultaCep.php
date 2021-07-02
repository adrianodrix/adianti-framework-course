<?php
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TToast;
use Adianti\Widget\Form\TLabel;

class ConsultaCep extends TPage
{
  public function __construct()
  {
    try {
      parent::__construct();  
      parent::add(new TLabel('Consulta CEP'));    
    } catch (\Throwable $th) {
      TToast::show('error', $th->getMessage(), 'top right');
    }
  }

  public static function onCep($param = null)
  {
    if(!array_key_exists('cep', $param)) { return null; }
    
    $consulta = file_get_contents('https://brasilapi.com.br/api/cep/v1/'. $param['cep']);
    $consulta = json_decode($consulta);
    if(json_last_error() !== JSON_ERROR_NONE || empty($consulta->street)) { return null; }

    $obj = new stdClass();
    $obj->endereco = $consulta->street;
    $obj->bairro   = $consulta->neighborhood;
    $obj->cidade   = $consulta->city;
    $obj->uf       = $consulta->state;

    print_r($obj);
    return $obj;
  }
}