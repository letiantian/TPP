<?php
/**
 * render the template file which is a php script
 */

class Render extends TPP
{
    private $__tpp_template_path="";
    private $__tpp_content="";
    private $__tpp_buffer="";
    
    public function __construct() {}

    /**
     * just use $__tpp_data to render $__tpp_template
     * @param $__tpp_template : the name of template file
     * @param $__tpp_data :an array that render the given template file $template
     * @return string
     * @throws Exception
     */
    public function render($__tpp_template, $__tpp_data = null) {
        $this->__tpp_template_path = str_replace("\\", "/", dirname(__DIR__)) . '/Template/'. $__tpp_template . '.php';

        if (is_readable($this->__tpp_template_path) === false) {
            throw new Exception("template file ". $this->__tpp_template_path .".php  not exist or not readable");
        }

        $tpp_base_url = function() {
            return $this->tpp_base_url();
        };

        if(is_array($__tpp_data)) {
            extract($__tpp_data);
        }
        ob_start();
        echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>",
            str_replace('<?=', '<?php echo ', file_get_contents($this->__tpp_template_path))));
        $this->__tpp_buffer = ob_get_contents();
        @ob_end_clean();
        $this->__tpp_content = $this->__tpp_content . $this->__tpp_buffer;
    }

    /**
     * echo(show) the content which has been rendered
     */
    public function show() {
        echo $this->__tpp_content;
    }

    /**
     * get the content which has been rendered
     * @return string
     */
    public function get_show() {
        return $this->__tpp_content;
    }

}
