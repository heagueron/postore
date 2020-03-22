<?php

namespace App\Policies;

use App\TwitterProfile;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TwitterProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any twitter profiles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the twitter profile.
     *
     * @param  \App\User  $user
     * @param  \App\TwitterProfile  $twitterProfile
     * @return mixed
     */
    public function view(User $user, TwitterProfile $twitterProfile)
    {
        //
    }

    /**
     * Determine whether the user can create twitter profiles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return empty( $user->twitter_profiles->all() );
    }

    /**
     * Determine whether the user can update the twitter profile.
     *
     * @param  \App\User  $user
     * @param  \App\TwitterProfile  $twitterProfile
     * @return mixed
     */
    public function update(User $user, TwitterProfile $twitterProfile)
    {
        //
    }

    /**
     * Determine whether the user can delete the twitter profile.
     *
     * @param  \App\User  $user
     * @param  \App\TwitterProfile  $twitterProfile
     * @return mixed
     */
    public function delete(User $user, TwitterProfile $twitterProfile)
    {
        //
    }

    /**
     * Determine whether the user can restore the twitter profile.
     *
     * @param  \App\User  $user
     * @param  \App\TwitterProfile  $twitterProfile
     * @return mixed
     */
    public function restore(User $user, TwitterProfile $twitterProfile)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the twitter profile.
     *
     * @param  \App\User  $user
     * @param  \App\TwitterProfile  $twitterProfile
     * @return mixed
     */
    public function forceDelete(User $user, TwitterProfile $twitterProfile)
    {
        //
    }
}
