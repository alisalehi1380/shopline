<?php

namespace Modules\RolePermission\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\RolePermission\Http\Requests\RolePermissionRequest;
use Modules\RolePermission\Models\Permission;
use Modules\RolePermission\Repositories\RolePermissionRepo;
use Modules\RolePermission\Services\RolePermissionService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Responses\AjaxResponses;
use Modules\Share\Services\ShareService;

class RolePermissionController extends Controller
{
    private string $class = Permission::class;

    public RolePermissionRepo $repo;
    public RolePermissionService $service;

    public function __construct(RolePermissionService $rolePermissionService, RolePermissionRepo $permissionRepo)
    {
        $this->repo = $permissionRepo;
        $this->service = $rolePermissionService;
    }

    /**
     * Get latest roles.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('manage', $this->class);
        $roles = $this->repo->index()->paginate(10);

        return view('RolePermission::index', compact('roles'));
    }

    /**
     * Create page for role.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('manage', $this->class);
        $permissions = $this->repo->getAllPermissions();

        return view('RolePermission::create', compact('permissions'));
    }

    /**
     * Store role with redirect.
     *
     * @param  RolePermissionRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(RolePermissionRequest $request)
    {
        $this->authorize('manage', $this->class);
        $this->service->store($request);

        return $this->successMessageWithRedirect('Create role');
    }

    /**
     * Edit role by id.
     *
     * @param  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function edit($id)
    {
        $this->authorize('manage', $this->class);
        $role = $this->repo->findById($id);
        $permissions = $this->repo->getAllPermissions();

        return view('RolePermission::edit', compact(['role', 'permissions']));
    }

    /**
     * Update role by id.
     *
     * @param RolePermissionRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(RolePermissionRequest $request, $id)
    {
        $this->authorize('manage', $this->class);
        $this->service->update($request, $id);

        return $this->successMessageWithRedirect('Update role');
    }

    /**
     * Delete role by id.
     *
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $this->authorize('manage', $this->class);
        $this->repo->delete($id);

        return AjaxResponses::SuccessResponse();
    }

    /**
     * Show success message with redirect.
     *
     * @param  string $title
     * @return RedirectResponse
     */
    private function successMessageWithRedirect(string $title)
    {
        ShareService::successToast($title);
        return to_route('role-permissions.index');
    }
}