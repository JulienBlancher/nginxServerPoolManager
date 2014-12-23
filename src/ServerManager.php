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

    /**
     * @param Browser $buzzBrowser
     * @param Config $config
     */
    public function __construct(Browser $buzzBrowser, Config $config)
    {
        $this->buzzBrowser = $buzzBrowser;
        $this->config = $config;
    }

    /**
     * @param $id
     * @return bool
     */
    public function up($id)
    {
        return $this->processQuery('id=' . $id . '&up=');
    }

    /**
     * @param $id
     * @return string
     */
    public function down($id)
    {
        return $this->processQuery('id=' . $id . '&down=');
    }

    /**
     * @param $id
     * @return bool
     */
    public function drain($id)
    {
        return $this->processQuery($id . '&drain=');
    }

    /**
     * @param $ip
     * @return bool
     */
    public function add($ip)
    {
        return $this->processQuery($ip);
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id)
    {
        return $this->processQuery($id . '&remove=');
    }

    /**
     * @param $ip
     * @return bool
     */
    public function backup($ip)
    {
        return $this->processQuery('backup=&server=' . $ip);
    }

    /**
     * @param $id
     * @param $weight
     * @return bool
     */
    public function weight($id, $weight)
    {
        return $this->processQuery($id . '&weight=' . $weight);
    }

    /**
     * @param $id
     * @param $maxFails
     * @return bool
     */
    public function maxFails($id, $maxFails)
    {
        return $this->processQuery($id . '&max_fails=' . $maxFails);

    }

    /**
     * @param $id
     * @param $failTimeout
     * @return bool
     */
    public function failTimeout($id, $failTimeout)
    {
        return $this->processQuery($id . '&fail_timeout=' . $failTimeout);
    }

    /**
     * @param $id
     * @param $slowStart
     * @return bool
     */
    public function slowStart($id, $slowStart)
    {
        return $this->processQuery($id . '&slow_start=' . $slowStart);
    }

    /**
     * @param $id
     * @param $route
     * @return bool
     */
    public function route($id, $route)
    {
        return $this->processQuery($id . '&route=' . $route);
    }

    /**
     * @param $id
     * @return bool
     */
    public function status($id)
    {
        $config = $this->processQuery('&id='.$id);
        return (strstr($config, 'down') === false ? 1 : 0);
    }

    /**
     * @param $id
     * @return bool
     */
    public function getConfig($id)
    {
        return (bool)$this->processQuery('&id='.$id);
    }

    /**
     * @return string
     */
    public function getGlobalConfig()
    {
        $status = nl2br($this->processQuery(), false);

        return $status;
    }

    /**
     * @param string $args
     * @return bool
     */
    private function processQuery($args = '')
    {
        $base_url = $this->config->getSsl() . '://' . $this->config->getDomain() . ($this->config->getPort() ? ':' . $this->config->getPort() : '') . '/' . $this->config->getUpstreamConfUrl() . '?upstream=' . $this->config->getUpstream();

        $response = $this->buzzBrowser->get($base_url . ($args ? '&' : '') . $args);

        $status_code = $response->getHeaders()[0];

        if (strstr($status_code, '200'))
            return $response->getContent();
        else
            return null;
    }
}