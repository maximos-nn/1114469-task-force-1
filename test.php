<?php
require 'src/TaskStateLogic.php';

$logic = new TaskStateLogic;

// Пока не ясно, что тестировать. Логика в классе отсутствует.
assert($logic->getNextState(TaskStateLogic::ACTION_CREATE) === TaskStateLogic::STATE_NEW);
assert($logic->getNextState(TaskStateLogic::ACTION_CANCEL) === TaskStateLogic::STATE_CANCELED);
assert($logic->getNextState(TaskStateLogic::ACTION_ASSIGN) === TaskStateLogic::STATE_INPROGRESS);
assert($logic->getNextState(TaskStateLogic::ACTION_FINISH) === TaskStateLogic::STATE_FINISHED);
assert($logic->getNextState(TaskStateLogic::ACTION_REFUSE) === TaskStateLogic::STATE_REFUSED);

var_dump($logic->getActions());
var_dump($logic->getStates());
