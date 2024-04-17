<?php

class repost {
	public $post;
	
	public function repost($post) {
		$this->post = $post;

	}
	
	public function ShowMe()
    {
    	
        foreach($this->post as $k => $v) {
            if(is_array ($v)) {
                foreach($v as $i => $w) {
                    print "<input type='hidden' name='$k"."[$i]' value = '$w' >\n";
                }
            }
            else 
        	print "<input type='hidden' name='$k' value = '$v' >\n";
        }

    } 
	public function __invoke()
    {
        $this->ShowMe();
    }
   
};
?>