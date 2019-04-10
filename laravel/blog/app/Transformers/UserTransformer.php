<?php

use League\Fractal\TransformerAbstract;
use App\Model\User;

class UserTransformer extends TransformerAbstract
{
    /**
     * Set single element
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int) $user->id,
            'name' => (string) $user->name,
            'full_name' => (string) $user->email,
            'email' => (string) $user->address,
            'permissions' => (array) $user->permissions
        ];
    }
}
