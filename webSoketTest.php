<?php
/**
 * Created by PhpStorm.
 * User: qingjia
 * Date: 16-10-25
 * Time: 上午10:35
 */

require './vendor/autoload.php';

use Workerman\Worker;

class webSoketTest {

    private $worker;

    private $users;

    public function __construct()
    {
        $this->worker = new Worker('websocket://127.0.0.1:1001');
        $this->init();
        $this->runAll();
    }

    public function init(){
        $this->worker->onConnect = function ($connection){
            $this->onConnect($connection);
        };

        $this->worker->onMessage = function($connection, $data){

            $this->OnMessage($connection, $data);
        };
    }

    public function onConnect($connection){
        $time = time();
        $this->users[$time] = $connection;
    }

    public function OnMessage($connection, $data){

        var_dump($data);

        list($uid, $content) = explode('|', $data);

        if($uid === 'all'){
            return $this->mass($content);
        }

        if(!isset($this->users[$uid])){
            return false;
        }

        return $this->send($this->users[$uid], $content);
    }

    public function send($user, $content){

        return $user->send($content);
    }

    public function mass($content){

        foreach ($this->users as $user){

            $user->send($content);
        }

        return true;
    }

    public static function runAll(){
        Worker::runAll();
    }

}

$worker = new webSoketTest();
