<?php

App::uses('AppController', 'Controller');

class ElectronicsController extends AppController {

    public $helpers = array('Paginator', 'Html', 'Form', 'Js' => array('Jquery'));
    public $uses = array('Electronic', 'Activity', 'Month', 'Week', 'ElectricalPower', 'MetaData');

    public function beforeFilter() {
        parent::beforeFilter();
        $time = time();
        $year = intval(GetTime::getYear($time));
        $month = intval(GetTime::getMonth($time));
        $week = intval(GetTime::getWeeks($time));
        $now_month = $this->Month->find('first', array('conditions' => array(
                'year' => $year,
                'month' => $month
        )));
        if ($now_month == null) {
            $now_month = $this->Month->save(
                    array(
                        'year' => $year,
                        'month' => $month
                    )
            );
        }
        $now_week = $this->Week->find('first', array('conditions' => array(
                'week' => $week,
                'month_id' => $now_month['Month']['id']
        )));
        if ($now_week == null) {
            $now_week = $this->Week->save(
                    array(
                        'week' => $week,
                        'month_id' => $now_month['Month']['id']
                    )
            );
        }
    }

    public function index() {
        $this->set('title_for_layout', Configure::read('title')['electronic']['index']);
        $this->set("electronics", $this->Electronic->find('all'));
    }

    public function show($id = null) {
        $e = $this->Electronic->findById($id);
        if ($e) {
            $title = Configure::read('title')['electronic']['show'] . " " . $e['Electronic']['name'];
            $this->set('title_for_layout', $title);
            $this->set("electronic", $e);
            $time = time();
            $year = intval(GetTime::getYear($time));
            $month = intval(GetTime::getMonth($time));
            $week = intval(GetTime::getWeeks($time));
            $now_month = $this->Month->find('first', array('conditions' => array(
                    'year' => $year,
                    'month' => $month
            )));
            $now_week = $this->Week->find('first', array('conditions' => array(
                    'week' => $week,
                    'month_id' => $now_month['Month']['id']
            )));
            $activities = $this->Activity->find('all', array(
                'conditions' => array(
                    'electronic_id' => $e['Electronic']['id'],
                    'week_id' => $now_week['Week']['id']
                ),
                'order' => array('Activity.updated_at desc'),
                'limit' => 18
            ));
            $powerMonth = $this->ElectricalPower->getElectricalPowerByID(
                    $id, GetTime::getFirstDayOfMonth(time()), GetTime::getEndDayOfMonth(time())
            );
            $data = array(
                'labels'=>array(),
                'label' => array(),
                'data' => array()
            );
            foreach ($powerMonth as $i=>$p ) {
                if($i==0 || $i==  (count($powerMonth)-1)){
                    array_push($data['labels'], date("h:i:s/d-m-y",$p['ElectricalPower']['updated_at']));
                }else{
                    array_push($data['labels'], "");
                }
                array_push($data['label'], date("h:i:s/d-m-y",$p['ElectricalPower']['updated_at']));
                array_push($data['data'], intval($p['ElectricalPower']['power']));
            }

            $this->set("data",$data);
            if ($activities) {
                $this->set("activities", $activities);
            }
        }
    }
    public function add(){
        $this->set("title_for_layout",  Configure::read('title')['electronic']['add']);
        if($this->request->isPost()){
            if($this->Electronic->save($this->request->data)){
                $this->redirect('index');
            }
        }        
    }

    public function change_status($id = null, $status) {
        $this->autoRender= FALSE;
        $e = $this->Electronic->findById($id);
        header('Content-Type: application/json');
        if ($e && $e['Electronic']['status'] == $status) {
            // $url = Configure::read('module_wifi_ip');
            $url = $this->MetaData->findById(1)['MetaData']['value'];
            // echo $url;
            $url .= ":333?device=" . $e['Electronic']['name'] . "&status=" . 
                (intval($status) + pow(-1, intval($status)));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000);
            $result = curl_exec($ch);
            // if($result) 
            // { 
            // curl_exec($ch);
                $e['Electronic']['status'] = intval($status) + pow(-1, intval($status));
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
                    echo json_encode(array('ret'=> 'OK', 'data'=>$result));
                    die();
                }  else {
                    return false;
                }
            // }else{
            //     return false;
            // }
            curl_close($ch);
        }
        return false;
    }

}
