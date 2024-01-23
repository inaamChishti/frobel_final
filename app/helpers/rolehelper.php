<?php

use App\Models\Role;

if(! function_exists('roles') ){
    function roles(){
        return Role::all('id', 'name');
    }
}
