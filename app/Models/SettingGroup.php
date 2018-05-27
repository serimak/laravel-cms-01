<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Watson\Validating\ValidatingTrait;
use Schema;

class SettingGroup extends Model
{
    use Notifiable;
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;
    protected $table = "stt_adldap_groups";
    
    protected $rules = [
          'ldap_group_name'   => 'required',
          'group_id' => 'numeric',
          'role_id' => 'numeric',
          'ldap_filter'   => 'required',
    ];

    protected $fillable = ['ldap_group_name','group_id','role_id','ldap_filter'];

    
    public static function getAllGroups()
    {
        static $static_cache = null;

        if (!$static_cache) {
            if (Schema::hasTable('stt_adldap_groups')) {
                $static_cache = SettingGroup::all();
            }
        }

            return $static_cache;

    }
}