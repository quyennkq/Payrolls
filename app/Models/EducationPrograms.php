<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationPrograms extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_education_programs';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'json_params' => 'object',
    ];

    public static function getSqlEducationPrograms($params = [])
    {

        $query = EducationPrograms::select('tb_education_programs.*')
            ->when(!empty($params['keyword']), function ($query) use ($params) {
                return $query->where('tb_data_crms.name', 'like', '%' . $params['keyword'] . '%');
            })
            ->when(!empty($params['area_id']), function ($query) use ($params) {
                return $query->where('tb_education_programs.area_id', $params['area_id']);
            })
            ->when(!empty($params['id']), function ($query) use ($params) {
                return $query->where('tb_education_programs.id', $params['id']);
            })
            ->when(!empty($params['status']), function ($query) use ($params) {
                return $query->where('tb_education_programs.status', $params['status']);
            });
        if (!empty($params['order_by'])) {
            if (is_array($params['order_by'])) {
                foreach ($params['order_by'] as $key => $value) {
                    $query->orderBy('tb_education_programs.' . $key, $value);
                }
            } else {
                $query->orderByRaw('tb_education_programs.' . $params['order_by'] . ' desc');
            }
        } else {
            $query->orderBy('tb_education_programs.id', 'desc');
        }
        $query->groupBy('tb_education_programs.id');
        return $query;
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
}
