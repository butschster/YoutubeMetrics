<?php

namespace App\Contracts\Services\Youtube;

use Carbon\Carbon;

interface KeyManager
{
    /**
     * @param array $keys
     */
    public function setKeys(array $keys): void;

    /**
     * Поверка на наличие ключей
     *
     * @return bool
     */
    public function hasKeys(): bool;

    /**
     * Получение списка доступных ключей
     *
     * @return array
     */
    public function keys(): array;

    /**
     * Получение рандомного ключа
     *
     * @return null|string
     */
    public function randomKey(): ?string;

    /**
     * Проверка ключа на бан
     *
     * @param string $key
     * @return bool
     */
    public function isBanned(string $key): bool;

    /**
     * Бан ключа до следующего расчетного периода
     *
     * @param string $key
     * @param Carbon|null $date
     */
    public function ban(string $key, Carbon $date = null): void;

    /**
     * Расчет кол-ва минут до следующего расчетного периода
     *
     * @param Carbon $date
     * @return int
     */
    public function calculateMinutesToPT(Carbon $date): int;
}