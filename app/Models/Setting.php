<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
// use Watson\Validating\ValidatingTrait;
use Schema;

class Setting extends Model
{
    use Notifiable;
    protected $injectUniqueIdentifier = true;
    // use ValidatingTrait;
    protected $table = "stt_adldap_settings";
    
    protected $rules = [
          'brand'     => 'required|min:1|numeric',
          'qr_text'         => 'max:31|nullable',
          'logo_img'        => 'mimes:jpeg,bmp,png,gif',
          'alert_email'   => 'email_array|nullable',
          'default_currency'   => 'required',
          'locale'   => 'required',
          'slack_endpoint'   => 'url|required_with:slack_channel|nullable',
          'slack_channel'   => 'regex:/(?<!\w)#\w+/|required_with:slack_endpoint|nullable',
          'slack_botname'   => 'string|nullable',
          'labels_per_page' => 'numeric',
          'labels_width' => 'numeric',
          'labels_height' => 'numeric',
          'labels_pmargin_left' => 'numeric|nullable',
          'labels_pmargin_right' => 'numeric|nullable',
          'labels_pmargin_top' => 'numeric|nullable',
          'labels_pmargin_bottom' => 'numeric|nullable',
          'labels_display_bgutter' => 'numeric|nullable',
          'labels_display_sgutter' => 'numeric|nullable',
          'labels_fontsize' => 'numeric|min:5',
          'labels_pagewidth' => 'numeric|nullable',
          'labels_pageheight' => 'numeric|nullable',
          'login_remote_user_enabled' => 'numeric|nullable',
          'login_common_disabled' => 'numeric|nullable',
          'login_remote_user_custom_logout_url' => 'string|nullable',
          'thumbnail_max_h'     => 'numeric|max:500|min:25',
          'pwd_secure_min' => 'numeric|required|min:5',
          'audit_warning_days' => 'numeric|nullable',
          'audit_interval' => 'numeric|nullable',
          'custom_forgot_pass_url' => 'url|nullable',
    ];

    protected $fillable = ['site_name','email_domain','email_format','username_format'];

    public static function getSettings()
    {
        static $static_cache = null;

        if (!$static_cache) {
            if (Schema::hasTable('stt_adldap_settings')) {
                $static_cache = Setting::first();
            }
        }

            return $static_cache;

    }
}