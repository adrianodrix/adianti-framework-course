<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TInputDialog;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Dialog\TQuestion;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TPassword;
use Adianti\Wrapper\BootstrapFormBuilder;

class DialogsView extends TPage
{
  public function info($param)
  {
    if(array_key_exists('type', $param))
    {
      new TMessage($param['type'], 'Mensagem');
    }
    else
    {
      new TMessage('info', 'Mensagem');
    }    
  }

  public function question($param)
  {
    $actionYes = new TAction([$this, 'onYes']);
    $actionYes->setParameter('nome', 'Acao 1');

    $actionNo = new TAction([$this, 'onNo']);
    $actionNo->setParameter('nome', 'Acao 2');

    new TQuestion('Você gostaria de executar esta operação', $actionYes, $actionNo);
  }

  public static function onYes($param)
  {
    new TMessage('info', 'Você escolheu SIM '. $param['nome']);
  }

  public static function onNo($param)
  {
    new TMessage('error', 'Você escolheu NÃO '. $param['nome']);
  }

  public static function inputs($param)
  {
    $form = new BootstrapFormBuilder('input_form');
    $login = new TEntry('login');
    $pass  = new TPassword('pass');

    $form->addFields([new TLabel('Usuário')], [$login]);
    $form->addFields([new TLabel('Senha')], [$pass]);
    $form->addAction('Confirmar', new TAction([__CLASS__, 'onConfirm']), 'fa:save green');
    new TInputDialog('Título da Janela', $form);
  }

  public static function onConfirm($param)
  {
    new TMessage('info', json_encode($param));
  }
}