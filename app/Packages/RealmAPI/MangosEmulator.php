<?php namespace Vain\Packages\RealmAPI;

/**
 * Created by PhpStorm.
 * User: Otto
 * Date: 26.01.2015
 * Time: 21:00
 */

use Illuminate\Support\Facades\Cache;

class MangosEmulator extends AbstractEmulator
{
    /**
     * Get information about running realm (player online, uptime, ...)
     * @return array
     */
    public function getServerStatus() // ToDo: rather use a db query?
    {
        $key = $this->cacheKey(__FUNCTION__);

        if ($this->useCache && Cache::has($key))
            return Cache::get($key);

        if (!($string = $this->soap->send('server info')))
            return null;

        $format = "Anzahl der verbundenen Spieler: %d (Maximum: %d) Spieler in der Warteschlange: %d (Maximum: %d)";
        $data = array_combine(['online', 'maximum', 'queue', 'queueMaximum'], sscanf($string, $format));

        Cache::put($key, $data, 1);

        return $data;
    }

    /**
     * Send an item/s to a player
     * @param string $name
     * @param array|int $items
     * @returns boolean
     */
    public function sendItems($name, $items)
    {
        $itemString = '';
        if (is_array($items)) {
            $prefix = '';
            foreach ($items as $item) {
                $itemString .= $prefix . $item;
                $prefix = ' ';
            }
        } else
            $itemString = $items;

        return $this->soap->send('send items '.$name.' "RG Premium System" "" ' . $itemString) !== false;
    }
}
