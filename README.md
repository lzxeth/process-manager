# process-manager #
一个多进程管理脚本，适合后台执行并发任务

这个脚本可以管理后台任务的执行进程数量，监控子进程的数量，平滑重启。

> Note: Daemon的实现是通过`nohup + &`完成，没有使用两次fork的方式。

#### 目录结构: ###
* config--prod.ini : 配置任务的名称和子进程个数，可以同时跑多个任务
* consumer-- xxx.php : 任务脚本，可以放在任何地方，修改prod.ini中的任务脚本路径即可
* log--prod.log : 日志，多进程执行过程中的日志
* run--run.pid : 进程pid文件，存储父进程的pid，防止启动多个副本
* prod.php : 实现多进程的脚本
* prod : 进程管理脚本，可以使用命令如下：
```
$ prod start #启动
$ prod stop #平滑关闭
$ prod reload #平滑重启
$ prod monitor #对子进程的数量进行调整，多杀少启
```
#### 实现的信号
* SIGTERM : 通知主进程关闭.
* SIGHUP : 通知主进程重启全部子进程，一般SIGHUP都是重新加载配置文件，进程号不会变化，
这里对于配置文件的依赖很少，重启就是平滑关闭全部子进程，在重新启动。
* SIGUSER1 : 重新加载配置文件，主要是获取任务名的子进程数量，然后和当前启动的子进程数量
比较，多kill少add.

