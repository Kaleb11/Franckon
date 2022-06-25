<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventorydata extends Model
{
    protected $fillable = ['id','itemType','measurenment','quantity','withPurchase','resetImage',
    'fromStore','adminOneApproval','adminTwoApproval','approved','purchasedCompany','bought','delivered','undelivered','orderReason','urgent','status','category_id','deliverdTime','requestUserId','requestUserName'];
    // public function categorydata(){
    //     return $this->belongsTo(Category::class,'category_id');
    // }
}
