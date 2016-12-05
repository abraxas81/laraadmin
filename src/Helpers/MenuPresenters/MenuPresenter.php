<?php
/**
 * Created by PhpStorm.
 * User: Saša
 * Date: 5.12.2016.
 * Time: 11:26
 */

namespace Dwij\Laraadmin\Helpers\MenuPresenters;

use Dwij\Laraadmin\Helpers\Cache\CacheHelper;
use Zizaco\Entrust\EntrustFacade as Entrust;

use Dwij\Laraadmin\Models\Menu;


abstract class MenuPresenter
{
    use CacheHelper;

    public $str = "";
    protected $tmpParent = "";
    protected $treeview;
    protected $subviewSign;
    protected $str_active = 'class="active"';
    protected $menu;
    protected $dropdownToogle ="";
    protected $childrenDropdown ="";

    /**
     * @return string
     */
    public function getStrActive(): string
    {
        return $this->str_active;
    }

    /**
     * @param string $str_active
     */
    public function setStrActive(string $str_active)
    {
        $this->str_active = $str_active;
    }


    /**
     * basic logic for processing menuItems
     *
     * @return string
     */
    public function buildMenu()
    {
        $menuItems = $this->checkCache(['sidebarMenu'], 'sidebarMenu');
        foreach ($menuItems as $menu) {
            if ($this->isModule($menu)) {
                $this->haveAccess($menu);
            } else {
                $this->printHtml($menu);
            }
        }
        return $this->str;
    }


    /**
     * query that is called to get menuItems
     * it use Trait for Caching if there is not cached results
     * @return mixed
     */
    protected function query()
    {
        return Menu::with('children.module', 'children.children')->where('parent',0)->orderBy('hierarchy', 'asc')->get();
    }


    /**
     * print menu and check if menu have children elements
     * and call function to print them too
     *
     * @param $menu
     * @param bool $active
     */
    protected function printHtml($menu, $active = false)
    {

        $haveChildren = $this->hasChildren($menu->children);

        if (!$active) {
            $this->setStrActive('');
        }
        $this->str .= '<li' . $this->treeview . ' ' . $this->getStrActive() . '><a '.$this->dropdownToogle.' href="' . url(config("laraadmin.adminRoute") . '/' . $menu->url) . '"><i class="fa ' . $menu->icon . '"></i> <span>' . $menu->name . $this->subviewSign . '</a>';
        $haveChildren ? $this->printChildren($menu->children) : $this->str .= '</li>';
    }


    /**
     * prints children of parent menu
     *
     * @param $children
     */
    protected function printChildren($children)
    {
        $this->str .= $this->childrenDropdown;
        $j = 0;
        foreach ($children as $child) {
            $j++;
            $this->haveAccess($child);
        }
        if ($j) $this->str .= '</ul>';
    }


    /**
     * check if menu is module or custom menu
     *
     * @param $menu
     * @return bool
     */
    protected function isModule($menu)
    {
        return $menu->module ? true : false;
    }

    /**
     * check if module is active in frontend
     *
     * @param $module
     * @return bool
     */
    protected function isActiveMenu($module)
    {
        return $module->id && $module->name == 'roles' ? true : false;
    }

    /**
     * check if Auth user have view access to menu
     *
     * @param $menu
     */
    protected function haveAccess($menu){
        if (Entrust::access("view", $menu->module)) {
            $this->printHtml($menu);
        };
    }

}