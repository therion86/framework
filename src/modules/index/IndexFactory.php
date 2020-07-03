<?php

declare(strict_types=1);

namespace cms\modules\index;

use cms\modules\index\page\IndexPage;
use framework\DependencyInjection;

/**
 * @author Therion86
 */
class IndexFactory
{

    /**
     * @var DependencyInjection
     */
    private DependencyInjection $di;

    /**
     * @param DependencyInjection $di
     * @author Therion86
     */
    public function __construct(DependencyInjection $di)
    {
        $this->di = $di;
    }

    /**
     * @return IndexPage
     * @author Therion86
     */
    public function createIndexPage(): IndexPage
    {
        return new IndexPage($this->di->getTemplateEngine());
    }
}