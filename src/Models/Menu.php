<?php
/**
 * Code generated using LaraAdmin
 * Help: http://laraadmin.com
 * LaraAdmin is open-sourced software licensed under the MIT license.
 * Developed by: Dwij IT Solutions
 * Developer Website: http://dwijitsolutions.com
 */

namespace Dwij\Laraadmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Dwij\Laraadmin\Helpers\LAHelper;

/**
 * Class Menu
 * @package Dwij\Laraadmin\Models
 *
 * Menu Model which looks after Menus in Sidebar and Navbar
 */
class Menu extends Model
{
    protected $table = 'la_menus';
    
    protected $guarded = [
    
    ];

    /*
     * added relation to module model
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /*
     * self relation to parent
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent');
    }

    /*
    * self relation to children
    */
    public function children()
    {
        return $this->hasMany(self::class, 'parent')->orderBy('hierarchy', 'asc');
    }
}
