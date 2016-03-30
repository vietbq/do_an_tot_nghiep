<?php

App::uses("AppController", "Controller");
define("API_ERROR", "10001");

class ApiController extends AppController {

    public $name = 'Api';
    private $secret_key = API_SECRET_KEY;
    public $uses = array('Electronic', 'ActivityOff', 'ActivityOn',
        'Month', 'Week', 'MonthEnergy', 'WeekEnergy');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('check_permit', 'upload_term', 'turn_off');
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
        if ($access_key == $access_key_check) {
            return TRUE;
        }
        return FALSE;
    }

    public function upload_term() {
        if ($this->request->is('get')) {
            $param = $this->request['url']['param'];
            $params = json_decode($param, true);
            if ($this->check_permit($params['access_time'], $params['access_key'])) {
                $data = $params['client_query'];
                if ($device = $this->Electronic->find('first', array('conditions' => array(
                        'name' => $data['device'],
                    )))) {
                    $device['Electronic']['term'] = $data['term'];
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
            }
        }
        echo json_encode(array('ret' => 'NG',
            'error_code' => API_ERROR,
            'error_msg' => 'API_ERROR'
        ));
        exit();
    }

    public function turn_off() {
        if ($this->request->is('get')) {
            $param = $this->request['url']['param'];
            $params = json_decode($param, true);
            $data = $params['client_query'];
            if ($device = $this->Electronic->find('first', array('conditions' => array(
                    'name' => $data['device'],
                )))) {
                $device['Electronic']['status'] = $data['status'];
                if ($this->Electronic->save($device)) {
                    $result = array('data' => "ok");
                    $ret_arr = array(
                        'ret' => 'OK',
                        'data' => $result
                    );
                    echo json_encode($ret_arr);
                    exit();
                }
            }else {
                echo "ko có";
                exit();
            }
        }
        echo json_encode(array('ret' => 'NG',
            'error_code' => API_ERROR,
            'error_msg' => 'API_ERROR'
        ));
        exit();
    }

    public function f3() {
        
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
