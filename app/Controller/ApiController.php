<?php

App::uses("AppController", "Controller");
define("API_ERROR", "10001");
define("API_ERROR_NOT_SIGN_UP", "10101");
define("API_ERROR_NOT_ACTIVED", "10102");


class ApiController extends AppController {

    public $name = 'Api';
    private $secret_key = API_SECRET_KEY;
    public $uses = array('Electronic', 'ActivityOff', 'Activity', 'MetaData',
        'Month', 'Week', 'MonthEnergy', 'WeekEnergy', 'ElectricalPower', 'Device');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('check_permit', 'upload_temp', "toggle", "power", "getDevices",
            "activities_of_device", "sign_up", "sign_in", "power_of_month", "upload_ip");
    }

    /**
     * General API format check
     * @return 
     */
    protected function getLinklib() {
        if ($this->request->isPost()) {
            $signed_params = $this->data['param'];
        } else {
            $signed_params = $this->request->query['param'];
        }

        if (empty($signed_params)) {
            echo json_encode(array('ret' => 'NG',
                'error_code' => API_ERR_WRONG_PARAM,
                'error_msg' => 'API_ERR_WRONG_PARAM'
            ));
            return false;
        }

        $signed_params = htmlspecialchars_decode($signed_params);
        $signed_params = stripslashes($signed_params);

        $linklib = new Linklib($signed_params);
        $error = $linklib->errorAsJson();

        if ($error) {
            echo $error;
            return false;
        } else {
            return $linklib;
        }
    }

    private function check_permit($access_time, $access_key) {
        $access_key_check = md5($access_time . API_SECRET_KEY);
        if ($access_key == $access_key_check &&
            strtotime($access_time) >= (strtotime(date('Y-m-d H:i:s')) - TIMEOUT_REQUEST_API)){
            return TRUE;
        }
        return FALSE;
    }

    public function upload_ip(){
        if ($this->request->is('get')) {
            $param = $this->request['url']['param'];
            $params = json_decode($param, true);
            $data = $params['client_query'];
            if ($device = $this->MetaData->findById(1)) {
                $device['MetaData']['value'] = $data['ip'];
                if( $this->MetaData->save($device)){
                    $devices = $this->Electronic->find('all', array(
                        'conditions' => array(
                            'type !=' => 2
                            )
                    ));
                    foreach ($devices as $key => $value) {
                        $value['Electronic']['status'] = 0;
                        $this->Electronic->save($value);
                    }
                    $result = array('data' => "ok");
                    $ret_arr = array(
                        'ret' => 'OK',
                        'data' => $result
                    );
                    echo json_encode($ret_arr);
                    exit();
                }
            }
        }
        echo json_encode(array('ret' => 'NG',
            'error_code' => API_ERROR,
            'error_msg' => 'API_ERROR'
        ));
        exit();
    }

    public function upload_temp() {
        if ($this->request->is('get')) {
            $param = $this->request['url']['param'];
            $params = json_decode($param, true);
            // if ($this->check_permit($params['access_time'], $params['access_key'])) {
                $data = $params['client_query'];
                if ($device = $this->Electronic->find('first', array('conditions' => array(
                        'name' => $data['device'],
                    )))) {
                    $device['Electronic']['term'] = $data['temp'];
                    if ($this->Electronic->save($device)) {
                        $result = array('data' => "ok");
                        $ret_arr = array(
                            'ret' => 'OK',
                            'data' => $result
                        );
                        echo json_encode($ret_arr);
                        exit();
                    }
                }
            // }
        }
        echo json_encode(array('ret' => 'NG',
            'error_code' => API_ERROR,
            'error_msg' => 'API_ERROR'
        ));
        exit();
    }

    public function power_of_month(){
        if ($this->request->is('get')) {
            $param = $this->request['url']['param'];
            $params = json_decode($param, true);
            $data = $params['client_query'];
            $e = $this->Electronic->findById($data['device_id']);
            if($e){
                $power = $this->ElectricalPower->find('all', array(
                    'conditions' => array(
                        'ElectricalPower.electronic_id' => $e['Electronic']['id'],
                        'ElectricalPower.updated_at >=' => GetTime::getFirstDayOfMonth(time()), 
                        'ElectricalPower.updated_at <=' => GetTime::getEndDayOfMonth(time())
                    ),
                    'fields' => array('sum(ElectricalPower.power) as power')
                        )
                );
                $ret_arr = array(
                    'ret' => 'OK',
                    'data' => array(
                        'power' => (int) $power[0][0]['power'],
                        'month' => intval(GetTime::getMonth(time()))
                        )
                );
                echo json_encode($ret_arr);
                exit();
            }else{
                echo json_encode(array('ret' => 'NG',
                    'error_code' => API_ERROR,
                    'error_msg' => 'Xay ra loi'
                ));
                exit();
            }
        }
    }

    public function activities_of_device(){
        if ($this->request->is('get')) {
            $param = $this->request['url']['param'];
            $params = json_decode($param, true);
            $data = $params['client_query'];

            $activities = $this->Activity->find('all', array(
                'conditions' => array(
                    'electronic_id' => $data['device_id'],
                ),
                'order' => array('Activity.updated_at desc'),
                'limit' => 20
            ));
            if($activities){
                $ret_arr = array(
                    'ret' => 'OK',
                    'data' => $activities
                );
                echo json_encode($ret_arr);
                exit();
            }else{
                echo json_encode(array('ret' => 'NG',
                    'error_code' => API_ERROR,
                    'error_msg' => 'Chua co hoat dong gì'
                ));
                exit();
            }
        }
    }

    public function toggle() {
        if ($this->request->is('get')) {
            $param = $this->request['url']['param'];
            $params = json_decode($param, true);
            $data = $params['client_query'];
            $status = $data['status'];
            $status = intval($status) + pow(-1, intval($status));
            if ($e = $this->Electronic->findById($data['device_id'])) {
                // $url = Configure::read('module_wifi_ip');
                $url = $this->MetaData->findById(1)['MetaData']['value'];
                $url .= ":333?device=" . $e['Electronic']['name'] . "&status=" . $status;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_TIMEOUT_MS, 4000);
                // if($result = curl_exec($ch)) 
                // { 
                curl_exec($ch);
                    $e['Electronic']['status'] = $status;
                    if ($this->Electronic->save($e)) {
                        $now_week = $this->getWeekNow();
                        if ($status == 0) {
                            $ac = end($e['Activity']);
                            $ac['time_off'] = time();
                        } else {
                            $ac = array(
                                'electronic_id' => $e['Electronic']['id'],
                                'time_on' => time(),
                                'week_id' => $now_week['Week']['id']
                            );
                        }
                        $this->Activity->save($ac);
                        echo json_encode(array('ret'=> 'OK'));
                        exit();
                    }  else {
                        echo json_encode(array('ret' => 'NG',
                            'error_code' => API_ERROR,
                            'error_msg' => 'Da xay ra loi!'
                        ));
                        exit();
                    }
                // }else{
                //     echo json_encode(array('ret' => 'NG',
                //         'error_code' => API_ERROR,
                //         'error_msg' => 'Da xay ra loi!'
                //     ));
                //     exit();
                // }
                curl_close($ch);
            }else{
                echo json_encode(array('ret' => 'NG',
                    'error_code' => API_ERROR,
                    'error_msg' => 'Da xay ra loi!'
                ));
                exit();
            }
        }
        echo json_encode(array('ret' => 'NG',
            'error_code' => API_ERROR,
            'error_msg' => 'Da xay ra loi!'
        ));
        exit();
    }

    public function power() {

        if ($this->request->is('get')) {
            $param = $this->request['url']['param'];
            $params = json_decode($param, true);

            $data = $params['client_query'];
            if ($device = $this->Electronic->find('first', array('conditions' => array(
                    'name' => $data['device'],
                )))) {
                if ($this->Electronic->save($device)) {
                    if ($this->ElectricalPower->save(array(
                                'electronic_id' => $device['Electronic']['id'],
                                'power' => (float) $data['power'],
                            ))) {
                        $result = array('data' => "ok");
                        $ret_arr = array(
                            'ret' => 'OK',
                            'data' => $result
                        );
                    } else {
                        echo json_encode(array('ret' => 'NG',
                            'error_code' => API_ERROR,
                            'error_msg' => 'API_ERROR'
                        ));
                        exit();
                    }
                    echo json_encode($ret_arr);
                    exit();
                }
            }
        }
        echo json_encode(array('ret' => 'NG',
            'error_code' => API_ERROR,
            'error_msg' => 'API_ERROR'
        ));
        exit();
    }

    public function getDevices() {

        if ($this->request->is('get')) {
            $this->Electronic->unbindModel(
    	        array('hasMany' => array('Activity', 'ActivityOff'))
    	    );
            if ($devices = $this->Electronic->find('all')) {

                $result = array('data' => "ok");
                $ret_arr = array(
                    'ret' => 'OK',
                    'data' => $devices
                );
            } else {
                echo json_encode(array('ret' => 'NG',
                    'error_code' => API_ERROR,
                    'error_msg' => 'API_ERROR'
                ));
                exit();
            }
            echo json_encode($ret_arr);
            exit();
        }
        echo json_encode(array('ret' => 'NG',
            'error_code' => API_ERROR,
            'error_msg' => 'API_ERROR'
        ));
        exit();
    }
    

    public function sign_up(){
        if ($this->request->is('get')) {
            $param = $this->request['url']['param'];
            $params = json_decode($param, true);

            $data = $params['client_query'];
            if(!$this->Device->find('first', array('conditions'=>array('device_id' => $data['serial'])))){
                if($this->Device->save(
                    array(
                        'device_id' => $data['serial'],
                        'name' => $data['name']
                        )
                    )){
                    echo json_encode(array('ret' => 'OK'));
                    exit();
                }else{
                    echo json_encode(array('ret' => 'NG',
                        'error_code' => API_ERROR,
                        'error_msg' => 'Da xay ra loi!'
                    ));
                    exit(); 
                }
            }else{
                echo json_encode(array('ret' => 'NG',
                    'error_code' => API_ERROR,
                    'error_msg' => 'Da xay ra loi!'
                ));
                exit(); 
            }
        }
        echo json_encode(array('ret' => 'NG',
            'error_code' => API_ERROR,
            'error_msg' => 'API_ERROR'
        ));
        exit();
    }

    public function sign_in(){
        if ($this->request->is('get')) {
            $param = $this->request['url']['param'];
            $params = json_decode($param, true);

            $data = $params['client_query'];
            if($device = $this->Device->find('first', array('conditions'=>array('device_id' => $data['serial'])))){
                if($device['Device']['status']==1){
                    echo json_encode(array('ret' => 'OK'));
                    exit();
                }else{
                    echo json_encode(array('ret' => 'NG',
                        'error_code' => API_ERROR_NOT_ACTIVED,
                        'error_msg' => 'Chua duoc admin chap nhan'
                    ));
                    exit(); 
                }
            }else{
                echo json_encode(array('ret' => 'NG',
                    'error_code' => API_ERROR_NOT_SIGN_UP,
                    'error_msg' => 'Chua dang ky!'
                ));
                exit(); 
            }
        }
        echo json_encode(array('ret' => 'NG',
            'error_code' => API_ERROR_NOT_SIGN_UP,
            'error_msg' => 'Chua dang ky'
        ));
        exit();
    }

    public function test() {
        $this->set('title_for_layout', 'API TEST');
        // default params
        $udid = 'testapi_udid';
        $auid = 'testapi_auid';
        $access_time = date('Y-m-d H:i:s');
        $access_key = md5($access_time . $udid . $auid . LINKLIB_SECRET_KEY);
        $client_query_arr = array();
        $api_method = '';
        $check = 0;
        if ($this->request->isPost()) {
            
            $check = 1;
            $udid = $this->request->data('udid');
            $auid = $this->request->data('auid');
            $access_time = $this->request->data('access_time');
            $access_key = md5($access_time . API_SECRET_KEY);

            $api_method = $this->request->data('api_method');
            $params = $this->request->data('params');
            $values = $this->request->data('values');

            if (empty($params) || empty($values)) {
                $client_query = "{}";
            } else {
                $client_query_arr = array_combine($params, $values);
                $client_query = $client_query_arr;
                // encode password before sending
                if (isset($client_query['password'])) {
                    $client_query['password'] = md5($client_query['password']);
                }
                $client_query = json_encode($client_query);
            }

            $url = ADMIN_ROOT_URL . 'api/' . $api_method . '/?param=';
//            $param = '{"udid":' . '"' . $udid . '",';
//            $param = $param . '"auid":' . '"' . $auid . '",';
            $param = '{"access_time":' . '"' . $access_time . '",';
            $param = $param . '"access_key":' . '"' . $access_key . '",';
            $param = $param . '"client_query":' . $client_query;
            $param = $param . '}';
            $param = urlencode($param);
            $url = $url . $param;

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_exec($curl);
            if (curl_errno($curl)) {
                $result = curl_error($curl);
            } else {
                $result = curl_multi_getcontent($curl);
            }
            $this->set('api_url', $url);
            $this->set("api_call_result", $result);
            $this->new_param($api_method, $client_query);
        }

        // extract list of API methods
        $class_name = get_class($this);
        $all_methods = get_class_methods($class_name);
        $fc = new ReflectionClass($class_name);
        $api_methods = array();
        foreach ($fc->getMethods() as $m) {
            $fm = new ReflectionMethod($this, $m->name);
            if ($m->class == $class_name && $fm->isPublic() && !in_array($m->name, array('beforeFilter',
                        'test',
                        'load_param', 'load_params', 'new_param', 'load_param_json'))) {
                $api_methods[] = $m->name;
            }
        }

        $params = $this->load_params();
        $this->set('client_query_arr', $client_query_arr);

        $this->set('auid', $auid);
        $this->set('udid', $udid);
        $this->set('access_time', $access_time);
        $this->set('access_key', $access_key);
        $this->set('api', $api_method);
        $this->set('api_methods', $api_methods);
        if ($api_method != null) {
            $this->set('params', $params[$api_method]);
        } else {
            if ($check == 0) {
                $this->set('client_query_arr', json_decode($params[$api_methods[0]], true));
            }
        }
    }

    public function load_param($method) {
        //$this->autoRender = FALSE;
        $params = $this->load_params();
        return $params[$method];
    }

    public function load_param_json($method) {
        $this->autoRender = FALSE;
        $file = "params.txt";
        $content = file_get_contents($file, true);
        $params = json_decode($content, true);
        if (isset($params[$method])) {
            echo $params[$method];
        } else {
            return FALSE;
        }
    }

    public function load_params() {
        //$this->autoRender = FALSE;
        $file = "params.txt";
        $content = file_get_contents($file, true);
        $params = json_decode($content, true);
        return $params;
    }

    public function new_param($method, $params_new) {
        //$this->autoRender = FALSE;
        $params = $this->load_params();
        $params[$method] = $params_new;
        $content = json_encode($params);
        $file = "params.txt";
        file_put_contents($file, $content);
    }

}
