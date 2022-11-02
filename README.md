# Bothelp PHP SDK
PHP Клиент для работы с Bothelp.io API 

Документация по API bothelp по [ссылке](https://main.bothelp.io/swagger)

- ####[Установка](#install)
- ####[QuickStart](#quickStart)
- ####Методы
    - [Список подписчиков](#subscribersList)

## Установка {#install}

###Требования 
```php >= 7.4``` 

### Установка через composer 
``` composer require bothelpio/bothelp-php-sdk ```

## QuickStart {#quickStart}

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

## Список подписчиков {#subscribersList}
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

