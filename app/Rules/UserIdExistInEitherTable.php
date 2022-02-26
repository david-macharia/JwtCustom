<?php


namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class UserIdExistInEitherTable implements Rule
{

    public $request;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(FormRequest $request)
    {
        $this->request=$request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!isset($value)){
           return false;
        }
           $globalUser= new GlobalUser();
         $result=DB::table('merchants_data')->where('merchant_id','=',$value)->first();
          if(isset($result)){
            $globalUser->query=$result;
            $globalUser->user_id="$value";
            $globalUser->user_type="merchant";
           
              $this->request->global_user= $globalUser;
        
          return true;
          }
          $result=DB::table('client_data')->where('client_id','=',$value)->first();
          if(isset($result)){
            $globalUser->query=$result;
            $globalUser->user_id="$value";
            $globalUser->user_type="client";
            $this->request->global_user= $globalUser;
               
            
            return true;
            }

         return false;
           
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Client id or marchant id is wrong';
    }
}
 class GlobalUser{
    public  $user_type;
    public $user_id;
    public $query;
    public function isClient():bool{
        if($this->user_type=="client"){
            return true;
        }
        return false;

    }
    public function isMerchant():bool{
        if($this->user_type=="merchant"){
           return true;
        }
        return false;
    }
}