<?php

require "../Framework.php";
require "../Environment.php";
$env = new \Yo\Environment(__DIR__."/config.xml");
$yo = new \Yo\Framework();
$yo->setEnvironment($env);
$yo->run();
