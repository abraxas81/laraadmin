<?php
/**
 * Created by PhpStorm.
 * User: Saša
 * Date: 1.12.2016.
 * Time: 15:34
 */

namespace Dwij\Laraadmin\Helpers\MenuPresenters;


class Sidebar extends MenuPresenter
{
    protected $childrenDropdown = '<ul class="treeview-menu">';

    protected function printHtml($menu, $active = false)
    {

        $haveChildren = $this->hasChildren($menu->children);

        if (!$active) {
            $this->setStrActive('');
        }
        $this->str .= '<li' . $this->treeview . ' ' . $this->getStrActive() . '><a href="' . url(config("laraadmin.adminRoute") . '/' . $menu->url) . '"><i class="fa ' . $menu->icon . '"></i> <span>' . $menu->name . '</span> ' . $this->subviewSign . '</a>';
        $haveChildren ? $this->printChildren($menu->children) : $this->str .= '</li>';
    }

    protected function hasChildren($childrens)
    {
        $numOfChildrens = count($childrens);
        if ($numOfChildrens) {
            $this->treeview = " class=\"treeview\"";
            $this->subviewSign = '<i class="fa fa-angle-left pull-right"></i>';
        } else {
            $this->treeview = "";
            $this->subviewSign = '';
        }
        return $numOfChildrens;
    }
}