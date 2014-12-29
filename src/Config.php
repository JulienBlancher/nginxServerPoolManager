<?php
/**
 * @author Julien Blancher <ju.blancher@gmail.com>
 */

namespace Yoopies\Deployment;

class Config
{
    /** @var string */
    private $domain;

    /** @var int */
    private $port;

    /** @var string */
    private $upstream;

    /** @var string */
    private $ssl = 'http';

    /** @var string */
    private $upstreamConfUrl;

    /** @var bool */
    private $twigCache;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->analyseObj();
        $this->domain = $config['domain'];
        $this->port = $config['port'];
        $this->upstream = $config['upstream'];
        if ($config['ssl'])
            $this->ssl = 'https';
        $this->upstreamConfUrl = $config['upstream_conf_url'];
        $this->twigCache = (bool)$config['twig_cache'];
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getUpstream()
    {
        return $this->upstream;
    }

    /**
     * @param string $upstream
     */
    public function setUpstream($upstream)
    {
        $this->upstream = $upstream;
    }

    /**
     * @return string
     */
    public function getSsl()
    {
        return $this->ssl;
    }

    /**
     * @param string $ssl
     */
    public function setSsl($ssl)
    {
        $this->ssl = $ssl;
    }

    /**
     * @return string
     */
    public function getUpstreamConfUrl()
    {
        return $this->upstreamConfUrl;
    }

    /**
     * @param string $upstreamConfUrl
     */
    public function setUpstreamConfUrl($upstreamConfUrl)
    {
        $this->upstreamConfUrl = $upstreamConfUrl;
    }

    /**
     * @return boolean
     */
    public function isTwigCache()
    {
        return $this->twigCache;
    }

    /**
     * @param boolean $twigCache
     */
    public function setTwigCache($twigCache)
    {
        $this->twigCache = $twigCache;
    }

    private function analyseObj()
    {
        $reflectionObject     = new \ReflectionProperty($this, 'port');
        //var_dump($reflectionObject);
//        $reflectionProperties = (array)$reflectionObject->getProperties();
//
//        foreach ($reflectionProperties as $property) {
//            var_dump($property);
//        }
    }
}