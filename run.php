#!php
<?php

use Dannyvdsluijs\AdventOfCode2015;

require_once 'vendor/autoload.php';

$answer = (new AdventOfCode2015\Day13())->partTwo();

printf("The correct answer is: %s\r\n", $answer);