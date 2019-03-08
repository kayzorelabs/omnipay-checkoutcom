<?php
/**
 * Created by PhpStorm.
 * User: dany
 * Date: 11/03/19
 * Time: 09:57
 */

namespace Omnipay\CheckoutCom\Message;


class RefundResponse extends AbstractResponse
{

    public function isSuccessful()
    {
        if (!empty($this->data['errorCode'])) {
            return false;
        }

        if (!empty($this->data['status'])) {
            return ($this->data['status'] == 'Refunded');
        }

        return false;
    }

    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getMessage()
    {
        if (!$this->isSuccessful() && isset($this->data['errorCode'])) {
            return $this->data['errorCode'] . ': ' . $this->data['message'];
        }

        if (!$this->isSuccessful() && isset($this->data['responseCode'])) {
            return $this->data['responseCode'] . ': ' . $this->data['responseMessage'];
        }

        return null;
    }
}


