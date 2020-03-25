<?php

namespace TaskForce\actions;

class AssignAction extends AbstractAction
{
    public static function getCaption(): string
    {
        return 'назначить';
    }

    public static function getName(): string
    {
        return 'assign';
    }

    public function isAuthorized(): bool
    {
        return $this->userId === $this->taskStateLogic->getCustomerId();
    }
}
