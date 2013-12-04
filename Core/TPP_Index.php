<?php

require_once 'TPP_Loader.php';
require_once 'TPP.php';
class TPP_Index {

    public function  __construct() {}

    /**
     * assemble a complete url -> $full_url.
     * for example: $full_url = 'http://127.0.0.1/hello/';
     * @return string
     */
    function get_full_url() {
        if (false !== strpos($_SERVER["REQUEST_URI"] , 'http://') || false !== strpos($_SERVER["REQUEST_URI"] , 'https://'))  {
            $full_url = trim($_SERVER["REQUEST_URI"]);
        }
        else {
            if (false !== strpos($_SERVER["HTTP_HOST"] , 'http://') || false !== strpos($_SERVER["HTTP_HOST"] , 'https://'))  {
                $full_url = trim($_SERVER['HTTP_HOST']) . trim($_SERVER["REQUEST_URI"]);
            }
            else {
                $full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
                $full_url = trim($full_url) . trim($_SERVER['HTTP_HOST']) . trim($_SERVER["REQUEST_URI"]);
            }
        }

        //for GET
        $ttt = explode("?", $full_url);
        $full_url = $ttt[0];



        if (substr($full_url, -1) !== '/') {
            $full_url = $full_url . '/';
        }
        return $full_url;
    }

    /**
     * extract the request url
     * if $full_url = 'http://127.0.0.1/hello/' ,then $request_url = '/hello/';
     * if $full_url = 'http://127.0.0.1/' ,then $request_url = '/';
     */
    function get_request_url($full_url) {
        $full_url = trim($full_url);
        $tpp = new TPP();
        $tpp_base_url = $tpp->tpp_base_url();

        //echo $tpp_base_url;

        if (false === strpos($tpp_base_url , 'http://') && false === strpos($tpp_base_url , 'https://'))  {
            $array1 = explode('://', $full_url);

            //print_r($array1);

            $url1 = $array1[1]; //do not have 'http://' or 'https://'
            $array2 = explode('/', $url1);

            //print_r($array2);

            $array2[0] = '';
            $url2 = implode('/', $array2);

            if (strpos($url2, $tpp_base_url) === 0) {
                $request_url = substr_replace($url2, '/', 0, strlen($tpp_base_url));
                //echo $request_url;
            }
            else {
                throw new Exception("error occurred while processing url");
            }
        }
        else {
            //echo '@$!@$!@$!@$!@';
            //echo $full_url;
            //echo $tpp_base_url;
            $request_url = substr_replace($full_url, '/', 0, strlen($tpp_base_url));
            //echo '   ' . $request_url;
        }
        return $request_url;
    }

    /**
     * translate $request_url to $method_url
     * @param $request_url
     * @throws Exception
     * @internal param $url_maps
     * @return bool|mixed
     */
    function get_method_url($request_url) {
        include 'tpp_config.php';
        foreach ($url_maps as $key => $value) {
            if (0 === strpos($request_url , $key)) {
                $method_url = substr_replace($request_url, $value, 0, strlen($key));
                return $method_url;
            }
        }
        return $request_url;
    }

    /**
     * do response
     * @param $method_url
     * @throws Exception
     * @internal param $tpp_default_controller
     */

    function do_response($method_url) {
        //$called_class = '';
        //$called_func ='';
        //$url_args = [];
        include 'tpp_config.php';
        if ('/' === $method_url) {
            $method_url = '/' . $tpp_default_controller . '/' . $tpp_default_method . '/';
        }
        $url_array = explode("/",$method_url);
        array_pop($url_array); //pop the last element

        /**
         * '/aa/a/' => ['','aa','a']
         * '/' => '/welcome/index/' =>['', 'welcome','index']
         * '/aaa/' => ['','aaa']
         */
        //substr($url_array[1], -1);

        $first_letter = $url_array[1][0];
        $first_letter_ord = ord($first_letter);
        if ('_' !== $first_letter &&
            !($first_letter_ord >=41 && $first_letter_ord <=90) &&
            !($first_letter_ord >=97 && $first_letter_ord <=122)) {
            throw new Exception("bad class request");
        }

        //**>'/aaa/' => ['','aaa']
        if (2 === count($url_array)) {
            //echo '2<br/>';
            $called_class_name = trim($url_array[1]);
            $class = TPP_Loader::get_instance()->load_controller($called_class_name);
            if(method_exists($class, $tpp_default_method)) {
                $class->$tpp_default_method();
                return;
            }
            else {
                throw new Exception("method  not exist");
            }
        }

        //**>'/aa/a/' => ['','aa','a']
        if(3 === count($url_array)) {
            //echo '3<br/>';
            $called_class_name = trim($url_array[1]);
            $called_func_name = trim($url_array[2]);
            $class = TPP_Loader::get_instance()->load_controller($called_class_name);

            if(method_exists($class,$called_func_name)) {
                $class->$called_func_name();
                return;
            }
            else {
                throw new Exception("method  not exist");
            }
        }

        //**>'/aa/bb/cc' => ['','aa','bb', 'cc']
        //**>'/aa/bb/c/d/d' => ['', 'aa', 'bb', 'c', 'd', 'd']
        if(4 <= count($url_array)) {
            //echo '4<br/>';
            $called_class_name = trim($url_array[1]);
            $called_func_name = trim($url_array[2]);
            $url_args = $url_array;
            array_shift($url_args); //pop the first element
            array_shift($url_args);
            array_shift($url_args);
            $class = TPP_Loader::get_instance()->load_controller($called_class_name);
            if(method_exists($class,$called_func_name)) {
                //$class->$called_func($url_args);
                call_user_func_array(array($class, $called_func_name), $url_args);
                return;
            }
            else {
                throw new Exception("method  not exist");
            }
        }
    }
}