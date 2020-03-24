<?php

namespace TaskForce\actions;

class CancelAction extends AbstractAction
{
    public function getCaption(): string
    {
        return 'отменить';
    }

    public function getName(): string
    {
        return 'cancel';
    }

    public function isAuthorized(int $userId, int $customerId, int $contractorId): bool
    {
        return $userId === $customerId;
    }
}
