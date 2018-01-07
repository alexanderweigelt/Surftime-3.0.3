<?php
/**
 * Routing Controller
 *
 * *Description*
 *
 * @author Alexander Weigelt <support@alexander-weigelt.de>
 * @link http://alexander-weigelt.de
 * @version Surftime CMS 3.1.0
 * @license http://creativecommons.org/licenses/by-nc-nd/4.0/legalcode CC BY-NC-ND 4.0
 */

namespace Controller;


/**
 * Class RoutingController
 * @package Controller
 */
class RoutingController {

	/**
	 * Parsed routes
	 *
	 * @var array
	 */
	private $arrRoutes = [];

	/**
	 * Call arguments
	 *
	 * @var array
	 */
	private $arrArgs = [];

	/**
	 * @var int
	 */
	private $keyRoutes = 0;

	/**
	 * @var string
	 */
	private $realPath;

	/**
	 * Defines the Get Parameter key for real path
	 * (using in .htaccess file)
	 */
	const KEY_GET_PATH = 'site';

	/**
	 * RoutingController constructor.
	 */
	function __construct()
	{
		$this->realPath = $this->getRealPath();
	}

	/**
	 * Set a new Route
	 *
	 * @param string $route
	 * @param string $controller
	 * @param string $method
	 * @param string $name
	 *
	 * @return $this
	 */
	public function route($route, $controller, $method = 'GET', $name = null)
	{
		if (!$name || empty($name)) {
			$key = $this->keyRoutes;
			$this->keyRoutes++;
		}
		else {
			$key = $name;
		}
		$this->arrRoutes[$key] = [
			'path' => $route,
			'controller' => $controller,
			'method' => $method,
		];

		return $this;
	}

	/**
	 * Set routes from YAML routing file
	 *
	 * @param $file
	 *
	 * @return $this
	 */
	public function routeFile($file)
	{
		$arrRoutes = yaml_parse_file($file);
		if (is_array($arrRoutes)) {
			$this->arrRoutes = array_merge($this->arrRoutes, $arrRoutes);
		}

		return $this;
	}

	/**
	 * Get routing information from YAML file.
	 *
	 * @return array
	 */
	public function getRoutes(): array
	{
		return $this->arrRoutes;
	}

	/**
	 * Reset routes
	 *
	 * @return $this
	 */
	public function reset()
	{
		$this->arrRoutes = [];
		$this->arrArgs = [];
		$this->keyRoutes = 0;

		return $this;
	}

	/**
	 * Parse a route.
	 */
	public function parse()
	{
		foreach ($this->getRoutes() as $routes) {
			if ($this->comparePaths($routes['path'], $this->realPath)) {
				if (!empty($routes['method'])) {
					$this->setArgs($routes['method']);
				}
				$call = explode('::', $routes['controller']);
				if (!empty($call[0]) && !empty($call[1])) {
					call_user_func_array( [ new $call[0], $call[1] ], $this->getArgs());
				}
			}
		}
		$this->reset();
	}

	/**
	 * Returns arguments from route and requested method
	 *
	 * @return array
	 */
	private function getArgs(): array
	{
		$arrArgs = [];
		foreach ($this->arrArgs as $args) {
			$arrArgs[] = &$args;
			unset($args);
		}

		return $arrArgs;
	}

	/**
	 * Set arguments by requested method
	 *
	 * @param $method
	 */
	private function setArgs($method)
	{
		switch ($method) {
			case 'POST':
				$this->arrArgs = array_merge($this->arrArgs, $_POST);
				break;
			case 'GET':
				$get = $_GET;
				unset($get[self::KEY_GET_PATH]);
				$this->arrArgs = array_merge($this->arrArgs, $get);
				break;
		}
	}

	/**
	 * Returns true, if matched path from url and route.
	 *
	 * @param $routePath
	 * @param $realPath
	 *
	 * @return bool
	 */
	private function comparePaths($routePath, $realPath): bool
	{
		$arrParam = [];
		$route = explode('/', $routePath);
		$real = explode('/', $realPath);
		foreach ($route as $key => $part) {
			if ($this->getVariableRoutePart($part) && !empty($real[$key])) {
				$arrParam[] = $real[$key];
				$route[$key] = $real[$key];
			}
		}
		if (!strcmp(implode('/', $route), implode('/', $real))) {
			$this->arrArgs = $arrParam;
			return true;
		}

		return false;
	}

	/**
	 * Returns real path from url.
	 *
	 * @return string
	 */
	private function getRealPath(): string
	{
		$path = $_GET[self::KEY_GET_PATH];
		if (is_null($path)) {
			return '/';
		}
		$pathParts = pathinfo($path);

		return ltrim($pathParts['dirname'] . '/' . $pathParts['filename'], './');
	}

	/**
	 * Return if route portions from the given route.
	 *
	 * @return bool
	 */
	private function getVariableRoutePart($part): bool
	{
		return preg_match("/{.*}/", $part);
	}

}