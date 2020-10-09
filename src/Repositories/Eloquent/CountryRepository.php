<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\CountryRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\Country;

class CountryRepository extends BaseRepository implements CountryRepositoryContract
{
    /**
     * @var Country
     */
    protected $country;

    /**
     * CountryRepository constructor.
     *
     * @param Country $country
     */
    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    public function modelClass(): string
    {
        return Country::class;
    }

    public function model(): Model
    {
        return $this->country;
    }
}
