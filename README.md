# Navigation Generator

## Description:
Adds new console command to spryker, which uses the imported category data to generate a navigation_node.csv based on the category-tree.

## Usage:
1. Add `NavigationGeneratorConsole` to `Pyz\Zed\Console\ConsoleDependencyProvider::getConsoleCommands()`

   ```php
   <?php
   
   namespace Pyz\Zed\Console;
   
   [...]
   use Pyz\Zed\NavigationGenerator\Communication\Console\NavigationGeneratorConsole;
   
   class ConsoleDependencyProvider extends SprykerConsoleDependencyProvider
   {
       /**
        * @param \Spryker\Zed\Kernel\Container $container
        *
        * @return array<\Symfony\Component\Console\Command\Command>
        */
       protected function getConsoleCommands(Container $container): array
       {
           $commands = [
               [...]
               new NavigationGeneratorConsole(),
           ];
   
           return $commands;
       }
   }
   ```
3. Run command:

   ```bash
    vendor/bin/console data:generate:navigation-node
    ```
## Configuration:
* `NavigationGeneratorConstants::OUTPUT_PATH` 
  * Default: `APPLICATION_ROOT_DIR . '/data/import/common/common/navigation_node.csv'`
* `NavigationGeneratorConstants::FALLBACK_LOCALE`
  * Default: `de_DE`
  * Is used when for a configured locale no category data is available
* `NavigationGeneratorConstants::NAVIGATION_KEY` 
  * Default: `MAIN_NAVIGATION`
