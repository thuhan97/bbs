/**
* {{$Module}}Model class
* Author: jvb
* Date: {{date('Y/m/d H:i')}}
*/

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class {{$Module}} extends Model
{
use SoftDeletes;

protected $table = '{{$table}}';

protected $primaryKey = 'id';

protected $fillable = [
@foreach($list_column as $column)
    '{{$column}}',
@endforeach
];

/**
* The attributes that should be hidden for arrays.
*
* @var array
*/
protected $hidden = [
'created_at', 'updated_at', 'deleted_at',
];
}
