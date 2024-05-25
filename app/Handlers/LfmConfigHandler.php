<?php

namespace App\Handlers;

class LfmConfigHandler extends \UniSharp\LaravelFilemanager\Handlers\ConfigHandler
{
    public function userField()
    {
        // if(auth()->user()->hasRole('Admin')){
        // 	return '';
        // }else{
        //     return parent::userField();    	
        // }
        if(auth()->user()->hasRole('Admin')){
        	return '/';
        }else{
        	// return '/' . auth()->id();        	
            return parent::userField();
        }
        return parent::userField();
    }
}
