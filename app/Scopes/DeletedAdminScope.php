<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DeletedAdminScope implements Scope
{
  public function apply(Builder $builder, Model $model)
  {
      if(Auth::check() && Auth::user()->is_admin){
        //$builder->withTrashed();
        
        //SoftDeletingScope يقوم 
        //بمنع ظهور المنشورات المحذوفة بشكل ناعم
        //باستدعائنا للاستعلام التالي
        // فإننا نمنع عمله وبالتالي نحصل
        // على نفس نتيجة الاستعلام السابق 
        $builder->withoutGlobalScope('Illuminate\Database\Eloquent\SoftDeletingScope');
      }
  }

}