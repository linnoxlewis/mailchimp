<?php

namespace linnoxlewis\mailchimp;

use linnoxlewis\mailchimp\categories\Campaings;
use linnoxlewis\mailchimp\categories\Folders;
use linnoxlewis\mailchimp\categories\Templates;
use yii\base\Component;

/**
 * Компонент для работы с сервисом mailChimp
 *
 * Class Mailchimp
 *
 * @package linnoxlewis\mailchimp
 */
class Mailchimp extends Component
{
    use Campaings,Folders,Templates;

    /**
     * Статус "Подписать".
     *
     * @var string
     */
    const SUBSCRIBE = 'subscribed';

    /**
     * Статус "Отписать".
     *
     * @var string
     */
    const UNSUBSCRIBE = 'unsubscribed';

    /**
     * Статус "Подписать с подтверждением письмом".
     *
     * @var string
     */
    const PENDING = 'pending';

    /**
     * Статус "Удалить".
     *
     * @var string
     */
    const CLEAN = 'cleaned';

    /**
     * АПИ ключ
     *
     * @var
     */
    public $apiKey;

    /**
     * Адрес запроса к апи
     *
     * @var string
     */
    public $urlId = 'us20';

    /**
     * Получение ссылки для отправки
     *
     * @return string
     */
    protected  function getUrl() : string
    {
        return 'https://' . $this->urlId . '.api.mailchimp.com/3.0/';
    }

    /**
     * Выполенение запроса к АПИ
     *
     * @param string     $method метод запроса
     * @param string     $type   тип запроса
     * @param array|bool $data   Данные
     *
     * @return mixed
     */
    protected function request($method = '', $type = 'post', $data = false)
    {
        $url = $this->getUrl() . $method;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/vnd.api+json',
            'Content-Type: application/vnd.api+json',
            'Authorization: apikey ' . $this->apiKey
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        switch ($type) {
            case 'post':
                curl_setopt($ch, CURLOPT_POST, true);
                if (is_array($data)) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            case 'get':
                $query = '';
                if (is_array($data)) {
                    $query = http_build_query($data, '', '&');
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $query);
                break;

            case 'delete':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;

            case 'patch':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                if (is_array($data)) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;

            case 'put':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                if (is_array($data)) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
        }
        $out = curl_exec($ch);
        curl_close($ch);
        return json_decode($out);
    }

    /**
     * Получить список доступных листов рассылки
     *
     * @return array|mixed|object
     */
    public function getLists()
    {
        return $this->request('lists', 'get');
    }

    /**
     * Добавление подписчика
     *
     * @param string $listId лист подписки
     * @param string $email  email
     * @param string $status статус
     *
     * @return string
     */
    public function subscriber($email = '', $listId, $status): string
    {
        $data = array(
            'email_address' => $email,
            'status'        => $status,
         //   'merge_fields'  => array('FNAME' => $email, 'LNAME' => '')
        );

        $res = $this->request('lists/' . $listId . '/members', 'post', $data);

       return $res->status;
    }

    /**
     * Поисковик
     *
     * @param string $query запрос
     *
     * @return mixed
     */
    public function search(string $query)
    {
        return $this->request('search-members?query=' . $query, 'get');
    }
}
