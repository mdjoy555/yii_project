<?php

namespace app\components;

use yii\base\Component;
use Yii;

Class CommonComponent extends Component{

    public function getData(){
        $data = Yii::$app->db->createCommand("select * from posts")->queryAll();
        
        return $data;
    }
}