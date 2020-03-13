<?php

namespace TaskForce;

use TaskForce\actions\AbstractAction;
use TaskForce\actions\AssignAction;
use TaskForce\actions\CancelAction;
use TaskForce\actions\CreateAction;
use TaskForce\actions\FinishAction;
use TaskForce\actions\RefuseAction;
use TaskForce\actions\RespondAction;

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
    const STATE_INPROGRESS = 'in_progress';
    const STATE_FINISHED = 'finished';
    const STATE_FAILED = 'failed';

    // Пока не ясна логика использования
    // const ROLE_CUSTOMER = 'заказчик';
    // const ROLE_CONTRACTOR = 'исполнитель';

    private $customerId;
    private $contractorId;
    // private $currentState;
    // private $deadline;

    public function __construct(int $customerId, int $contractorId)
    {
        $this->customerId = $customerId;
        $this->contractorId = $contractorId;
    }

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
            self::STATE_INPROGRESS => 'В работе',
            self::STATE_INVALID => 'Не определено',
            self::STATE_NEW => 'Новое'
        ];
    }

    public function getAvailableActions(string $state, int $userId): array
    {
        $actions = [];
        switch ($state) {
            case self::STATE_NEW:
                $actions = [
                    new CancelAction,
                    new RespondAction,
                    new AssignAction
                ];
                break;
            case self::STATE_INPROGRESS:
                $actions = [
                    new RefuseAction,
                    new FinishAction
                ];
                break;
            default:
                return [];
        }

        return array_values(
            array_filter($actions, function (AbstractAction $action) use ($userId) {
                return $action->isAuthotized($userId, $this->customerId, $this->contractorId);
            })
        );
    }

    public function getNextState(string $action): string
    {
        switch ($action) {
            case self::ACTION_CREATE:
                return self::STATE_NEW;
            case self::ACTION_ASSIGN:
                return self::STATE_INPROGRESS;
            case self::ACTION_CANCEL:
                return self::STATE_CANCELED;
            case self::ACTION_FINISH:
                return self::STATE_FINISHED;
            case self::ACTION_REFUSE:
                return self::STATE_FAILED;
            case self::ACTION_RESPOND:
                return self::STATE_NEW;
            default:
                return self::STATE_INVALID;
        }
    }
}
