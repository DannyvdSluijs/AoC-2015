#!php
<?php

use Dannyvdsluijs\AdventOfCode2015;

require_once 'vendor/autoload.php';

ini_set('memory_limit','2048M');


$answer = (new AdventOfCode2015\Day21())->partTwo();

printf("The correct answer is: %s\r\n", $answer);