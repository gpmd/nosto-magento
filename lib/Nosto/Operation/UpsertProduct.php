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
 * Operation class for upserting and deleting products through the Nosto API.
 * A product upsert will create the product if it doesn't exist or update it if
 * it does, while a product delete also results in an upsert but flags the
 * product's availability as 'Discontinued'
 */
class Nosto_Operation_UpsertProduct extends Nosto_Operation_AbstractAuthenticatedOperation
{
    /**
     * @var Nosto_Object_Product_ProductCollection collection object of products to perform the operation on.
     */
    private $collection;

    /**
     * Constructor.
     *
     * @param Nosto_Types_Signup_AccountInterface $account the account object.
     */
    public function __construct(Nosto_Types_Signup_AccountInterface $account)
    {
        parent::__construct($account);
        $this->collection = new Nosto_Object_Product_ProductCollection();
    }

    /**
     * Adds a product tho the collection on which the operation is the performed.
     *
     * @param Nosto_Types_Product_ProductInterface $product
     */
    public function addProduct(Nosto_Types_Product_ProductInterface $product)
    {
        $this->collection->append($product);
    }

    /**
     * Sends a POST request to create or update all the products currently in the collection.
     *
     * @return bool if the request was successful.
     * @throws Nosto_NostoException on failure.
     * @throws Nosto_Request_Http_Exception_AbstractHttpException
     */
    public function upsert()
    {
        $request = $this->initApiRequest($this->account->getApiToken(Nosto_Request_Api_Token::API_PRODUCTS));
        $request->setPath(Nosto_Request_Api_ApiRequest::PATH_PRODUCTS_UPSERT);
        $response = $request->post($this->collection);
        return $this->checkResponse($request, $response);
    }
}
