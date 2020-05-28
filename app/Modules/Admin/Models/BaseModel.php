<?php


namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class BaseModel extends Model implements \OwenIt\Auditing\Contracts\Auditable
{

    use Auditable;

}
