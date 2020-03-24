<?php

namespace TaskForce\actions;

class AssignAction extends AbstractAction
{
    public function getCaption(): string
    {
        return 'назначить';
    }

    public function getName(): string
    {
        return 'assign';
    }

    public function isAuthorized(int $userId, int $customerId, int $contractorId): bool
    {
        return $userId === $customerId;
    }
}
