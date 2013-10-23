<?php
use Yo\Layout\Page;
require 'SplClassLoader.php';
$classLoader = new SplClassLoader('Yo', __DIR__ ."/..");
$classLoader->register();
$layout = new Page();

echo $layout->render();
?>