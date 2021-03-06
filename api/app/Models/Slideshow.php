<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    use HasFactory;
    // 下面是设置数据表名，如果不设置，则使用类名的复数形式作为表名，如Users
	protected $table = "slideshows";
	// `$primaryKey`属性（可选），值是主键名称，在主键不是id的时候则需要指定主键
	protected $primaryKey = "id";
    // 下面即是允许入库的字段，数组形式，name age sex三个字段允许入库
    protected $fillable = ['title','type','url','images'];
    // 定义`$timestamps`属性，不设置为`false`，默认操作表中的`create_at`和`updated_at`字段，我们表中一般没有这个字段，所以设置为`false`，表示不要操作这两个字段
    public $timestamps = false;
    // 下面用于设置不允许入库字段，一般和$fillable存在一个即可
    protected $guarded = [];

}
