<?php

namespace App\Modules\Base\Repositories\Eloquent;

use App\Exceptions\BaseJsonRenderException;
use App\Modules\Base\Models\Test;
use App\Repositories\Eloquent\BaseRepository;
use DB;

/**
 * @property mixed data
 */
class TestRepository extends BaseRepository
{
    /**
    * TestRepository constructor.
    *
    * @param Test $model
    */
    public function  __construct(Test $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @param null $id
     * @return mixed
     * @throws BaseJsonRenderException
     */
    public function saveData(array $data, $id = null)
    {
        try {
            DB::beginTransaction();

            $saveData = $data;

            if (is_null($id)) {
                $this->data = $this->create($saveData);
            } else {
                $this->data = $this->findOrFail($id);
                $this->data->update($saveData);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw new BaseJsonRenderException($ex->getMessage(), $ex->getCode());
        }

        return $this->data;
    }

}
