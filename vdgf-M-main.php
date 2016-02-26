<?php

/*
= = = = = = = = = = = = = = config section = = = = = = = = = = = = = =

1) update server file path for where the static html files will be stored
2) update url to modx install for calling the pgaes to be stored

= = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
*/

// set path to html storage, can be changed for testing 
$basePath = '/FULL_SERVER_PATH/public_html/';

// set url to your modx install
$mdxurl = 'http://URL-TO-MODX-INSTALL/';

/* end config section */



// detect event name
$eventName = $modx->event->name;

// log errors and info
$modx->setDebug(E_ALL & ~E_NOTICE);
$modx->setLogLevel(modX::LOG_LEVEL_DEBUG);

// choose action based on event
switch ($eventName) {

    // for resource create or update
    case 'OnDocFormSave':

    // check if new or update
    if ($mode == 'upd') {
        // run single page code

        // Get the page id
        $rid = $resource->get('id');
        $modxUri = $resource->get('uri');
        
        $modx->reloadContext('web');
         
        // get the webpage from MODX
        $contents = file_get_contents($modxInstl . 'index.php?id=' . $rid);
                 
        // remove comments
        $contents = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/Uis', '', $contents);
                  
        // minify
        $contents = preg_replace('/^\s+|\n|\r|\s+$/m', '', $contents);
                
        // save new copy
        file_put_contents($basePath . $modxUri, $contents);
    
    }
    else {
        // rebuild full website
    
        $modx->reloadContext('web');
            
        //getting the published ids
        // get collection of resources, determine id and if published
        $docs = $modx->getCollection('modResource');
        foreach ($docs as $doc) {
            $pub = $doc->get('published');
            $folder = $doc->get('isfolder');
            $rid = $doc->get('id');
            $modxUri = $doc->get('uri');
            
            // if published, fetch url and build static webpage
            if (($pub == '1') && ($folder == '0')) {
              
                // determine if folders exist and create if not
                $path_parts = pathinfo($basePath . $modxUri);
                $target_path = $path_parts['dirname'];
                  
                if (!file_exists($target_path)) {
                    mkdir($target_path, 0755, true);
                }
                  
                // get the webpage from MODX
                $contents = file_get_contents($modxInstl . 'index.php?id=' . $rid);
                         
                // remove comments
                $contents = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/Uis', '', $contents);
                          
                // minify
                $contents = preg_replace('/^\s+|\n|\r|\s+$/m', '', $contents);
                        
                // save new copy
                file_put_contents($basePath . $modxUri, $contents);
                  
            }
        }
    }

    break;

    case 'OnBeforeEmptyTrash':
    // delete html files

    // get collection of resources, determine if deleted
    $docs = $modx->getCollection('modResource');
    foreach ($docs as $doc) {
        $dltd = $doc->get('deleted');
        $modxUri = $doc->get('uri');
        // if deleted, fetch url and unlink static webpage
        if ($dltd == '1') {
            unlink($basePath . $modxUri);
        }
    }

    break;

    case 'OnTempFormSave':
    // get template id, getResources, replace if use template id
    $tid = $template->get('id');
    
    // get collection of resources, determine if deleted
    $docs = $modx->getCollection('modResource',  array('template' => $tid));
    foreach ($docs as $doc) {
        $pub = $doc->get('published');
        $folder = $doc->get('isfolder');
        $rid = $doc->get('id');
        $modxUri = $doc->get('uri');

        // if published, fetch url and build static webpage
        if (($pub == '1') && ($folder == '0')) {

            // build webpages
            // get the webpage from MODX
            $contents = file_get_contents($modxInstl . 'index.php?id=' . $rid);
             
            // remove comments
            $contents = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/Uis', '', $contents);
              
            // minify
            $contents = preg_replace('/^\s+|\n|\r|\s+$/m', '', $contents);
            
            // save new copy
            file_put_contents($basePath . $modxUri, $contents); 
        }       
    }
    
    break;

    default:
    // rebuild full website

    $modx->reloadContext('web');
        
    //getting the published ids
    // get collection of resources, determine id and if published
    $docs = $modx->getCollection('modResource');
    foreach ($docs as $doc) {
        $pub = $doc->get('published');
        $folder = $doc->get('isfolder');
        $rid = $doc->get('id');
        $modxUri = $doc->get('uri');
        
        // if published, fetch url and build static webpage
        if (($pub == '1') && ($folder == '0')) {
          
            // determine if folders exist and create if not
            $path_parts = pathinfo($basePath . $modxUri);
            $target_path = $path_parts['dirname'];
              
            if (!file_exists($target_path)) {
                mkdir($target_path, 0755, true);
            }
              
            // get the webpage from MODX
            $contents = file_get_contents($modxInstl . 'index.php?id=' . $rid);
                     
            // remove comments
            $contents = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/Uis', '', $contents);
                      
            // minify
            $contents = preg_replace('/^\s+|\n|\r|\s+$/m', '', $contents);
                    
            // save new copy
            file_put_contents($basePath . $modxUri, $contents);
              
            }
    }

}
