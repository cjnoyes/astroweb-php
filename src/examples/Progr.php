<?php

$base = realpath(dirname(__FILE__).'/../astroweb');

include_once $base . '/Job.php';
include_once $base . '/inputs/Birth.php';
include_once $base . '/inputs/Rectify.php';
include_once $base . '/inputs/ProgressedData.php';

$job = new Job('progr');
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
$prog = new ProgressedData();
$prog->years=55;
$job->addInput($prog);
$job->execute();
print_r($job->getData());
//$job->cleanup();

