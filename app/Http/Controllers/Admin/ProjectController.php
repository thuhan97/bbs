<?php
/**
 * Created by PhpStorm.
 * User: muatu
 * Date: 1/31/2019
 * Time: 3:15 PM
 */

namespace App\Http\Controllers\Admin;

use File;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Repositories\Contracts\IProjectRepository;
class ProjectController extends AdminBaseController
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.projects';
    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::projects';
    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Project::class;


//    protected $resourceSearchExtend = 'admin.projects._search_extend';

    /**
     * @var  string
     */


    protected $resourceTitle = 'Dự án';

    public function __construct(
        IProjectRepository $repository
    )
    {
        $this->repository = $repository;
        parent::__construct();
    }
//
    public function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'name' => 'required|max:255',
                'customer' => 'required|max:255',
                'scale' => 'numeric',
//                'leader_id' => 'required',
            ],
            'messages' => [],
            'attributes' => [
                'name' => 'tên dự án',
                'customer' => 'khách hàng',
                'scale' => 'quy mô dự án',
//                'leader_id' => 'trưởng nhóm',
            ],
            'advanced' => [],
        ];
    }

    public function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'name' => 'required|max:255',
                'customer' => 'required|max:255',
                'start_date' => 'required',
                'end_date' => 'required',
            ],
            'messages' => [],
            'attributes' => [
                'name' => 'tên dự án',
                'customer' => 'khách hàng',
                'start_date' => 'ngày bắt đầu',
                'end_date' => 'ngày kết thúc',
            ],
            'advanced' => [],
        ];
    }

    public function update(Request $request, $id)
    {
        $record = $this->repository->findOne($id);
        $filename = '';
        if ($request->hasFile('image_url')) {
            $image = request()->file('image_url');

            if( ! File::exists(URL_IMAGE_PROJECT)) {
                $org_img = File::makeDirectory(public_path(URL_IMAGE_PROJECT), 0777, true);
            }
            $filename = rand(1111,9999).time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path(URL_IMAGE_PROJECT);
            //$request->merge(['images'=>$filename]);
            $image->move($destinationPath, $filename);
        }
        /*dd($request->merge());*/
        $this->authorize('update', $record);

        $valuesToSave = $this->getValuesToSave($request, $record);
        if ($request->hasFile('image_url')){
            $valuesToSave['image_url'] = $filename;
        } else {
            $valuesToSave['image_url'] = $record->image_url;
        }
        $request->merge($valuesToSave);
        $this->resourceValidate($request, 'update', $record);
        if ($this->repository->update($record, $this->alterValuesToSave($request, $valuesToSave))) {
            flash()->success('Cập nhật thành công.');

            return $this->getRedirectAfterSave($record, $request);
        } else {
            flash()->info('Cập nhật thất bại.');
        }

        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', $this->getResourceModel());
        if ($request->hasFile('image_url')) {
            $image = request()->file('image_url');

            if( ! File::exists(URL_IMAGE_PROJECT)) {
                $org_img = File::makeDirectory(public_path(URL_IMAGE_PROJECT), 0777, true);
            }
            $filename = rand(1111,9999).time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path(URL_IMAGE_PROJECT);
            //$request->merge(['images'=>$filename]);
            $image->move($destinationPath, $filename);
        }
        $valuesToSave = $this->getValuesToSave($request);
        if ($request->hasFile('image_url')){
            $valuesToSave['image_url'] = $filename;
        }
        $request->merge($valuesToSave);
        $this->resourceValidate($request, 'store');

        if ($record = $this->repository->save($this->alterValuesToSave($request, $valuesToSave))) {
            flash()->success('Thêm mới thành công.');

            return $this->getRedirectAfterSave($record, $request);
        } else {
            flash()->info('Thêm mới thất bại.');
        }

        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }





}