<?php

/* @var $cache_user CI_Cache */
interface MeAPI_Controller_SocialmeInterface extends MeAPI_Response_ResponseInterface {

    public function index(MeAPI_RequestInterface $request);

 }