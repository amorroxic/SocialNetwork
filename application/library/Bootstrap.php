<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/**
	 * Initialize the View
	 * @return Zend_View
	 */
    protected function _initView()
    {
        // Initialize view
        $view = new Zend_View();

        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->setView($view);

        // Return it, so that it can be stored by the bootstrap
        return $view;
    }

    /**
     * Initialize the database
     * @return void
     */
    protected function _initDatabase()
    {
	    // Register the default database adapter
		Zend_Db_Table::setDefaultAdapter(PDO_Database::getInstance());

		// Check if xcache is loaded
		if (extension_loaded('xcache')) {
		    // Create an XCache cache
		    $metadataCache = Zend_Cache::factory(
							'Core',
		                    'XCache',
		                    array(
		                    	'lifetime' => 3600,
		   						'automatic_serialization' => true
		                    ),
		                    array());

			// Set the Zend_Db_Table metadata cache
			Zend_Db_Table::setDefaultMetadataCache($metadataCache);
		}

    }

    /**
     * Initialize the front controller plugins
     * @return void
     */
    protected function _initControllerPlugins()
    {
        // Ensure the front controller is initialized
        $this->bootstrap('FrontController');

        // Retrieve the front controller from the bootstrap registry
        $controller = $this->getResource('FrontController');

		// Register the profiler plugin
		//if (APPLICATION_ENV != 'production') {
			$controller->registerPlugin(new Plugins_Profiler());
		//}

		// Register the GZip plugin
		$controller->registerPlugin(new Plugins_GZip());

		// Register the cache plugin
		//if (APPLICATION_ENV != 'development') {
			$cacheOptions = require(ROOTDIR . '/configuration/cache.conf.php');
			$controller->registerPlugin(new Plugins_Cache($cacheOptions));
			Plugins_Cache::$doNotCache = true;
		//}

	    $cache = Plugins_Cache::$cacheInstance;
		Zend_Locale::setCache($cache);

    }

}
