<?php

namespace Yoopies\Deployment;

use Buzz\Browser;

/**
 * Class ServerManager
 *
 * @package Yoopies\Deployment
 */
class ServerManager
{
    /** @var Browser */
    private $buzzBrowser;

    /** @var Config */
    private $config;


    public function __construct(Browser $buzzBrowser, Config $config)
    {
        $this->buzzBrowser = $buzzBrowser;
        $this->config = $config;
    }

    /**
     * @param $id
     */
    public function upServer($id) {
        $this->processQuery($id.'&up=');
    }

    /**
     * @param $id
     */
    public function downServer($id) {
        $this->processQuery($id.'&up=');
    }

    /**
     * @param $id
     */
    public function drainServer($id) {
        $this->processQuery($id.'&drain=');
    }

    /**
     * @param $serverIp
     */
    public function addServer($serverIp) {
        $this->processQuery($serverIp);
    }

    /**
     * @param $id
     */
    public function removeServer($id) {
        $this->processQuery($id.'&remove=');

    }

    /**
     * @param $serverIp
     */
    public function backupServer($serverIp) {
        $this->processQuery('backup=&server='.$serverIp);
    }

    /**
     * @param $id
     * @param $weight
     */
    public function serverWeight($id, $weight) {
        $this->processQuery($id.'&weight='.$weight);
    }

    /**
     * @param $id
     * @param $maxFails
     */
    public function serverMaxFails($id, $maxFails) {
        $this->processQuery($id.'&max_fails='.$maxFails);

    }

    /**
     * @param $id
     * @param $failTimeout
     */
    public function serverFailTimeout($id, $failTimeout) {
        $this->processQuery($id.'&fail_timeout='.$failTimeout);
    }

    /**
     * @param $id
     * @param $slowStart
     */
    public function serverSlowStart($id, $slowStart) {
        $this->processQuery($id.'&slow_start='.$slowStart);
    }

    /**
     * @param $id
     * @param $route
     */
    public function serverRoute($id, $route) {
        $this->processQuery($id.'&route='.$route);
    }

    /**
     * @param string $args
     */
    private function processQuery($args = '') {

        $base_url = $this->config->getSsl().'://'.$this->config->getDomain().($this->config->getPort() ? ':'.$this->config->getPort() : '').'/'.$this->config->getUpstreamConfUrl().'?upstream='.$this->config->getUpstream();

        echo $base_url.'<br>';
        $response = $this->buzzBrowser->get($base_url.'?'.$args);

        echo $response->getContent();
    }

    /**
     * @return Browser
     */
    public function getBuzzBrowser()
    {
        return $this->buzzBrowser;
    }

    /**
     * @param Browser $buzzBrowser
     */
    public function setBuzzBrowser($buzzBrowser)
    {
        $this->buzzBrowser = $buzzBrowser;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param Config $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
}