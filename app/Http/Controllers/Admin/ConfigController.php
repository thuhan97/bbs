<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Repositories\Contracts\IConfigRepository;
use Illuminate\Http\Request;

/**
 * ConfigController
 * Author: trinhnv
 * Date: 2018/11/15 16:31
 */
class ConfigController extends Controller
{
    /**
     * @var  string
     */
    protected $resourceAlias = 'admin.config';

    /**
     * @var  string
     */
    protected $resourceRoutesAlias = 'admin::configs';

    /**
     * Fully qualified class name
     *
     * @var  string
     */
    protected $resourceModel = Config::class;

    /**
     * Controller construct
     */
    public function __construct(IConfigRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $record = Config::firstOrNew([
            'id' => 1
        ]);

        return view($this->resourceAlias . '._layout', [
            'resourceAlias' => $this->resourceAlias . '.index',
            'record' => $record
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        Config::updateOrCreate([
            'id' => 1
        ], $data);

        flash()->success('Lưu thiết lập thành công');
        return redirect(route($this->resourceRoutesAlias . '.index'));
    }

}
