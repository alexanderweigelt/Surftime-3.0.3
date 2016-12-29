<?php

/**
 * Install CMS Model
 *
 * *Description*
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.0.3
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */

namespace Model;


/**
 * Class InstallModel
 * @property object db
 * @package Model
 */

class InstallModel extends \Model\ConnectDB {

	/** Install Settings */
	const DEFAULT_PASS = 'webmaster';
	const DEFAULT_USER = 'webmaster';

	/** Eigenschaften definieren */
	private $contentDB;
	private $structureDB;
	private $sampleData;
	public $successInstallation;

	/**
	 * Constructor
	 *
	 * *Description*
	 */

	public function __construct() {
		$this->db = parent::connect();
	}

	/**
	 * Installtion, Erstellen von Datenbanktabellen ausfuehren
	 *
	 * *Description*
	 *
	 * @return
	 */

	public function runInstallation() {
		$this->setContentDB( SYSTEM_CONTENT );
		$this->setStructureDB( SYSTEM_DB_STRUCTURE );
		$this->setSampleData( SYSTEM_SAMPLE_DATA );

		if ( ! $this->writeDatabaseStructure() ) {
			return false;
		}

		if ( ! $this->writeDatabaseContent() ) {
			return false;
		}

		if ( ! $this->createRobotsTxt() ) {
			return false;
		}

		if ( ! $this->writeDatabaseSampleData() ) {
			return false;
		}

		return true;
	}

	/**
	 * @param string $type
	 *
	 * @return mixed
	 */

	public function getSuccessInstallation( $type = '' ) {
		// Array Message
		$successInstallation = [
			'structure' => [],
			'content'   => [],
			'error'     => []
		];
		if ( ! empty( $this->successInstallation[ $type ] ) ) {
			return $this->successInstallation[ $type ];
		} elseif ( ! empty( $this->successInstallation ) ) {
			return $this->successInstallation;
		}

		return $successInstallation;
	}

	/**
	 * @param mixed $successInstallation
	 */

	public function setSuccessInstallation( $type, $message ) {
		$this->successInstallation[ $type ][] = $message;
	}

	/**
	 * @return mixed
	 */

	public function getContentDB() {
		return $this->contentDB;
	}

	/**
	 * @param mixed $contentDB
	 */

	public function setContentDB( $contentDB ) {
		$this->contentDB = $this->loadXMLData( $contentDB );
	}

	/**
	 * Returns the new database structure
	 *
	 * @return mixed
	 */

	public function getStructureDB() {
		return $this->structureDB;
	}

	/**
	 * Load the new database structure
	 *
	 * @param mixed $structureDB
	 */

	public function setStructureDB( $structureDB ) {
		$this->structureDB = $this->loadXMLData( $structureDB );
	}

	/**
	 * Returns an array of sample data
	 *
	 * @param mixed $sampleData
	 */

	public function getSampleData() {
		return $this->sampleData;
	}

	/**
	 * Load sample data from XML File
	 */

	public function setSampleData( $sampleDataPath ) {
		$data = $this->loadXMLData( $sampleDataPath );
		if ( !empty($data) and !isset( $data['entries']['setEntry'][0] ) ) {
			$entry = $data['entries']['setEntry'];
			unset( $data['entries']['setEntry'] );
			$data['entries']['setEntry'][0] = $entry;
		}
		if ( !empty($data) and !isset( $data['panel']['updatePanel'][0] ) ) {
			$panel = $data['panel']['updatePanel'];
			unset( $data['panel']['updatePanel'] );
			$data['panel']['updatePanel'][0] = $panel;
		}
		$this->sampleData = $data;
	}

	/**
	 * Create Tables in database
	 *
	 * *description* Loads the data for the database structure from an XML file
	 * and converts it into an executable array.
	 *
	 * @return bool
	 */

	private function writeDatabaseStructure() {
		$arrStructureDB = $this->getStructureDB();
		if ( !empty($arrStructureDB) ) {
			foreach ( self::dbStrukture() as $table => $columns ) {
				$query = 'CREATE TABLE IF NOT EXISTS ' . TBL_PRFX . $table . ' (';
				foreach ( $columns['cols'] as $column ) {
					$col = $column . ' ';
					if ( ! empty( $arrStructureDB[ $table ]['columns'][ $column ]['type'] ) ) {
						$col .= $arrStructureDB[ $table ]['columns'][ $column ]['type'] . ' ';
					}
					if ( ! empty( $arrStructureDB[ $table ]['columns'][ $column ]['attribute'] ) ) {
						$col .= $arrStructureDB[ $table ]['columns'][ $column ]['attribute'] . ' ';
					}
					if ( ! empty( $arrStructureDB[ $table ]['columns'][ $column ]['null'] ) ) {
						$col .= $arrStructureDB[ $table ]['columns'][ $column ]['null'] . ' ';
					}
					if ( ! empty( $arrStructureDB[ $table ]['columns'][ $column ]['extra'] ) ) {
						$col .= $arrStructureDB[ $table ]['columns'][ $column ]['extra'] . ' ';
					}
					if ( ! empty( $arrStructureDB[ $table ]['columns'][ $column ]['default'] ) ) {
						$col .= "DEFAULT '" . $arrStructureDB[ $table ]['columns'][ $column ]['default'] . "'";
					}
					$query .= $col . ', ';
				}
				$arrConstraint = [];
				foreach ( $arrStructureDB[ $table ]['constraints'] as $key => $constraints ) {
					switch ($key) {
						case 'primary':
							$arrConstraint['primary'] = 'PRIMARY KEY (' . $constraints . ')';
							break;
						case 'unique':
							$arrConstraint['unique'] = 'UNIQUE KEY (' . $constraints . ')';
							break;
						case 'fulltext':
							$arrConstraint['fulltext'] = 'FULLTEXT (' . $constraints . ')';
							break;
					}
				}
				$query .= implode( ", ", $arrConstraint );
				$query .= ') ';
				$query .= 'ENGINE=' . $arrStructureDB[ $table ]['engine'] . ' ';
				$query .= "DEFAULT CHARSET=" . self::$charset . ' ';
				$query .= "COMMENT='" . $arrStructureDB[ $table ]['comment'] . "'";

				if ( $this->db->query( $query ) ) {
					$this->setSuccessInstallation( 'structure', $table );
				}
				else{
					$this->setSuccessInstallation( 'error', $table );

					return false;
				}
			}

			return true;
		} else {
			return false;
		}
	}

	/**
	 * Write a first content in database
	 *
	 * @return bool
	 */

	private function writeDatabaseContent() {
		$arrContent = $this->getContentDB();
		if ( ! empty( $arrContent ) ) {
			foreach ( self::dbStrukture() as $table => $columns ) {
				$col     = [];
				$val     = [];
				$arrExec = [];

				/* create query and execute array */
				foreach ( $columns['cols'] as $column ) {
					$i = 0;
					if ( empty( $arrContent[ $table ]["insert"][ $column ] ) and is_array( $arrContent[ $table ]["insert"] ) ) {
						foreach ( $arrContent[ $table ]["insert"] as $insert ) {
							if ( isset( $insert[ $column ] ) ) {
								if ( ! empty( $insert[ $column ] ) ) {
									$data = $this->compileData( $insert[ $column ] );
								} else {
									$data = '';
								}
								$arrExec[ $i ][ ':' . $column ] = $data;
								if ( ! in_array( $column, $col ) ) {
									$col[] = $column;
									$val[] = ':' . $column;
								}
								$i ++;
							}
						}
					} else {
						if ( isset( $arrContent[ $table ]["insert"][ $column ] ) ) {
							if ( ! empty( $arrContent[ $table ]["insert"][ $column ] ) ) {
								$data = $this->compileData( $arrContent[ $table ]["insert"][ $column ] );
							}
							else{
								$data = '';
							}
							$arrExec[ $i ][ ':' . $column ] = $data;
							if ( ! in_array( $column, $col ) ) {
								$col[] = $column;
								$val[] = ':' . $column;
							}
						}
					}
				}

				$query = 'INSERT INTO  ' . TBL_PRFX . $table . ' (';
				$query .= implode( ", ", $col ) . ') ';
				$query .= 'VALUES (' . implode( ", ", $val ) . ')';

				if ( ! empty( $col ) ) {
					$stmt = $this->db->prepare( $query );
					foreach ( $arrExec as &$row ) {
						if ( $stmt->execute( $row ) ) {
							if ( ! in_array( $table, $this->getSuccessInstallation( 'content' ) ) ) {
								$this->setSuccessInstallation( 'content', $table );
							}
						} else {
							$this->setSuccessInstallation( 'error', $table );

							return false;
						}
					}
				}
			}

			return true;
		}
		else{
			return false;
		}
	}

	/**
	 * Create an robots.txt File
	 */

	private function createRobotsTxt() {
		$error  = '';
		$robots = PROJECT_ROOT . 'robots.txt';
		if ( file_exists( $robots ) ) {
			unlink( $robots );
		}

		$sitemap = URL_REWRITING ? \Controller\Helpers::getHost() . '/sitemap.xml' : \Controller\Helpers::getHost() . '/xml.php?site=sitemap';
		$datei   = fopen( $robots, 'w' );
		$error   = fwrite( $datei, "Sitemap: " . $sitemap . "\r\n\r\nUser-agent: *\r\nDisallow:", 100 );
		fclose( $datei );
		if ( $error ) {
			return true;
		}

		return false;
	}

	/**
	 * Write sample data in database
	 *
	 * @return bool
	 */

	private function writeDatabaseSampleData() {
		$success       = '';
		$arrSampleData = $this->getSampleData();
		if ( !empty($arrSampleData) ) {
			$action        = new \Controller\ActionsController();
			foreach ( $arrSampleData as $set => $sampleData ) {
				switch ( $set ) {
					case 'entries':
						foreach ( $sampleData['setEntry'] as $request ) {
							$request['setEntry'] = $request;
							$action->setRequestData( $request );
							if ( $action->getEntriesData()->getEntry( $request['page'] ) ) {
								$success = $action->editEntry();
							} else {
								$success = $action->setEntry();
							}
						}
						break;
					case 'settings':
						$request['settings'] = $sampleData;
						$action->setRequestData( $request );
						$success = $action->saveSettings();
						break;
					case 'theme':
						$request['theme'] = $sampleData;
						$action->setRequestData( $request );
						$success = $action->chooseTheme();
						break;
					case 'panel':
						foreach ( $sampleData['updatePanel'] as $request ) {
							$request['updatePanel'] = $request;
							$action->setRequestData( $request );
							$success = $action->updatePanel();
						}
						break;
				}
			}
			if ( $success['error'] ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Platzhalter aus XML-Datei ersetzen
	 *
	 * *Description* Tauscht den jeweiligen Platzhalter im Text der XML-Datei gegen den entsprechenden Wert.
	 *
	 * @param string
	 *
	 * @return string
	 */

	private function compileData( $text ) {
		// Such-Parameter (Platzhalter im Text)
		$arrSearch = array(
			'[[%DATE%]]',
			'[[%HTTP-HOST%]]',
			'[[%TIMESTAMP%]]',
			'[[%USERNAME%]]',
			'[[%PASSWORD%]]'
		);

		// Ersetzungs-Parameter (Variablen von außerhalb der Funktion)
		$arrReplace = array(
			date( 'Y-m-d' ),
			$_SERVER['HTTP_HOST'],
			date( 'Y-m-d H:i:s' ),
			self::DEFAULT_USER,
			\Controller\Helpers::encryptPassword( self::DEFAULT_PASS )
		);

		// Suchen & Ersetzen im Content
		$content = str_replace( $arrSearch, $arrReplace, $text );

		return $content;
	}

	/**
	 * load xml data from file
	 *
	 * @param $file
	 *
	 * @return array
	 */

	private function loadXMLData( $file ) {
		$xml = [];
		if ( file_exists( $file ) ) {

			$objectXML = simplexml_load_file( $file, 'SimpleXMLElement', LIBXML_NOCDATA );
			$arrXML    = objectToArray( $objectXML );
			if ( ! empty( $arrXML ) ) {
				$xml = $arrXML;
			}
		}

		return $xml;
	}
}

?>