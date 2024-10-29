<?php 


namespace App\Services;

class CommonBusinessService
{
    public function bulkDelete($ids, $modelName){
        if(!blank($ids)){
            $deletedCounter = $modelName::whereIn('id', $ids)->delete();
            return ['success' =>  "$deletedCounter items deleted successfully"];
        }
        return ['error' => 'No item selected!'];
    }
    
}