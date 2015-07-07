<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class models_function extends CI_model {
    /*
     * SamMarie Application V.1.0 Copyright 2014
     * Build Date : 17 Juli 2014
     * Founder & Programmer : Wisnu Groho Aji 
     * Website : http://wiqi.co
     */
    
    function watermark($source,$categories){
       $img['image_library'] = 'GD2';
        $img['create_thumb'] = FALSE;
        $img['maintain_ratio'] = TRUE;
        $img['thumb_marker'] = '';
        
        $ori = "./media/".$categories."/";
        
        $img['quality']      = '100%';
        $img['source_image'] = $source;
	$img['new_image']    = $ori;
        $img['wm_type'] = 'overlay';
        $img['wm_opacity'] = '50';
        $img['wm_overlay_path'] = './media/wm/logo.png';
        $img['wm_vrt_alignment'] = 'middle';
        $img['wm_hor_alignment'] = 'center';
        
        $this->image_lib->initialize($img);
        $this->image_lib->watermark();
	$this->image_lib->clear() ;
        
        unlink($source);
    }
    
    function resize($source,$categories){
         $img['image_library'] = 'GD2';
         $img['create_thumb'] = TRUE;
         $img['maintain_ratio'] = TRUE;
         $img['thumb_marker'] = '';
         
         $thumb = "./media/".$categories."/thumb";
             	 
         //// Making THUMBNAIL ///////
	$img['width']  = 100;
	$img['height'] = 100;
                
	// Configuration Of Image Manipulation :: Dynamic
	$img['quality']      = '100%';
        $img['source_image'] = $source;
	$img['new_image']    = $thumb;
        $img['wm_type'] = 'overlay';
        $img['wm_opacity'] = '50';
        $img['wm_overlay_path'] = './media/wm/logo.png';
        $img['wm_vrt_alignment'] = 'middle';
        $img['wm_hor_alignment'] = 'center';
        $img['wm_hor_offset'] = '10';
        $img['wm_vrt_offset'] = '10';
			 
	// Do Resizing
	$this->image_lib->initialize($img);
        $this->image_lib->resize();
        //$this->image_lib->watermark();
	$this->image_lib->clear() ;
    }
}
?>