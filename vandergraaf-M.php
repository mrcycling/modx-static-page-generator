<?php

// setting up modx access

require_once ('/PATH_TO_MODX/config.core.php');
require_once ('/PATH_TO_MODX_CORE/model/modx/modx.class.php');
$modx = new modX();
$modx->initialize('web');
$modx->getService('error', 'error.modError');

// define base directory, can be changed for testing 
$baseurl = '/FULL_SERVER_PATH/public_html/';

// getting the published ids
// get collection of resources, determine id and if published
$docs = $modx->getCollection('modResource');
foreach ($docs as $doc) {
   $pub = $doc->get('published');
   $rid = $doc->get('id');
   
   // if published, fetch url and build static webpage
   if ($pub == '1') {
	
      // fetch friendly url
      $web_url = $modx->makeUrl($rid);
      		
      // determine if folders exist and create if not    
      $path_parts = pathinfo($web_url);
      $target_path = $path_parts['dirname'];
          
      if (!file_exists($target_path)) {
         mkdir($target_path, 0755, true);
      }
      		
      // get the webpage from MODX
      $contents = file_get_contents('http://canoncal.yourdomain.com/index.php?id=' . $rid);
         
      // remove comments
      $contents = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/Uis', '', $contents);
      	
      // minify
      $contents = preg_replace('/^\s+|\n|\r|\s+$/m', '', $contents);

		 	// save new copy
      file_put_contents($baseurl . $web_url, $contents);
		
   }
	
}
