<?php
/**
 * @author Julien Blancher <ju.blancher@gmail.com>
 * TODO errors, success, warning bubles etc in Session
 * TODO be able to change all the parameters available in the Nginx "API"
 * TODO cf ServerController->indexAction() to be fully scalable
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

/**
 * @param $param
 *
 * @return mixed|string
 */
function ParamToController($param)
{
    /** @var  $controller */
    $controller = str_replace("_", " ", $param);
    /** @var  $controller */
    $controller = ucwords($controller);
    /** @var  $controller */
    $controller = lcfirst($controller);
    /** @var  $controller */
    $controller = str_replace(" ", "", $controller);
    /** @var  $controller */
    $controller = $controller."Action";

    return $controller;
}

Twig_Autoloader::register();
/** @var Twig_Loader_Filesystem $loader */
$loader = new Twig_Loader_Filesystem([
    __DIR__.'/../views',
]);
/** @var Twig_Environment $twig */
$twig = new Twig_Environment($loader, [
    'cache' => true === $config->isTwigCache() ? __DIR__.'/../var/cache' : false,
    'debug' => true,
]);
/** @var  $paramToController */
$paramToController = new Twig_SimpleFilter('paramtocontroller', 'ParamToController');
$twig->addExtension(new Twig_Extension_Debug());
$twig->addFilter($paramToController); // TODO finish this - Conf modification


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
$actionMethod  = $actionName.'Action';

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
    echo $actionMethod.': 404 Baby! ';


