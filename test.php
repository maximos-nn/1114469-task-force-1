<?php
require_once __DIR__ . '/vendor/autoload.php';

use TaskForce\TaskStateLogic;
use TaskForce\actions\RefuseAction;
use TaskForce\actions\FinishAction;
use TaskForce\actions\RespondAction;
use TaskForce\actions\CancelAction;
use TaskForce\actions\AssignAction;

$customerId = 1;
$contractorId = 2;
$logic = new TaskStateLogic($customerId, $contractorId);

assert(
    $logic->getNextState(TaskStateLogic::ACTION_CREATE) === TaskStateLogic::STATE_NEW,
    'При запросе статуса на действие ' . TaskStateLogic::ACTION_CREATE . ' возвращается статус ' . TaskStateLogic::STATE_NEW
);
assert(
    $logic->getNextState(TaskStateLogic::ACTION_CANCEL) === TaskStateLogic::STATE_CANCELED,
    'При запросе статуса на действие ' . TaskStateLogic::ACTION_CANCEL . ' возвращается статус ' . TaskStateLogic::STATE_CANCELED
);
assert(
    $logic->getNextState(TaskStateLogic::ACTION_ASSIGN) === TaskStateLogic::STATE_IN_PROGRESS,
    'При запросе статуса на действие ' . TaskStateLogic::ACTION_ASSIGN . ' возвращается статус ' . TaskStateLogic::STATE_IN_PROGRESS
);
assert(
    $logic->getNextState(TaskStateLogic::ACTION_FINISH) === TaskStateLogic::STATE_FINISHED,
    'При запросе статуса на действие ' . TaskStateLogic::ACTION_FINISH . ' возвращается статус ' . TaskStateLogic::STATE_FINISHED
);
assert(
    $logic->getNextState(TaskStateLogic::ACTION_REFUSE) === TaskStateLogic::STATE_FAILED,
    'При запросе статуса на действие ' . TaskStateLogic::ACTION_REFUSE . ' возвращается статус ' . TaskStateLogic::STATE_FAILED
);

echo '<pre>', var_dump($logic->getActions()), '</pre>';
echo '<pre>', var_dump($logic->getStates()), '</pre>';

$actions = $logic->getAvailableActions(TaskStateLogic::STATE_IN_PROGRESS, $contractorId);
assert(
    count($actions) === 1 && get_class($actions[0]) === RefuseAction::class,
    'Запрос доступных для исполнителя действий при статусе ' . TaskStateLogic::STATE_IN_PROGRESS . ' возвращает ' . RefuseAction::class
);
echo '<pre>', var_dump($actions), '</pre>';

$actions = $logic->getAvailableActions(TaskStateLogic::STATE_IN_PROGRESS, $customerId);
assert(
    count($actions) === 1 && get_class($actions[0]) === FinishAction::class,
    'Запрос доступных для заказчика действий при статусе ' . TaskStateLogic::STATE_IN_PROGRESS . ' возвращает ' . FinishAction::class
);
echo '<pre>', var_dump($actions), '</pre>';

$actions = (new TaskStateLogic($customerId, 0))->getAvailableActions(TaskStateLogic::STATE_NEW, $contractorId);
assert(
    count($actions) === 1 && get_class($actions[0]) === RespondAction::class,
    'Запрос доступных для исполнителя действий при статусе ' . TaskStateLogic::STATE_NEW . ' возвращает ' . RespondAction::class
);
echo '<pre>', var_dump($actions), '</pre>';

$actions = $logic->getAvailableActions(TaskStateLogic::STATE_NEW, $customerId);
assert(
    1 === count(array_filter($actions, function ($obj) {
        return $obj instanceof CancelAction;
    })),
    'Запрос доступных для заказчика действий при статусе ' . TaskStateLogic::STATE_NEW . ' возвращает ' . CancelAction::class
);
echo '<pre>', var_dump($actions), '</pre>';

$actions = $logic->getAvailableActions(TaskStateLogic::STATE_NEW, $customerId);
assert(
    1 === count(array_filter($actions, function ($obj) {
        return $obj instanceof AssignAction;
    })),
    'Запрос доступных для заказчика действий при статусе ' . TaskStateLogic::STATE_NEW . ' возвращает ' . AssignAction::class
);
echo '<pre>', var_dump($actions), '</pre>';

$actions = $logic->getAvailableActions(TaskStateLogic::STATE_FAILED, $contractorId);
assert(
    !count($actions),
    'Запрос доступных для исполнителя действий при статусе ' . TaskStateLogic::STATE_FAILED . ' возвращает пустой массив'
);
echo '<pre>', var_dump($actions), '</pre>';

$actions = $logic->getAvailableActions(TaskStateLogic::STATE_IN_PROGRESS, 0);
assert(
    !count($actions),
    'Запрос доступных для иного пользователя действий при статусе ' . TaskStateLogic::STATE_IN_PROGRESS . ' возвращает пустой массив'
);
echo '<pre>', var_dump($actions), '</pre>';
