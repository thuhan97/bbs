<?php
/**
 * RulesService class
 * Author: jvb
 * Date: 2019/04/22 08:21
 */

namespace App\Services;

use App\Models\Post;
use App\Models\Share;
use Illuminate\Http\Request;

class ShareService extends AbstractService
{
    /**
     * ShareService constructor.
     *
     * @param \App\Models\Share $model
     */
    public function __construct(Share $model)
    {
        $this->model = $model;
    }

    public function documentList(Request $request, &$search, &$perPage)
    {
        $search = $request->get('search');
        $perPage = $request->get('page_size', DEFAULT_PAGE_SIZE);

        return Share::where('type', '=', SHARE_DOCUMENT)
            ->search($search)
            ->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function experienceList(Request $request, &$search, &$perPage)
    {
        $search = $request->get('search');
        $perPage = $request->get('page_size', DEFAULT_PAGE_SIZE);

        return Share::where('type', '=', SHARE_EXPERIENCE)
            ->search($search)
            ->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * @param int $id
     *
     * @return Post
     */
    public function detail($id)
    {
        return Share::find($id);
    }

}
