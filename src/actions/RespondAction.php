<?php

namespace TaskForce\actions;

class RespondAction extends AbstractAction
{
    public static function getCaption(): string
    {
        return 'откликнуться';
    }

    public static function getName(): string
    {
        return 'respond';
    }

    public function isAuthorized(): bool
    {
        return !$this->isCustomer && $this->userId !== $this->taskStateLogic->getCustomerId() && !$this->taskStateLogic->getContractorId();
    }
}
