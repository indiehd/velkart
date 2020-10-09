<?php

namespace IndieHD\Velkart\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use IndieHD\Velkart\Contracts\Repositories\Eloquent\AddressRepositoryContract;
use IndieHD\Velkart\Models\Eloquent\Address;

class AddressRepository extends BaseRepository implements AddressRepositoryContract
{
    /**
     * @var Address
     */
    protected $address;

    /**
     * AddressRepository constructor.
     *
     * @param Address $address
     */
    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function modelClass(): string
    {
        return Address::class;
    }

    public function model(): Model
    {
        return $this->address;
    }
}
