<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\NavigationGenerator;

use Spryker\Client\CategoryStorage\CategoryStorageClientInterface;
use Spryker\Zed\Category\Business\CategoryFacadeInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

/**
 * @method \ValanticSpryker\Zed\NavigationGenerator\NavigationGeneratorConfig getConfig()
 */
class NavigationGeneratorDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_STORE = 'FACADE_STORE';
    public const FACADE_CATEGORY = 'FACADE_CATEGORY';
    public const CLIENT_CATEGORY_STORAGE = 'CLIENT_CATEGORY_STORAGE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $this->addStoreFacade($container);
        $this->addCategoryFacade($container);
        $this->addCategoryStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addStoreFacade(Container $container): void
    {
        $container->set(
            static::FACADE_STORE,
            fn (Container $container): StoreFacadeInterface => $container->getLocator()->store()->facade(),
        );
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addCategoryFacade(Container $container): void
    {
        $container->set(
            static::FACADE_CATEGORY,
            fn (Container $container): CategoryFacadeInterface => $container->getLocator()->category()->facade(),
        );
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    private function addCategoryStorageClient(Container $container): void
    {
        $container->set(
            static::CLIENT_CATEGORY_STORAGE,
            fn (Container $container): CategoryStorageClientInterface => $container->getLocator()->categoryStorage()->client(),
        );
    }
}
