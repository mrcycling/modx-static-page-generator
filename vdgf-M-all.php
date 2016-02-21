<?php

// check if new or update
if ($mode == 'upd') {
    // run single page code
    
    // Get the page id
    $rid = $resource->get('id');
    $web_url = $resource->get('uri');
    
    $modx->reloadContext('web');
    
    // define base file path
    $baseurl = '/home/bierboy/sbdm/sandbox/modx/';
    
    // resource created
    // determine if folders exist and create if not
    $path_parts = pathinfo($baseurl . $web_url);
    $target_path = $path_parts['dirname'];
      
    if (!file_exists($target_path)) {
        mkdir($target_path, 0755, true);
    }
      
    // get the webpage from MODX
    $contents = file_get_contents('http://sandbox.pedalerspubandgrille.com/modx/test/index.php?id=' . $rid);
     
    // remove comments
    $contents = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/Uis', '', $contents);
      
    // minify
    $contents = preg_replace('/^\s+|\n|\r|\s+$/m', '', $contents);
    
    // save new copy
    file_put_contents($baseurl . $web_url, $contents);

}
else {
    // rebuild full website
    
    // define base directory, can be changed for testing 
    $baseurl = '/home/bierboy/sbdm/sandbox/modx/';

    $modx->reloadContext('web');
        
    //getting the published ids
    // get collection of resources, determine id and if published
    $docs = $modx->getCollection('modResource');
    foreach ($docs as $doc) {
    $pub = $doc->get('published');
    $folder = $doc->get('isfolder');
    $rid = $doc->get('id');
    $web_url = $doc->get('uri');
    
    // if published, fetch url and build static webpage
    if (($pub == '1') && ($folder == '0')) {
      
        // determine if folders exist and create if not
        $path_parts = pathinfo($baseurl . $web_url);
        $target_path = $path_parts['dirname'];
          
        if (!file_exists($target_path)) {
            mkdir($target_path, 0755, true);
        }
          
        // get the webpage from MODX
        $contents = file_get_contents('http://sandbox.pedalerspubandgrille.com/modx/test/index.php?id=' . $rid);
         
        // remove comments
        $contents = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/Uis', '', $contents);
          
        // minify
        $contents = preg_replace('/^\s+|\n|\r|\s+$/m', '', $contents);
        
        // save new copy
        file_put_contents($baseurl . $web_url, $contents);
          
        }
    }
  
}
