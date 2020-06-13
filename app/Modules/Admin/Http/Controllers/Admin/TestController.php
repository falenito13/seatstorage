<?php

namespace App\Modules\Admin\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Helper\ProfileHelper;
use App\Modules\Admin\Http\Requests\Admin\Test\CreateRequest;
use App\Modules\Admin\Repositories\Contracts\ITestRepository as ModuleRepository;
use App\Utilities\ServiceResponse;
use Illuminate\Http\Request;
use \App\Modules\Admin\Http\Controllers\BaseController as BaseController;

class TestController extends BaseController
{

    /**
     * @var string
     */
    public $moduleTitle = 'test';

    /**
     * @var string
     */
    public $viewFolderName = 'test';

    /**
     * TestController constructor.
     * @param ModuleRepository $repository
     */
    public function __construct
    (
        ModuleRepository $repository
    )
    {
        parent::__construct();
        $this->repository = $repository;
        $this->successCreateText = $this->moduleTitle . $this->successCreateText;
        $this->successUpdateText = $this->moduleTitle . $this->successUpdateText;
        $this->successDeleteText = $this->moduleTitle . $this->successDeleteText;
        $this->baseData['moduleKey'] = 'test';
        $this->baseData['baseRouteName'] = $this->baseData['baseRouteName'] . '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = ProfileHelper::getLang();
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->baseData['allData'] = $this->repository->paginate();

        return view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName.'.index', $this->baseData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->baseModuleName  . $this->baseAdminViewName . $this->viewFolderName.'.create', $this->baseData);
    }

    /**
     * @param CreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {

        try {

            $this->repository->create($request->except('_token'));

        } catch (\Exception $ex) {
            return redirect()->back()->with('notifications', ServiceResponse::notification($ex->getMessage(), 'danger'))->withInput();
        }

        return redirect()->back()->with('notifications', ServiceResponse::notification($this->successCreateText, 'success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->baseData['data'] = $this->repository->find($id);

        return view($this->baseModuleName  . $this->baseAdminViewName . $this->viewFolderName.'.edit', $this->baseData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateRequest $request, $id)
    {

        try {

            $this->repository->update($request->except('_token'),$id);

        } catch (\Exception $ex) {
            return redirect()->back()->with('notifications', ServiceResponse::notification($ex->getMessage(), 'danger'))->withInput();
        }

        return redirect()->back()->with('notifications', ServiceResponse::notification($this->successUpdateText, 'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
        } catch (\Exception $ex) {
            return redirect()->back()->with('notifications', ServiceResponse::notification($ex->getMessage(), 'danger'))->withInput();
        }

        return redirect()->back()->with('notifications', ServiceResponse::notification($this->successUpdateText, 'success'));
    }

}
