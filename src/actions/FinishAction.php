<?php

namespace TaskForce\actions;

class FinishAction extends AbstractAction
{
    public function getCaption(): string
    {
        return 'завершить';
    }

    public function getName(): string
    {
        return 'finish';
    }

    public function isAuthotized(int $userId, int $customerId, int $contractorId): bool
    {
        return $userId === $customerId;
    }
}
