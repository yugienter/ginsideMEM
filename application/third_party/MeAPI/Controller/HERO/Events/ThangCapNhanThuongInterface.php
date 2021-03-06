﻿<?php
/* @var $cache_user CI_Cache */

interface MeAPI_Controller_HERO_Events_ThangCapNhanThuongInterface extends MeAPI_Response_ResponseInterface {

    //Load Template
    public function index(MeAPI_RequestInterface $request);

    public function giaidau(MeAPI_RequestInterface $request);

    public function themgiaidau(MeAPI_RequestInterface $request);

    public function chinhsuagiaidau(MeAPI_RequestInterface $request);

    public function quanlyqua(MeAPI_RequestInterface $request);

    public function themqua(MeAPI_RequestInterface $request);

    public function chinhsuaqua(MeAPI_RequestInterface $request);

    public function quanlyquaattach(MeAPI_RequestInterface $request);

    public function themquaattach(MeAPI_RequestInterface $request);

    public function chinhsuaquaattach(MeAPI_RequestInterface $request);

    public function thongke(MeAPI_RequestInterface $request);

    public function lichsu(MeAPI_RequestInterface $request);

    //Process
    public function add_gift(MeAPI_RequestInterface $request);
    
    public function add_gift_attach(MeAPI_RequestInterface $request);
    
    public function edit_gift(MeAPI_RequestInterface $request);
}
