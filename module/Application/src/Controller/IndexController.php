<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Form\UploadForm;
use Application\Module;
//use Laminas\ComponentInstaller\ConfigDiscovery\ApplicationConfig;
//use Laminas\Mvc\Application;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
//use User\Entity\User;


class IndexController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Constructor. Its purpose is to inject dependencies into the controller.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function indexAction()
    {

        return new ViewModel();

    }

    public function aboutAction()
    {

        $appName = 'EDS Manager';
        $appDescription = 'Краткое описание приложения EDS Manager.';

        // Возвращает переменные скрипту представления с помощью
        // переменной-контейнера ViewModel
        return new ViewModel([
            'appName' => $appName,
            'appVersion' => Module::VERSION,
            'appDescription' => $appDescription
        ]);
    }

    /**
     * The "settings" action displays the info about currently logged in user.
     */
    public function settingsAction()
    {
        // Use the CurrentUser controller plugin to get the current user.
        $user = $this->currentUser();

        if ($user==null) {
            throw new \Exception('Not logged in');
        }

        return new ViewModel([
            'user' => $user
        ]);
    }

    public function libraryAction()
    {
        return new ViewModel();
    }

    // Это действие показывает форму выгрузки файлов. Эта страница позволяет
    // выгрузить один файл на сервер.
    public function uploadAction()
    {

        // Создаем модель формы.
        $form = new UploadForm('upload');

        // Проверяем, отправил ли пользователь форму.
        if($this->getRequest()->isPost()) {


            // Обязательно объедините информацию о файлах $_FILES!
            $request = $this->getRequest();
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            // Передаем данные форме.
            $form->setData($post);

            // Валидируем форму.
            if($form->isValid()) {

                // Перемещаем выгруженный файл в его каталог назначения.
                $data = $form->getData();

                // Form is valid, save the form!
                if (! empty($post['isAjax'])) {
                    return new JsonModel(array(
                        'status'   => true,
                        'redirect' => $this->url()->fromRoute('library'),
                        'formData' => $data,
                    ));
                }

                // Fallback for non-JS clients
                return $this->redirect()->toRoute('library');

            }
        }

        if (! empty($post['isAjax'])) {
            // Send back failure information via JSON
            return new JsonModel([
                'status'     => false,
                'formErrors' => $form->getMessages(),
                'formData'   => $form->getData(),
            ]);
        }

        return ['form' => $form];


    }

    public function uploadProgressAction()
    {
        $id = $this->params()->fromQuery('id', null);
        $progress = new \Laminas\ProgressBar\Upload\SessionProgress();
        return new \Laminas\View\Model\JsonModel($progress->getProgress($id));
    }


}
