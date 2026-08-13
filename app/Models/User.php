<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'mobile_verified', 'avatar', 'national_code',
        'last_ip', 'last_agent', 'is_active', 'subscribe', 'city', 'province_id',
        'is_admin',
        'address', 'zip_code', 'role_id', 'referral_id', 'referral_code', 'authenticated', 'ban',
    ];

    private array $report_fields = [
        'id', 'name', 'mobile', 'email', 'national_code', 'email_verified_at', 'referral_code',
        'mobile_verified', 'created_at', 'deleted_at', 'authenticated', 'role_id',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function all_items($search_text = '', int $perPage = 10): object
    {
        return $this->when($search_text, function ($query, $search_text) {
            $query->where('name', 'like', '%'.$search_text.'%')
                ->orWhere('mobile', 'like', '%'.$search_text.'%')
                ->orWhere('national_code', 'like', '%'.$search_text.'%');
        })
            ->where('role_id', '>', 2)
            ->orderBy('id', 'desc')
            ->with(['role:id,name'])
            ->paginate($perPage, $this->report_fields)->withQueryString();
    }

    public function trash_items($search_text = '', int $perPage = 10): object
    {
        return $this->onlyTrashed()
            ->when($search_text, function ($query, $search_text) {
                $query->where('name', 'like', '%'.$search_text.'%')
                    ->orWhere('mobile', 'like', '%'.$search_text.'%')
                    ->orWhere('national_code', 'like', '%'.$search_text.'%');
            })
            ->where('role_id', '>', 2)
            ->orderBy('id', 'desc')
            ->with(['role:id,name'])
            ->paginate($perPage, $this->report_fields)->withQueryString();
    }
}
