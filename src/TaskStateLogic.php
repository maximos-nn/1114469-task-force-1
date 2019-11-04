<?php

class TaskStateLogic
{
    const ACTION_CREATE = 'создать';
    const ACTION_CANCEL = 'отменить';
    const ACTION_ASSIGN = 'назначить';
    const ACTION_FINISH = 'завершить';
    const ACTION_REFUSE = 'отказаться';

    const STATE_INVALID = 'не определено'; //под вопросом
    const STATE_NEW = 'новое';
    const STATE_CANCELED = 'отменено';
    const STATE_INPROGRESS = 'выполняется';
    const STATE_FINISHED = 'завершено';
    const STATE_FAILED = 'провалено';

    // Пока не ясна логика использования
    // const ROLE_CUSTOMER = 'заказчик';
    // const ROLE_CONTRACTOR = 'исполнитель';

    // private int $customerId;
    // private int $contractorId;
    // private int $currentState;
    // private int $deadline;

    public function getActions(): array
    {
        return [
            self::ACTION_ASSIGN,
            self::ACTION_CANCEL,
            self::ACTION_CREATE,
            self::ACTION_FINISH,
            self::ACTION_REFUSE
        ];
    }

    public function getStates(): array
    {
        return [
            self::STATE_CANCELED,
            self::STATE_FAILED,
            self::STATE_FINISHED,
            self::STATE_INPROGRESS,
            self::STATE_NEW
        ];
    }

    public function getNextState(string $action): string
    {
        switch ($action) {
            case self::ACTION_CREATE:
                $result = self::STATE_NEW;
                break;

            case self::ACTION_ASSIGN:
                $result = self::STATE_INPROGRESS;
                break;

            case self::ACTION_CANCEL:
                $result = self::STATE_CANCELED;
                break;

            case self::ACTION_FINISH:
                $result = self::STATE_FINISHED;
                break;

            case self::ACTION_REFUSE:
                $result = self::STATE_FAILED;
                break;

            default:
                $result = self::STATE_INVALID;
                break;
        }
        return $result;
    }
}
