<?php

namespace App\Models;

use App\Traits\HasPagination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletLog extends Model
{
    use HasFactory, HasPagination;

    protected $guarded = ['id'];

    public const SCAN_REWARD = 'ScanReward';
    public const SCAN_SUPER_BONUS = 'ScanSuperBonus';
    public const SUBSCRIPTION_REWARD = 'SubscriptionReward';
    public const SUBSCRIPTION_SUPER_BONUS = 'SubscriptionSuperBonus';
    public const INVITE_SUPER_BONUS = 'InviteSuperBonus';
    public const UPLOAD_BONUS = 'UploadBonus';

}
