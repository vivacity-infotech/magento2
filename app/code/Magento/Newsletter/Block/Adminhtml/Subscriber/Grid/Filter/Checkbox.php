<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

/**
 * Newsletter subscribers grid filter checkbox
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace Magento\Newsletter\Block\Adminhtml\Subscriber\Grid\Filter;

class Checkbox extends \Magento\Backend\Block\Widget\Grid\Column\Filter\AbstractFilter
{
    /**
     * Get the condition of grid filter checkbox
     *
     * @return array
     */
    public function getCondition()
    {
        return [];
    }

    /**
     * Get html code for grid filter checkbox
     *
     * @return string
     */
    public function getHtml()
    {
        return '<input type="checkbox" onclick="subscriberController.checkCheckboxes(this)"/>';
    }
}
