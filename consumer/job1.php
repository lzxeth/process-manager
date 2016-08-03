<?php
$file = '/data0/www/process-manager/job1.log';

file_put_contents($file, file_get_contents($file). posix_getpid()."\t i was access\n");
