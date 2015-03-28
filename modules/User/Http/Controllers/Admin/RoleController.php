<?php namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\User\Entities\Role;
use Modules\User\Http\Requests\RoleFormRequest;
use Vain\Http\Controllers\Controller;

class RoleController extends Controller {

    public function index()
    {
        $roles = Role::paginate();

        return view('user::admin.roles.index')
            ->with('roles', $roles);
    }

    public function create()
    {
        return view('user::admin.roles.create');
    }

    public function store(RoleFormRequest $request)
    {
        Role::create($request->all());

        return $this->createDefaultResponse($request);
    }

    public function show($id)
    {
        /** @var User $user */
        $role = Role::find($id);

        return view('user::admin.roles.edit')
            ->with('role', $role);
    }

    public function update(RoleFormRequest $request, $id)
    {
        $role = Role::find($id);

        $role->fill($request->all());
        $role->save();

        return $this->createDefaultResponse($request);
    }

    public function destroy(Request $request, $id)
    {
        // todo protect system roles?

        Role::find($id)->delete();

       return $this->createDefaultResponse($request);
    }

    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function createDefaultResponse($request)
    {
        if ($request->ajax()) {
            // very default response, we basicly just need the response code
            return response('', 200);
        }

        return redirect()->route('user.admin.roles.index');
    }
}