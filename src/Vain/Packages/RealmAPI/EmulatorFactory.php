<?php

namespace Vain\Packages\RealmAPI;

use InvalidArgumentException;

/**
 * Created by PhpStorm.
 * User: Otto
 * Date: 26.01.2015
 * Time: 20:52.
 */
class EmulatorFactory
{
    use Configurator;

    /**
     * saves resolved instances as singletons.
     *
     * @var AbstractEmulator[]
     */
    protected $instances;

    public function __construct()
    {
        $this->instances = [];
    }

    /**
     * @param $realm
     * @param bool $useCache
     *
     * @return AbstractEmulator
     */
    public function connection($realm, $useCache = true)
    {
        if (array_key_exists($realm, $this->instances)) {
            // since we can modify the cache we may update the singleton
            $this->instances[$realm]->setUseCache($useCache);
        } else {
            // resolve new instance
            $this->instances[$realm] = $this->resolveEmulator($realm, $useCache);
        }

        return $this->instances[$realm];
    }

    /**
     * @param $realm
     * @param $useCache
     *
     * @return AbstractEmulator
     */
    protected function resolveEmulator($realm, $useCache)
    {
        $type = $this->getTypeConfig($realm);

        switch ($type) {
            case AbstractEmulator::REALM_TRINITY:
                return new TrinityEmulator($realm, $useCache);

            case AbstractEmulator::REALM_MANGOS:
                return new MangosEmulator($realm, $useCache);

            default:
                throw new InvalidArgumentException('Unsupported realm type \''.$type.'\'');
        }
    }
}
