<?php
/**
 * Copyright (c) 2017, Nosto_Nosto Solutions Ltd
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
 * @author Nosto_Nosto Solutions Ltd <contact@nosto.com>
 * @copyright 2017 Nosto_Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */



/**
 * Base operation class for handling all communications through the Nosto_Nosto API.
 * Each endpoint is known as an operation in the SDK.
 */
abstract class Nosto_Operation_AbstractOperation
{
    const CONTENT_TYPE_URL_FORM_ENCODED = 'application/x-www-form-urlencoded';
    const CONTENT_TYPE_APPLICATION_JSON = 'application/json';

    /**
     * @var int timeout for waiting response from the api, in second
     */
    private $responseTimeout = 5;

    /**
     * @var int timeout for connecting to the api, in second
     */
    private $connectTimeout = 5;

    /**
     * Helper method to throw an exception when an API or HTTP endpoint responds
     * with a non-200 status code.
     *
     * @param $request Nosto_Request_Http_HttpRequest the HTTP request
     * @param $response Nosto_Request_Http_HttpResponse the HTTP response to check
     * @return bool returns true when everything was okay
     * @throws \Nosto\Request\Http\Exception\AbstractHttpException
     */
    protected static function checkResponse(Nosto_Request_Http_HttpRequest $request, Nosto_Request_Http_HttpResponse $response)
    {
        if ($response->getCode() !== 200) {
            Nosto_Nosto::throwHttpException($request, $response);
        }
        return true;
    }

    /**
     * Create and returns a new API request object initialized with a content-type
     * of 'application/json' and the specified authentication token
     *
     * @param Nosto_Request_Api_Token $token the token to use for the endpoint
     * @return Nosto_Request_Api_ApiRequest the newly created request object.
     * @throws Nosto_NostoException if the account does not have the correct token set.
     */
    protected function initApiRequest(Nosto_Request_Api_Token $token = null)
    {
        if (is_null($token)) {
            throw new Nosto_NostoException('No API token found for account.');
        }

        $request = new Nosto_Request_Api_ApiRequest();
        $request->setResponseTimeout($this->getResponseTimeout());
        $request->setConnectTimeout($this->getConnectTimeout());
        $request->setContentType(self::CONTENT_TYPE_APPLICATION_JSON);
        $request->setAuthBasic('', $token->getValue());
        return $request;
    }

    /**
     * Create and returns a new API request object initialized with a content-type
     * of 'application/x-www-form-urlencoded' and the specified authentication token
     *
     * @param Nosto_Request_Api_Token $token the token to use for the endpoint
     * @return Nosto_Request_Http_HttpRequest the newly created request object.
     * @throws Nosto_NostoException if the account does not have the correct token set.
     */
    protected function initHttpRequest(Nosto_Request_Api_Token $token = null)
    {
        if (is_null($token)) {
            throw new Nosto_NostoException('No API token found for account.');
        }

        $request = new Nosto_Request_Http_HttpRequest();
        $request->setResponseTimeout($this->getResponseTimeout());
        $request->setConnectTimeout($this->getConnectTimeout());
        $request->setContentType(self::CONTENT_TYPE_URL_FORM_ENCODED);
        $request->setAuthBasic('', $token->getValue());
        return $request;
    }

    /**
     * Get response timeout in second
     * @return int response timeout in second
     */
    public function getResponseTimeout()
    {
        return $this->responseTimeout;
    }

    /**
     * Set response timeout in second
     * @param int $responseTimeout in second
     */
    public function setResponseTimeout($responseTimeout)
    {
        $this->responseTimeout = $responseTimeout;
    }

    /**
     * connect timeout in second
     * @return int connect timeout in second
     */
    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    /**
     * Set connect timeout in second
     * @param int $connectTimeout in second
     */
    public function setConnectTimeout($connectTimeout)
    {
        $this->connectTimeout = $connectTimeout;
    }
}
