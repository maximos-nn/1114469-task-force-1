<?php

namespace TaskForce\actions;

class RefuseAction extends AbstractAction
{
    public static function getCaption(): string
    {
        return 'отказаться';
    }

    public static function getName(): string
    {
        return 'refuse';
    }

    public function isAuthorized(): bool
    {
        return $this->userId === $this->taskStateLogic->getContractorId();
    }
}
