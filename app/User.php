<?php
/**
 *
 * @category zStarter
 *
 * @ref zCURD
 * @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */

namespace App;

use App\Traits\HasPagination;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Scanlog;
use App\Models\WalletLog;
use App\Models\Country;
use App\Models\Category;
use App\Models\State;
use App\Models\City;
use App\Models\Availability;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasRoles, HasPagination;
     use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $table = 'users';


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'name'
    ];

    public function stories()
    {
        return $this->hasMany(Story::class);
    }
    // public function getTableColumns() {
    //     return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    // }

    public function get_roles()
    {
        $roles = [];
        foreach ($this->getRoleNames() as $key => $role) {
            $roles[$key] = $role;
        }

        return $roles;
    }

    public function getDisplayName()
    {

        if ($this->first_name != null) {
            $name = ucwords($this->first_name);
            if ($this->last_name != null) {
                $name .= $this->last_name;
            }
        } else {
            $name = "Not Available";
        }
        return $name;
    }

    public function scopeNotRole(Builder $query, $roles, $guard = null): Builder
    {
        if ($roles instanceof Collection) {
            $roles = $roles->all();
        }

        if (!is_array($roles)) {
            $roles = [$roles];
        }

        $roles = array_map(function ($role) use ($guard) {
            if ($role instanceof Role) {
                return $role;
            }

            $method = is_numeric($role) ? 'findById' : 'findByName';
            $guard = $guard ?: $this->getDefaultGuardName();

            return $this->getRoleClass()->{$method}($role, $guard);
        }, $roles);

        return $query->whereHas('roles', function ($query) use ($roles) {
            $query->where(function ($query) use ($roles) {
                foreach ($roles as $role) {
                    $query->where(config('permission.table_names.roles') . '.id', '!=', $role->id);
                }
            });
        });
    }

    /**
     * Get avatar attribute with full path
     *
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        $avatar = !is_null($value) ? asset('storage/backend/users/' . $value) : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=19B5FE&color=ffffff&v=19B5FE';
        // dd($avatar);
        if (\Str::contains(request()->url(), '/api/vi')) {
            return asset($avatar);
        }
        return $avatar;
    }

    public function getNameAttribute()
    {
        return ucwords($this->first_name . " " . $this->last_name);
    }

    public function scopeRole(Builder $query, $roles, $guard = null): Builder
    {
        if ($roles instanceof Collection) {
            $roles = $roles->all();
        }

        if (!is_array($roles)) {
            $roles = [$roles];
        }

        $roles = array_map(function ($role) use ($guard) {
            if ($role instanceof Role) {
                return $role;
            }

            $method = is_numeric($role) ? 'findById' : 'findByName';
            $guard = $guard ?: $this->getDefaultGuardName();

            return $this->getRoleClass()->{$method}($role, $guard);
        }, $roles);

        return $query->whereHas('roles', function ($query) use ($roles) {
            $query->where(function ($query) use ($roles) {
                foreach ($roles as $role) {
                    $query->where(config('permission.table_names.roles') . '.id', '=', $role->id);
                }
            });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function score()
    {
        return $this->hasMany(WalletLog::class, 'user_id','id');
    }

    public function followup()
    {
        return $this->hasMany(FollowUp::class, 'user_id');
    }


    public function countryData()
    {
        return $this->belongsTo(Country::class, 'country');
    }

    public function stateData()
    {
        return $this->belongsTo(State::class, 'state');
    }

    public function cityData()
    {
        return $this->belongsTo(City::class, 'city');
    }

    public function isActive()
    {
        return $this->status == 1;
    }

    public function isInactive()
    {
        return $this->status == 0;
    }
    public function speciality()
    {
       return $this->belongsTo(Category::class, 'speciality') ?? '';
    }
    public function schedules()
    {
       return $this->hasMany(Availability::class,'user_id','id') ?? '';
    }
   

}


