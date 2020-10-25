<?php

use App\Models\Server;

function ipChecker($IP) {
    $servers = Server::latest()->get()->where('ip', $IP)->first();

    if(!empty($servers)) {
        return $servers->name;
    } else {
        return $IP;
    }
}


function expireChecker($time) {
    $remaining = round((strtotime($time) - strtotime('now'))  / (60 * 60 * 24));

    if($remaining > 0) {
        if($remaining == 1) {
            $day_text = 'day';
        } else {
            $day_text = 'days';
        }

        if($remaining < 10) {
            $text_color = 'red-500';
        } elseif($remaining < 30) {
            $text_color = 'orange-400';
        } else {
            $text_color = 'gray-500';
        }


        return '<span class="text-'.$text_color.' font-bold pl-3 text-sm">'.$remaining.' '.$day_text.' <span class="to-expire-text">to expire</span></span>';
    } else {
        return '<span class="text-red-500 font-bold pl-3 text-sm">domain expired</span>';
    }
}

function mxProviderChecker($provider) {

    if(strpos($provider, 'google') !== false OR strpos($provider, 'GOOGLE') !== false){
        return 'Google Apps';
    } elseif(strpos($provider, 'secureserver') !== false) {
        return 'GoDaddy';
    } elseif(strpos($provider, 'outlook') !== false) {
        return 'Microsoft Outlook';
    } elseif(strpos($provider, 'barracudanetworks') !== false) {
        return 'Barracuda Networks';
    } elseif(strpos($provider, 'seocloudsrv') !== false) {
        return 'SEO Cloud Server';
    } elseif(strpos($provider, 'arsmtp') !== false) {
        return 'App River (dyn)';
    } elseif(strpos($provider, 'zoho') !== false) {
        return 'Zoho';
    } elseif(strpos($provider, 'yahoo') !== false) {
        return 'Yahoo';
    } elseif(strpos($provider, 'sophos') !== false) {
        return 'Sophos';
    } elseif(strpos($provider, 'ppe-hosted') !== false) {
        return 'Proofpoint';
    } elseif(strpos($provider, 'securence') !== false) {
        return 'Securence';
    } elseif(strpos($provider, 'serverdata') !== false) {
        return 'Server Data';
    } else{
        return $provider;
    }

}

function uptimeType($type) {
    if($type == 1) {
        return '<span class="bg-green-500 text-white rounded px-3 py-1 text-xs"><i class="fas fa-level-up-alt"></i> Up</span>';
    } else {
        return '<span class="bg-red-500 text-white rounded px-3 py-1 text-xs"><i class="fas fa-level-down-alt"></i> Down</span>';
    }
}


function dynamicJSFormat($time) {
    $seconds = strtotime(now()) - strtotime($time);


    if($seconds > 3600) {
        return '%h hours %m minutes %s seconds';
    } elseif($seconds > 60) {
        return '%m minutes %s seconds';
    } else {
        return '%s seconds';
    }
}
