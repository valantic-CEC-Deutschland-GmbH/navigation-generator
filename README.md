# Navigation Generator

## Description:
Adds new console command to spryker, which uses the imported category data to generate a navigation_node.csv based on the category-tree.

## Usage:
1. Register console command: add `NavigationGeneratorConsole` to `Pyz\Zed\Console\ConsoleDependencyProvider::getConsoleCommands()`
2. Run command:
    ```
    vendor/bin/console data:generate:navigation-node
    ```
## Configuration:
* `NavigationGeneratorConstants::OUTPUT_PATH` (Default: `APPLICATION_ROOT_DIR . '/data/import/common/common/navigation_node.csv'`)
* `NavigationGeneratorConstants::FALLBACK_LOCALE` (Default: `de_DE`, is used when for a configured locale no category data is available)
* `NavigationGeneratorConstants::NAVIGATION_KEY` (Default: `MAIN_NAVIGATION`)
