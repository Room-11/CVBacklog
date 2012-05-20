<?php namespace com\github\gooh\CVBacklog;

$appRoot = function($path) {
    return realpath(__DIR__ . '/../..' . $path);
};

ini_set('log_errors', 1);
ini_set('error_log', $appRoot('/error.log'));
ini_set('display_errors', isset($_GET['debug']));
ini_set('display_startup_errors', isset($_GET['debug']));
ini_set('arg_separator.output', '&');
ini_set('zlib.output_compression', 1);

stream_context_set_default(
    array(
        'http' => array(
            'ignore_errors' => true,
            'user_agent' => 'CV-Backlog (+https://github.com/gooh/CVBacklog)'
        )
    )
);

require $appRoot('/autoload.inc.php');
$backlog = new Cached(
    new Backlog(new Crawler(new Webpage), new Client(new Questions)),
    realpath(__DIR__ . '/../cache')
);
$backlog->defineCachingForMethod('findAll', 3600);
$controller = new BacklogController($backlog);
echo $controller->handleRequest();
