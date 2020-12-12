<?php

declare(strict_types=1);

namespace cms\modules\index\page;

use framework\interfaces\HttpRequestInterface;
use framework\interfaces\HttpResponseInterface;
use framework\page\PageAbstract;

/**
 * @author Therion86
 */
class IndexPage extends PageAbstract
{

    /**
     * @param HttpRequestInterface $request
     * @param HttpResponseInterface $response
     * @return HttpResponseInterface
     * @author Therion86
     */
    public function execute(
        HttpRequestInterface $request,
        HttpResponseInterface $response
    ): HttpResponseInterface {
        $this->getTemplateEngine()->load('index', 'index');
        $this->getTemplateEngine()->assign('indexText', 'First Page Done!');
        return $this->printResponse($response);
    }
}