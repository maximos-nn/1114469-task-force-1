<?php

namespace TaskForce\actions;

class RefuseAction extends AbstractAction
{
    public function getCaption(): string
    {
        return 'отказаться';
    }

    public function getName(): string
    {
        return 'refuse';
    }

    public function isAuthorized(int $userId, int $customerId, int $contractorId, bool $isCustomer): bool
    {
        return $userId === $contractorId;
    }
}
