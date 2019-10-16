<?php
class Trim {
    public function space_trim ($str) {
                        $str = preg_replace('/^[ 　]+/u', '', $str);
                        $str = preg_replace('/[ 　]+$/u', '', $str);
                        return  $str;
    }
    
}
?>