<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TImageCapture;
use Adianti\Widget\Form\TImageCropper;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormImageUploader extends TPage
{
  private $form;

  public function __construct()
  {
    parent::__construct();
    
    $this->form = new BootstrapFormBuilder;
    $this->form->setFormTitle('Captura e Corte de Imagem');

    $imageCropper = new TImageCropper('imagecropper');
    $imageCapture = new TImageCapture('imagecapture');

    $imageCropper->setSize(300, 150);
    $imageCropper->setCropSize(150, 150);
    $imageCropper->setAllowedExtensions(['png', 'jpg', 'jpeg']);

    $imageCapture->setSize(300, 200);
    $imageCapture->setCropSize(200, 200);

    $this->form->addFields([ new TLabel('Image Cropper')], [$imageCropper]);
    $this->form->addFields([ new TLabel('Image Capture')], [$imageCapture]);

    $this->form->addAction('Enviar', new TAction([$this, 'onShow']), 'far:check-circle');
    parent::add($this->form);    
  }

  public static function onShow($param)
  {
    new TMessage('info', 'Image Crop: tmp/'. $param['imagecropper'] .'<br/>'.
                         'Image Capture: tmp/'. $param['imagecapture']
                );
  }
}