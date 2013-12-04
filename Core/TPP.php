<?php
/**
 * Class TPP:
 */
class TPP {

    public  function  __construct() {}

    /**
     * get the unique instance of Loader
     * @return TPP_Loader|null
     */
    public function tpp_loader() {
        require_once 'TPP_Loader.php';
        return TPP_Loader::get_instance();
    }

    /**
     * get the base url of this web app
     * @return string
     */
    public  function tpp_base_url() {
        include 'tpp_config.php';
        //echo $tpp_base_url;
        $tpp_base_url = trim($tpp_base_url);
        if (false === strpos($tpp_base_url , 'http://') || false === strpos($tpp_base_url , 'https://')) {
            if (substr($tpp_base_url, -1) !== '/') {
                $tpp_base_url = '/' . $tpp_base_url;
            }
        }
        if ('' === $tpp_base_url or '/' === $tpp_base_url) {
            $tpp_base_url = '/';
        }
        elseif (substr($tpp_base_url, -1) !== '/') {
            $tpp_base_url = $tpp_base_url . '/';
        }

        return $tpp_base_url;
    }

}

//$tpp = new TPP();
//print $tpp->tpp_base_url();
