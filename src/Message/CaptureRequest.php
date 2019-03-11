<?php
/**
 * Created by PhpStorm.
 * User: dany
 * Date: 11/03/19
 * Time: 09:49
 */

namespace Omnipay\CheckoutCom\Message;


class CaptureRequest extends  AbstractRequest
{

    public function getData()
    {
        $this->validate('amount', 'currency');

        $data = array();
        $data['value'] = $this->getAmountInteger();
        $data['trackId'] = $this->getTrackId();
        $data['description'] = $this->getDescription();

        if ($udf = $this->getUdfValues()) {
            $data['udf1'] = $udf[0];
            $data['udf2'] = isset($udf[1]) ? $udf[1] : null;
            $data['udf3'] = isset($udf[2]) ? $udf[2] : null;
            $data['udf4'] = isset($udf[3]) ? $udf[3] : null;
            $data['udf5'] = isset($udf[4]) ? $udf[4] : null;
        }


        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest($data);
        return $this->response = new CaptureResponse($this, $httpResponse);
    }
    public function getEndpoint()
    {
        if($this->getTestMode()) {
            return parent::getEndpoint() . '/charges/charge_test_' . $this->getTransactionReference() . '/capture';
        }else{
            return parent::getEndpoint() . '/charges/charge_' . $this->getTransactionReference() . '/capture';
        }
    }

}