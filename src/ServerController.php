<?php

namespace Yoopies\Deployment;

use Yoopies\Deployment\Model\ModelController;

class ServerController extends ModelController
{
    /** @var ServerManager */
    protected $serverManager;

    public function __construct(\Twig_Environment $twig, ServerManager $serverManager)
    {
        parent::__construct($twig);
        $this->serverManager = $serverManager;
    }

    public function indexAction()
    {
        $this->render('home.html.twig');
    }

    public function addServerAction($ip)
    {
        var_dump($ip);
        //$this->serverManager->addServer(null);
    }

    /**
     * @return ServerManager
     */
    public function getServerManager()
    {
        return $this->serverManager;
    }
}