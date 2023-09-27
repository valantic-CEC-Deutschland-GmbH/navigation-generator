<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\NavigationGenerator\Business;

use Spryker\Client\CategoryStorage\CategoryStorageClientInterface;
use Spryker\Zed\Category\Business\CategoryFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Store\Business\StoreFacadeInterface;
use ValanticSpryker\Zed\NavigationGenerator\Business\Model\NavigationNodeFileGenerator;
use ValanticSpryker\Zed\NavigationGenerator\NavigationGeneratorDependencyProvider;

/**
 * @method \ValanticSpryker\Zed\NavigationGenerator\NavigationGeneratorConfig getConfig()
 */
class NavigationGeneratorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \ValanticSpryker\Zed\NavigationGenerator\Business\Model\NavigationNodeFileGenerator
     */
    public function createNavigationNodeFileGenerator(): NavigationNodeFileGenerator
    {
        return new NavigationNodeFileGenerator(
            $this->getConfig(),
            $this->getStoreFacade(),
            $this->getCategoryFacade(),
            $this->getCategoryStorageClient(),
        );
    }

    /**
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    private function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(NavigationGeneratorDependencyProvider::FACADE_STORE);
    }

    /**
     * @return \ValanticSpryker\Zed\Category\Business\CategoryFacadeInterface
     */
    private function getCategoryFacade(): CategoryFacadeInterface
    {
        return $this->getProvidedDependency(NavigationGeneratorDependencyProvider::FACADE_CATEGORY);
    }

    /**
     * @return \ValanticSpryker\Client\CategoryStorage\CategoryStorageClientInterface
     */
    private function getCategoryStorageClient(): CategoryStorageClientInterface
    {
        return $this->getProvidedDependency(NavigationGeneratorDependencyProvider::CLIENT_CATEGORY_STORAGE);
    }
}
