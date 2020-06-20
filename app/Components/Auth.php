<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/15/2020
 * Time: 7:22 PM
 */

namespace App\Components;

use App\Models\UserType;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use \Illuminate\Support\Facades\Validator;
use App\Components\Util;
use App\Models\User;
use App\Models\LocalAuth;

class Auth
{
    const CACHE_PREFIX = 't_token.';
    const DEFAULT_TIMEOUT = 30000; // in minutes

    const LABEL_ID = 'id';
    const LABEL_EMAIL = 'email';
    const LABEL_TYPE = 'type';
    const LABEL_ROLE = 'role';
    const LABEL_ORGANISATION_ID = 'organisation_id';
    const LABEL_TYPE_NAME = 'type_name';

    protected $token;
    protected $id;
    protected $type;
    protected $email;
    protected $role;
    protected $organisation_id;

    protected $filled = false;
    protected $loaded = false;

    public function __construct($token, $load_from_cache = true, $extend_time = true)
    {
        $this->token = $token;

        if ($load_from_cache) {
            $this->load($extend_time);
        }
    }

    public function getToken()
    {
        return $this->token;
    }

    /**
     * The actual token stored in the cache. It has the cache prefix.
     * @return string
     */
    public function getFullToken()
    {
        return self::CACHE_PREFIX . $this->token;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTypeName()
    {
        return UserType::$label_map[$this->getType()];
    }

    /**
     * @return integer
     */
    public function getTypeId()
    {
        return UserType::$type_map[$this->getType()];
    }


    public function getEmail()
    {
        return $this->email;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getOrganisationId()
    {
        return $this->organisation_id;
    }

    public function isFilled()
    {
        return $this->filled;
    }

    public function isLoaded()
    {
        return $this->loaded;
    }

    public function destroy()
    {
        Cache::forget($this->getFullToken());
    }

    public function getData()
    {
        return [
            self::LABEL_ID => $this->id,
            self::LABEL_EMAIL => $this->email,
            self::LABEL_TYPE => $this->type,
            self::LABEL_ROLE => $this->role,
            self::LABEL_ORGANISATION_ID => $this->organisation_id
        ];
    }

    /**
     * Fill the Auth instance with the cached/to be cached data
     * @param array $data
     * @return bool
     */
    protected function fill($data)
    {
        $validation = Validator::make($data, [
            self::LABEL_ID => 'required|numeric',
            self::LABEL_EMAIL => 'email',
            self::LABEL_TYPE => 'required',
        ]);

        if ($validation->fails()){
            $this->filled = false;
            return false;
        }

        $this->id = $data[self::LABEL_ID];
        $this->email = $data[self::LABEL_EMAIL];
        $this->type = $data[self::LABEL_TYPE];
        $this->organisation_id = empty($data[self::LABEL_ORGANISATION_ID]) ? null : $data[self::LABEL_ORGANISATION_ID];
        $this->role = (empty($data[self::LABEL_ROLE])) ? null : $data[self::LABEL_ROLE];

        $this->filled = true;
        return true;
    }

    protected function load($extend_life = true)
    {
        $json_data = Cache::get($this->getFullToken());

        if (empty($json_data)){
            $this->loaded = false;
            return false;
        }

        if ($this->fill(json_decode($json_data, true))){
            if ($extend_life) {
                Cache::put($this->getFullToken(), $json_data, self::DEFAULT_TIMEOUT);
            }
            $this->loaded = true;
            return true;
        }
        $this->loaded = false;
        return false;
    }

    /**
     * Saves the Auth data in cache
     */
    protected function save()
    {
        $json_data = json_encode($this->getData());
        Cache::put($this->getFullToken(), $json_data, self::DEFAULT_TIMEOUT);
    }


    /**
     * Creates an Auth Instance using a User
     * @param User $user
     * @param LocalAuth $auth
     * @return Auth|null
     * @throws Exception
     */
    public static function createForUser(User $user, LocalAuth $auth)
    {
        if (env('APP_ENV') == 'production') {
//            $exists = !empty(Redis::keys('laravel:' . self::CACHE_PREFIX . $user->getType() . '.' . $user->id . '.*'));
//            if ($exists) {
//                throw new CustomException('Already logged in somewhere else.', ErrorCode::ACCESS_DENIED);
//            }
        }

        return self::create([
            self::LABEL_ID => $user->id,
            self::LABEL_EMAIL => $user->getContactInfo('email'),
            self::LABEL_TYPE => $user->getType(),
            self::LABEL_ROLE => $user->getRole(),
            self::LABEL_ORGANISATION_ID => $user->organisation_id,
            self::LABEL_TYPE_NAME => $user->getTypeName()
        ]);
    }

    /**
     * Creates an Auth Instance
     * @param $data
     * @return Auth|null
     */
    public static function create($data)
    {
        $identifier = $data[self::LABEL_TYPE] . '.' . $data[self::LABEL_TYPE_NAME] . '.';
        $token = Util::generateToken(self::CACHE_PREFIX, $identifier);

        if (empty($token)){
            return null;
        }

        $auth = new self($token, false);
        if (!$auth->fill($data)){
            return null;
        }

        $auth->save();

        return $auth;
    }

    public static function createNonCached($data)
    {
        $auth = new self(null, false, false);
        $auth->fill($data);
        return $auth;
    }
}