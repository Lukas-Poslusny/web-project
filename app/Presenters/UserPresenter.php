<?php

declare(strict_types=1);

namespace App\Presenters;

use App\UserRepository;
use Nette;
use Nette\Application\UI;
use Tracy\Debugger;


final class UserPresenter extends Nette\Application\UI\Presenter
{
    /** @inject */
    public UserRepository $userRepository;

    public function actionLogin() {
        if($this->getUser()->isLoggedIn()) {
            $this->redirect('Lorem:');
        }
    }

    public function actionRegister() {
        if($this->getUser()->isLoggedIn()) {
            $this->redirect('Lorem:');
        }
    }

    public function actionLogout() {
        $this->getUser()->logout();
        $this->redirect('User:login');
    }

    protected function createComponentRegistrationForm(): UI\Form
    {
        $form = new UI\Form;
        $form->addText('name', 'Jmeno:');
        $form->addPassword('password', 'Heslo:');
        $form->addSubmit('login', 'Registrovat');
        $form->onSuccess[] = [$this, 'registrationFormSucceeded'];
        return $form;
    }

    public function registrationFormSucceeded(UI\Form $form, \stdClass $values): void
    {

        $this->userRepository->saveUser($values->name, $values->password);
        Debugger::barDump($values);
        $this->flashMessage('Byl jste uspesne registrovan.');
        $this->redirect('Lorem:');
        $values->name;
    }

    protected function createComponentLoginForm(): UI\Form
    {
        $form = new UI\Form;
        $form->addText('name', 'Jmeno:')
            ->setRequired('Prosim vyplnte sve uzivatelske jmeno.');
        $form->addPassword('password', 'Heslo:')
            ->setRequired('Prosim vyplnte sve heslo.');
        $form->addSubmit('login', 'Login');
        $form->onSuccess[] = [$this, 'loginFormSucceeded'];
        return $form;
    }

    public function loginFormSucceeded(UI\Form $form, \stdClass $values): void
    {
        Debugger::barDump($values);
        try {
            $this->getUser()->login($values->name, $values->password);
            $this->flashMessage('Byl jste uspesne prihlasen.');
            $this->redirect('Lorem:');
            $values->name;
        } catch (Nette\Security\AuthenticationException $e) {
            $this->flashMessage('Spatny username nebo heslo');
        }

    }
}
