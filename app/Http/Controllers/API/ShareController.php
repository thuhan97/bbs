<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ShareService;
use App\Traits\RESTActions;
use App\Transformers\ShareDocumentTransformer;
use App\Transformers\ShareExperienceTransformer;
use App\Transformers\ShareTransformer;
use Illuminate\Http\Request;
use Illuminate\View\View as ViewAlias;

class ShareController extends Controller
{
    use RESTActions;

    /**
     * @var ShareService
     */
    private $shareService;
    /**
     * @var ShareExperienceTransformer
     */
    private $experienceTransformer;
    /**
     * @var ShareDocumentTransformer
     */
    private $documentTransformer;

    /**
     * ShareController constructor.
     *
     * @param ShareService             $shareService
     * @param ShareDocumentTransformer $transformer
     */
    public function __construct(
        ShareService $shareService,
        ShareTransformer $transformer,
        ShareDocumentTransformer $documentTransformer,
        ShareExperienceTransformer $experienceTransformer
    )
    {
        $this->shareService = $shareService;
        $this->documentTransformer = $documentTransformer;
        $this->experienceTransformer = $experienceTransformer;
        $this->transformer = $transformer;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|ViewAlias
     */
    public function document(Request $request)
    {
        $shares = $this->shareService->documentList($request, $perPage, $search);
        return $this->respondTransformer($shares, $this->documentTransformer, 'documents');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|ViewAlias
     */
    public function experience(Request $request)
    {
        $shares = $this->shareService->documentList($request, $perPage, $search);
        return $this->respondTransformer($shares, $this->experienceTransformer, 'experiences');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|ViewAlias
     */
    public function detail($id)
    {
        $share = $this->shareService->detail($id);
        if ($share != null) {
            return $this->respondTransformer($share);
        }
        return $this->respondNotfound();
    }

}
