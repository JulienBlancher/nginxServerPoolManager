<?php

namespace Yoopies\Deployment\Model;


abstract class ModelController
{
    /** @var \Twig_Environment */
    protected $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param string $template
     * @param array  $context
     */
    protected function render($template, $context = [])
    {
        echo $this->renderView($template, $context);
    }

    /**
     * @param string $template
     * @param array  $context
     *
     * @return string
     */
    protected function renderView($template, $context = [])
    {
        return $this->twig->render($template, $context);
    }
}