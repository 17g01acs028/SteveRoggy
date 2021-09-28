<?php

namespace App\Repositories;

use App\Survey;
use Auth;
use App\Repositories\BaseRepository;

/**
 * Class CourseRepository
 * @package App\Repositories
 * @version February 3, 2021, 1:21 pm UTC
*/

class SurveyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
        'client_id',
        'name',
        'description',
        'finish_message',
        'session_lifespan'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Survey::class;
    }
}
