<?php

class TaskStateLogic
{
    const ACTION_CREATE = 'создать';        // под вопросом
    const ACTION_CANCEL = 'отменить';
    const ACTION_ASSIGN = 'назначить';
    const ACTION_FINISH = 'завершить';
    const ACTION_REFUSE = 'отказаться';
    const ACTION_RESPOND = 'откликнуться';  // не меняет состояние задания
                                            // с другой стороны, отсутствие откликов делает
                                            // невозможным переход в состояние 'В работе'

    const STATE_INVALID = 'Не определено';  //под вопросом
    const STATE_NEW = 'Новое';
    const STATE_CANCELED = 'Отменено';
    const STATE_INPROGRESS = 'В работе';
    const STATE_FINISHED = 'Выполнено';
    const STATE_FAILED = 'Провалено';

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
                return self::STATE_NEW;
            case self::ACTION_ASSIGN:
                return self::STATE_INPROGRESS;
            case self::ACTION_CANCEL:
                return self::STATE_CANCELED;
            case self::ACTION_FINISH:
                return self::STATE_FINISHED;
            case self::ACTION_REFUSE:
                return self::STATE_FAILED;
            default:
                return self::STATE_INVALID;
        }
    }
}
