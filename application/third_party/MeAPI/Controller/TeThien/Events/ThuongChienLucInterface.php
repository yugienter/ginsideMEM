<?php

/* @var $cache_user CI_Cache */

interface MeAPI_Controller_TeThien_Events_ThuongChienLucInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request);
}
