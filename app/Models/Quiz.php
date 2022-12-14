<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;


class Quiz extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded  = ['id'];
    protected $dates    = ['finished_at'];
    protected $appends  = ['details', 'my_rank'];
    protected $fillable = ['title', 'description', 'slug', 'status'];

    //relacion uno a uno inversa
    public function lesson(){
        return $this->belongsTo('App\Models\Lesson');

    }

    public function getFinishedAtAttributes($date) {
        return $date ? Carbon::parse($date) : null;
    }

    public function questions() {
        return $this->hasMany('App\Models\Question');
    }

    public function myResult() {
        return $this->hasOne('App\Models\Result')->where('user_id', auth()->user()->id);
    }

    public function results() {
        return $this->hasMany('App\Models\Result');
    }

    public function getDetailsAttribute() {
        if ($this->results()->count() > 0) {
            return [
                'average'=>round($this->results()->avg('point')),
                'join_count'=>$this->results()->count()
            ];
        }

        return null;
    }

    public function topTenUser() {
        return $this->results()->orderByDesc('point')->take(10);
    }

    public function getMyRankAttribute() {
        $rank = 0;

        foreach($this->results()->orderByDesc('point')->get() as $result) {
            $rank += 1;
            if(auth()->user()->id == $result->user_id) {
                return $rank;
            }
        }
    }

    /**
    * Return the sluggable configuration array for this model.
    *
    * @return array
    */
   public function sluggable()
    {
        return [
            'slug' => [ //slug => databse table - column name
                'source' => 'title' //title => column that will slug
            ]
        ];
    }

}
