<?php

namespace App\Http\Controllers\CRM;

use App\DataTables\TeamDataTable;
use App\Http\Requests\CRM;
use App\Http\Requests\CRM\CreateTeamRequest;
use App\Http\Requests\CRM\UpdateTeamRequest;
use App\Repositories\CRM\TeamRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\User;

class TeamController extends AppBaseController
{
    /** @var TeamRepository $teamRepository*/
    private $teamRepository;

    public function __construct(TeamRepository $teamRepo)
    {
        $this->teamRepository = $teamRepo;
    }

    /**
     * Display a listing of the Team.
     *
     * @param TeamDataTable $teamDataTable
     *
     * @return Response
     */
    public function index(TeamDataTable $teamDataTable)
    {
        return $teamDataTable->render('teams.index');
    }

    /**
     * Show the form for creating a new Team.
     *
     * @return Response
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created Team in storage.
     *
     * @param CreateTeamRequest $request
     *
     * @return Response
     */
    public function store(CreateTeamRequest $request)
    {
        $input = $request->all();

        $team = $this->teamRepository->create($input);

        Flash::success('تنبيه...تم حفظ القسم بنجاح.');

        return redirect(route('teams.index'));
    }

    /**
     * Display the specified Team.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $team = $this->teamRepository->find($id);

        if (empty($team)) {
            Flash::error('عفوآ...لم يتم العثور على المنتج');

            return redirect(route('teams.index'));
        }

        return view('teams.show')->with('team', $team);
    }

    /**
     * Show the form for editing the specified Team.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $team = $this->teamRepository->find($id);

        if (empty($team)) {
            Flash::error('عفوآ...لم يتم العثور على القسم');

            return redirect(route('teams.index'));
        }

        return view('teams.edit')->with('team', $team);
    }

    /**
     * Update the specified Team in storage.
     *
     * @param int $id
     * @param UpdateTeamRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTeamRequest $request)
    {
        $team = $this->teamRepository->find($id);

        if (empty($team)) {
            Flash::error('عفوآ...لم يتم العثور على القسم');

            return redirect(route('teams.index'));
        }

        $team = $this->teamRepository->update($request->all(), $id);

        Flash::success('تنبيه...تم تعديل القسم بنجاح.');

        return redirect(route('teams.index'));
    }

    /**
     * Remove the specified Team from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {

    $team = $this->teamRepository->find($id);

        if (empty($team)) {
            Flash::error('عفوآ...لم يتم العثور على القسم');

            return redirect(route('teams.index'));
        }

        $check = User::where('team_id',$id)->get();

        if(count($check)>0){
            Flash::error('  عفوا .... لا يمكنك حذف القسم لارتباطه بمستخدمين  ');

            return redirect(route('teams.index'));
        }else{
            $this->teamRepository->delete($id);

            Flash::success('تنبيه...تم حذف القسم بنجاح');

            return redirect(route('teams.index'));
        }


    }

}
