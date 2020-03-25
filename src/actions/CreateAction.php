<?php

namespace TaskForce\actions;

class CreateAction extends AbstractAction
{
    public static function getCaption(): string
    {
        return 'создать';
    }

    public static function getName(): string
    {
        return 'create';
    }

    public function isAuthorized(): bool
    {
        return $this->isCustomer && !$this->taskStateLogic->getCustomerId() && !$this->taskStateLogic->getContractorId();
    }
}
