<?php

declare(strict_types=1);

namespace cms\modules\index\page;

use framework\interfaces\HttpRequestInterface;
use framework\interfaces\HttpResponseInterface;
use framework\interfaces\ReadPageInterface;
use framework\interfaces\TemplateEngineInterface;
use framework\page\PageAbstract;

/**
 * @author Therion86
 */
class IndexPage extends PageAbstract implements ReadPageInterface
{

    /**
     * @param TemplateEngineInterface $templateEngine
     * @author Therion86
     */
    public function __construct(
        TemplateEngineInterface $templateEngine
    ) {
        parent::__construct($templateEngine);
    }

    /**
     * @param HttpRequestInterface $request
     * @param HttpResponseInterface $response
     * @return HttpResponseInterface
     * @author Therion86
     */
    public function executeRead(
        HttpRequestInterface $request,
        HttpResponseInterface $response
    ): HttpResponseInterface {
        $this->getTemplateEngine()->load('index', 'index');
        $this->getTemplateEngine()->assign('indexText', 'First Page Done!');
        return $this->printResponse($response);
    }
}