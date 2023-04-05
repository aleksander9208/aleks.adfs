# Модуля для интеграции с ADFS

Тестовая версия модуля для интеграции с ADFS под Bitrix, для запросов использовалась библиотека onelogin/php-saml

## Пример реализации

```
global $USER;

CModule::IncludeModule('lepricon.adfs');
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
        echo "<p>Not authenticated</p>";
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
```