#!php
<?php

require_once 'vendor/autoload.php';

$answer = (new \Dannyvdsluijs\AdventOfCode2015\Day03())->partTwo();

printf("The correct answer is: %s\r\n", $answer);