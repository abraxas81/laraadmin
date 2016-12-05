<?php
/**
 * Created by PhpStorm.
 * User: Saša
 * Date: 25.11.2016.
 * Time: 15:46
 */

namespace Dwij\Laraadmin\Helpers\Cache;

use Illuminate\Support\Facades\Cache;


trait CacheHelper
{
    private $cacheable = true;

    /**
     * @return boolean
     */
    public function isCacheable(): bool
    {
        return $this->cacheable;
    }

    /**
     * @param boolean $cacheable
     */
    public function setCacheable(bool $cacheable)
    {
        $this->cacheable = $cacheable;
    }

    private function checkCache(array $tags, $key)
    {
        if(!$this->isCacheable()){
            return $this->query();
        }
        if(!$this->getMenusFromCache($tags, $key)){
            Cache::tags($tags)->put($key, $this->query(), 60);
        }
        return $this->getMenusFromCache($tags, $key);
    }

    private function getMenusFromCache($tags, $key)
    {
        return Cache::tags($tags)->get($key);
    }

    protected function query(){}

}