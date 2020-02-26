# hostcms6-canonicalurl

Генератор Canonical URL для HostCMS 6 (генерирует по алиасам заданным в системе, а не из REQUEST_URI) 

Позволяет вставлять в макет правильный [Canonical URL](https://yandex.ru/support/webmaster/robot-workings/canonical.html) сформированный на основе данных о путях указанных в системе для каждого инорфмационного элемента (группа, товар, статья, новость).

При наличии постраничной навигации можно оставить только для индексации первую страницу, а остальные закрыть для индексации см. [форум](https://www.hostcms.ru/forums/3/8724/page-3/#69672)


## Установка модуля

Скачайте репозитарий, распакуйте и поместите на сервер с HostCMS в каталог `modules`. У вас должен появиться файл `/modules/core/canonicalurl.php`. 
Далее можено выполнить подключение в коде.

## Использование в коде

### Вставка rel="canonical" код макета HostCMS

Данный модуль содерит один публичный метод `Core_CanonicalURL::generate()` - возвращает canonical-url согласно указанному в настройках элемента пути с сохранением регистра символов.

Тег `<link rel="cannonical">` должен быть размещен внутри секции `<head>`. 

Пример:
	
	<head>
		<meta charset="utf-8"/>
		
		<title><?php Core_Page::instance()->showTitle(); ?></title>
		<link rel="canonical" href="<?= Core_CanonicalURL::generate(); ?>"/>

В результате с сгенерированном правильный canonical адрес страницы и избавитесь от большинства дублей. 
Поисковые системы учитывают указанный в canonical адрес, и отдают таким страницам [пердпочтение](https://webmaster.yandex.ru/blog/nekanonicheskie-stranitsy-v-poiske). 
Однако неканонические страницы также могут быть [посещены поисковым роботом и показаны в результатах поиска](https://webmaster.yandex.ru/blog/nekanonicheskie-stranitsy-v-poiske)

## Помощь в установке

https://r3code.ru
