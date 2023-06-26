# Модуля для интеграции с ADFS

Mодуля для интеграции с ADFS под Bitrix, для запросов использовалась библиотека onelogin/php-saml. Модуль так же настроен для авторизации через kerberos

Для настроек авторизации через ADFS нужно получить:
1. Точка входа(SSO сервера для подключения) - https://domen-portala/adfs/ls
2. Entity Id - http://domen-portala/adfs/services/trust
3. Файл сертификата

Настройки сервера прописать на странице (/bitrix/admin/adfs_setting_admin.php?lang=ru)
Сертификат доступа прописываем в текстовом формате

Для получение настроек сервера можно ознакомится в файле "Инструкция_sso.pdf"