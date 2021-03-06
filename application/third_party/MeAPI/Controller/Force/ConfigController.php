<?php
class MeAPI_Controller_Force_ConfigController implements MeAPI_Controller_Force_ConfigInterface {
    protected $_response;
    private $CI;
    private $_mainAction;
    private $url_service;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        $this->CI->load->MeAPI_Model('MestoreVersionModel');
        $listgame = $this->CI->MestoreVersionModel->listGame();
        $listGame = array();
        if(count($listgame)>0){
            foreach($listgame as $v){
                $listGame[$v['service_id']] = $v;
            }
        }
        $this->data['listgame'] = $listGame;
        $this->url_service = 'http://misc.dllglobal.net';
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index&module=all'.$page;
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title']= 'DANH SÁCH CẤU HÌNH';
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
        }else{
            $page = 1;
        }
        $listItem = $this->url_service.'/?control=inside&func=gsv_config_get&page='.$page;
        $j_listItem = file_get_contents($listItem);
        $listItem = json_decode($j_listItem,true);
        $total = $listItem['data']['total'];
        unset($listItem['data']['total']);
        $this->data['listItem'] = $listItem['data'];
        
        
        $per_page = 30;
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control='.$_GET['control'].'&func=index';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();
        
        $this->CI->template->write_view('content', 'force/config/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'THÊM CẤU HÌNH';
        if ($this->CI->input->post()){
            $guide = array(
                'title'=>$_POST['guide_title'],
                'url'=>$_POST['guide_url'],
                'icon'=>$_POST['guide_icon'],
            );
            $payplist = array(
                'title'=>$_POST['payplist_title'],
                'url'=>$_POST['payplist_url'],
                'icon'=>$_POST['payplist_icon'],
            );
            $arrData = array(
                'service_id'=>$_POST['service_id'],
                'forgot'=>$_POST['forgot'],
                'event'=>$_POST['event'],
                'support'=>$_POST['support'],
                'privacypolicy'=>$_POST['privacypolicy'],
                'guide'=>  json_encode($guide),
                'payplist'=>  json_encode($payplist)
            );
            $param = http_build_query($arrData);
            $linkItem = $this->url_service.'/?control=inside&func=gsv_config_add&'.$param;
            file_get_contents($linkItem);
            redirect($this->_mainAction);
        }
        $this->CI->template->write_view('content', 'force/config/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'SỬA CẤU HÌNH';
        
        $linkItem = $this->url_service.'/?control=inside&func=gsv_config_get&service_id='.$_GET['service_id'];
        $j_getItem = file_get_contents($linkItem);
        $getItem = json_decode($j_getItem,true);
        $this->data['items'] = $getItem['data']['0'];
        
        if ($this->CI->input->post()){
            $guide = array(
                'title'=>$_POST['guide_title'],
                'url'=>$_POST['guide_url'],
                'icon'=>$_POST['guide_icon'],
            );
            $payplist = array(
                'title'=>$_POST['payplist_title'],
                'url'=>$_POST['payplist_url'],
                'icon'=>$_POST['payplist_icon'],
            );
            $arrData = array(
                'service_id'=>$_POST['service_id'],
                'forgot'=>$_POST['forgot'],
                'event'=>$_POST['event'],
                'support'=>$_POST['support'],
                'privacypolicy'=>$_POST['privacypolicy'],
                'guide'=>json_encode($guide),
                'payplist'=>json_encode($payplist)
            );
            $param = http_build_query($arrData);
            $linkItem = $this->url_service.'/?control=inside&func=gsv_config_update&id='.$_GET['id'].'&'.$param;
            file_get_contents($linkItem);
            redirect($this->_mainAction);
        }
        $this->CI->template->write_view('content', 'force/config/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getResponse() {
        return $this->_response;
    }
}