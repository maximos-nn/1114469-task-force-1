<?php

namespace TaskForce;

use TaskForce\actions\AbstractAction;
use TaskForce\actions\AssignAction;
use TaskForce\actions\CancelAction;
use TaskForce\actions\CreateAction;
use TaskForce\actions\FinishAction;
use TaskForce\actions\RefuseAction;
use TaskForce\actions\RespondAction;

use TaskForce\exceptions\InvalidTaskStateException;
use TaskForce\exceptions\InvalidTaskRoleException;
use TaskForce\exceptions\InvalidTaskActionException;

class TaskStateLogic
{
    const STATE_INVALID = 'invalid'; // под вопросом
    const STATE_NEW = 'new';
    const STATE_CANCELED = 'canceled';
    const STATE_IN_PROGRESS = 'in_progress';
    const STATE_FINISHED = 'finished';
    const STATE_FAILED = 'failed';

    const ROLE_CUSTOMER = 'заказчик';
    const ROLE_CONTRACTOR = 'исполнитель';
    // const ROLE_ANONIMOUS = 'аноним'; // под вопросом

    private $customerId;
    private $contractorId;
    private $currentState;
    // private $deadline;

    public function __construct(int $customerId, int $contractorId, string $state)
    {
        if (!array_key_exists($state, $this->getStates())) {
            throw new InvalidTaskStateException('Неизвестный статус задания.');
        }

        $this->customerId = $customerId;
        $this->contractorId = $contractorId;
        $this->currentState = $state;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getContractorId(): int
    {
        return $this->contractorId;
    }

    // Функционал перенесен в классы действий.
    // Метод, вероятно, будет удалён.
    public function getActions(): array
    {
        // $class = RespondAction::class;
        return [
            AssignAction::getName() => AssignAction::getCaption(),
            CancelAction::getName() => CancelAction::getCaption(),
            CreateAction::getName() => CreateAction::getCaption(),
            FinishAction::getName() => FinishAction::getCaption(),
            RefuseAction::getName() => RefuseAction::getCaption(),
            RespondAction::getName() => RespondAction::getCaption()
            // $class::getName() => $class::getCaption(),
        ];
    }

    public function getStates(): array
    {
        return [
            self::STATE_CANCELED => 'Отменено',
            self::STATE_FAILED => 'Провалено',
            self::STATE_FINISHED => 'Выполнено',
            self::STATE_IN_PROGRESS => 'В работе',
            self::STATE_INVALID => 'Не определено',
            self::STATE_NEW => 'Новое'
        ];
    }

    public function getAvailableActions(int $userId, string $role): array
    {
        if ($role !== self::ROLE_CUSTOMER && $role !== self::ROLE_CONTRACTOR) {
            throw new InvalidTaskRoleException('Неизвестная роль пользователя.');
        }

        switch ($this->currentState) {
            case self::STATE_NEW:
                $actions = [
                    new CancelAction($userId, $role, $this),
                    new RespondAction($userId, $role, $this),
                    new AssignAction($userId, $role, $this)
                ];
                break;
            case self::STATE_IN_PROGRESS:
                $actions = [
                    new RefuseAction($userId, $role, $this),
                    new FinishAction($userId, $role, $this)
                ];
                break;
            default:
                return [];
        }

        return array_values(
            array_filter($actions, function (AbstractAction $action) {
                return $action->isAuthorized();
            })
        );
    }

    public function getNextState(string $action): string
    {
        switch ($action) {
            case CreateAction::getName():
            case RespondAction::getName():
                return self::STATE_NEW;
            case AssignAction::getName():
                return self::STATE_IN_PROGRESS;
            case CancelAction::getName():
                return self::STATE_CANCELED;
            case FinishAction::getName():
                return self::STATE_FINISHED;
            case RefuseAction::getName():
                return self::STATE_FAILED;
            default:
                throw new InvalidTaskActionException('Неизвестное действие задания.');
        }
    }
}
