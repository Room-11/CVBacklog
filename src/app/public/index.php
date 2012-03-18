<?php namespace com\github\gooh\CVBacklog;
// ini_set('display_errors', isset($_GET['debug']));
// ini_set('display_startup_errors', isset($_GET['debug']));
stream_context_set_default(
    array(
        'http' => array(
            'ignore_errors' => true,
            'user_agent' => 'CV-Backlog (+https://github.com/gooh/CVBacklog)'
        )
    )
);
require __DIR__ . '/../../autoload.inc.php';

$controller = new Cached(
    new BacklogController,
    realpath(__DIR__ . '/../cache')
);
$controller->defineCachingForMethod('handleRequest', 3600);
echo $controller->handleRequest();
