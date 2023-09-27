<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\NavigationGenerator\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \ValanticSpryker\Zed\NavigationGenerator\Business\NavigationGeneratorFacadeInterface getFacade()
 */
class NavigationGeneratorConsole extends Console
{
    protected const COMMAND_NAME = 'data:generate:navigation-node';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName(static::COMMAND_NAME)
            ->setDescription('Generates navigation-node.csv based on imported category data');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getFacade()->generateNavigationNodeFile();

        return static::CODE_SUCCESS;
    }
}
