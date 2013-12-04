<?php


require_once './Core/TPP_Index.php';
require_once './Core/tpp_config.php';

try {
    $__tpp_index = new TPP_Index();
    $__tpp_full_url = $__tpp_index->get_full_url();

//    echo $__tpp_full_url . '<br/>';

    $__tpp_request_url = $__tpp_index->get_request_url($__tpp_full_url);

//    echo $__tpp_request_url . '<br/>';

    $__tpp_method_url = $__tpp_index->get_method_url($__tpp_request_url);

//    echo $__tpp_method_url . '<br/>';

    $__tpp_index->do_response($__tpp_method_url);

}
catch (Exception $e) {
    if ($tpp_show_error) {
        echo $e->getMessage();
    }
    else {
        $__tpp_index->do_response($tpp_404_page);
    }
}