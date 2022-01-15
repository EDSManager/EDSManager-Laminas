<?php

namespace Application\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;

class UploadForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->addElements();
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('document-file');
        $file->setLabel('Файл для загрузки: ');
        $file->setAttribute('id', 'document-file');

        $this->add($file);
    }
}