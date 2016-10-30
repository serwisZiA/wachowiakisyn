<?php

use yii\db\Migration;
use backend\models\ModelOld;

class m160315_091953_model_table_insert_data extends Migration
{
    public function up()
    {
        $modelsOld = ModelOld::find()->all();
        
        $arTypeMap = [
            'Switch_rejon' => 2,
            'Switch_centralny' => 2,
            'Switch_bud' => 2,
            'Serwer' => 4,
            'Router' => 1,
            'Kamera' => 6,
            'Bramka_voip' => 3,
        ];
        
        $arLayerMap = [
            'Switch_rejon' => TRUE,
            'Switch_centralny' => TRUE,
            'Switch_bud' => FALSE,
            'Serwer' => NULL,
            'Router' => NULL,
            'Kamera' => NULL,
            'Bramka_voip' => NULL,
        ];
        
        $port = function ($x){
        	return '{' . str_replace(';', ',', $x->ports) . '}';	
        };
        
        
        foreach ($modelsOld as $modelOld){ 
        
            //var_dump($addressOld);
            //exit;
            
            $this->insert('model', [
                "id" => $modelOld->id,
                "name" => $modelOld->name,
                "port_count" => $modelOld->port_count,
                "type" => $arTypeMap[$modelOld->device_type],
                "manufacturer" => $modelOld->producent,
                'layer3' => $arLayerMap[$modelOld->device_type],
            	'port' => $port($modelOld)
            ]);
        }
        
        $this->execute("SELECT setval('model_id_seq', (SELECT MAX(id) FROM model))");
        
        $this->insert('model', [
//         	"id" => $modelOld->id,
        	"name" => 'ROOT',
        	"port_count" => 2,
        	"type" => 9,
        	"manufacturer" => 10,
        	'layer3' => null,
        	'port' => '{1,2}'
        ]);
        
        $this->update('model', ['config' => 1], ['in', 'id', [2, 21]]);
        $this->update('model', ['config' => 2], ['in', 'id', [1, 5, 13, 15, 31, 40, 41, 46, 47, 57, 58, 59, 60]]);
    }
    

    public function down()
    {
        $this->truncateTable('model');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
