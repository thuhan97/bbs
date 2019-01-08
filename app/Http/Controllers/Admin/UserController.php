<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Repositories\Contracts\IUserRepository;

/**
 * UserController
 * Author: trinhnv
 * Date: 2018/07/16 10:24
 */
class UserController extends AdminBaseController
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.users';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::users';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = User::class;

    protected $resourceSearchExtend = 'admin.users._partials.search_form';

    /**
     * @var  string
     */
    protected $resourceTitle = 'User';

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function resourceStoreValidationData()
    {
        return [
            'rules' => [
                'name' => 'filled|max:255',
                'email' => 'email|unique:users,email',
                'staff_code' => 'filled|max:10|unique:users,staff_code',
                'birthday' => 'date|before:' . date('Y-m-d', strtotime('- 15 years')),
                'phone' => 'min:10|max:30|unique:users,phone',
                'id_card' => 'min:9|max:12|unique:users,id_card',
            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
    }

    public function resourceUpdateValidationData($record)
    {
        return [
            'rules' => [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email,' . $record->id,
                'staff_code' => 'filled|max:10|unique:users,staff_code,' . $record->id,
                'birthday' => 'date|before:' . date('Y-m-d', strtotime('- 15 years')),
                'phone' => 'min:10|max:30|unique:users,phone',
                'id_card' => 'min:9|max:12|unique:users,id_card',
            ],
            'messages' => [],
            'attributes' => [],
            'advanced' => [],
        ];
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
}
