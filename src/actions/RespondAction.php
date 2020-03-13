<?php

namespace TaskForce\actions;

class RespondAction extends AbstractAction
{
    public function getCaption(): string
    {
        return 'откликнуться';
    }

    public function getName(): string
    {
        return 'respond';
    }

    public function isAuthotized(int $userId, int $customerId, int $contractorId): bool
    {
        return $userId !== $customerId && !$contractorId; // && ROLE_CONTRACTOR
    }
}
