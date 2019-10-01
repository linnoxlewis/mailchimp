Yii2 .

Установка: composer require "linnoxlewis/Mailchimp"

Конфигурация:
```
use linnoxlewis\mailchimp;
return [
 'components' => [ 
        // ...,
    'mailchimp' => [ 
        'class' => Mailchimp::class, 
        'apikey' => 'your api key', 
        'urlId' =>'us20', 
    ]
  ],
]
```
Пример использования :
```
$mailchimp = Yii::$app->get('mailchimp');
$mailchimp->addMessage('test@email.com');

```
