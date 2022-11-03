<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CompanyLead;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyLeadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the companyLead can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the companyLead can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CompanyLead  $model
     * @return mixed
     */
    public function view(User $user, CompanyLead $model)
    {
        return true;
    }

    /**
     * Determine whether the companyLead can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the companyLead can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CompanyLead  $model
     * @return mixed
     */
    public function update(User $user, CompanyLead $model)
    {
        return true;
    }

    /**
     * Determine whether the companyLead can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CompanyLead  $model
     * @return mixed
     */
    public function delete(User $user, CompanyLead $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CompanyLead  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the companyLead can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CompanyLead  $model
     * @return mixed
     */
    public function restore(User $user, CompanyLead $model)
    {
        return false;
    }

    /**
     * Determine whether the companyLead can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\CompanyLead  $model
     * @return mixed
     */
    public function forceDelete(User $user, CompanyLead $model)
    {
        return false;
    }
}
