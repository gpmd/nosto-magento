<?php
/**
 * Copyright (c) 2017, Nosto Solutions Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 * this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * 3. Neither the name of the copyright holder nor the names of its contributors
 * may be used to endorse or promote products derived from this software without
 * specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Nosto Solutions Ltd <contact@nosto.com>
 * @copyright 2017 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */



/**
 * Model for OrderConfirm information. This is used when compiling the info about an
 * OrderConfirm that is sent to Nosto.
 */
class Nosto_Object_Order_Order extends Nosto_AbstractObject implements Nosto_Types_Order_OrderInterface, Nosto_Types_ValidatableInterface, Nosto_Types_MarkupableInterface
{
    /**
     * @var string visitor checksum
     */
    private $hcid;

    /**
     * @var string|int the unique OrderConfirm number identifying the OrderConfirm
     */
    private $orderNumber;

    /**
     * @var string the date when the OrderConfirm was placed in the format Y-m-d
     */
    private $createdAt;

    /**
     * @var string the name of the payment provider used for OrderConfirm
     */
    private $paymentProvider;

    /**
     * @var Nosto_Types_Order_BuyerInterface the details of the person placing the OrderConfirm
     */
    private $customer;

    /**
     * @var Nosto_Types_LineItemInterface[] the list of items in the OrderConfirm
     */
    private $purchasedItems = array();

    /**
     * @var string the latest OrderConfirm status of the OrderConfirm
     */
    private $orderStatusCode;

    /**
     * @var string the latest OrderConfirm status of the OrderConfirm
     */
    private $orderStatusLabel;

    /**
     * @var Nosto_Types_Order_StatusInterface[] the previous OrderConfirm statuses of the OrderConfirm
     */
    private $orderStatuses;

    /**
     * @var string an external OrderConfirm reference used for reporting purposes
     */
    private $externalOrderRef;

    public function __construct()
    {
        // Dummy
    }

    /**
     * @inheritdoc
     */
    public function validationRules()
    {
        return array();
    }

    /**
     * Add a unique purchased item to the OrderConfirm
     *
     * @param Nosto_Types_LineItemInterface $purchasedItem the purchased item
     */
    public function addPurchasedItems(Nosto_Types_LineItemInterface $purchasedItem)
    {
        $this->purchasedItems[] = $purchasedItem;
    }

    /**
     * Add an previous OrderConfirm status to the OrderConfirm
     *
     * @param Nosto_Types_Order_StatusInterface $orderStatus the OrderConfirm status
     */
    public function addOrderStatus(Nosto_Types_Order_StatusInterface $orderStatus)
    {
        $this->orderStatuses[] = $orderStatus;
    }

    /**
     * @inheritdoc
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Sets the unique OrderConfirm number identifying the OrderConfirm
     *
     * @param string $orderNumber the OrderConfirm number
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @inheritdoc
     */
    public function getExternalOrderRef()
    {
        return $this->externalOrderRef;
    }

    /**
     * Sets the external OrderConfirm reference for the OrderConfirm
     *
     * @param string $externalOrderRef the external OrderConfirm reference
     */
    public function setExternalOrderRef($externalOrderRef)
    {
        $this->externalOrderRef = $externalOrderRef;
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the date when the OrderConfirm was placed in the format Y-m-d
     *
     * @param \DateTimeInterface|\DateTime $createdAt the created date.
     *
     * @throws Nosto_NostoException
     */
    public function setCreatedAt($createdAt)
    {
        if ($createdAt instanceof DateTime
            || (is_object($createdAt) && method_exists($createdAt, 'format'))) {
            $this->createdAt = $createdAt->format('Y-m-d H:i:s');
        } else {
            throw new Nosto_NostoException('Invalid argumanet, expected DateTime or DateTimeInterface');
        }
    }

    /**
     * @inheritdoc
     */
    public function getPaymentProvider()
    {
        return $this->paymentProvider;
    }

    /**
     * Sets the name of the payment provider for the OrderConfirm
     *
     * @param string $paymentProvider the payment provider
     */
    public function setPaymentProvider($paymentProvider)
    {
        $this->paymentProvider = $paymentProvider;
    }

    /**
     * @inheritdoc
     */
    public function getOrderStatusCode()
    {
        return $this->orderStatusCode;
    }

    /**
     * @inheritdoc
     */
    public function getOrderStatusLabel()
    {
        return $this->orderStatusLabel;
    }

    /**
     * Sets the latest OrderConfirm status for the OrderConfirm
     *
     * @param Nosto_Types_Order_StatusInterface $orderStatus the OrderConfirm status
     */
    public function setOrderStatus(Nosto_Types_Order_StatusInterface $orderStatus)
    {
        $this->orderStatusCode = $orderStatus->getCode();
        $this->orderStatusLabel = $orderStatus->getLabel();
    }

    /**
     * @inheritdoc
     */
    public function getPurchasedItems()
    {
        return $this->purchasedItems;
    }

    /**
     * Sets the purchased items for the OrderConfirm
     *
     * @param Nosto_Types_LineItemInterface[] $purchasedItems the purchased items
     */
    public function setPurchasedItems(array $purchasedItems)
    {
        $this->purchasedItems = $purchasedItems;
    }

    /**
     * @inheritdoc
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Sets the buyer information for the OrderConfirm
     *
     * @param Nosto_Types_Order_BuyerInterface $customer the buyer information
     */
    public function setCustomer(Nosto_Types_Order_BuyerInterface $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @inheritdoc
     */
    public function getOrderStatuses()
    {
        $formatted = array();
        if ($this->orderStatuses instanceof Traversable
            || is_array($this->orderStatuses)
        ) {
            foreach ($this->orderStatuses as $orderStatus) {
                if (!isset($formatted[$orderStatus->getCode()])) {
                    $formatted[$orderStatus->getCode()] = array();
                }
                $formatted[$orderStatus->getCode()][] = $orderStatus->getDate();
            }
        }

        return $formatted;
    }

    /**
     * Get the visitor checksum
     *
     * @return string
     */
    public function getHcid()
    {
        return $this->hcid;
    }

    /**
     * Set the visitor checksum
     *
     * @param string $hcid
     */
    public function setHcid($hcid)
    {
        $this->hcid = $hcid;
    }

    /**
     * @inheritdoc
     */
    public function getMarkupKey()
    {
        return 'nosto_purchase_order';
    }
}
