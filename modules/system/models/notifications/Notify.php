<?php


namespace app\modules\system\models\notifications;

/**
 * Class Notify - абстрактный класс для уведомлений пользователя: vk, email, sms
 *
 * Сначала создаем новый обьект "Уведомление".
 * Затем наполняем настройками через метод set();
 * После отправляем методом send();
 * @package app\models\notifications
 */


abstract class Notify {

    public $to; /** @var Notify Кому предназначалось сообщение; */
    public $message; /** @var Notify Тело сообщения */

    /**
     * Функция отправки уведомления;
     *
     * @return mixed
     */
    abstract public function send();

    /**
     * Функция конструктор для публичных свойств класса;
     *
     * @param array $config
     * @return mixed
     */
    abstract function set($config = []);


}
?>
