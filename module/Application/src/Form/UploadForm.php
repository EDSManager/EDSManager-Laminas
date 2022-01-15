<?php

namespace Application\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\InputFilter;


class UploadForm extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->addElements();

        // Добавляем правила валидации
        $this->addInputFilter();
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('document-file');
        $file->setLabel('Файл для загрузки: ');
        $file->setAttribute('id', 'document-file');

        $this->add($file);
    }

    // Этот метод создает фильтр входных данных (используется для фильтрации/валидации формы).
    private function addInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();

        //$this->setInputFilter($inputFilter);

        // Добавляем правила валидации для поля "file".

        $fileInput = new InputFilter\FileInput ('document-file');
        $fileInput->setRequired(true);
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            [
                'target'    => './data/upload/',
                'randomize' => true,
            ]
        );

        $inputFilter->add($fileInput);

        $this->setInputFilter($inputFilter);
    }
}