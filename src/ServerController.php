<?php

namespace Yoopies\Deployment;

use Yoopies\Deployment\Model\ModelController;

/**
 * Class ServerController
 * @package Yoopies\Deployment
 */
class ServerController extends ModelController
{
    /** @var ServerManager */
    protected $serverManager;

    /**
     * @param \Twig_Environment $twig
     * @param ServerManager $serverManager
     */
    public function __construct(\Twig_Environment $twig, ServerManager $serverManager)
    {
        parent::__construct($twig);
        $this->serverManager = $serverManager;
    }

    /**
     *
     */
    public function indexAction()
    {
        $this->render('home.html.twig', [
            'allStatus'     =>  $this->getServerManager()->getGlobalConfig(),
            'front1Status'  =>  $this->getServerManager()->status('0'),
            'front2Status'  =>  $this->getServerManager()->status('1'),
            'errors'        =>  ( !isset($_GET['errors']) ? null : $_GET['errors'] ),
        ]);
    }

    /**
     * @param $id
     */
    public function upAction($id)
    {
        $errors = null;
        $return = $this->getServerManager()->up($id);

        //Error
        if (null === $return) {
            $errors = "There was an error while putting the server off the pool";
        }
        header('Location: ' . parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) . ( null === $errors ? '' : '?errors='.$errors ) );
    }

    /**
     * @param $id
     * @return string
     */
    public function downAction($id)
    {
        $errors = null;
        $return = $this->getServerManager()->down($id);

        //Error
        if (null === $return) {
            $errors[] = "There was an error while putting the server off the pool";
        }
        header('Location: ' . parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) . ( null === $errors ? '' : '?errors='.$errors ) );
    }

    /**
     * @param $id
     */
    public function drainAction($id)
    {
        $this->getServerManager()->drain($id);
    }

    /**
     * @param $serverIp
     */
    public function addAction($serverIp)
    {
        $this->getServerManager()->add($serverIp);
    }

    /**
     * @param $id
     */
    public function removeAction($id)
    {
        $this->getServerManager()->remove($id);
    }

    /**
     * @param $serverIp
     */
    public function backupAction($serverIp)
    {
        $this->getServerManager()->backup($serverIp);
    }

    /**
     * @param $id
     * @param $weight
     */
    public function weightAction($id, $weight)
    {
        $this->getServerManager()->weight($id, $weight);
    }

    /**
     * @param $id
     * @param $maxFails
     */
    public function maxFailsAction($id, $maxFails)
    {
        $this->getServerManager()->maxFails($id, $maxFails);

    }

    /**
     * @param $id
     * @param $failTimeout
     */
    public function failTimeoutAction($id, $failTimeout)
    {
        $this->getServerManager()->failTimeout($id, $failTimeout);
    }

    /**
     * @param $id
     * @param $slowStart
     */
    public function slowStartAction($id, $slowStart)
    {
        $this->getServerManager()->slowStart($id, $slowStart);
    }

    /**
     * @param $id
     * @param $route
     */
    public function routeAction($id, $route)
    {
        $this->getServerManager()->route($id, $route);
    }

    /**
     * @param $ip
     */
    public function statusAction($ip)
    {
        $this->getServerManager()->status($ip);
    }

    /**
     * @description get the full configuration for a server designated by its ip
     * @param $ip
     */
    public function getConfigAction($ip)
    {
        $this->getServerManager()->status($ip);
    }

    /**
     *
     */
    public function getGlobalConfigAction()
    {
        $globalConfig = $this->getServerManager()->getGlobalConfig();

        $this->render('home.html.twig', [
            'allStatus' => $globalConfig,
        ]);
    }

    /**
     * @return ServerManager
     */
    public function getServerManager()
    {
        return $this->serverManager;
    }
}