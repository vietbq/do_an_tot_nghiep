<?php

App::uses("AppController", "Controller");
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class UsersController extends AppController {

    public $uses = array('User');
    public $helpers = array('Paginator', 'Html', 'Form');
    public $components = array('Paginator');

    public function index() {
        $this->set('title_for_layout', Configure::read('title')['admin']['index']);
        $admins = $this->User->find("all");
        $this->set('admins', $admins);
    }

    public function add() {
        $this->set('title_for_layout', Configure::read('title')['admin']['add']);
        if ($this->request->isPost()) {
            $user = $this->request->data;
            $user['User']['password'] = "123456";
            if ($this->User->save($user)) {
                $this->Session->setFlash("Thêm người quản lý thành công");
            }
        }
    }
    public function show($id=null){
        $this->set('title_for_layout', Configure::read('title')['admin']['show']);
        if ($user = $this->User->findById($id)) {
            $this->set("user", $user);
        }else{
            $this->redirect("/pages/");
        }
    }

    public function edit($id = null) {
        $this->set('title_for_layout', Configure::read('title')['admin']['edit']);
        //var_dump($this->request->is('post'));
        $user = $this->User->findById($id);
        if ($user && $id == AuthComponent::user('id')) {
            if ($this->request->data != null) {
                $passwordHasher = new SimplePasswordHasher(array('hashType' => 'md5'));
                if ($user['User']['password'] == $passwordHasher->hash($this->request->data['data']['password'])) {
                    $new_user['User'] = $this->request->data['User'];
                    if ($new_user['User']['password'] == '' && $new_user['User']['password_confirmation'] == '') {
                        $new_user['User']['password'] = $new_user['User']['password_confirmation'] = $this->request->data['data']['password'];
                    }
                    if ($this->User->save($new_user)) {
                        $this->Session->setFlash("Thay đổi thông tin thành công",'default', null,'edit_user');
                    }
                } else {
                    $this->Session->setFlash("Mật khẩu hiện tại không đúng! Hãy nhập lại.",'default', null, 'edit_user');
                }
            }
            $this->set("user", $user);
        }else{
            $this->redirect("/pages/");
        }
    }

}
