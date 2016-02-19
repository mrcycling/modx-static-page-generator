<?php

// Get the page id
$rid = $resource->get('id');
$web_url = $resource->get('uri');

// define base file path
$baseurl = '/PATH/TO/public_html/';

// determine if folders exist and create if not    
$path_parts = pathinfo($web_url);
$target_path = $path_parts['dirname'];
          
if (!file_exists($target_path)) {
    mkdir($target_path, 0755, true);
}
      		
// get the webpage from MODX
$contents = file_get_contents('http://URL-TO-MODX-INSTALL/index.php?id=' . $rid);
         
// remove comments
$contents = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/Uis', '', $contents);
      	
// minify
$contents = preg_replace('/^\s+|\n|\r|\s+$/m', '', $contents);

// save new copy
file_put_contents($baseurl . $web_url, $contents);
