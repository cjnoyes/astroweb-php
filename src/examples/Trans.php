<?php

$base = realpath(dirname(__FILE__).'/../astroweb');

include_once $base . '/Job.php';
include_once $base . '/inputs/Birth.php';
include_once $base . '/inputs/Rectify.php';
include_once $base . '/inputs/TransData.php';
include_once $base . '/inputs/Transit.php';

$job = new Job('trans');
$rect = new Rectify();
$job->addInput($rect);
$birth = new Birth();
$birth->tzHours = -5;
$birth->tzMinutes = 0;
$birth->year = 1958;
$birth->month = 3;
$birth->day = 29;
$birth->hours = 17;
$birth->minutes = 35;
$birth->dateType = Birth::PARTS;
$birth->timeType = Birth::PARTS;
$birth->longLatType = Birth::FLOAT;
$birth->longitude = -71.5;
$birth->latitude = 44.0;
$job->addInput($birth);
$transdat = new TransData();
$transdat->count = 10;
$transdat->days = 1;
$transdat->months=0;
$transdat->years=1;
$job->addInput($transdat);
$trans = new Transit();
$trans->date = time();
$trans->time = time();
$trans->dateType = Transit::TIMESTAMP;
$trans->timeType = Transit::TIMESTAMP;
$trans->tzHours = -5;
$trans->tzMinutes = 0;
$trans->longLatType = Transit::FLOAT;
$trans->longitude = -73.94;
$trans->latitude = 40.67;
$job->addInput($trans);
$job->execute();
print_r($job->getData());
//$job->cleanup();

