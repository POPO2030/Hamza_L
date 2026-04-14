<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Flash;
use Auth;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CRM\Team;
use App\Models\Role;

class UserController extends AppBaseController
{
    /** @var UserRepository $userRepository*/
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param UserDataTable $userDataTable
     *
     * @return Response
     */
    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('users.index');
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
          if (auth()->user()->team_id == 11) {
            // For team ID 11
            $teams = Team::whereNotIn('id', [1, 10, 13])->pluck('name', 'id');
            $roles=Role::whereNotIn('id', [1, 9, 13,18])->pluck('name','id');
            
        } elseif (auth()->user()->team_id  == 13) {
            // For team ID 13
            $teams = Team::whereIn('id', [10, 13])->pluck('name', 'id');
            $roles=Role::whereIn('id', [9, 13,18])->pluck('name', 'id');

        } elseif (auth()->user()->team_id  == 1) {
            // For team ID 1, get all teams
            $teams = Team::pluck('name', 'id');
            $roles=Role::pluck('name','id');

        }
      
    return view('users.create')->with(['teams'=>$teams,'roles'=>$roles]);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $user = $this->userRepository->create(
            [
                'name' => $input['name'],
                'username' => $input['username'],
                'team_id' => $input['team_id'],
                'role_id' => $input['role_id'],
                'password' => Hash::make($input['password']),
            ]
        );

        Flash::success('تنبيه...تم حفظ المستخدم بنجاح.');

        return redirect(route('users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('عفوآ...لم يتم العثور على المستخدم');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('عفوآ...لم يتم العثور على المستخدم');

            return redirect(route('users.index'));
        }

           if (auth()->user()->team_id == 11) {
            // For team ID 11
            $teams = Team::whereNotIn('id', [1, 10, 13])->pluck('name', 'id');
             $roles=Role::whereNotIn('id', [1, 9, 13,18])->pluck('name','id');
        } elseif (auth()->user()->team_id  == 13) {
            // For team ID 13
            $teams = Team::whereIn('id', [10, 13])->pluck('name', 'id');
            $roles=Role::whereIn('id', [9, 13,18])->pluck('name', 'id');
        } else  {
            // For team ID 1, get all teams
            $teams = Team::pluck('name', 'id');
            $roles=Role::pluck('name','id');
        }
        return view('users.edit')->with(['user'=>$user,'teams'=>$teams,'roles'=>$roles]);
       
    }

    /**
     * Update the specified User in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('عفوآ...لم يتم العثور على المستخدم');

            return redirect(route('users.index'));
        }

        if (Auth::user()->team_id == 1|| Auth::user()->team_id == 11 || Auth::user()->team_id == 13){
        $user = $this->userRepository->update(   [
            'name' => $request['name'],
            'username' => $request['username'],
            'team_id' => $request['team_id'],
            'role_id' => $request['role_id'],
            'password' => Hash::make($request['password']),
        ], $id);
            Flash::success('تنبيه...تم تعديل المستخدم بنجاح.');
        return redirect(route('users.index'));
        }else{
            $user = $this->userRepository->update(   [
                'password' => Hash::make($request['password']),
            ], $id);

            Flash::success('تنبيه...تم تعديل المستخدم بنجاح.');
            return redirect(route('home'));
        }
      



    }

    /**
     * Remove the specified User from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('عفوآ...لم يتم العثور على المستخدم');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('تم الحذف المستخدم بنجاح');

        return redirect(route('users.index'));
    }
}
