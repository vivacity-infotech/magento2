<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

namespace Magento\Bundle\Test\Block\Catalog\Product;

use Magento\Bundle\Test\Block\Catalog\Product\View\Type\Bundle;
use Magento\Bundle\Test\Fixture\BundleProduct;
use Mtf\Client\Element\Locator;
use Mtf\Fixture\FixtureInterface;
use Mtf\Fixture\InjectableFixture;

/**
 * Class View
 * Bundle product view block on the product page.
 */
class View extends \Magento\Catalog\Test\Block\Product\View
{
    /**
     * Customize and add to cart button selector.
     *
     * @var string
     */
    protected $customizeButton = '.action.primary.customize span';

    /**
     * Bundle options block
     *
     * @var string
     */
    protected $bundleBlock = '//*[@id="product-options-wrapper"]//fieldset[contains(@class,"bundle")]';

    /**
     * Selector for visible bundle options block.
     *
     * @var string
     */
    protected $visibleOptions = '//*[@class="product-add-form"][contains(@style,"block")]';

    /**
     * Selector for newsletter form.
     *
     * @var string
     */
    protected $newsletterFormSelector = '#newsletter-validate-detail[novalidate="novalidate"]';

    /**
     * Get bundle options block.
     *
     * @return Bundle
     */
    public function getBundleBlock()
    {
        return $this->blockFactory->create(
            'Magento\Bundle\Test\Block\Catalog\Product\View\Type\Bundle',
            ['element' => $this->_rootElement->find($this->bundleBlock, Locator::SELECTOR_XPATH)]
        );
    }

    /**
     * Click "Customize and add to cart button".
     *
     * @return void
     */
    public function clickCustomize()
    {
        $browser = $this->browser;
        $selector = $this->newsletterFormSelector;
        $this->browser->waitUntil(
            function () use ($browser, $selector) {
                $this->reinitRootElement();
                $element = $browser->find($selector);
                return $element->isVisible() ? true : null;
            }
        );
        $this->_rootElement->find($this->customizeButton)->click();
        $this->waitForElementVisible($this->addToCart);
    }

    /**
     * Return product options.
     *
     * @param FixtureInterface $product [optional]
     * @return array
     */
    public function getOptions(FixtureInterface $product = null)
    {
        $options = [];

        $this->clickCustomize();
        $options['bundle_options'] = $this->getBundleBlock()->getOptions($product);
        $options += parent::getOptions($product);

        return $options;
    }

    /**
     * Fill in the option specified for the product.
     *
     * @param FixtureInterface $product
     * @return void
     */
    public function fillOptions(FixtureInterface $product)
    {
        if ($product instanceof InjectableFixture) {
            /** @var \Magento\Bundle\Test\Fixture\BundleProduct $product */
            $checkoutData = $product->getCheckoutData();
            $bundleCheckoutData = isset($checkoutData['options']['bundle_options'])
                ? $checkoutData['options']['bundle_options']
                : [];
        } else {
            // TODO: Removed after refactoring(removed) old product fixture.
            /** @var \Magento\Bundle\Test\Fixture\BundleFixed $product */
            $bundleCheckoutData = $product->getSelectionData();
        }
        if (!$this->getBundleBlock()->isVisible()) {
            $this->clickCustomize();
        }
        $this->getBundleBlock()->fillBundleOptions($bundleCheckoutData);
    }
}
