<?php
    
 /**
 * Treats data from plugin
 *
 * *Description* Schnittstelle Datenbankanwendungen fuer Plugin
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
namespace Model;


/**
 * Class HandlePluginData
 * @package Model
 */

class HandlePluginData {
	
	/** Properties */
	public $entries;

	/**
	 * HandlePluginData constructor.
	 */

	public function __construct(){
		$this->entries = new \Model\GetContent();
	}

	/**
	 * Plugin MySQL SELECT ausfuehren
	 *
	 * *Description* simpler mysql-select
	 *
	 * @param string , array, array
	 *
	 * @return array|bool
	 */
	
	public function selectDB($table, $exec = [], $select = [] ){
		
		$arrExec = [];
		if(!empty($select)){
			$selected = implode(',', $select);
		}
		else {
			$selected = '*';
		}
		if(!empty($exec)){
			$order = '';
			$group = '';
			foreach($exec as $key => $value){
				if($key == 'orderBY'){
					if(!empty($value) and ($value[1] == 'ASC' or $value[1] == 'DESC')){ 
						$order = ' ORDER BY '.preg_replace('/[^a-zA-Z0-9_]/','',$value[0]).' '.$value[1].' ';
					}
					else{
						$order = '';
					}
				}
				elseif($key == 'groupBY'){
					$group = !empty($value) ? ' GROUP BY '.preg_replace('/[^a-zA-Z0-9_]/','',$value).' ' : '';
				}
				else{
					$key = preg_replace('/[^a-zA-Z0-9_]/','',$key);
					$arrExec[':'.$key] = $value;
					$param[] = $key.' = :'.$key;
				}
			}
			$where = !empty($param) ? ' WHERE '.implode(' AND ', $param) : '';
		}
		else {
			$where = '';
			$order = '';
			$group = '';
		}
			
		$sql = "SELECT ".$selected." FROM ".TBL_PRFX.preg_replace('/[^a-zA-Z0-9_]/','',$table)." ".$where.$group.$order; 
		$stmt = $this->entries->db->prepare($sql);
		$stmt->execute($arrExec);
		$request = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		if(!empty($request)){
			return $request;
		}
		else{
			return FALSE;
		}		
	}

	/**
	 * Plugin MySQL UPDATE execute
	 *
	 * *Description* simple mysql update
	 *
	 * @param string , array, array
	 *
	 * @return bool
	 */
	
	public function updateDB($table, $exec = [], $where = [] ){
		
		//With no WHERE clause, all rows are updated.
		if(!empty($where)){
			foreach($where as $key => $value){
				$key = preg_replace('/[^a-zA-Z0-9_]/','',$key);
				$arrWhere[':'.$key] = $value;
				$param[] = $key.' = :'.$key; 
			}
			$clause = ' WHERE '.implode(' AND ', $param);
		}
		else{
			$clause = '';
			$arrWhere = array();
		}
		if(!empty($exec)){
			foreach($exec as $key => $value){
				$key = preg_replace('/[^a-zA-Z0-9_]/','',$key);
				$arrSet[':'.$key] = $value;
				$settings[] = $key.' = :'.$key;
			}
			$set = 'SET '.implode(', ', $settings);
		}
		else{
			$set = '';
		}
		$arrExec = array_merge( $arrWhere, $arrSet );
		
		$sql = "UPDATE ".TBL_PRFX.preg_replace('/[^a-zA-Z0-9_]/','',$table)." ".$set.$clause; 
		$stmt = $this->entries->db->prepare($sql);
		if($stmt->execute($arrExec)){
			return TRUE;
		}
		else{
			return FALSE;
		}	
	}
	
	/**
	 * Plugin MySQL INSERT execute
	 *
	 * *Description* simpler mysql-insert
	 *
	 * @param string, array
	 *
	 * @return boolean
	 */
 
	public function insertDB($table, $exec = array()){
		
		if(!empty($exec)){
			foreach($exec as $key => $value){
				$key = preg_replace('/[^a-zA-Z0-9_]/','',$key);
				$arrExec[':'.$key] = $value;
				$prepared[] = ' :'.$key;
				$column[] = $key;
			}
			$columns = ' ('.implode(',',$column).') ';
			$values = ' VALUES ('.implode(',', $prepared).')';
		}
		else{
			$columns = '';
			$values = '';
		}
		
		$sql = "INSERT INTO ".TBL_PRFX.preg_replace('/[^a-zA-Z0-9_]/','',$table)." ".$columns.$values; 
		$stmt = $this->entries->db->prepare($sql);
		if($stmt->execute($arrExec)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Plugin MySQL DELETE Table execute
	 *
	 * *Description* Delete entry from database
	 *
	 * @param string, array
	 *
	 * @return boolean
	 */
 
	public function deleteDB($table, $where = array()){
		
		if(!empty($where)){
			foreach($where as $key => $value){
				$key = preg_replace('/[^a-zA-Z0-9_]/','',$key);
				$arrExec[':'.$key] = $value;
				$param[] = $key.' = :'.$key; 
			}
			$clause = 'WHERE '.implode(' AND ', $param);
		}
		else{
			$clause = '';
			$arrExec = array();
		}
		// sql to delete a record
		$sql = "DELETE FROM ".TBL_PRFX.preg_replace('/[^a-zA-Z0-9_]/','',$table)." ".$clause;
		$stmt = $this->entries->db->prepare($sql);
		if($stmt->execute($arrExec)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Create MySQL tables
	 *
	 * *Description* simpler mysql-select
	 *
	 * @param string, array
	 *
	 * @return boolean
	 */
 
	public function createDB($table, $column_definition = array()){
		
		$error = FALSE;
		if(!empty($column_definition['column_definition']) and is_array($column_definition['column_definition'])){
			foreach($column_definition['column_definition'] as $column => $definitions){
				if(!empty($definitions) and is_array($definitions)){
					$index_option = " ";
					foreach($definitions as $definition){
						$index_option .= $definition." ";
					}
				}
				else{
					$error = TRUE;
				}
				$arr_column_definition[] = $column.' '.$index_option;
			}
			$columns = ' ('.implode(', ', $arr_column_definition).') ';
		}
		else{
			$error = TRUE;
		}
		if(!empty($column_definition['create_definition']) and is_array($column_definition['create_definition'])){
			foreach($column_definition['create_definition'] as $data => $type){
				$data_type[] = strtoupper($data).'='.$type;
			} 
			$create = implode(' ', $data_type);
		}
		else{
			$error = TRUE;
		}
		if(!empty($table) and preg_match('/^[a-zA-Z_]+$/si', $table) and !$error){
			$sql = "CREATE TABLE IF NOT EXISTS ".TBL_PRFX.$table.$columns.$create;
			if($this->entries->db->query($sql)){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Plugin MySQL Query execute
	 *
	 * *Description* universelle Schnittstelle fuer alle Arten von MySQL-Query
	 *
	 * @param string, array
	 *
	 * @return boolean
	 */
 
	public function queryDB($sql = NULL, $arrExec = array()){
		if(!empty($sql)){
			$stmt = $this->entries->db->prepare($sql);
			$stmt->execute($arrExec);
			$request = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			if(!empty($request)){
				return $request;
			}
			else{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}
}

?>