ErrorException: imagecreatefrompng(http://127.0.0.1:8000/uploads/certificates/1671444302_certificate.png): Failed to open stream: No connection could be made because the target machine actively refused it in C:\xampp\htdocs\wecertify\app\Jobs\MailJob.php:52
Stack trace:
#0 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Foundation\Bootstrap\HandleExceptions.php(259): Illuminate\Foundation\Bootstrap\HandleExceptions->handleError(2, 'imagecreatefrom...', 'C:\\xampp\\htdocs...', 52)
#1 [internal function]: Illuminate\Foundation\Bootstrap\HandleExceptions->Illuminate\Foundation\Bootstrap\{closure}(2, 'imagecreatefrom...', 'C:\\xampp\\htdocs...', 52)
#2 C:\xampp\htdocs\wecertify\app\Jobs\MailJob.php(52): imagecreatefrompng('http://127.0.0....')
#3 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(36): App\Jobs\MailJob->handle()
#4 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Container\Util.php(41): Illuminate\Container\BoundMethod::Illuminate\Container\{closure}()
#5 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(93): Illuminate\Container\Util::unwrapIfClosure(Object(Closure))
#6 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(37): Illuminate\Container\BoundMethod::callBoundMethod(Object(Illuminate\Foundation\Application), Array, Object(Closure))
#7 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Container\Container.php(651): Illuminate\Container\BoundMethod::call(Object(Illuminate\Foundation\Application), Array, Array, NULL)
#8 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Bus\Dispatcher.php(128): Illuminate\Container\Container->call(Array)
#9 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php(141): Illuminate\Bus\Dispatcher->Illuminate\Bus\{closure}(Object(App\Jobs\MailJob))
#10 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php(116): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}(Object(App\Jobs\MailJob))
#11 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Bus\Dispatcher.php(132): Illuminate\Pipeline\Pipeline->then(Object(Closure))
#12 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Queue\CallQueuedHandler.php(124): Illuminate\Bus\Dispatcher->dispatchNow(Object(App\Jobs\MailJob), false)
#13 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php(141): Illuminate\Queue\CallQueuedHandler->Illuminate\Queue\{closure}(Object(App\Jobs\MailJob))
#14 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php(116): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}(Object(App\Jobs\MailJob))
#15 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Queue\CallQueuedHandler.php(126): Illuminate\Pipeline\Pipeline->then(Object(Closure))
#16 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Queue\CallQueuedHandler.php(70): Illuminate\Queue\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\Queue\Jobs\DatabaseJob), Object(App\Jobs\MailJob))
#17 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Queue\Jobs\Job.php(98): Illuminate\Queue\CallQueuedHandler->call(Object(Illuminate\Queue\Jobs\DatabaseJob), Array)
#18 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Queue\Worker.php(425): Illuminate\Queue\Jobs\Job->fire()
#19 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Queue\Worker.php(375): Illuminate\Queue\Worker->process('database', Object(Illuminate\Queue\Jobs\DatabaseJob), Object(Illuminate\Queue\WorkerOptions))
#20 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Queue\Worker.php(173): Illuminate\Queue\Worker->runJob(Object(Illuminate\Queue\Jobs\DatabaseJob), 'database', Object(Illuminate\Queue\WorkerOptions))
#21 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Queue\Console\WorkCommand.php(150): Illuminate\Queue\Worker->daemon('database', 'default', Object(Illuminate\Queue\WorkerOptions))
#22 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Queue\Console\WorkCommand.php(134): Illuminate\Queue\Console\WorkCommand->runWorker('database', 'default')
#23 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(36): Illuminate\Queue\Console\WorkCommand->handle()
#24 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Container\Util.php(41): Illuminate\Container\BoundMethod::Illuminate\Container\{closure}()
#25 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(93): Illuminate\Container\Util::unwrapIfClosure(Object(Closure))
#26 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(37): Illuminate\Container\BoundMethod::callBoundMethod(Object(Illuminate\Foundation\Application), Array, Object(Closure))
#27 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Container\Container.php(651): Illuminate\Container\BoundMethod::call(Object(Illuminate\Foundation\Application), Array, Array, NULL)
#28 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Console\Command.php(144): Illuminate\Container\Container->call(Array)
#29 C:\xampp\htdocs\wecertify\vendor\symfony\console\Command\Command.php(308): Illuminate\Console\Command->execute(Object(Symfony\Component\Console\Input\ArgvInput), Object(Illuminate\Console\OutputStyle))
#30 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Console\Command.php(126): Symfony\Component\Console\Command\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Illuminate\Console\OutputStyle))
#31 C:\xampp\htdocs\wecertify\vendor\symfony\console\Application.php(1002): Illuminate\Console\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#32 C:\xampp\htdocs\wecertify\vendor\symfony\console\Application.php(299): Symfony\Component\Console\Application->doRunCommand(Object(Illuminate\Queue\Console\WorkCommand), Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#33 C:\xampp\htdocs\wecertify\vendor\symfony\console\Application.php(171): Symfony\Component\Console\Application->doRun(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#34 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Console\Application.php(102): Symfony\Component\Console\Application->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#35 C:\xampp\htdocs\wecertify\vendor\laravel\framework\src\Illuminate\Foundation\Console\Kernel.php(155): Illuminate\Console\Application->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#36 C:\xampp\htdocs\wecertify\artisan(37): Illuminate\Foundation\Console\Kernel->handle(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#37 {main}