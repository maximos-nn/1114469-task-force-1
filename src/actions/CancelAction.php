<?php

namespace TaskForce\actions;

class CancelAction extends AbstractAction
{
    public static function getCaption(): string
    {
        return 'отменить';
    }

    public static function getName(): string
    {
        return 'cancel';
    }

    public function isAuthorized(): bool
    {
        return $this->userId === $this->taskStateLogic->getCustomerId();
    }
}
