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
    const ACTION_CREATE = 'create'; // под вопросом
    const ACTION_CANCEL = 'cancel';
    const ACTION_ASSIGN = 'assign';
    const ACTION_FINISH = 'finish';
    const ACTION_REFUSE = 'refuse';
    const ACTION_RESPOND = 'respond';   // не меняет состояние задания
                                        // с другой стороны, отсутствие откликов делает
                                        // невозможным переход в состояние 'В работе'

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

    // Функционал перенесен в классы действий.
    // Метод, вероятно, будет удалён.
    public function getActions(): array
    {
        return [
            self::ACTION_ASSIGN => 'назначить',
            self::ACTION_CANCEL => 'отменить',
            self::ACTION_CREATE => 'создать',
            self::ACTION_FINISH => 'завершить',
            self::ACTION_REFUSE => 'отказаться',
            self::ACTION_RESPOND => 'откликнуться'
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
                    new CancelAction,
                    new RespondAction,
                    new AssignAction
                ];
                break;
            case self::STATE_IN_PROGRESS:
                $actions = [
                    new RefuseAction,
                    new FinishAction
                ];
                break;
            default:
                return [];
        }

        $isCustomer = $role === self::ROLE_CUSTOMER;
        return array_values(
            array_filter($actions, function (AbstractAction $action) use ($userId, $isCustomer) {
                return $action->isAuthorized($userId, $this->customerId, $this->contractorId, $isCustomer);
            })
        );
    }

    public function getNextState(string $action): string
    {
        switch ($action) {
            case self::ACTION_CREATE:
            case self::ACTION_RESPOND:
                return self::STATE_NEW;
            case self::ACTION_ASSIGN:
                return self::STATE_IN_PROGRESS;
            case self::ACTION_CANCEL:
                return self::STATE_CANCELED;
            case self::ACTION_FINISH:
                return self::STATE_FINISHED;
            case self::ACTION_REFUSE:
                return self::STATE_FAILED;
            default:
                throw new InvalidTaskActionException('Неизвестное действие задания.');
        }
    }
}
