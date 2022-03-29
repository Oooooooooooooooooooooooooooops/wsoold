<?php

// ISIB Api Routing & reply procedures

try {
    require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';
    if (CModule::IncludeModule('isib')) {
        $api = new ISIB\Api();
        switch ($api->queryPath[0]) {
            case 'user':
                $user = new ISIB\User();
                $api->resolve($user->route($api));
            break;
            case 'igroup':
                $igroup = new ISIB\IGroup();
                $api->resolve($igroup->route($api));
            break;
            case 'project':
                $iproj = new ISIB\IProject();
                $api->resolve($iproj->route($api));
            break;
            case 'compete':
                $compete = new ISIB\Compete($api->queryPath[1]);
                $api->resolve($compete->route($api));
            break;
            case 'application':
                $appl = new ISIB\Application();
                $api->resolve($appl->route($api));
            break;
            case 'socnet':
                $appl = new ISIB\Socnet();
                $api->resolve($appl->route($api));
            break;
            case 'comment':
                $appl = new ISIB\Comments();
                $api->resolve($appl->route($api));
            break;
            case 'message':
                $appl = new ISIB\Message();
                $api->resolve($appl->route($api));
            break;
            case 'template':
                $appl = new ISIB\Template();
                $api->resolve($appl->route($api));
            break;
            case 'criteria':
                $appl = new ISIB\Criteria();
                $api->resolve($appl->route($api));
            break;


            //Path not found
            default:
            throw new Error('Путь '.join('/', $api->queryPath).' не найден');
        }

        $api->resolve();
    } else {
        throw new Error('Не удалось подключить модуль ИСИБ');
    }
} catch (Error $e) {
    ob_clean();
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *'); 
    header('Access-Control-Allow-Methods: DELETE, POST, GET, OPTIONS'); 
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With'); 
    die(json_encode((object) ['error' => $e->getMessage(), 'fallback' => true, 'error_fields' => []]));
}