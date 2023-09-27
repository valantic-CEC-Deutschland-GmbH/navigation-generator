<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\NavigationGenerator\Business;

interface NavigationGeneratorFacadeInterface
{
    /**
     * @return void
     */
    public function generateNavigationNodeFile(): void;
}
