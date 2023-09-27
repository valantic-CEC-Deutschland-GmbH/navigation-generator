<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\NavigationGenerator;

use ValanticSpryker\Shared\NavigationGenerator\NavigationGeneratorConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class NavigationGeneratorConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getOutputPath(): string
    {
        return $this->get(NavigationGeneratorConstants::OUTPUT_PATH, APPLICATION_ROOT_DIR . '/data/import/common/common/navigation_node.csv');
    }

    /**
     * @return string
     */
    public function getFallbackLocale(): string
    {
        return $this->get(NavigationGeneratorConstants::FALLBACK_LOCALE, 'de_DE');
    }

    /**
     * @return string
     */
    public function getNavigationKey(): string
    {
        return $this->get(NavigationGeneratorConstants::NAVIGATION_KEY, 'MAIN_NAVIGATION');
    }
}
