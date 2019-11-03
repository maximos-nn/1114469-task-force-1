<?php

class TaskStateLogic
{
    const ACTION_CREATE = 1;
    const ACTION_CANCEL = 2;
    const ACTION_ASSIGN = 3;
    const ACTION_FINISH = 4;
    const ACTION_REFUSE = 5;

    const STATE_INVALID = 0; //под вопросом
    const STATE_NEW = 1;
    const STATE_CANCELED = 2;
    const STATE_INPROGRESS = 3;
    const STATE_FINISHED = 4;
    const STATE_REFUSED = 5;

    // Пока не ясна логика использования
    // const ROLE_CUSTOMER = 0;
    // const ROLE_CONTRACTOR = 1;

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
            self::STATE_FINISHED,
            self::STATE_INPROGRESS,
            self::STATE_NEW,
            self::STATE_REFUSED
        ];
    }

    public function getNextState(int $action): int //?int
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
                $result = self::STATE_REFUSED;
                break;

            default:
                $result = self::STATE_INVALID;
                break;
        }
        return $result;
    }
}
