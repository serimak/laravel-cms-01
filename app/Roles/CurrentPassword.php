<?php
namespace App\Roles;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
class CurrentPassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value,auth()->user()->password);
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'รหัสผ่านปัจจุบันของคุณไม่ถูกต้อง';
    }
}