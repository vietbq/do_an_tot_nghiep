<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {
    public $uses = array('User');
    public $components = array(
        'Session',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'auth',
                'action' => 'login'
            ),
            'authError' => 'You must be logged in to view this page!!!',
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'User',
                    'fields' => array('username' => 'email'),
                    'passwordHasher' => array(
                        'className' => 'Simple',
                        'hashType' => 'md5'
                    ),
                )
            )
        )
    );

    public function getWeekNow() {
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
        return $now_week;
    }

}
