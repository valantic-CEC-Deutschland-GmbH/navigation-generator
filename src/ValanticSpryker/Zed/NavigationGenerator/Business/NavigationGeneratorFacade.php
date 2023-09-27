<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\NavigationGenerator\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \ValanticSpryker\Zed\NavigationGenerator\Business\NavigationGeneratorBusinessFactory getFactory()
 */
class NavigationGeneratorFacade extends AbstractFacade implements NavigationGeneratorFacadeInterface
{
    /**
     * @return void
     */
    public function generateNavigationNodeFile(): void
    {
        $this->getFactory()->createNavigationNodeFileGenerator()->generateNavigationNodeFile();
    }
}
