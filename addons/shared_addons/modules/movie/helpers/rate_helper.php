<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	
	/*class rtxc {
		var $img;
		var $rtx;
		
		function __construct(){
			$rt=rand(0,4);
			$rt2=rand(0,9)/10; 
			$this->rtx=$rt+$rt2;
			$this->img();
		}
		
	}
	*/
	function imgreate($rtx)
		{
			for($i=0;$i<5;$i++){
				if($i<$rtx){
					$mg='star-on.svg';
				}else{
					$mg='star-off.svg';
				}
				$img .='<img src="'.base_url().'/addons/shared_addons/themes/movie/images/rate/'.$mg.'" alt="1" title="bad">&nbsp;';
			}
			return $img;
		}