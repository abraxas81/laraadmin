<?php
/**
 * Created by PhpStorm.
 * User: Saša
 * Date: 1.12.2016.
 * Time: 15:34
 */

namespace Dwij\Laraadmin\Helpers\MenuPresenters;


class TopNavBuilder extends MenuPresenter
{
    protected $dropdownToogle;
    protected $childrenDropdown = '<ul class="dropdown-menu" role="menu">';

    protected function hasChildren($childrens)
    {
        $numOfChildrens = count($childrens);
        if ($numOfChildrens) {
            $this->treeview = " class=\"dropdown\"";
            $this->subviewSign = '<span class="caret">';
            $this->dropdownToogle = 'class="dropdown-toggle" data-toggle="dropdown"';
        } else {
            $this->treeview = "";
            $this->subviewSign = '';
            $this->dropdownToogle = '';
        }
        return $numOfChildrens;
    }

}