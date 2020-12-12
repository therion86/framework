<?php

declare(strict_types=1);

namespace framework\page;

use framework\interfaces\HttpResponseInterface;
use framework\interfaces\PageInterface;
use framework\interfaces\TemplateEngineInterface;

abstract class PageAbstract implements PageInterface
{

    /**
     * @var TemplateEngineInterface
     */
    private TemplateEngineInterface $templateEngine;

    /**
     * @param TemplateEngineInterface $templateEngine
     * @author Therion86
     */
    public function __construct(TemplateEngineInterface $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    /**
     * @return TemplateEngineInterface
     */
    protected function getTemplateEngine(): TemplateEngineInterface
    {
        return $this->templateEngine;
    }

    /**
     * @param HttpResponseInterface $response
     * @return HttpResponseInterface
     * @author Therion86
     */
    protected function printResponse(HttpResponseInterface $response): HttpResponseInterface
    {
        $response->setBody($this->getTemplateEngine()->printTemplate());
        return $response;
    }
}