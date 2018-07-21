<?php

class Framework {
    protected $prefix='anps_';
    
    protected function set_option($arr=array(), $option_name=null) { 
        $arr_save=array(); 

        foreach($arr as $name=>$value) { 
            if($option_name=='google_fonts')
                $arr_save[] = array('value'=>urlencode($value['family']), 'name'=>$value['family'], 'variants'=>$value['variants'], 'subsets'=>$value['subsets']);
            else
            $arr_save[] = array('value'=>$value, 'name'=>$name);
        } 
        update_option($this->prefix.$option_name, $arr_save);
    }    
}