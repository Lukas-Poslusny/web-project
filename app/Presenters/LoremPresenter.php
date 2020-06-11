<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class LoremPresenter extends Nette\Application\UI\Presenter
{
    public function actionDefault() {
        if(!$this->getUser()->isLoggedIn()) {
            $this->redirect('User:login');
        }
    }
}
