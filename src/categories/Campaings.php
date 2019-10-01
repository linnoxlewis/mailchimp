<?php

namespace linnoxlewis\mailchimp\categories;

/**
 * Компании
 *
 * Trait templates
 *
 * @package common\components\mailchimp\categories
 */
trait Campaings
{
    /**
     * Список компаний| определенная компания
     *
     * @param string|null $campId id компании
     *
     * @return mixed
     */
    public function getCampaigns($campId = null)
    {
        empty($campId) ? $url = 'campaigns' : $url = 'campaigns/' . $campId;

        return $this->request($url, 'get');
    }

    /**
     * Создание компании
     *
     * @param string $listId id списка
     * @param string $subj предмет письма
     * @param string $fromName от кого
     * @param string $replyTo кому
     *
     * @return mixed
     */
    public function createCampaing($listId = '', string $subj, string $fromName, string $replyTo)
    {
        $data = $this->prepareCampingData($listId, $subj, $fromName, $replyTo);

        $res = $this->request('campaigns', 'post', $data);

        return $res;
    }

    /**
     * Обновление компании
     *
     * @param string $listId id списка
     * @param string $subj предмет письма
     * @param string $fromName от кого
     * @param string $replyTo кому
     *
     * @return mixed
     */
    public function updateCamping($campId, $listId = '', string $subj, string $fromName, string $replyTo)
    {
        $data = $this->prepareCampingData($listId, $subj, $fromName, $replyTo);

        $res = $this->request('campaigns/' . $campId, 'patch', $data);

        return $res;
    }

    /**
     * Удаление компании
     *
     * @param string $campId id компании
     *
     * @return mixed
     */
    public function deleteCampaign(string $campId)
    {
        return $this->request('campaigns/' . $campId, 'delete');
    }

    /**
     * Создание текста для компании
     *
     * @param string $html хтмл код контента
     * @param string $plain текст
     * @param string $campId id компании
     *
     * @return mixed
     */
    public function createCampaingContent($campId,$plain, $html)
    {
        $data = ['plain_text' => $plain, 'html' => $html];

        return $this->request('campaigns/' . $campId . '/content', 'put', $data);
    }

    /**
     * Получение контента для компании
     *
     * @param string $campId id компании
     *
     * @return mixed
     */
    public function getCampaingContent($campId)
    {
        return $this->request('campaigns/' . $campId . '/content', 'get');
    }

    /**
     * Отправка тестового письма для компании
     *
     * @param string $id_camping компании
     * @param string $email куда отправлять тестовое сообщение
     *
     * @return mixed
     */
    public function addMessage($email = '')
    {
        $data = ['test_emails' => array($email), 'send_type' => 'html'];

        return $this->request('campaigns/' . '/actions/test', 'post', $data);
    }

    /**
     * Отправка компании
     *
     * @param string|int $idCamping id компании
     *
     * @return mixed
     */
    public function sendCampaing($idCamping = '')
    {
        return $this->request('campaigns/' . $idCamping . '/actions/send', 'post');
    }

    /**
     * Формирование даты для отправки
     *
     * @param string $listId id списка
     * @param string $subj предмет письма
     * @param string $fromName от кого
     * @param string $replyTo кому
     *
     * @return mixed
     */
    protected function prepareCampingData($listId = '', string $subj, string $fromName, string $replyTo)
    {
        return [
            'type' => 'regular',
            'recipients' => ['list_id' => $listId],
            'settings' => [
                'subject_line' => $subj,
                'reply_to' => $replyTo,
                'from_name' => $fromName
            ]
        ];
    }
}

