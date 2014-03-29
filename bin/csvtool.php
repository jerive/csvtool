#!/usr/bin/php
<?php

(@include_once __DIR__ . '/../vendor/autoload.php') || @include_once __DIR__ . '/../../../autoload.php';

use Symfony\Component\Console\Input\ArgvInput;
use Jerive\CsvTool\Command as Cmd;

$input = new ArgvInput;
$app = new Symfony\Component\Console\Application;

ini_set('auto_detect_line_endings', true);

$app->add(new Cmd\CutCommand);
$app->add(new Cmd\CallbackCommand);
$app->add(new Cmd\AppendCommand);
$app->add(new Cmd\MergeCommand);
$app->add(new Cmd\PadCommand);

$app->run(new ArgvInput);
