<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QuestionCreateRequest;
use App\Http\Requests\QuestionImportRequest;
use App\Models\Question;
use App\Models\QuestionSets;
use App\Repositories\Contracts\ILevelRepository;
use App\Repositories\Contracts\IQuestionRepository;
use App\Repositories\Contracts\ITopicRepository;
use Illuminate\Http\Request;

/**
 * QuestionController
 * Author: trinhnv
 * Date: 2018/09/03 01:51
 */
class QuestionController extends AdminBaseController
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.questions';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::questions';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Question::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Question';

    /**
     * @var ILevelRepository
     */
    private $levelRepository;

    /**
     * @var ITopicRepository
     */
    private $topicRepository;

    /**
     * Controller construct
     */
    public function __construct(IQuestionRepository $repository, ILevelRepository $levelRepository, ITopicRepository $topicRepository)
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
        $pathToFile = public_path() . '/template/question-temp.xlsx';
        return response()->download($pathToFile);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function import(Request $request, $id)
    {
        $set = QuestionSets::find($id);
        if ($set) {
            return view('admin.questions.import', [
                'setId' => $id,
                'set' => $set,
                'resourceAlias' => $this->getResourceAlias(),
                'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
                'resourceTitle' => $this->getResourceTitle(),
            ]);
        }
        abort(404);
    }

    public function importData(QuestionImportRequest $request)
    {
        $question_set_id = $request->get('question_set_id');
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
        \Excel::load($path, function ($reader) use ($request, &$importErrors, &$insertDatas, $question_set_id) {
            $validationData = $this->validationData();
            $validationRules = $validationData['rules'];
            // reader methods
            $reader->each(function ($cellCollection, $rowNumber) use (&$importErrors, &$insertDatas, $validationData, $validationRules, $question_set_id) {
                $row = $cellCollection->toArray();
                if (!is_null($row[0])) {
                    $data = [
                        'question_set_id' => $question_set_id,
                        'content' => $row['name'],
                        'option_a' => $row['a'],
                        'option_b' => $row['b'],
                        'option_c' => $row['c'],
                        'option_d' => $row['d'],
                        'answer' => isset(Question::ANSWERS[strtolower($row['answer'])]) ? Question::ANSWERS[strtolower($row['answer'])] : 0, // A is default answer,
                    ];

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
            \DB::beginTransaction();

            if (isset($requestData['delete_old_data']) && $requestData['delete_old_data']) {
                Question::where('question_set_id', $question_set_id)->forceDelete();
            }
            Question::insertAll($insertDatas);

            \DB::commit();
            $message = 'Import data successfully.';
        } else {
            $message = 'Import data failed. There are some errors: ';
        }

        $set = QuestionSets::find($question_set_id);
        return view('admin.questions.import', [
            'setId' => $question_set_id,
            'set' => $set,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'import_errors' => $importErrors,
            'message' => $message
        ]);
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
        $requestData = $request->all();
        $searchModel = $this->getResourceModel()::search($search);
        if ($request->has('set_id')) {
            $searchModel->where('question_set_id', $requestData['set_id']);
        }
        return $searchModel->paginate($perPage);
    }

    public function filterSearchViewData(Request $request, $data = [])
    {
        if ($request->has('set_id')) {
            $questionSet = QuestionSets::find($request->get('set_id'));
            $data['addVarsForView']['_pageSubtitle'] = 'List ' . ($questionSet->name ?? '');

        }

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

    private function validationData()
    {
        $questionRequest = new QuestionCreateRequest;
        return [
            'rules' => $questionRequest->rules(),
            'messages' => $questionRequest->messages(),
            'attributes' => $questionRequest->attributes(),
            'advanced' => [],
        ];
    }

    private function makeRelationData($data = [])
    {
        return $data;
    }

}
