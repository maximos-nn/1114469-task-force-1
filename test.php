<?php
require_once __DIR__ . '/vendor/autoload.php';

use TaskForce\TaskStateLogic;
use TaskForce\actions\RefuseAction;
use TaskForce\actions\FinishAction;
use TaskForce\actions\RespondAction;
use TaskForce\actions\CancelAction;
use TaskForce\actions\AssignAction;
use TaskForce\actions\CreateAction;

try {
    $customerId = 1;
    $contractorId = 2;
    $logic = new TaskStateLogic($customerId, $contractorId, TaskStateLogic::STATE_IN_PROGRESS);

    assert(
        $logic->getNextState(CreateAction::getName()) === TaskStateLogic::STATE_NEW,
        'При запросе статуса на действие ' . CreateAction::getName() . ' возвращается статус ' . TaskStateLogic::STATE_NEW
    );
    assert(
        $logic->getNextState(CancelAction::getName()) === TaskStateLogic::STATE_CANCELED,
        'При запросе статуса на действие ' . CancelAction::getName() . ' возвращается статус ' . TaskStateLogic::STATE_CANCELED
    );
    assert(
        $logic->getNextState(AssignAction::getName()) === TaskStateLogic::STATE_IN_PROGRESS,
        'При запросе статуса на действие ' . AssignAction::getName() . ' возвращается статус ' . TaskStateLogic::STATE_IN_PROGRESS
    );
    assert(
        $logic->getNextState(FinishAction::getName()) === TaskStateLogic::STATE_FINISHED,
        'При запросе статуса на действие ' . FinishAction::getName() . ' возвращается статус ' . TaskStateLogic::STATE_FINISHED
    );
    assert(
        $logic->getNextState(RefuseAction::getName()) === TaskStateLogic::STATE_FAILED,
        'При запросе статуса на действие ' . RefuseAction::getName() . ' возвращается статус ' . TaskStateLogic::STATE_FAILED
    );

    echo '<pre>', var_dump($logic->getActions()), '</pre>';
    echo '<pre>', var_dump($logic->getStates()), '</pre>';

    $actions = $logic->getAvailableActions($contractorId, TaskStateLogic::ROLE_CONTRACTOR);
    assert(
        count($actions) === 1 && get_class($actions[0]) === RefuseAction::class,
        'Запрос доступных для исполнителя действий при статусе ' . TaskStateLogic::STATE_IN_PROGRESS . ' возвращает ' . RefuseAction::class
    );
    echo '<pre>', var_dump($actions), '</pre>';

    $actions = $logic->getAvailableActions($customerId, TaskStateLogic::ROLE_CUSTOMER);
    assert(
        count($actions) === 1 && get_class($actions[0]) === FinishAction::class,
        'Запрос доступных для заказчика действий при статусе ' . TaskStateLogic::STATE_IN_PROGRESS . ' возвращает ' . FinishAction::class
    );
    echo '<pre>', var_dump($actions), '</pre>';

    $actions = $logic->getAvailableActions(0, TaskStateLogic::ROLE_CUSTOMER);
    assert(
        !count($actions),
        'Запрос доступных для иного пользователя действий при статусе ' . TaskStateLogic::STATE_IN_PROGRESS . ' возвращает пустой массив'
    );
    echo '<pre>', var_dump($actions), '</pre>';

    $logic = new TaskStateLogic($customerId, 0, TaskStateLogic::STATE_NEW);

    $actions = $logic->getAvailableActions($contractorId, TaskStateLogic::ROLE_CONTRACTOR);
    assert(
        count($actions) === 1 && get_class($actions[0]) === RespondAction::class,
        'Запрос доступных для исполнителя действий при статусе ' . TaskStateLogic::STATE_NEW . ' возвращает ' . RespondAction::class
    );
    echo '<pre>', var_dump($actions), '</pre>';

    $actions = $logic->getAvailableActions($customerId, TaskStateLogic::ROLE_CUSTOMER);
    assert(
        1 === count(array_filter($actions, function ($obj) {
            return $obj instanceof CancelAction;
        })),
        'Запрос доступных для заказчика действий при статусе ' . TaskStateLogic::STATE_NEW . ' возвращает ' . CancelAction::class
    );
    echo '<pre>', var_dump($actions), '</pre>';

    $actions = $logic->getAvailableActions($customerId, TaskStateLogic::ROLE_CUSTOMER);
    assert(
        1 === count(array_filter($actions, function ($obj) {
            return $obj instanceof AssignAction;
        })),
        'Запрос доступных для заказчика действий при статусе ' . TaskStateLogic::STATE_NEW . ' возвращает ' . AssignAction::class
    );
    echo '<pre>', var_dump($actions), '</pre>';

    $logic = new TaskStateLogic($customerId, 0, TaskStateLogic::STATE_FAILED);

    $actions = $logic->getAvailableActions($contractorId, TaskStateLogic::ROLE_CONTRACTOR);
    assert(
        !count($actions),
        'Запрос доступных для исполнителя действий при статусе ' . TaskStateLogic::STATE_FAILED . ' возвращает пустой массив'
    );
    echo '<pre>', var_dump($actions), '</pre>';

    $logic = new TaskStateLogic($customerId, 0, 'unknown state');

} catch (\Throwable $th) {
    echo $th;
}
