<?php
require 'src/TaskStateLogic.php';

$logic = new TaskStateLogic;

// Пока не ясно, что тестировать. Логика в классе отсутствует.
assert(
    $logic->getNextState(TaskStateLogic::ACTION_CREATE) === TaskStateLogic::STATE_NEW,
    'При запросе статуса на действие ' . TaskStateLogic::ACTION_CREATE . ' возвращается статус ' . TaskStateLogic::STATE_NEW
);
assert(
    $logic->getNextState(TaskStateLogic::ACTION_CANCEL) === TaskStateLogic::STATE_CANCELED,
    'При запросе статуса на действие ' . TaskStateLogic::ACTION_CANCEL . ' возвращается статус ' . TaskStateLogic::STATE_CANCELED
);
assert(
    $logic->getNextState(TaskStateLogic::ACTION_ASSIGN) === TaskStateLogic::STATE_INPROGRESS,
    'При запросе статуса на действие ' . TaskStateLogic::ACTION_ASSIGN . ' возвращается статус ' . TaskStateLogic::STATE_INPROGRESS
);
assert(
    $logic->getNextState(TaskStateLogic::ACTION_FINISH) === TaskStateLogic::STATE_FINISHED,
    'При запросе статуса на действие ' . TaskStateLogic::ACTION_FINISH . ' возвращается статус ' . TaskStateLogic::STATE_FINISHED
);
assert(
    $logic->getNextState(TaskStateLogic::ACTION_REFUSE) === TaskStateLogic::STATE_FAILED,
    'При запросе статуса на действие ' . TaskStateLogic::ACTION_REFUSE . ' возвращается статус ' . TaskStateLogic::STATE_FAILED
);

var_dump($logic->getActions());
var_dump($logic->getStates());
