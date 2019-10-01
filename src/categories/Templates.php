<?php

namespace linnoxlewis\mailchimp\categories;

/**
 * Шаблоны
 *
 * Trait templates
 *
 * @package common\components\mailchimp\categories
 */
trait Templates
{
    /**
     * Получить список доступных шаблонов| шаблона
     *
     * @param int|string|null $templateId id шаблона
     *
     * @return mixed
     */
    public function getTemplates($templateId = null)
    {
        (empty($templateId)) ? $url ='templates/' : $url = 'templates/' . $templateId;

        return $this->request($url, 'get');
    }

    /**
     * Создание шаблона
     *
     * @param string $name компании
     * @param string $folderId папка
     * @param string $html код шаблона
     *
     * @return mixed
     */
    public function addTemplate(string $name, string $folderId, string $html)
    {
        $data = $this->prepareTemplateData($name,$folderId,$html);

        $res = $this->request('templates/', 'post', $data);

        return $res;
    }

    /**
     * Обновление шаблона
     *
     * @param string $name компании
     * @param string $folderId папка
     * @param string $html код шаблона
     *
     * @return mixed
     */
    public function updateTemplate(string $name, string $folderId, string $html)
    {
        $data = $this->prepareTemplateData($name,$folderId,$html);

        $res = $this->request('templates/', 'patch', $data);

        return $res;
    }

    /**
     * Удаление шаблона
     *
     * @param int|string $templateId id шаблона
     *
     * @return mixed
     */
    public function removeTemplate($templateId)
    {
        return $this->request('templates/' . $templateId, 'delete');
    }

    /**
     * Подготовка данных для шаблона
     *
     * @param string $name компании
     * @param string $folderId папка
     * @param string $html код шаблона
     *
     * @return array
     */
    protected function prepareTemplateData(string $name, string $folderId, string $html): array
    {
        return [
            'name' => $name,
            'folder_id' => $folderId,
            'html' => $html
        ];
    }
}

