<?php
interface MeAPI_Controller_Game_Reports_PaymentPromoInterface extends MeAPI_Response_ResponseInterface {
    public function index(MeAPI_RequestInterface $request);
}