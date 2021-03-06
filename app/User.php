<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const GUEST_PROFILE_PICTURE_URL = "/images/Guest";
    const userWithNoFacebookAccount = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'nickName',
        'profileImage',
        'nativeLanguage',
        'learningLanguage',
        'city',
        'numberOfActions',
        'numberOfBestAnswers',
        'numberOfFavorites',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function facebookPageUrl() {

        return "http://facebook.com/" . $this->getFacebookId();
    }

    public function isGuest() {

        return false;
    }

    public function languageList() {
        
        return array(
            'Spanish' => 'Spanish', 
            'English' => 'English', 
            'Korean' => 'Korean'
        );
    }

    public function cityList() {
        
        return array(
            'Seoul' => 'Seoul', 
            'New York' => 'New York', 
            'Manila' => 'Manila'
        );
    }

    public function getProfilePictureUrl($size = array("width" => 200, "height" => 200)) {

        if($this->getFacebookId() === User::userWithNoFacebookAccount)
            return User::getGuestProfilePictureUrl($size);

        return "https://graph.facebook.com/" . $this->getFacebookId() . "/picture?width=200&height=200";
    }


    public static function getProfilePictureUrlWithId($userId, $size = array("width" => 200, "height" => 200)) {

        if(User::getFacebookIdWithId($userId) === User::userWithNoFacebookAccount)
            return User::getGuestProfilePictureUrl($size);

        return "https://graph.facebook.com/" .
            User::getFacebookIdWithId($userId) .
            "/picture?width=" .
            $size['width'] .
            "&height=" .
            $size['height'];
    }

    public static function getGuestProfilePictureUrl($size)
    {
        return User::GUEST_PROFILE_PICTURE_URL . $size['width'] . '.png';
    }


    private function getFacebookId() {

        $facebookAccount = DB::table('social_facebook_accounts')->where('user_id', $this->id)->first();

        if(isset($facebookAccount))
            return $facebookAccount->provider_user_id;
        else
            return User::userWithNoFacebookAccount;
    }


    private static function getFacebookIdWithId(string $userId)
    {

        $facebookAccount = DB::table('social_facebook_accounts')->where('user_id', $userId)->first();

        if(isset($facebookAccount))
            return $facebookAccount->provider_user_id;
        else
            return User::userWithNoFacebookAccount;
    }

    public static function getUserNameWithId(string $userId)
    {
        return User::where('id', $userId)->first()->name;
    }
}