<?php

define("APP_PATH", realpath("..") . "/app");
define("CONFIG_PATH", realpath("..") . "/config");

require_once APP_PATH . "/System.php";

$system = new Project\System();

$system->start();