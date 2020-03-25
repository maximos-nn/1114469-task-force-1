<?php

namespace TaskForce\actions;

use TaskForce\TaskStateLogic;

abstract class AbstractAction
{
    protected $userId;
    protected $isCustomer;
    protected $taskStateLogic;

    public function __construct(int $userId, string $role, TaskStateLogic $taskStateLogic) {
        $this->userId = $userId;
        $this->isCustomer = $role === TaskStateLogic::ROLE_CUSTOMER;
        $this->taskStateLogic = $taskStateLogic;
    }

    abstract public static function getCaption(): string;
    abstract public static function getName(): string;
    abstract public function isAuthorized(): bool;
}
