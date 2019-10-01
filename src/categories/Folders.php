<?php

namespace linnoxlewis\mailchimp\categories;

/**
 * Папки шаблонов
 *
 * Trait templates
 *
 * @package common\components\mailchimp\categories
 */
trait Folders
{
    /**
     * Получить список доступных папок| папки шаблона
     *
     * @param int|string|null $folderId id  папки шаблона
     *
     * @return mixed
     */
    public function getFolders($folderId = null)
    {
        (empty($folderId)) ? $url ='template-folders/' : $url = 'templates/' . $folderId;

        return $this->request($url, 'get');
    }

    /**
     * Создание папки
     *
     * @param string $name имя папки
     *
     * @return mixed
     */
    public function addFolder(string $name)
    {
        return $this->request('template-folders/', 'post',['name' => $name]);
    }

    /**
     * Обновление папки шаблона
     *
     * @param string $name имя папки
     *
     * @return mixed
     */
    public function updateFolder(string $name)
    {
        return $this->request('template-folders/', 'patch',['name' => $name]);
    }

    /**
     * Удаление шаблона
     *
     * @param int|string $folderId id папки
     *
     * @return mixed
     */
    public function removeFolder($folderId)
    {
        return $this->request('template-folders/' . $folderId, 'delete');
    }
}

