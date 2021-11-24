<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
        "execution",
        "status",
        "creator",
        "responsible_person",
        "expiration_date",
    ];

    public function scopeFilterDate($query, $date)
    {
        switch ($date){
            case("today"):
                return $query->whereDate('expiration_date', '=', today()->toDateString())
                             ->where('responsible_person', '=', auth()->user()->id);
            case("week"):
                return $query->whereDate('expiration_date', '>', today()->toDateString())
                             ->whereDate('expiration_date', '<=', today()->addWeek()->toDateString())
                             ->where('responsible_person', '=', auth()->user()->id);
            case("more"):
                return $query->whereDate('expiration_date', '>', today()->addWeek()->toDateString())
                             ->where('responsible_person', '=', auth()->user()->id);
        }
    }

    public function scopeFilterByUser($query, $user)
    {
        $subordinates = User::subordinates(auth()->user()->id)->get();
        $filterUser = $subordinates->firstWhere("id", $user);
        if ($filterUser) {
            return $query->where('responsible_person', '=', $filterUser->id);
        }
    }
}
