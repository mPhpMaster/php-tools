<?php
/**
 * Copyright © 2020 mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */


if ( !function_exists('app_name') ) {
    /**
     * Get app name from setting by locale
     *
     * @param null $locale
     *
     * @return string
     * @todo: change $res as the project
     */
    function app_name($locale = null)
    {
        //!$locale && ($locale = app()->getLocale());
        $res = config('app.name'); //setting("app_name_{$locale}", config('app.name'));
        return (string)is_string($res) ? $res : "";
    }
}

if ( !function_exists('app_version') ) {
    /**
     * Get App Version ENV
     *
     * @return string
     * @todo: change $res as the project
     */
    function app_version()
    {
        $res = config('app.version'); //setting("app_version", config('app.version'));
        return (string)is_string($res) ? $res : "";
    }
}

if ( !function_exists('app_currency') ) {
    /**
     * Get App currency
     *
     * @return string
     * @todo: change $res as the project
     */
    function app_currency()
    {
        $res = config('app.currency'); // setting('currency_code', config('app.currency'));
        return (string)is_string($res) ? $res : "";
    }
}

if ( !function_exists('app_number_format') ) {
    /**
     * @param double|int|string $number
     * @param double|int|null   $decimals
     * @param string|null       $currency
     *
     * @return string
     */
    function app_number_format($number, $decimals = null, $currency = null)
    {
        return (string)to_number_format($number, $decimals ?? 2, $currency ?? app_currency());
    }
}

if ( !function_exists('app_url') ) {
    /**
     * @param string $default
     *
     * @return string
     */
    function app_url($default = "//")
    {
        return (string)config("app.url", $default);
    }
}

if ( !function_exists('app_frontend_url') ) {
    /**
     * @param string $default
     *
     * @return string
     */
    function app_frontend_url($default = "//")
    {
        return (string)config("app.app_frontend_url", app_url($default));
    }
}

/** @noinspection ClassConstantCanBeUsedInspection */
if ( !function_exists('User') ) {
    /**
     * get Auth::User, current logged in user
     *
     * @param int|\User|\AuthUser|bool|null $id
     *
     * @return \User
     * @todo: add ('User'  => \App\Models\User::class,) at the end of app.aliases config
     * @todo: add ('AuthUser'  => \Illuminate\Foundation\Auth\User::class,) at the end of app.aliases config
     * @todo: change $auth_user
     */
    function User($id = false)
    {
        $auth_user = \Auth::user() ?? \Auth::getUser() ?? app('auth')->user() ?? auth()->user();
        if ( !is_null($id) && $id !== false && !($id instanceof \AuthUser) )
            $user = hasTrait(\User::class, \App\Traits\HasActiveTrait::class) ? \User::ActiveOnly()->find(intval($id)) : \User::find(intval($id));
        elseif ( is_null($id) )

            $user = new \User();
        elseif ( $id instanceof \AuthUser )
            $user = User($id->id);
        else
            $user = $auth_user ?: new \User();
        //            $user = app('auth')->user() ?: new \User();

        if ( $user && $user instanceof \AuthUser ) {
            $user = $user->id ? \User::find($user->id) : \User::make(valueToArray($user));
        }

        return $user/* ?: new App\User()*/ ;
    }
}

if ( !function_exists('str') ) {
    /**
     * @param \Illuminate\Support\Stringable|string $string
     *
     * @return \Illuminate\Support\Stringable
     */
    function str($string)
    {
        return $string instanceof \Illuminate\Support\Stringable ? $string : \Illuminate\Support\Str::of($string);
    }
}

if ( !function_exists('whenAuthNot') ) {
    /**
     * @param int|\User|\AuthUser|bool|null $user
     * @param callable|null $true_callback
     * @param callable|null $false_callback
     *
     * @return bool
     */
    function whenAuthNot($user = null, $true_callback = null, $false_callback = null)
    {
        return whenAuth($user, $false_callback, $true_callback) === false;
    }
}

if ( !function_exists('whenAuth') ) {
    /**
     * @param int|\User|\AuthUser|bool|null $user
     * @param callable|null $true_callback
     * @param callable|null $false_callback
     *
     * @return bool
     * @todo: change $confirmed to check if the given user is authenticated
     */
    function whenAuth($user = null, $true_callback = null, $false_callback = null)
    {
        try {
            $confirmed = User($user??false);
        } catch (Exception $exception) {
            /** @noinspection ForgottenDebugOutputInspection */
            d($exception);
        }

        if ( $confirmed && $true_callback ) {
            getValue($true_callback, $user);
        }

        if ( !$confirmed && $false_callback ) {
            getValue($false_callback, $user);
        }

        return (bool)$confirmed;
    }
}

if ( !function_exists('whenAdmin') ) {
    /**
     * @param callable|mixed|null $true_callback
     * @param callable|mixed|null $false_callback
     *
     * @return bool
     * @todo: change $is_admin
     */
    function whenAdmin($true_callback = null, $false_callback = null)
    {
        $user = User(false);
        $is_admin = $user && $user->id === 1; //$user->isAdmin();

        if ( $user ) {
            if ( $is_admin && $true_callback ) {
                return getValue($true_callback, $user, $is_admin);
            }

            if ( !$is_admin && $false_callback ) {
                return getValue($false_callback, $user, $is_admin);
            }
        }

        return $is_admin;
    }
}

if ( !function_exists('whenNotSupport') ) {
    /**
     * @param callable|mixed|null $true_callback
     * @param callable|mixed|null $false_callback
     *
     * @return bool
     */
    function whenNotSupport($true_callback = null, $false_callback = null)
    {
        return whenSupport($false_callback, $true_callback) === false;
    }
}

if ( !function_exists('whenSupport') ) {
    /**
     * @param callable|mixed|null $true_callback
     * @param callable|mixed|null $false_callback
     *
     * @return bool
     * @todo: change $is_support
     */
    function whenSupport($true_callback = null, $false_callback = null)
    {
        $user = User(false);
        $is_support = false;

        if ( $user ) {
            $is_support = $user->id === 1; //$user->isSupport();

            if ( $is_support && $true_callback ) {
                getValue($true_callback, $user, $is_support);
            }

            if ( !$is_support && $false_callback ) {
                getValue($false_callback, $user, $is_support);
            }
        }

        return $is_support;
    }
}

if ( !function_exists('isSupport') ) {
    /**
     * @param int|\User|null $user
     *
     * @return bool
     * @todo: change return
     */
    function isSupport($user = null)
    {
        $user = User($user ?? false);

        return $user && $user->id === 1; //$user->isSupport();
    }
}

if ( !function_exists('isAdmin') ) {
    /**
     * @param int|\User|null $user
     *
     * @return bool
     * @todo: change return
     */
    function isAdmin($user = null)
    {
        $user = User($user ?: false);

        return $user && $user->id === 1; //$user->isAdmin();
    }
}

if ( !function_exists('isNotAdmin') ) {
    /**
     * @param int|\User|null $user
     *
     * @return bool
     */
    function isNotAdmin($user = null)
    {
        return !isAdmin($user);
    }
}

if ( !function_exists('whenAdmin') ) {
    /**
     * @param Closure|null $true
     * @param Closure|null $false
     *
     * @return mixed
     */
    function whenAdmin(Closure $true = null, Closure $false = null)
    {
        $true = $true ?: returnTrue();
        $false = $false ?: returnFalse();
        $return = isAdmin() ? $true : $false;

        return value($return ?: $false);
    }
}

if ( !function_exists("UserId") ) {
    /**
     *
     * @param int|null $default
     *
     * @return null|int|mixed
     * @todo: change $default argument value
     * @todo: change $user
     */
    function UserId($default = 1)
    {
        $user = User();
        if ( !$user ) return $default;

        return $user->id ?: $default;
    }
}

if ( !function_exists("CreateUserLogColumnsForMigrations") ) {
    /**
     * **DEV ONLY**
     * Create User Log Columns For Migrations
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    function CreateUserLogColumnsForMigrations(\Illuminate\Database\Schema\Blueprint $table, $with_deleted_by = false)
    {
        $table->unsignedInteger('created_by');
        $table->unsignedInteger('updated_by')->nullable()->default(0);
        $with_deleted_by && $table->unsignedInteger('deleted_by')->nullable()->default(0);
    }
}

if ( !function_exists('fromCallable') ) {
    /**
     * @param $callable
     *
     * @return \Closure
     */
    function fromCallable($callable)
    {
        return isClosure($callable) ? $callable : Closure::fromCallable($callable);
    }
}

if ( !function_exists('applySimpleWhere') ) {
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed                                 $value
     * @param mixed|null                            $key
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    function applySimpleWhere(\Illuminate\Database\Eloquent\Builder $query, $value, $key = null)
    {
        $key = $key ?? "id";
        $where = is_array($value) ? "whereIn" : "where";
        return $query->{$where}($key, $value);
    }
}

if ( !function_exists('fixMobileNumber') ) {
    /**
     * @param string $value
     *
     * @return string
     * @todo: check $value
     */
    function fixMobileNumber($value)
    {
        if ( empty($value) ) {
            return "";
        }

        $value = starts_with($value, "5") ? "0{$value}" : $value;
        $value = starts_with($value, "05") ? $value : "05{$value}";
        return $value;
    }
}
