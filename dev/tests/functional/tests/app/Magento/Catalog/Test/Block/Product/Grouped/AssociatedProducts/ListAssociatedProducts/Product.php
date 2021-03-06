<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

namespace Magento\Catalog\Test\Block\Product\Grouped\AssociatedProducts\ListAssociatedProducts;

use Mtf\Block\Block;

class Product extends Block
{
    /**
     * Fields mapping
     *
     * @var array
     */
    protected $mapping = [
        'selection_qty' => "[data-column=qty] input",
    ];

    /**
     * Fill product options
     *
     * @param string $qtyValue
     */
    public function fillQty($qtyValue)
    {
        $this->_rootElement->find($this->mapping['selection_qty'])->setValue($qtyValue);
    }
}
