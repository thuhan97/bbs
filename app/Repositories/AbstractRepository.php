<?php

namespace App\Repositories;

use App\Facades\AuthAdmin;
use App\Repositories\Contracts\IBaseRepository;
use App\Traits\ParseRequestSearch;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

abstract class AbstractRepository implements IBaseRepository
{
    const ORDER_TXT = 'orders';

    use ParseRequestSearch;

    /**
     * Name of the Model with absolute namespace
     *
     * @var string
     */
    protected $modelName;
    /**
     * Instance that extends Illuminate\Database\Eloquent\Model
     *
     * @var Model
     */
    protected $model;
    /**
     * get logged in user
     *
     * @var User $loggedInUser
     */
    protected $loggedInUser;

    /**
     * AbstractEloquentRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->loggedInUser = $this->getLoggedInUser();
    }

    /**
     * Get Model instance
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @inheritdoc
     */
    public function findOne($id)
    {
        return $this->findOneBy([$this->model->getKeyName() => $id]);
    }

    /**
     * @inheritdoc
     */
    public function findOneBy(array $criteria)
    {
        return $this->model->where($criteria)->first();
    }

    /**
     * @inheritdoc
     */
    public function findBy(array $searchCriteria = [], array $fields = ['*'], $all = false)
    {
        $limit = !empty($searchCriteria['page_size']) ? (int)$searchCriteria['page_size'] : DEFAULT_PAGE_SIZE; // it's needed for pagination
        
        $queryBuilder = $this->model->where(function ($query) use ($searchCriteria) {
            $this->applySearchCriteriaInQueryBuilder($query, $searchCriteria);
        })->select($fields);
       
        //order by
        
        $default_order_field = $this->model->getKeyName();
        $orders = isset($searchCriteria[self::ORDER_TXT]) && is_array($searchCriteria[self::ORDER_TXT]) ? $searchCriteria[self::ORDER_TXT] : [$default_order_field => 'desc'];
        foreach ($orders as $field => $cond) {
            $cond = strtolower($cond) == 'asc' ? 'asc' : 'desc';
            $queryBuilder->orderBy($field, $cond);
        }
        $relations = isset($searchCriteria['with']) ? $searchCriteria['with'] : null;
        if ($relations) {
            $relations = explode(',', $relations);
            foreach ($relations as $relation) {
                if (method_exists($this, $relation)) {
                    $queryBuilder->with($relation);
                }
            }
        }
        if ($all) {
            return $queryBuilder->get();
        }
        return $queryBuilder->paginate($limit);
    }

    /**
     * Apply condition on query builder based on search criteria
     *
     * @param Object $queryBuilder
     * @param array  $searchCriteria
     *
     * @return mixed
     */
    protected function applySearchCriteriaInQueryBuilder($queryBuilder, array $searchCriteria = [])
    {
        foreach ($searchCriteria as $key => $value) {
            //skip pagination related query params
            if (in_array($key, $this->skipRequestSearchParams())) {
                continue;
            }
            //we can pass multiple params for a filter with commas
            if (is_string($value)) {
                if ($key === 'search') {
                    $queryBuilder->search($value);
                } else {
                    $allValues = explode(',', $value);
                    if (count($allValues) > 1) {
                        $queryBuilder->whereIn($key, $allValues);
                    } else {
                        $operator = '=';
                        $queryBuilder->where($key, $operator, $value);
                    }
                }

            } else {
                //check if $value has filter by ParseRequestSearch
                if ($key === 'search') {
                } else if (isset($value['field']) && isset($value['operator']) && isset($value['value'])) {
                    $queryBuilder->where($value['field'], $value['operator'], $value['value']);
                } else {
                    $queryBuilder->where($key, $value);
                }
            }
        }

        return $queryBuilder;
    }

    /**
     * @inheritdoc
     */
    public function save(array $data)
    {
        if (property_exists($this->model, 'autoOrder') && $this->model->autoOrder && (!isset($data['order']))) {
            $data['order'] = $this->model->max('order') + 1;
        }

        if (property_exists($this->model, 'autoCreator') && $this->model->autoCreator && !isset($data['creator_id'])) {
            $data['creator_id'] = AuthAdmin::id();
        }
        return $this->model->create($data);
    }

    /**
     * @inheritdoc
     */
    public function update(Model $model, array $data)
    {
        $fillAbleProperties = $this->model->getFillable();
        foreach ($data as $key => $value) {
            // update only fillAble properties
            if (in_array($key, $fillAbleProperties)) {
                $model->$key = $value;
            }
        }
        // update the model
        $model->save();
        // get updated model from database
        $model = $this->findOne($model->id);

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function findIn($key, array $values)
    {
        return $this->model->whereIn($key, $values)->get();
    }

    /**
     * @inheritdoc
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

    /**
     * get loggedIn user
     *
     * @return User
     */
    protected function getLoggedInUser()
    {
        $user = Auth::user();
        if ($user instanceof User) {
            return $user;
        } else {
            return new User();
        }
    }

    public function dragDropRank(array $ids, $order = 'DESC', $rankColName = 'rank')
    {
        // old ranks arrangement
        $oldArrange = $this->model
            ->whereIn($this->model->getKeyName(), $ids)
            ->orderBy($rankColName, $order)
            ->pluck($this->model->getKeyName(), $rankColName);

        if (count($ids) != count($oldArrange)) {
            return false;
        }

        // new ranks arrangement
        $newArrange = [];
        $count = 0;
        foreach ($oldArrange as $rank => $id) {
            $newArrange[$rank] = $ids[$count];
            $count += 1;
        }

        // update database
        foreach ($newArrange as $rank => $newId) {
            $row = $this->findOne($newId);
            if ($row->rank != $rank) {
                $this->update($row, [$rankColName => $rank]);
            }
        }

        return true;
    }

    public function getAll()
    {
        return $this->model->select('*')
            ->orderBy($this->model->getKeyName())
            ->get();
    }

    /**
     * @param array $data
     *
     * @return mixed|boolean
     */
    public function multiInsert(array $data)
    {
        if (!empty($data)) {
            if (isset($data[0]) && is_array($data[0])) {
                $thisModel = $this->model;
                return $thisModel::insertAll($data);
            } else {
                return $this->save($data);
            }
        }
        return false;
    }

    /**
     * @param array $data
     * @param array $conditions
     *
     * @return mixed|boolean
     */
    public function multiUpdate(array $conditions, array $data)
    {
        if (!empty($conditions) && !empty($data)) {

            return $this->model->where($conditions)->update($data);
        }

        return false;
    }


    /**
     * @param array $conditions
     * @param bool  $forceDelete
     *
     * @return mixed
     */
    public function multiDelete(array $conditions, bool $forceDelete = false)
    {
        $thisModel = $this->model->where($conditions);
        return $forceDelete ? $thisModel->forceDelete() : $thisModel->delete();
    }

    /**
     * @param array $updateConditions
     * @param array $data
     *
     * @return Model
     */
    public function updateOrCreate(array $updateConditions, array $data)
    {
        return $this->model->updateOrCreate($updateConditions, $data);
    }

}
