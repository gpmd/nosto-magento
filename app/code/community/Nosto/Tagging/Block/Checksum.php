<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Nosto
 * @package   Nosto_Tagging
 * @author    Nosto Solutions Ltd <magento@nosto.com>
 * @copyright Copyright (c) 2013-2015 Nosto Solutions Ltd (http://www.nosto.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Nosto checksum block.
 * Adds meta-data to the HTML document for identifying the visitor.
 *
 * @category Nosto
 * @package  Nosto_Tagging
 * @author   Nosto Solutions Ltd <magento@nosto.com>
 */
class Nosto_Tagging_Block_Checksum extends Mage_Core_Block_Template
{
    /**
     * Render HTML placeholder element for visitor's checksum.
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!Mage::helper('nosto_tagging')->isModuleEnabled()
            || !Mage::helper('nosto_tagging/account')->existsAndIsConnected()
        ) {
            return '';
        }
        return parent::_toHtml();
    }

    /**
     * Return the checksum of visitor's cookie. If no cookie is found
     * empty string will be returned.
     *
     * @return string
     */
    public function getChecksum()
    {
        $nostoHelper = Mage::helper('nosto_tagging');
        $cookieId = $nostoHelper->getCookieId();
        $checksum = '';
        if ($cookieId) {
            $checksum = hash(Nosto_Tagging_Helper_Data::VISITOR_HASH_ALGO, $cookieId);
        }
        return $checksum;
    }
}