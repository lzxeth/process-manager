<?php
$file = '/data0/www/process-manager/log/job1.log';

file_put_contents($file, file_get_contents($file). posix_getpid()."\t i was access\n");

sleep(20); //信号会中断sleep返回剩余的秒数