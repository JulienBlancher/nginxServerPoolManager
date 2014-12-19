<?php
/**
 * @author Julien Blancher <ju.blancher@gmail.com>
 */

require __DIR__ . '/../vendor/autoload.php';

/** @var \Symfony\Component\HttpFoundation\Request $request */
$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
/** @var \Yoopies\Deployment\Config $config */
$config = new \Yoopies\Deployment\Config(
    \Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__.'/../config/config.yml'))
);

/**
 * Load Twig Baby
 */
Twig_Autoloader::register();
/** @var Twig_Loader_Filesystem $loader */
$loader = new Twig_Loader_Filesystem([
    __DIR__.'/../views',
]);
/** @var Twig_Environment $twig */
$twig = new Twig_Environment($loader, [
    'cache' => true === $config->isTwigCache() ? __DIR__.'/../var/cache' : false,
]);

/** @var \Buzz\Browser $buzzBrowser */
$buzzBrowser   = new \Buzz\Browser();
/** @var \Yoopies\Deployment\ServerManager $serverManager */
$serverManager = new \Yoopies\Deployment\ServerManager($buzzBrowser, $config);
/** @var string $route */
$route         = $request->getPathInfo();
/** @var \Yoopies\Deployment\ServerController $controller */
$controller    = new \Yoopies\Deployment\ServerController($twig, $serverManager);
/** @var string $actionName */
$actionName    = ('' === $routeAction = mb_substr($route, 1)) ? 'index' : $routeAction;
/** @var string $actionMethod */
$actionMethod  = mb_strtolower($actionName).'Action';

if (method_exists($controller, $actionMethod)) {
    /** @var array $getParams */
    $params = $request->query->all();
    /** @var array $paramsValue */
    $paramsValue = [];

    foreach ($params as $paramValue)
        $paramsValue[] = $paramValue;

    $controller->$actionMethod(...$paramsValue);
}
else
    echo '404 Baby!';


