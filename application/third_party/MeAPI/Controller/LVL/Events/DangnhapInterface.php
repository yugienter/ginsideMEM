<?php
interface MeAPI_Controller_LVL_Events_DangnhapInterface extends MeAPI_Response_ResponseInterface {
    public function index(MeAPI_RequestInterface $request);
    public function add(MeAPI_RequestInterface $request);
    public function edit(MeAPI_RequestInterface $request);
    public function delete(MeAPI_RequestInterface $request);
    public function excel(MeAPI_RequestInterface $request);
}
