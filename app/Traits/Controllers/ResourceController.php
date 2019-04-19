<?php

namespace App\Traits\Controllers;

use App\Models\DeviceUser;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

trait ResourceController
{
    use ResourceHelper;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewList', $this->getResourceModel());
        $records = $this->searchRecords($request, $perPage, $search);

        return view($this->getResourceIndexPath(), $this->filterSearchViewData($request, [
            'records' => $records,
            'search' => $search,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'perPage' => $perPage,
            'resourceSearchExtend' => $this->resourceSearchExtend,
            'addVarsForView' => $this->addVarsSearchViewData()
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', $this->getResourceModel());

        $class = $this->getResourceModel();
        return view($this->getResourceCreatePath(), $this->filterCreateViewData([
            'record' => new $class(),
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'addVarsForView' => $this->addVarsCreateViewData()
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', $this->getResourceModel());

        $valuesToSave = $this->getValuesToSave($request);
        $request->merge($valuesToSave);
        $this->resourceValidate($request, 'store');

        if ($record = $this->repository->save($this->alterValuesToSave($request, $valuesToSave))) {
            flash()->success('Thêm mới thành công.');

            return $this->getRedirectAfterSave($record, $request,$isCreate = true);
        } else {
            flash()->info('Thêm mới thất bại.');
        }

        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = $this->repository->findOne($id);

        $this->authorize('update', $record);
        $allocateUsers = null;
        if (isset($this->resourceAllocate)) {
            $allocateUsers = $this->deviceUserService->getRecordByDeviceId($record->id);
        }

        return view($this->getResourceShowPath(), $this->filterShowViewData($record, [
            'record' => $record,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'addVarsForView' => $this->addVarsShowViewData(),
            'allocateUsers' => $allocateUsers
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $record = $this->repository->findOne($id);

        $this->authorize('update', $record);

        return view($this->getResourceEditPath(), $this->filterEditViewData($record, [
            'record' => $record,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'addVarsForView' => $this->addVarsEditViewData()
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
//        dd($request->all());
        $record = $this->repository->findOne($id);

        $this->authorize('update', $record);

        $valuesToSave = $this->getValuesToSave($request, $record);

        $request->merge($valuesToSave);

        $this->resourceValidate($request, 'update', $record);
        dd($record,$request->all());
        if ($this->repository->update($record, $this->alterValuesToSave($request, $valuesToSave))) {

            flash()->success('Cập nhật thành công.');

            return $this->getRedirectAfterSave($record, $request,$isCreate = false);

        } else {
            flash()->info('Cập nhật thất bại.');
        }

        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $record = $this->getResourceModel()::findOrFail($id);

        $this->authorize('delete', $record);

        if (!$this->checkDestroy($record)) {
            return redirect(route($this->getResourceRoutesAlias() . '.index'));
        }

        if ($record->delete()) {
            flash()->success('Xóa thành công.');
        } else {
            flash()->info('Không thể xóa bản ghi.');
        }

        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deletes(Request $request)
    {
        $this->authorize('deletes');
        $this->validate($request, [
            'ids' => 'required|array'
        ]);
        $ids = $request->get('ids');
        if ($this->repository->multiDelete([[
            function ($q) use ($ids) {
                $q->whereIn('id', $ids);
            }
        ]])) {
            flash()->success('Đã xóa những bản ghi được chọn.');
        } else {
            flash()->info('Không xóa được những bản ghi được chọn');
        }

        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }

    /**
     * @param Request $request
     * @param         $perPage
     * @param         $search
     *
     * @return LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function searchRecords(Request $request, &$perPage, &$search)
    {
        $perPage = (int)$request->input('per_page', '');
        $perPage = (is_numeric($perPage) && $perPage > 0 && $perPage <= 100) ? $perPage : DEFAULT_PAGE_SIZE;
        $search = $request->input('search', '');

        $records = $this->getSearchRecords($request, $perPage, $search);

        $records->appends($request->except('page'));

        return $records;
    }

    public function getResourceIndexPath()
    {
        return '_resources.index';
    }

    public function getResourceCreatePath()
    {
        return '_resources.create';
    }

    public function getResourceEditPath()
    {
        return '_resources.edit';
    }

    public function getResourceShowPath()
    {
        return '_resources.show';
    }
}
