<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QuestionSetCreateRequest;
use App\Http\Requests\QuestionSetImportRequest;
use Illuminate\Http\Request;

/**
 * QuestionSetsController
 * Author: jvb
 * Date: 2018/11/01 15:25
 */
class QuestionSetsController extends AdminBaseController
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.question_sets';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::question-sets';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = QuestionSets::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Question Sets';

    protected $resourceSearchExtend = 'admin.question_sets._partials.search_form';

    /**
     * Controller construct
     */
    public function __construct(IQuestionSetsRepository $repository, ILevelRepository $levelRepository, ITopicRepository $topicRepository)
    {
        $this->repository = $repository;
        $this->levelRepository = $levelRepository;
        $this->topicRepository = $topicRepository;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadTemplate()
    {
        $pathToFile = public_path() . '/template/question-set-temp.xlsx';
        return response()->download($pathToFile);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function import(Request $request)
    {
        return view('admin.question_sets.import', [
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
        ]);
    }

    public function filterSearchViewData(Request $request, $data = [])
    {
        $data['level_id'] = $request->get('level_id');
        $data['topic_id'] = $request->get('topic_id');
        $data['resourceSearchExtend'] = $this->resourceSearchExtend;

        return $this->makeRelationData($data);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function filterCreateViewData($data = [])
    {
        return $this->makeRelationData($data);
    }

    /**
     * @param       $record
     * @param array $data
     *
     * @return array
     */
    public function filterEditViewData($record, $data = [])
    {
        return $this->makeRelationData($data);

    }

    public function resourceStoreValidationData()
    {
        return $this->validationData();
    }

    public function resourceUpdateValidationData($record)
    {
        return $this->validationData();
    }

    private function validationData($data = [])
    {
        $questionRequest = new QuestionSetCreateRequest();

        $rules = $questionRequest->rules();

        if (isset($data['potato'])) {
            $rules['max_pick_potato'] .= '|max:' . $data['potato'];
        }

        if (isset($data['max_pick_potato'])) {
            $rules['min_pick_potato'] .= '|max:' . $data['max_pick_potato'];
        }

        return [
            'rules' => $rules,
            'messages' => $questionRequest->messages(),
            'attributes' => $questionRequest->attributes(),
            'advanced' => [],
        ];
    }

    private function makeRelationData($data = [])
    {
        $data['levels'] = ['' => 'Select level'] + Level::pluck('name', 'id')->toArray();
        $data['topics'] = ['' => 'Select topic'] + Topic::pluck('name', 'id')->toArray();

        return $data;
    }

    /**
     * Classes using this trait have to implement this method.
     * Retrieve the list of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $perPage
     * @param string|null              $search
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSearchRecords(Request $request, $perPage = 15, $search = null)
    {
        $searchModel = $this->getResourceModel()::search($search);
        $requestData = $request->all();
        if (!empty($requestData['level_id'])) {
            $searchModel->where('level_id', $requestData['level_id']);
        }
        if (!empty($requestData['topic_id'])) {
            $searchModel->where('topic_id', $requestData['topic_id']);
        }
        return $searchModel->paginate($perPage);
    }

    public function importData(QuestionSetImportRequest $request)
    {
        //Do validation file
        $extensions = array("xls", "xlsx", "xlm", "xla", "xlc", "xlt", "xlw", "csv");
        $fileExtension = $request->file('import_file')->getClientOriginalExtension();
        $request->merge(['ext' => strtolower($fileExtension)]);
        $this->validate($request, [
            'ext' => 'in:' . implode(',', $extensions),
        ], [
            'ext.in' => 'The selected file is invalid.'
        ]);

        $requestData = $request->all();
        $insertDatas = [];
        $importErrors = [];

        $path = $request->file('import_file')->getRealPath();
        \Excel::load($path, function ($reader) use ($request, &$importErrors, &$insertDatas) {

            // reader methods
            $reader->each(function ($cellCollection, $rowNumber) use (&$importErrors, &$insertDatas) {
                $row = $cellCollection->toArray();
                if (!is_null($row[0])) {
                    $data = [
                        'name' => $row['name'],
                        'image' => 'browse to change',
                        'description' => $row['description'],
                        'total_question' => $row['total_question'],
                        'potato' => $row['potato'],
                        'min_pick_potato' => $row['min_pick_potato'],
                        'max_pick_potato' => $row['max_pick_potato'],
                        'number_to_pass' => $row['number_to_pass'],
                        'total_time' => $row['total_time'],
                        'level_name' => $row['level'],
                        'topic_name' => $row['topic'],
                    ];

                    $validationData = $this->validationData($row);
                    $validationRules = $validationData['rules'];
                    unset($validationRules['level_id'], $validationRules['topic_id']);

                    //do row validate
                    $validator = $this->getValidationFactory()->make($data, $validationRules, $validationData['messages'], $validationData['attributes']);
                    if ($validator->fails()) {
                        $errorMsgs = $validator->errors()->getMessages();
                        $lineMsg = ' - Row ' . ($rowNumber + 1) . ':';
                        foreach ($errorMsgs as $errorMsg) {
                            $lineMsg .= ' ' . $errorMsg[0];
                        }
                        array_push($importErrors, $lineMsg);
                    } else {
                        array_push($insertDatas, $data);
                    }
                }
            });
        });

        if (empty($importErrors)) {
            $relationData = $this->makeRelationData();
            $levels = $relationData['levels'];
            $topics = $relationData['topics'];
            \DB::beginTransaction();
            foreach ($insertDatas as &$insertData) {
                $insertData['level_id'] = $this->getLevelId($levels, $insertData['level_name']);
                $insertData['topic_id'] = $this->getTopicId($topics, $insertData['topic_name']);

                unset($insertData['level_name'], $insertData['topic_name']);
            }

            if (isset($requestData['delete_old_data']) && $requestData['delete_old_data']) {
                $currentTableName = with(new QuestionSets())->getTable();;
                $newTableName = $currentTableName . '_' . date('Ymd_his');
                \DB::statement("CREATE TABLE $newTableName LIKE $currentTableName;");
                \DB::statement("INSERT $newTableName SELECT * FROM $currentTableName;");
                QuestionSets::truncate();
            } else {
            }
            QuestionSets::insertAll($insertDatas);
            \DB::commit();
            $message = 'Import data successfully.';
        } else {
            $message = 'Import data failed. There are some errors: ';
        }

        return view('admin.question_sets.import', [
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'import_errors' => $importErrors,
            'message' => $message
        ]);
    }

    private function getLevelId(&$levels, $name)
    {
        $levelId = array_search($name, $levels);
        if (!$levelId) {
            $level = $this->levelRepository->save(['name' => $name, 'is_actived' => 1]);
            $levelId = $level->id;
            $levels += [$levelId => $name];
        }
        return $levelId;

    }

    private function getTopicId(&$topics, $name)
    {
        $topicId = array_search($name, $topics);
        if (!$topicId) {
            $topic = $this->topicRepository->save(['name' => $name, 'is_actived' => 1]);
            $topicId = $topic->id;
            $topics += [$topicId => $name];
        }
        return $topicId;
    }

}
