# Bothelp Api Client PHP

PHP Клиент для работы с Bothelp.io API

📖 Документация по API bothelp по [ссылке](https://main.bothelp.io/swagger)

---
📑 **Навигация**
- [Установка](#1-установка)
- [QuickStart](#2-quickstart-)
- Методы
    - [Список подписчиков](#3-список-подписчиков)
    - [Изменение полей подписчика](#4-изменение-полей-подписчика)
    - [Изменение меток подписчика](#5-изменение-меток-подписчика)
    - [Изменение customFields подписчика](#6-изменение-customfields-подписчика)
    - [Отправка сообщений](#7-отправка-сообщений)
    - [Работа с авторассылками](#8-работа-с-авторассылками)
    - [Работа с ботом подписчика](#9-работа-с-ботом-подписчика)


## 1. Установка

### Требования

`php >= 7.4` 

### Установка через composer 
`composer require bothelpio/bothelp-php-sdk`


## 2. QuickStart 🚀

В личном кабинете получаем

client_id

client_secret

Создаем клиента
```phpt
use BothelpSDK\BothelpClient;
use BothelpSDK\Config\ClientOptions;

// создаем клиента
$options = new ClientOptions(
    '***YourClientId***',
    '***YourClientSecret***'
);
$client = new new BothelpClient($options);

//отправляем произовольный запрос к апи bothelp
// get
$response = $client->apiRequest('GET', 'subsribers?after=12323');
// patch
$response = $client->apiRequest(
    'PATCH', 
    'subsribers/12', 
    [
      ['op' => 'replace', 'path' => '/name', 'value' => 'John Doe']
    ]
);
//etc...
 
```

## 3. Список подписчиков
```phpt
use BothelpSDK\BothelpClient;
use BothelpSDK\Config\ClientOptions;
use BothelpSDK\Request\Subscriber\SubscriberFilter;
use BothelpSDK\Resource\Subscriber\SubscriberService;

// создаем клиента
$options = new ClientOptions(
    '***YourClientId***',
    '***YourClientSecret***'
);
$client = new new BothelpClient($options);

// создаем сервис для работы с подписчиками
$subscriberService = new SubscriberService($client);

// ПРИМЕР 1 
// получим список всех подписчиков и выведем их имена
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

## 4. Изменение полей подписчика 

```phpt
use BothelpSDK\BothelpClient;
use BothelpSDK\Config\ClientOptions;
use BothelpSDK\Request\Subscriber\SubscriberId;
use BothelpSDK\Resource\Subscriber\SubscriberService;

// создаем клиента
$options = new ClientOptions(
    '***YourClientId***',
    '***YourClientSecret***'
);
$client = new new BothelpClient($options);

// создаем сервис для работы с подписчиками
$subscriberService = new SubscriberService($client);

// Определим с каким подписчиком будем работать.
// по ID подписчика
$id = (new SubscriberId())->setId(92);
// или по CUID подписчика
$id = (new SubscriberId())->setCuid('1et0.2k');

// Вызовем нужные методы

// записать телефон
$subscriberService->setPhone($id, '+79941111111');
// записать email
$subscriberService->setEmail($id, 'hello@bothelp.io');
// записать полное имя
$subscriberService->setName($id, 'John Doe');
// записать имя
$subscriberService->setFirstName($id, 'John');
// записать фамилию
$subscriberService->setLastName($id, 'Doe');
// записать заметки
$subscriberService->setNotes($id, 'some notes text... ');

```

## 5. Изменение меток подписчика
```phpt
use BothelpSDK\BothelpClient;
use BothelpSDK\Config\ClientOptions;
use BothelpSDK\Request\Subscriber\SubscriberId;
use BothelpSDK\Resource\Subscriber\SubscriberService;

// создаем клиента
$options = new ClientOptions(
    '***YourClientId***',
    '***YourClientSecret***'
);
$client = new new BothelpClient($options);

// создаем сервис для работы с подписчиками
$subscriberService = new SubscriberService($client);

// Определим с каким подписчиком будем работать.
// по ID подписчика
$id = (new SubscriberId())->setId(92);
// или по CUID подписчика
$id = (new SubscriberId())->setCuid('1et0.2k');

// Вызовем нужные методы

// добавим 3 метки пользователю
$subscriberService->setTags($id, ['awesome', 'bad', 'best']);
// удалить 2 метки у пользователя
$subscriberService->removeTags($id, ['bad', 'best']);

```

## 6. Изменение customFields подписчика
```phpt
use BothelpSDK\BothelpClient;
use BothelpSDK\Config\ClientOptions;
use BothelpSDK\Request\Subscriber\SubscriberId;
use BothelpSDK\Resource\CustomField\CustomField;

// создаем клиента
$options = new ClientOptions(
    '***YourClientId***',
    '***YourClientSecret***'
);
$client = new new BothelpClient($options);

// создаем сервис для работы с customField
$customFieldService = new CustomField($client);

// Установим поле favorite_color в значение blue для подписчика с id = 92
$id = (new SubscriberId())->setId(92);
$customFieldService->setField($id, 'favorite_color', 'blue');

// Установим поле Бюджет в значение 7000 для подписчика с cuid = 1et0.2k
$id = (new SubscriberId())->setCuid('1et0.2k');
$customFieldService->setField($id, 'Бюджет', '7000');

```

## 7. Отправка сообщений

:construction_worker: Скоро будет
## 8. Работа с авторассылками

:construction_worker: Скоро будет
## 9. Работа с ботом подписчика

:construction_worker: Скоро будет

## Лицензия

:warning: Это частная разработка :warning:

Используется по лицензии [MIT](https://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_MIT)