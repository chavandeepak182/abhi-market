<?php

$output = shell_exec('php /full/path/to/artisan queue:work --once');
echo $output;