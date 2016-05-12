<?php

namespace Vain\Packages\RealmAPI;

use Illuminate\Support\Facades\Config;

trait Configurator
{
    /**
     * @param $realm
     *
     * @return int
     */
    protected function getTypeConfig($realm)
    {
        return $this->getConfigOrFail($realm, 'realm.emulators');
    }

    /**
     * @param $realm
     *
     * @return array
     */
    protected function getDatabaseConfig($realm)
    {
        return $this->getConfigOrFail($realm, 'realm.databases');
    }

    /**
     * @param $realm
     *
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    protected function getSoapConfig($realm)
    {
        return $this->getConfigOrFail($realm, 'realm.soap');
    }

    /**
     * @param $realm
     * @param $key
     *
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    private function getConfigOrFail($realm, $key)
    {
        $config = Config::get($key);

        if (!array_key_exists($realm, $config)) {
            throw new InvalidArgumentException('Cannot find realm \''.$realm.'\' in realm config, make sure it is setup correctly');
        }

        return $config[$realm];
    }
}
