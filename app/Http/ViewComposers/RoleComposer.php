<?php

namespace App\Http\ViewComposers;

use App\Repositories\UserRepository;
use Illuminate\View\View;
use App\Models\Role;

class RoleComposer
{
  protected $roles;

  public function __construct(Role $roles)
  {
    $this->roles = $roles;
  }

  public function compose()
  {
    $view->with('roles', $this->roles->all());
  }
}
