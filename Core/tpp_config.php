<?php

/**
 * this array is for mapping url to the  specified class
 * the first letter and last letter of key and value must be '/'
 */
$url_maps = [
    '/hello/' => '/welcome/hello/'

];

/**
 * for example:
 * 'http://127.0.0.1/tinierPHP2/'  --> can not be 'http://127.0.0.1/tinierPHP2'  --> now,it is supported
 * 'http://127.0.0.1/'  --> can not be 'http://127.0.0.1' --> now,it is supported
 * '/tinierPHP/'   --> can not be '/tinierPHP2' or 'tinierPHP2' or 'tinierPHP2/' --> now,it is supported
 * '/'      --> can not be '' --> now,it is supported
 */
$tpp_base_url = '';


/**
 * define the name of default controller
 */
$tpp_default_controller = 'welcome';

/**
 * define the default method of controller
 */
$tpp_default_method = 'index';


/**
 *
 */
$tpp_show_error = false;

/**
 *
 */
$tpp_404_page = '/error/error404/';


