<?php

use App\Models\Settings;

if ( !function_exists('siteContactNumber') )
{
    function siteContactNumber(){
        return Settings::whereIdentifier('contact-number')->exists()
            ? Settings::whereIdentifier('contact-number')->first()->value
            : null;
    }
}

if ( !function_exists('siteCallbackEmail') )
{
    function siteCallbackEmail(){
        return Settings::whereIdentifier('callback-email')->exists()
            ? Settings::whereIdentifier('callback-email')->first()->value
            : null;
    }
}
