<?php
class MeAPI_Controller_GameRequest_ConfigController implements MeAPI_Controller_GameRequest_ConfigInterface {
    protected $_response;
    private $CI;
    private $_mainAction;
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->MeAPI_Model('GameConfigModel');
        $this->CI->load->MeAPI_Validate('GameConfigValidate');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        if($_GET['page']>0){
            $page = '&page='.$_GET['page'];
        }
        $this->_mainAction = base_url().'?control='.$_GET['control'].'&func=index'.$page;
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Library('Pgt');
        $this->data['title'] = 'Danh sách config';
        
        $this->filter();
        $getcolm = $this->CI->Session->get_session('colm');
        if (empty($getcolm)) {
            $this->CI->Session->set_session('colm', 'order');
            $this->CI->Session->set_session('order', 'ASC');
        }
        $arrFilter = array(
            'colm' => $this->CI->Session->get_session('colm'),
            'order' => $this->CI->Session->get_session('order'),
            'keyword' => $this->CI->Session->get_session('keyword'),
        );

        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
            $arrFilter["page"] = $page;
        } else {            
            $arrParam = $this->CI->security->xss_clean($_POST);
            $arrFilter = array(
                'colm' => "id",
                'order' => "DESC",
                'keyword' => $arrParam['keyword'],
                'page' => 1
            );
            $page = 1;
        }
       
        $per_page = 15;
        $pa = $page - 1;
        $start = $pa * $per_page;

        $this->data['start'] = $start;

        $listItems = $this->CI->GameConfigModel->listItem($arrFilter);
        $total = count($listItems);
        $config = array();
        $config['cur_page'] = $page;
        $config['base_url'] = base_url() . '?control='.$_GET['control'].'&func=index';
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;
        $this->CI->Pgt->cfig($config);
        $this->data['pages'] = $this->CI->Pgt->create_links();

        $listData = FALSE;
        if(empty($listItems) !== TRUE){
            $listData = array_slice($listItems, $start, $per_page);
        }
        
        
        $this->data['listItems'] = $listData;
        $this->data['pageInt'] = $start;
        $this->data['page_post'] = $per_page;
        $this->data['arrFilter'] = $arrFilter;
        $this->CI->template->write_view('content', 'gamerequest/config/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function filter() {
        $arrParam = $this->CI->security->xss_clean($_POST);
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
        }
        if ($_GET['type'] == 'sort') {
            $this->CI->Session->set_session('order', $_GET['order']);
            $this->CI->Session->set_session('colm', $_GET['colm']);
        }
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Sửa config';
        $this->data['items'] = $this->CI->GameConfigModel->getItem((int)$_GET['id']);
        if ($this->CI->input->post()){
            $this->CI->GameConfigValidate->validateForm($this->CI->input->post());
            if($this->CI->GameConfigValidate->isVaild()){
                $errors = $this->CI->GameConfigValidate->getMessageErrors();
                $items = $this->CI->GameConfigValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->GameConfigValidate->getData();
                $data['id'] = $_GET['id'];
                $this->CI->GameConfigModel->saveItem($data,array('task'=>'edit'));
                if($_GET['types']==1){
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.(int)$_GET['id']);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
        $this->CI->template->write_view('content', 'gamerequest/config/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title'] = 'Thêm config';
        
        if ($this->CI->input->post()){
            $this->CI->GameConfigValidate->validateForm($this->CI->input->post());
            if($this->CI->GameConfigValidate->isVaild()){
                $errors = $this->CI->GameConfigValidate->getMessageErrors();
                $items = $this->CI->GameConfigValidate->getData();
                $this->data['errors'] = $errors;
                $this->data['items'] = $items;
            }else{
                $data = $this->CI->GameConfigValidate->getData();
                $id = $this->CI->GameConfigModel->saveItem($data,array('task'=>'add'));
                $data['id'] = $id;
                if($_GET['types']==1){
                    redirect(base_url().'?control='.$_GET['control'].'&func=edit&id='.$id);
                }else{
                    redirect($this->_mainAction);
                }
            }
        }
        $this->data['items'] = $items;
        $this->CI->template->write_view('content', 'gamerequest/config/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request){
        $arrParam = array_merge($_POST,$_GET);
        if($arrParam['type']=='multi'){
            $this->CI->GameConfigModel->deleteItem($arrParam,array('task'=>'multi'));
        }else{
            $this->CI->GameConfigModel->deleteItem($arrParam);
        }
        redirect($this->_mainAction);
    }
    public function getResponse() {
        return $this->_response;
    }
}
