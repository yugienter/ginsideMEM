<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_TieuHiep_Events_LoginInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request);

}
