# Bothelp PHP SDK

---

PHP Клиент для работы с Bothelp.io API

📖 Документация по API bothelp по [ссылке](https://main.bothelp.io/swagger)

---
📑 **Навигация**
- [Установка](#1-)
- [QuickStart](#2-quickstart)
- Методы
    - [Список подписчиков](#3--)
    - [Изменение полей подписичка](#4-)
    - [Отправка сообщений](#5-)
    - [Работа с авторассылками](#6-)
    - [Работа с ботом подпичика](#7-)

---

##1. Установка

###Требования 
```php >= 7.4``` 

### Установка через composer 
``` composer require bothelpio/bothelp-php-sdk ```

----
##2. QuickStart 🚀

В личном кабинете получаем

client_id

client_secret

Создаем клиента
```phpt
use BothelpSDK\BothelpClient;
use BothelpSDK\Config\ClientOptions;

$options = new ClientOptions(
    '***YourClientId***',
    '***YourClientSecret***'
);
$client = new new BothelpClient($options);

//отправляем произовольный запрос к апи bothelp
$response = $client->apiRequest('GET', 'subsribers?after=12323');
 
```
---
##3. Список подписчиков
```phpt
// создаем клиента
use BothelpSDK\BothelpClient;
use BothelpSDK\Config\ClientOptions;
use BothelpSDK\Request\Subscriber\SubscriberFilter;
use BothelpSDK\Resource\Subscriber\SubscriberService;

$options = new ClientOptions(
    '***YourClientId***',
    '***YourClientSecret***'
);
$client = new new BothelpClient($options);

// создаем сервис для работы с подписчиками
$subscriberService = new SubscriberService($client);

// ПРИМЕР 1 
// получим список всех подписчиков и выведем из имена
$list = $subscriberService->list();
foreach($list as $subscriber) {
    echo $subscriber->getName();
}

// ПРИМЕР 2
// получим подписчика по email
$filter = new SubscriberFilter();
$filter->setEmail('johnDhoe@example.com');
$list = $subscriberService->list($filter);
if ($list->count() > 0) {
   $subscriber = $list[0];
   print_r($subscriber->getRawData());
}

// ПРИМЕР 3
// получим список всех подписчиков после определенной даты 
// и пройдемся по постраничке
$filter = new SubscriberFilter();
$filter->setCreatedAfter(1662126165);
$page1list = $subscriberService->list($filter);
if ($page1list->hasNext()) { // есть еще страницы в выдаче?
 // заберем вторую страницу...
 $page2List = $subscriberService->list($page1list->getNextFilter());
}

```
---
## 4. Изменения полей подписчика

:construction_worker: Скоро будет
## 5. Отправка сообщений

:construction_worker: Скоро будет
## 6. Работа с авторассылками

:construction_worker: Скоро будет
## 7. Работа с ботом подпичика

:construction_worker: Скоро будет

## Лицензия

:warning: SDK это частная разработка и доступна всем желающим :warning:

Используется по лицензии [MIT](https://github.com/git/git-scm.com/blob/main/MIT-LICENSE.txt)