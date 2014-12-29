<?php
/**
 * @author Julien Blancher <ju.blancher@gmail.com>
 */

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
     * TODO getAllStatus and return it to be fully scalable
     */
    public function indexAction()
    {
        $globalConfig = $this->getServerManager()->getGlobalConfig();

        foreach ($globalConfig as $key => $front) {
            $globalConfig[$key] = explode(" ", $front);
        }

        $this->render('home.html.twig', [
            'allStatus' => $globalConfig,
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

    /** TODO
     * @param $id
     */
    public function drainAction($id)
    {
        $this->getServerManager()->drain($id);
    }

    /** TODO
     * @param $serverIp
     */
    public function addAction($serverIp)
    {
        $this->getServerManager()->add($serverIp);
    }

    /** TODO
     * @param $id
     */
    public function removeAction($id)
    {
        $this->getServerManager()->remove($id);
    }

    /** TODO
     * @param $serverIp
     */
    public function backupAction($serverIp)
    {
        $this->getServerManager()->backup($serverIp);
    }

    /** TODO
     * @param $id
     * @param $weight
     */
    public function weightAction($id, $weight)
    {
        $this->getServerManager()->weight($id, $weight);
    }

    /** TODO
     * @param $id
     * @param $maxFails
     */
    public function maxFailsAction($id, $maxFails)
    {
        $this->getServerManager()->maxFails($id, $maxFails);
    }

    /** TODO
     * @param $id
     * @param $failTimeout
     */
    public function failTimeoutAction($id, $failTimeout)
    {
        $this->getServerManager()->failTimeout($id, $failTimeout);
    }

    /** TODO
     * @param $id
     * @param $slowStart
     */
    public function slowStartAction($id, $slowStart)
    {
        $this->getServerManager()->slowStart($id, $slowStart);
    }

    /** TODO
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
     * @return ServerManager
     */
    public function getServerManager()
    {
        return $this->serverManager;
    }
}