<?php

use Bitrix\Main\Application;
use Bitrix\Main\Context;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Engine\CurrentUser;
use Aleks\Adfs\Helper\ErrorHelper;
use Aleks\Adfs\Helper\SettingsHelper;
use OneLogin\Saml2\Auth;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

global $USER, $APPLICATION;

if (!$USER->GetID()) {
    CModule::IncludeModule('aleks.adfs');

    $request = Context::getCurrent()->getRequest();
    $session = Application::getInstance()->getSession();

    $auth = new Auth(SettingsHelper::getSettings());
    $requestID = null;

    if(isset($request['acs'])) {
        if (isset($session) && $session->get('AuthNRequestID') !== null) {
            $requestID = $session->get('AuthNRequestID');
        }

        $auth->processResponse($requestID);

        ErrorHelper::inErrors($auth);

        if (!$auth->isAuthenticated()) {
            Debug::writeToFile(
                [
                    'date' => date('d.m.Y H:i'),
                    'method' => __METHOD__,
                    'error' => $auth->getErrors(),
                ],
                '',
                __DIR__ . '/../../log/ADFS/' . date('d_m_Y') . '.log'
            );
            exit();
        }

        $userId = CurrentUser::get()->getId();
        if (!$session->has('ADFS_' .$userId)) {
            $adfsAnswer = [
                'samlUserdata' => $auth->getAttributes(),
                'samlNameId' => $auth->getNameId(),
                'samlNameIdFormat' => $auth->getNameIdFormat(),
                'samlNameidNameQualifier' => $auth->getNameIdNameQualifier(),
                'samlNameidSPNameQualifier' => $auth->getNameIdSPNameQualifier(),
                'samlSessionIndex' => $auth->getSessionIndex(),
            ];
            $session->set('ADFS_' .$userId, $adfsAnswer);

            $login = $adfsAnswer['samlUserdata']['AuthNRequestID'][0];

            $rsUser = CUser::GetByLogin($login)->Fetch();
            $USER->Authorize($rsUser['ID']);
            LocalRedirect('/mainpage/');
        }
    } else if (isset($request['sls'])) {
        if (isset($session) && $session->get('LogoutRequestID') !== null) {
            $requestID = $session->get('LogoutRequestID');
        }

        $auth->processSLO(false, $requestID);
        ErrorHelper::inErrors($auth);
    } else {
        $ssoBuiltUrl = $auth->login(null, array(), false, false, true);
        $_SESSION['AuthNRequestID'] = $auth->getLastRequestID();
        header('Pragma: no-cache');
        header('Cache-Control: no-cache, must-revalidate');
        header('Location: ' . $ssoBuiltUrl);
        exit();
    }
}