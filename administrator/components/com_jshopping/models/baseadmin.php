<?php
/**
* @version      4.14.0 25.05.2016
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

defined('_JEXEC') or die();

class JshoppingModelBaseadmin extends JModelLegacy{
    
    protected $nameTable = '';
    protected $tableFieldPublish = 'publish';
    protected $tableFieldOrdering = 'ordering';

    public function getPrepareDataSave($input){
        return $input->post->getArray();
    }
    
    public function getNameTable(){
		if (empty($this->nameTable)){
			$r = null;
			preg_match('/Model(.*)/i', get_class($this), $r);
			$this->nameTable = strtolower($r[1]);
		}
		return $this->nameTable;
	}
    
    public function getDefaultTable(){
        return JSFactory::getTable($this->getNameTable(), 'jshop');
    }
    
    public function save(array $post){
        $table = $this->getDefaultTable();        
        $table->bind($post);
        if (!$table->check()){
            $this->setError($table->getError());
            return 0;
        }
        if (!$table->store()){
            $this->setError(_JSHOP_ERROR_SAVE_DATABASE);
            return 0;
        }
        return $table;
    }
    
    public function deleteList(array $cid, $msg = 1){
        $app = JFactory::getApplication();
        $res = array();
		foreach($cid as $id){
            $table = $this->getDefaultTable();
            $table->delete($id);
            if ($msg){
                $app->enqueueMessage(_JSHOP_ITEM_DELETED, 'message');
            }
            $res[$id] = true;
		}
        return $res;
    }
    
    public function publish(array $cid, $flag){
        $field = $this->tableFieldPublish;
        foreach($cid as $id){
            $table = $this->getDefaultTable();
            $table->load($id);
            $table->$field = $flag;
            $table->store();
		}
    }
    
    public function order($id, $move, $where = ''){
        $table = $this->getDefaultTable();
        $table->load($id);
        $table->move($move, $where, $this->tableFieldOrdering);
    }
    
    public function saveorder(array $cid, array $order, $where = ''){
        $field = $this->tableFieldOrdering;
        foreach($cid as $k=>$id){
            $table = $this->getDefaultTable();
            $table->load($id);
            if ($table->$field != $order[$k]){
                $table->$field = $order[$k];
                $table->store();
            }
        }
        $table = $this->getDefaultTable();
        $table->$field = null;
        $table->reorder($where);
    }
    
}