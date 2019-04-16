<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'isp', 'satisfaction', 'lat', 'long'
    ];

    protected $appends = array('score');

    public function getScoreAttribute()
    {
        return substr($this->satisfaction, 0, 1);
    }

    /**
     * Is this respondent within the range of another Respondent
     * (default range 2 km)
     * (units are metres)
     */
    public function inRange(Respondent $other, $range=3200)
    {
        return $this->distanceFrom($other) < $range;
    }

    public function distanceFrom(Respondent $other)
    {
        return $this->haversineGreatCircleDistance(
            floatval($this->lat),
            floatval($this->long),
            floatval($other->lat),
            floatval($other->long)
        );
    }

    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    function haversineGreatCircleDistance(
      $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
      // convert from degrees to radians
      $latFrom = deg2rad($latitudeFrom);
      $lonFrom = deg2rad($longitudeFrom);
      $latTo = deg2rad($latitudeTo);
      $lonTo = deg2rad($longitudeTo);

      $latDelta = $latTo - $latFrom;
      $lonDelta = $lonTo - $lonFrom;

      $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
      return $angle * $earthRadius;
    }

}
