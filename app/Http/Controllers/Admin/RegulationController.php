<?php

namespace App\Http\Controllers\Admin;

use App\Models\Regulation;
use App\Models\RegulationFile;
use App\Repositories\Contracts\IRegulationRepository;
use Illuminate\Http\Request;

/**
 * RegulationController
 * Author: jvb
 * Date: 2019/01/11 09:23
 */
class RegulationController extends AdminBaseController
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.regulations';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::regulations';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Regulation::class;

    /**
     * @var  string
     */
    protected $resourceTitle = 'Quy định, Nội quy';

    /**
     * Controller construct
     */
    public function __construct(IRegulationRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

//    /**
//     * @param         $record
//     * @param Request $request
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function getRedirectAfterSave($record, $request,$isCreate = true)
//    {
//        //Delete relate files
//        $record->regulation_files()->delete();
//        $file_paths = $request->get('file_path');
//        if (!empty($file_paths)) {
//
//            $files = [];
//            foreach ($file_paths as $file_path) {
//                $files[] = new RegulationFile([
//                    'file_path' => $file_path
//                ]);
//            }
//            $record->regulation_files()->saveMany($files);
//        }
//
//        //Insert relate files
//        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
//    }
}
