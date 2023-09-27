<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\NavigationGenerator\Business\Model;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use ValanticSpryker\Zed\NavigationGenerator\NavigationGeneratorConfig;
use Spryker\Client\CategoryStorage\CategoryStorageClientInterface;
use Spryker\Zed\Category\Business\CategoryFacadeInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class NavigationNodeFileGenerator
{
    private const NAVIGATION_KEY = 'navigation_key';

    private const NODE_KEY = 'node_key';

    private const PARENT_NODE_KEY = 'parent_node_key';

    private const NODE_TYPE = 'node_type';

    private const ATTRIBUTES = 'attributes';

    private const ATTRIBUTE_TITLE = 'title';

    private const ATTRIBUTE_URL = 'url';

    private const ATTRIBUTE_CSS = 'css_class';

    private array $categoriesData = [];

    private array $categoryIdCache = [];

    private array $locales;

    /**
     * @param \ValanticSpryker\Zed\NavigationGenerator\NavigationGeneratorConfig $config
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     * @param \Spryker\Zed\Category\Business\CategoryFacadeInterface $categoryFacade
     * @param \Spryker\Client\CategoryStorage\CategoryStorageClientInterface $categoryStorageClient
     */
    public function __construct(
        private NavigationGeneratorConfig $config,
        private StoreFacadeInterface $storeFacade,
        private CategoryFacadeInterface $categoryFacade,
        private CategoryStorageClientInterface $categoryStorageClient
    ) {
        $this->locales = $this->getLocales();
    }

    /**
     * @return void
     */
    public function generateNavigationNodeFile(): void
    {
        foreach ($this->locales as $locale) {
            $store = explode('_', $locale)[1];
            $categories = $this->categoryStorageClient->getCategories($locale, $store);

            foreach ($categories as $category) {
                $this->formatCategory($category, '', $locale);
            }
        }

        $this->writeFile();
    }

    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $category
     * @param string $parentCategoryKey
     * @param string $locale
     *
     * @return void
     */
    private function formatCategory(CategoryNodeStorageTransfer $category, string $parentCategoryKey, string $locale): void
    {
        $categoryKey = $this->getCategoryKey($category->getIdCategory());
        $this->categoriesData[$locale][] = [
            self::NODE_KEY => $categoryKey,
            self::PARENT_NODE_KEY => $parentCategoryKey,
            self::ATTRIBUTES => $this->getCategoryAttributes($category),
        ];

        foreach ($category->getChildren() as $child) {
            $this->formatCategory($child, $categoryKey, $locale);
        }
    }

    /**
     * @return void
     */
    private function writeFile(): void
    {
        $file = fopen($this->config->getOutputPath(), 'w');
        fputcsv($file, $this->getHeader());
        $fallbackLocale = $this->config->getFallbackLocale();
        foreach ($this->categoriesData[$fallbackLocale] as $key => $categoryData) {
            $data = [
                self::NAVIGATION_KEY => $this->config->getNavigationKey(),
                self::NODE_KEY => $categoryData[self::NODE_KEY],
                self::PARENT_NODE_KEY => $categoryData[self::PARENT_NODE_KEY],
                self::NODE_TYPE => 'category',
            ];

            foreach ($this->getLocales() as $locale) {
                $localizedCategoryData = $this->categoriesData[$locale] ?? $this->categoriesData[$fallbackLocale];
                $data += $this->getLocalizedAttributes($localizedCategoryData[$key][self::ATTRIBUTES], $locale);
            }

            fputcsv($file, $data);
        }
        fclose($file);
    }

    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $category
     *
     * @return array
     */
    private function getCategoryAttributes(CategoryNodeStorageTransfer $category): array
    {
        return [
            self::ATTRIBUTE_TITLE => $category->getMetaTitle(),
            self::ATTRIBUTE_URL => $category->getUrl(),
            self::ATTRIBUTE_CSS => '',
        ];
    }

    /**
     * @param array $attributes
     * @param string $locale
     *
     * @return array
     */
    private function getLocalizedAttributes(array $attributes, string $locale): array
    {
        $localizedAttributes = [];
        foreach ($attributes as $attributeName => $attribute) {
            $keyName = $attributeName . '.' . $locale;
            $localizedAttributes[$keyName] = $attribute;
        }

        return $localizedAttributes;
    }

    /**
     * @param int $idCategory
     *
     * @return string
     */
    private function getCategoryKey(int $idCategory): string
    {
        if (isset($this->categoryIdCache[$idCategory])) {
            $categoryKey = $this->categoryIdCache[$idCategory];
        } else {
            $categoryKey = $this->categoryFacade->findCategoryById($idCategory)->getCategoryKey();
            $this->categoryIdCache[$idCategory] = $categoryKey;
        }

        return $categoryKey;
    }

    /**
     * @return string[]
     */
    private function getHeader(): array
    {
        $header = [
            self::NAVIGATION_KEY,
            self::NODE_KEY,
            self::PARENT_NODE_KEY,
            self::NODE_TYPE,
        ];

        foreach ($this->locales as $locale) {
            $localizedHeaderFields = [
                sprintf('%s.%s', self::ATTRIBUTE_TITLE, $locale),
                sprintf('%s.%s', self::ATTRIBUTE_URL, $locale),
                sprintf('%s.%s', self::ATTRIBUTE_CSS, $locale),
            ];
            $header = array_merge($header, $localizedHeaderFields);
        }

        return $header;
    }

    /**
     * @return array
     */
    private function getLocales(): array
    {
        $locales = [];
        foreach ($this->storeFacade->getAllStores() as $store) {
            $locales = array_merge($locales, $store->getAvailableLocaleIsoCodes());
        }

        return $locales;
    }
}
