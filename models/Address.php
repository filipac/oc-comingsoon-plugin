<?php
namespace Filipac\Comingsoon\Models;

use Filipac\Comingsoon\Classes\ThemeYaml;
use Illuminate\Support\Arr;

class Address extends ThemeYaml
{
    public function getAddressesAttribute()
    {
        return collect(Arr::get($this->attributes, 'data.addresses', []));
    }

    public function add($email)
    {
        if(!$this->addresses->contains($email)) {
            $this->addresses = $this->addresses->push($email);
        }
    }

    public function remove($email)
    {
        if($this->addresses->contains($email)) {
            $index = $this->addresses->search($email);
            $this->addresses = $this->addresses->forget($index);
        }
    }
}
