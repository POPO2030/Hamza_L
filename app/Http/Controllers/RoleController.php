<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\User;

class RoleController extends AppBaseController
{
    /** @var RoleRepository $roleRepository*/
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepository = $roleRepo;
    }

    /**
     * Display a listing of the Role.
     *
     * @param RoleDataTable $roleDataTable
     *
     * @return Response
     */
    public function index(RoleDataTable $roleDataTable)
    {
        return $roleDataTable->render('roles.index');
    }

    /**
     * Show the form for creating a new Role.
     *
     * @return Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param CreateRoleRequest $request
     *
     * @return Response
     */
    public function store(CreateRoleRequest $request)
    {
        
        $input = $request->all();
        $input['permissions']=json_encode($request->permissions);

        $role = $this->roleRepository->create($input);
        Flash::success('تنبيه...تم حفظ الصلاحيات بنجاح.');

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified Role.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            Flash::error('عفوآ...لم يتم العثور على الصلاحيات');

            return redirect(route('roles.index'));
        }

        return view('roles.show')->with('role', $role);
    }

    /**
     * Show the form for editing the specified Role.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->find($id);
        if (empty($role)) {
            Flash::error('عفوآ...لم يتم العثور على الصلاحيات');

            return redirect(route('roles.index'));
        }
        return view('roles.edit')->with('role', $role);
    }

    /**
     * Update the specified Role in storage.
     *
     * @param int $id
     * @param UpdateRoleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoleRequest $request)
    {
        $role = $this->roleRepository->find($id);
        if (empty($role)) {
            Flash::error('عفوآ...لم يتم العثور على الصلاحيات');

            return redirect(route('roles.index'));
        }
        $input = $request->all();
        $input['permissions']=json_encode($request->permissions);
        $role = $this->roleRepository->update($input, $id);

        Flash::success('تنبيه...تم تعديل الصلاحيات بنجاح.');

        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            Flash::error('عفوآ...لم يتم العثور على الصلاحيات');

            return redirect(route('roles.index'));
        }

        
        $check = User::where('role_id',$id)->get();
        
        if(count($check)>0){
            Flash::error('عفوا...لا يمكن حذف الصلاحية لارتباطها بمستخدمين ');

            return redirect(route('customers.index'));
        }
        $this->roleRepository->delete($id);

        Flash::success('تنبيه...تم حذف الصلاحيات بنجاح..');

        return redirect(route('roles.index'));
    }
}
