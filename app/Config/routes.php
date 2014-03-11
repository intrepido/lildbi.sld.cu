<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */

	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));


 	/** *******************************************************************************************************
 	/** **********************************  Documents  *************************************************** **/
 	/** *******************************************************************************************************
 
 	/** ADD */
	//Add Documents	
	Router::connect('/documents/add/series_monograficas', array('controller' => 'documents', 'action' => 'add', 'typeName' => 'series_monograficas'));
	Router::connect('/documents/add/monografia_pert_coleccion', array('controller' => 'documents', 'action' => 'add', 'typeName' => 'monografia_pert_coleccion'));
	Router::connect('/documents/add/monografia', array('controller' => 'documents', 'action' => 'add', 'typeName' => 'monografia'));
	Router::connect('/documents/add/no_convencional', array('controller' => 'documents', 'action' => 'add', 'typeName' => 'no_convencional'));
	Router::connect('/documents/add/serie_periodica', array('controller' => 'documents', 'action' => 'add', 'typeName' => 'serie_periodica'));
	Router::connect('/documents/add/coleccion_monografias', array('controller' => 'documents', 'action' => 'add', 'typeName' => 'coleccion_monografias'));
	Router::connect('/documents/add/tesis_disertacion_pert_serie_monografica', array('controller' => 'documents', 'action' => 'add', 'typeName' => 'tesis_disertacion_pert_serie_monografica'));
	Router::connect('/documents/add/tesis_disertacion', array('controller' => 'documents', 'action' => 'add', 'typeName' => 'tesis_disertacion'));
	
	//Add Documents Visualization
	Router::connect('/documents/add/series_monograficas/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'series_monograficas'));
	Router::connect('/documents/add/monografia_pert_coleccion/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'monografia_pert_coleccion'));
	Router::connect('/documents/add/monografia/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'monografia'));
	Router::connect('/documents/add/no_convencional/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'no_convencional'));
	Router::connect('/documents/add/serie_periodica/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'serie_periodica'));
	Router::connect('/documents/add/coleccion_monografias/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'coleccion_monografias'));
	Router::connect('/documents/add/tesis_disertacion_pert_serie_monografica/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'tesis_disertacion_pert_serie_monografica'));
	Router::connect('/documents/add/tesis_disertacion/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'tesis_disertacion'));
	
	 /** EDIT */
	//Edit Documents Visualization
	Router::connect('/documents/edit/series_monograficas/:id/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'series_monograficas'));
	Router::connect('/documents/edit/monografia_pert_coleccion/:id/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'monografia_pert_coleccion'));
	Router::connect('/documents/edit/monografia/:id/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'monografia'));
	Router::connect('/documents/edit/no_convencional/:id/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'no_convencional'));
	Router::connect('/documents/edit/serie_periodica/:id/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'serie_periodica'));
	Router::connect('/documents/edit/coleccion_monografias/:id/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'coleccion_monografias'));
	Router::connect('/documents/edit/tesis_disertacion_pert_serie_monografica/:id/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'tesis_disertacion_pert_serie_monografica'));
	Router::connect('/documents/edit/tesis_disertacion/:id/visualization', array('controller' => 'documents', 'action' => 'visualization', 'typeName' => 'tesis_disertacion'));
	
	//Edit Documents	
	Router::connect('/documents/edit/series_monograficas/*', array('controller' => 'documents', 'action' => 'edit', 'typeName' => 'series_monograficas'));
	Router::connect('/documents/edit/monografia_pert_coleccion/*', array('controller' => 'documents', 'action' => 'edit', 'typeName' => 'monografia_pert_coleccion'));
	Router::connect('/documents/edit/monografia/*', array('controller' => 'documents', 'action' => 'edit', 'typeName' => 'monografia'));
	Router::connect('/documents/edit/no_convencional/*', array('controller' => 'documents', 'action' => 'edit', 'typeName' => 'no_convencional'));
	Router::connect('/documents/edit/serie_periodica/*', array('controller' => 'documents', 'action' => 'edit', 'typeName' => 'serie_periodica'));
	Router::connect('/documents/edit/coleccion_monografias/*', array('controller' => 'documents', 'action' => 'edit', 'typeName' => 'coleccion_monografias'));
	Router::connect('/documents/edit/tesis_disertacion_pert_serie_monografica/*', array('controller' => 'documents', 'action' => 'edit', 'typeName' => 'tesis_disertacion_pert_serie_monografica'));
	Router::connect('/documents/edit/tesis_disertacion/*', array('controller' => 'documents', 'action' => 'edit', 'typeName' => 'tesis_disertacion'));

	
	/** *****************************************************************************************************
	/** **********************************  Analitics *************************************************** **/
	/** *****************************************************************************************************
	
	/** ADD */
	
	//Add Analitics Visualization
	Router::connect('/analitics/add/series_monograficas/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'series_monograficas'));
	Router::connect('/analitics/add/monografia_pert_coleccion/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'monografia_pert_coleccion'));
	Router::connect('/analitics/add/monografia/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'monografia'));
	Router::connect('/analitics/add/no_convencional/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'no_convencional'));
	Router::connect('/analitics/add/serie_periodica/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'serie_periodica'));
	Router::connect('/analitics/add/coleccion_monografias/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'coleccion_monografias'));
	Router::connect('/analitics/add/tesis_disertacion_pert_serie_monografica/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'tesis_disertacion_pert_serie_monografica'));
	Router::connect('/analitics/add/tesis_disertacion/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'tesis_disertacion'));
	
	//Add Analitics
	Router::connect('/analitics/add/series_monograficas/*', array('controller' => 'analitics', 'action' => 'add', 'typeName' => 'series_monograficas'));
	Router::connect('/analitics/add/monografia_pert_coleccion/*', array('controller' => 'analitics', 'action' => 'add', 'typeName' => 'monografia_pert_coleccion'));
	Router::connect('/analitics/add/monografia/*', array('controller' => 'analitics', 'action' => 'add', 'typeName' => 'monografia'));
	Router::connect('/analitics/add/no_convencional/*', array('controller' => 'analitics', 'action' => 'add', 'typeName' => 'no_convencional'));
	Router::connect('/analitics/add/serie_periodica/*', array('controller' => 'analitics', 'action' => 'add', 'typeName' => 'serie_periodica'));
	Router::connect('/analitics/add/coleccion_monografias/*', array('controller' => 'analitics', 'action' => 'add', 'typeName' => 'coleccion_monografias'));
	Router::connect('/analitics/add/tesis_disertacion_pert_serie_monografica/*', array('controller' => 'analitics', 'action' => 'add', 'typeName' => 'tesis_disertacion_pert_serie_monografica'));
	Router::connect('/analitics/add/tesis_disertacion/*', array('controller' => 'analitics', 'action' => 'add', 'typeName' => 'tesis_disertacion'));
	
	
	/** EDIT */
	//Edit Analitics Visualization
	Router::connect('/analitics/edit/series_monograficas/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'series_monograficas'));
	Router::connect('/analitics/edit/monografia_pert_coleccion/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'monografia_pert_coleccion'));
	Router::connect('/analitics/edit/monografia/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'monografia'));
	Router::connect('/analitics/edit/no_convencional/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'no_convencional'));
	Router::connect('/analitics/edit/serie_periodica/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'serie_periodica'));
	Router::connect('/analitics/edit/coleccion_monografias/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'coleccion_monografias'));
	Router::connect('/analitics/edit/tesis_disertacion_pert_serie_monografica/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'tesis_disertacion_pert_serie_monografica'));
	Router::connect('/analitics/edit/tesis_disertacion/:id/visualization', array('controller' => 'analitics', 'action' => 'visualization', 'typeName' => 'tesis_disertacion'));
	
	//Edit Analitics
	Router::connect('/analitics/edit/series_monograficas/*', array('controller' => 'analitics', 'action' => 'edit', 'typeName' => 'series_monograficas'));
	Router::connect('/analitics/edit/monografia_pert_coleccion/*', array('controller' => 'analitics', 'action' => 'edit', 'typeName' => 'monografia_pert_coleccion'));
	Router::connect('/analitics/edit/monografia/*', array('controller' => 'analitics', 'action' => 'edit', 'typeName' => 'monografia'));
	Router::connect('/analitics/edit/no_convencional/*', array('controller' => 'analitics', 'action' => 'edit', 'typeName' => 'no_convencional'));
	Router::connect('/analitics/edit/serie_periodica/*', array('controller' => 'analitics', 'action' => 'edit', 'typeName' => 'serie_periodica'));
	Router::connect('/analitics/edit/coleccion_monografias/*', array('controller' => 'analitics', 'action' => 'edit', 'typeName' => 'coleccion_monografias'));
	Router::connect('/analitics/edit/tesis_disertacion_pert_serie_monografica/*', array('controller' => 'analitics', 'action' => 'edit', 'typeName' => 'tesis_disertacion_pert_serie_monografica'));
	Router::connect('/analitics/edit/tesis_disertacion/*', array('controller' => 'analitics', 'action' => 'edit', 'typeName' => 'tesis_disertacion'));
	
	
	/** *****************************************************************************************************
	/** **********************************  Plugin Configuration  **************************************** **/
	/** *****************************************************************************************************/
	
	Router::connect('/configurations', array('plugin' => 'configuration', 'controller' => 'configurations'));
	Router::connect('/configurations/:action/*', array('plugin' => 'configuration', 'controller' => 'configurations'));
	
	//Router::connect('/', array('controller' => 'posts', 'action' => 'index'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/cake/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
