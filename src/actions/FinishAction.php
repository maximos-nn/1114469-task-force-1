<?php

namespace TaskForce\actions;

class FinishAction extends AbstractAction
{
    public static function getCaption(): string
    {
        return 'завершить';
    }

    public static function getName(): string
    {
        return 'finish';
    }

    public function isAuthorized(): bool
    {
        return $this->userId === $this->taskStateLogic->getCustomerId();
    }
}
