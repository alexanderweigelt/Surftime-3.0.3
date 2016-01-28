<?php
    
 /**
 * Model setzt Inhalte in DB
 *
 * *Description* Inhalte in eine Datenbanktabelle schreiben, aktualisieren oder loeschen
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */ 
 
 namespace Model;
 

class SetContent extends \Model\ConnectDB {
	
/**
 * Konstruktor 
 *
 * *Description* 
 * 
 * @param
 *
 * @return 
 */
 
	public function __construct(){
		$this->db = parent::connect();
	}
	
/**
 * neuer Eintrag
 *
 * *Description* 
 * 
 * @param array
 *
 * @return boolean
 */
 
	public function insertEntry($request){
		//SQL-Anweisungen
		$sql_query_site = "INSERT INTO ".TBL_PRFX."site (page, created, headline, content) VALUES (:page, NOW(), :headline, :content)";
		$sql_query_meta = "INSERT INTO ".TBL_PRFX."meta (page_id, indexation, title, keywords, description) VALUES (:page_id, :indexation, :title, :keywords, :description)";
		$sql_query_navigation = "INSERT INTO ".TBL_PRFX."navigation (site_id, sorting, parent, anchor) VALUES (:site_id, :sorting, :parent, :anchor)";
		//Execute Array site
		$arr_exec_site = array(
			':page' => $request['page'], 
			':headline' => $request['headline'], 
			':content' => $request['content']
		);			
		//Eintrag Tabelle site
		$stmt = $this->db->prepare($sql_query_site);
		if($stmt->execute($arr_exec_site)){
			//Hole die letzte ID aus Auto Increment
			$id = $this->db->lastInsertId();
			//Execute Array meta
			$arr_exec_meta = array(
				':page_id' => $id, 
				':indexation' => $request['indexation'], 
				':title' => $request['title'], 
				':keywords' => $request['keywords'], 
				':description' => $request['description']
			);
			//Eintrag Tabelle meta
			$stmt = $this->db->prepare($sql_query_meta);
			if($stmt->execute($arr_exec_meta)){
				//Checkbox Eintrag Navigation gesetzt
				if(isset($request['menu-enable']) and $request['menu-enable'] == 'on'){
					$arr_exec_navigation = array(
						':site_id' => $id,
						':sorting' => $request['sorting'],
						':parent' => $request['parent'],
						':anchor' => $request['anchor']
					);
					//Eintrag Tabelle navigation
					$stmt = $this->db->prepare($sql_query_navigation);
					if($stmt->execute($arr_exec_navigation)){
						return TRUE;
					}
					else{
						return FALSE;
					}
				}
				else{
					return TRUE; 
				}
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
 * Eintrag aendern
 *
 * *Description* 
 * 
 * @param array
 *
 * @return boolean
 */
 
	public function updateEntry($request){
		
		//SQL-Anweisung
		$sql_query = "UPDATE ".TBL_PRFX."site s JOIN ".TBL_PRFX."meta m ON m.page_id = s.id
   			SET 
				s.page = :page, 
				s.created = NOW(), 
				s.headline = :headline, 
				s.content = :content,
				m.indexation = :indexation, 
				m.title = :title, 
				m.keywords = :keywords, 
				m.description = :description
			WHERE s.id = :id";
		//Array prepared statement
		$arrExec = array(
			':id' => $request['id'],
			':page' => $request['page'], 
			':headline' => $request['headline'], 
			':content' => $request['content'],
			':indexation' => $request['indexation'], 
			':title' => $request['title'], 
			':keywords' => $request['keywords'], 
			':description' => $request['description']
		);
		$stmt = $this->db->prepare($sql_query);
		if($stmt->execute($arrExec)){
			if(isset($request['menu-enable']) and $request['menu-enable'] == 'on'){
				$sql_query = "SELECT * FROM ".TBL_PRFX."navigation WHERE site_id = :site_id";
				$stmt = $this->db->prepare($sql_query);
				$stmt->execute(array(':site_id' => $request['id']));
				if(!empty($stmt->fetch())){
					$sql_query = "UPDATE ".TBL_PRFX."navigation SET sorting = :sorting, parent = :parent, anchor = :anchor WHERE site_id = :site_id";
				}
				else{ 
					$sql_query = "INSERT INTO ".TBL_PRFX."navigation(site_id, sorting, parent, anchor) VALUES (:site_id, :sorting, :parent, :anchor)";
				}
				$arrExec = array(
					':site_id' => $request['id'],
					':sorting' => $request['sorting'],
					':parent' => $request['parent'],
					':anchor' => $request['anchor']
				);
				//Eintrag Tabelle navigation aktualisieren
				$stmt = $this->db->prepare($sql_query);
				if($stmt->execute($arrExec)){
					return TRUE;
				}
				else{
					return FALSE;
				}
			}
			else{
				$sql_query = "DELETE FROM ".TBL_PRFX."navigation WHERE site_id = :id LIMIT 1";
				$arr_exec_navigation = array(
					':id' => $request['id']
				);
				//Eintrag Tabelle navigation entfernen
				$stmt = $this->db->prepare($sql_query);
				if($stmt->execute($arr_exec_navigation)){
					return TRUE;
				}
				else{
					return FALSE;
				}
			}
		}
		else{
			return FALSE;
		}
	}
	
/**
 * Eintrag entfernen
 *
 * *Description* 
 * 
 * @param string
 *
 * @return boolean
 */
 
	public function deleteEntry($page){
		// ID des Eintrag holen
		$sql_query = "SELECT id FROM ".TBL_PRFX."site WHERE page = :page";
		$stmt = $this->db->prepare($sql_query);
		$stmt->execute(
			array(':page' => $page)
		);
		$request = $stmt->fetch(\PDO::FETCH_ASSOC);
		if(!empty($request['id'])){
			//SQL-Anweisung
			$sql_query = "DELETE s, m FROM ".TBL_PRFX."site s, ".TBL_PRFX."meta m WHERE m.page_id = s.id AND s.id = :id";
			$arrExec = array(
				':id' => $request['id']
			);
			//Eintrag Tabelle navigation entfernen
			$stmt = $this->db->prepare($sql_query);
			if($stmt->execute($arrExec)){
				$sql_query = "DELETE FROM ".TBL_PRFX."navigation WHERE site_id = :id";
				$arrExec = array(
					':id' => $request['id']
				);
				//Eintrag Tabelle navigation entfernen
				$stmt = $this->db->prepare($sql_query);
				if($stmt->execute($arrExec)){
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
		else{
			return FALSE;
		}

	}

/**
 * Aktualisierung der Inhalte vom Panel in DB
 *
 * *Description* 
 * 
 * @param array, string
 *
 * @return boolean
 */
 	
	public function setPanel($request){
		$sql_query = "UPDATE ".TBL_PRFX."panel
			SET
				widget = :widget,
				last_modified = NOW()
			WHERE number = :number"; 
		//Array prepared statement
		$arrExec = array(
			':widget' => $request['widget'],
			':number' => $request['number']
			);
		//Eintrag Tabelle panel aktualisieren
		$stmt = $this->db->prepare($sql_query);
		if($stmt->execute($arrExec)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
/**
 * neuer Eintrag bzw Aktualisierung Variablen Seite
 *
 * *Description* 
 * 
 * @param array, string
 *
 * @return boolean
 */
 
	public function setSiteSettings($request){
		$sql_query = "UPDATE ".TBL_PRFX."settings 
			SET
				slogan = :slogan, 
				firstname = :firstname, 
				lastname = :lastname, 
				street = :street, 
				postalzip = :postalzip,
				city = :city, 
				phone = :phone, 
				email = :email, 
				company = :company,
				opening = :opening,
				variable = :variable
			WHERE var_id = 1";
			//Array prepared statement
			$arrExec = array(
				':slogan' => $request['slogan'],
				':firstname' => $request['firstname'],
				':lastname' => $request['lastname'], 
				':street' => $request['street'], 
				':postalzip' => $request['postalzip'],
				':city' => $request['city'], 
				':phone' => $request['phone'], 
				':email' => $request['email'], 
				':company' => $request['company'],
				':opening' => $request['opening'], 
				':variable' => $request['variable']
			);
		//Eintrag Tabelle settings aktualisieren
		$stmt = $this->db->prepare($sql_query);
		if($stmt->execute($arrExec)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
/**
 * neuer Benutzer
 *
 * *Description* 
 * 
 * @param array
 *
 * @return boolean
 */
 
	public function setNewUser($user){
		//Passwort verschlüsselt ersetzen
		if(!empty($user['password'])){
			$pass = \Controller\Helpers::encryptPassword($user['password']);
		}
		else{
			// Falls leer Passwort aus Session verwenden
			$pass = $_SESSION['password'];
		}		
		$sql_query = "INSERT INTO ".TBL_PRFX."user(email, username, password, registration_date, status) VALUES (:email, :username, :password, NOW(), :status)";
		$arrExec = array(
			':email' => $user['email'],
			':username' => $user['username'],
			':password' => $pass,
			':status' => $user['status']
		);
		//Eintrag User vornhemen
		$stmt = $this->db->prepare($sql_query);
		if($stmt->execute($arrExec)){
			return TRUE;
		}
		else{
			return FALSE;
		}		
	}
	
/**
 * Eintrag Benutzer aendern
 *
 * *Description* 
 * 
 * @param array
 *
 * @return boolean
 */
 
	public function updateUser($user){
		//Passwort verschlüsselt ersetzen
		if(!empty($user['password'])){
			$pass = \Controller\Helpers::encryptPassword($user['password']);
		}
		else{
			// Falls leer altes Passwort aus DB holen
			$sql_request = "SELECT password FROM ".TBL_PRFX."user WHERE username = :username";
			$stmt = $this->db->prepare($sql_request);
			$stmt->execute(
				array(':username' => $user['username'])
			);
			$request = $stmt->fetch(\PDO::FETCH_ASSOC);
			$pass = $request['password'];
		}		
		$sql_query = "UPDATE ".TBL_PRFX."user 
			SET
				email = :email,
				username = :username,
				password = :password,
				status = :status
			WHERE id = :id";
		$arrExec = array(
			':email' => $user['email'],
			':username' => $user['username'],
			':password' => $pass,
			':status' => $user['status'],
			':id' => $user['id']
		);
		//Update User 
		$stmt = $this->db->prepare($sql_query);
		if($stmt->execute($arrExec)){
			return TRUE;
		}
		else{
			return FALSE;
		}		
	}
	
/**
 * Eintrag Benutzer entfernen
 *
 * *Description* 
 * 
 * @param array
 *
 * @return boolean
 */
 
	public function deleteUser($name){
		//SQL-Anweisung
		$sql_query = "DELETE FROM ".TBL_PRFX."user WHERE username = :username";
		$arrExec = array(
			':username' => $name
		);
		//Eintrag Tabelle user entfernen
		$stmt = $this->db->prepare($sql_query);
		if($stmt->execute($arrExec)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
/**
 * neuer Eintrag bzw Aktualisierung Einstellungen Seite
 *
 * *Description* 
 * 
 * @param array, string
 *
 * @return boolean
 */
 
	public function setSetup($request, $where = 'system'){
		switch ($where){
			case 'system':
				$sql_query = "UPDATE ".TBL_PRFX."setup 
				SET
					logout = :logout,
					maintenance = :maintenance,
					compress = :compress,
					maxwidth = :maxwidth,
					maxheight = :maxheight
				WHERE set_id = 1";
				//Array prepared statement
				$arrExec = array(
					':logout' => $request['logout'],
					':maintenance' => $request['maintenance'],
					':compress' => $request['compress'],
					':maxwidth' => $request['maxwidth'],
					':maxheight' => $request['maxheight']
				);
				break;
				
			case 'template':
				$sql_query = "UPDATE ".TBL_PRFX."setup 
				SET 
					template = :template
				WHERE set_id = 1";
				//Array prepared statement
				$arrExec = array(
					':template' => $request['template']
				);
				break;
		}
		//Eintrag Tabelle settings aktualisieren
		$stmt = $this->db->prepare($sql_query);
		if($stmt->execute($arrExec)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}

?>