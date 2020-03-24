<?php

namespace TaskForce\actions;

abstract class AbstractAction
{
    abstract public function getCaption(): string;
    abstract public function getName(): string;
    abstract public function isAuthorized(int $userId, int $customerId, int $contractorId): bool;
}
