<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Events\NotifRle;
use App\Events\StoreTwo;
use App\Models\Category;
use App\Events\ItemAdded;
use App\Events\MainStore;
use Illuminate\Support\Str;
use App\Events\NotifRleData;
use App\Events\WithPurchase;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Inventorydata;
use Illuminate\Support\Carbon;
use App\Events\NotificationData;
use App\Events\NotificationPend;
use App\Events\NotificationByRole;
use Illuminate\Support\Facades\Auth;
use App\Events\NotificationProjectPend;

class admincontroller extends Controller
{
    public function __construct()
{
    if(!Auth::check()){
        return redirect('/login');
    }
}
    public function index(Request $request){

        // First check if you are loggedin and admin user
        if(!Auth::check() && $request->path() != 'login'){
            return redirect('/login');
        }
        if(!Auth::check() && $request->path() == 'login'){
            return view('welcome');
        }
       
       // You are already logged in... so check for if you are an admin user
            $user = Auth::user();
            if ($user->userType == 'User'){
                return redirect('/login');
            }
            if($request->path() == 'login'){
                return redirect('/projects');
                //return redirect('/login');
            }
        return $this->checkForPermission($user,$request);
        // return view('notfound');
         //return view('welcome');
        
         
    }
    public function checkForPermission($user, $request){
     $permission = json_decode($user->role->permission);
     $hasPermission = false;
     foreach($permission as $p){
         if($p->name == $request->path()){
              if($p->read){
                  $hasPermission = true;
              
         }
        
     }
     if($p->name == $request->path()){
        if(!$p->read){
            $hasPermission = false;
            return view('notfound');
        
   }}
    if(Str::contains($request->path(), 'inventory_data')){
        if($p->name == 'inventory_data'){
            if($p->read){
                $hasPermission = true;
            
       }
      
   }
    }
    }
    
     if($hasPermission) return view('welcome');
     return redirect('/projects');
     //return view('notfound');
     echo $permission[0]->name;
     echo $request->path();
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
    public function addCategory(Request $request){
        $user = Auth::user();
        // validate
        $this->validate($request, [
            'projectName' => 'required',
            'requestUser' => 'required',
            'iconImage' => 'required',
        ]);
        return Category::create([
            'projectName' => $request->projectName,
            'requestUser' => $request->requestUser,
            'iconImage' => $request->iconImage,
            'requestUserId' => $user -> id
        ]);
    }
    public function getCategory(Request $request){
        return Category::orderBy('id','desc')->paginate($request->total);
    }
    public function updateCategory(Request $request){
        // validate
        $this->validate($request, [
            'iconImage' => 'required',
            'projectName' => 'required',
            'requestUser' => 'required',
            'id'=> 'required',
        ]);
        return Category::where('id',$request->id)->update([
            'projectName' => $request->projectName,
            'requestUser' => $request->requestUser,
            'iconImage' => $request->iconImage
        ]);
    }
    public function deleteCategory(Request $request){  

        $this->validate($request, [
            'id'=> 'required'
        ]);
        return Category::where('id',$request->id)->delete();
    }
    public function createUser(Request $request){
        // validate
        $this->validate($request, [
            'fullName' => 'required',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'photo' => 'required',
            'role_id' => 'required',
            
        ]);
        $password = bcrypt($request->password);
        $user = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' =>$password,
            'photo' => $request->photo,
            'role_id' => $request->role_id,
            'category_id' => $request->category_id,
        ]);
        return $user;
    }
    public function getUsers(Request $request){
        return User::orderBy('id','desc')->paginate($request->total);
        
    }
    public function getUserById(Request $request){
        return User::where('id',$request->id)->get();
        
    }
    public function getInventoryById(Request $request,$id){
        $pp = InventoryData::Where('category_id','=',$id)->orderBy('id','desc')->paginate($request->total);
        event(new ItemAdded($pp));
        return $pp;
    }
    public function getPaginateInventoryById(Request $request,$id){
        $pp = InventoryData::Where('category_id','=',$id)->orderBy('id','desc')->paginate($request->total);
        return $pp;
    }
    public function getProjectById(Request $request,$id){
        return Category::Where('id','=',$id)->get();
        
    }
    public function searchUser(Request $request){
        $str = $request->str;
        $users = User::orderBy('id','desc')->select('id','fullName','email','photo',
        'role_id','created_at');
      // $users= $users->where(DB::raw('lower(fullName)'), "LIKE", "%".strtolower($str)."%");

        //    ->orwhere(DB::raw(str::lower(strstr("email","@",true))), "LIKE", "%".strtolower($str)."%");
          
        $users->when($str != '', function($q) use($str){
            $q->where('fullName', "ilike", "%".$str."%")
           ->orWhere('email', "ilike", "%".$str."%")
           ->orWhere('created_at', "ilike", "%".$str."%")
           ->orwhereHas('role',function($q) use($str){
            $q->where('roleName', "ilike", "%".($str)."%"); 
         });
         });
         
        
         $users = $users->paginate($request->total);
        
        
        return $users;
       
     }
     public function searchProject(Request $request){
        $str = $request->str;
        $projects = Category::orderBy('id','desc')->select('id','projectName','iconImage','created_at');
      // $users= $users->where(DB::raw('lower(fullName)'), "LIKE", "%".strtolower($str)."%");

        //    ->orwhere(DB::raw(str::lower(strstr("email","@",true))), "LIKE", "%".strtolower($str)."%");
          
        $projects->when($str != '', function($q) use($str){
            $q->where('projectName', "ilike", "%".$str."%");
         });
         
        
         $projects = $projects->paginate($request->total);
        
        
        return $projects;
       
     }
     public function searchInventory(Request $request){
        $user = Auth::user();
        $str = $request->str;
        $projectId = $request->project_id;
        $inventory = Inventorydata::where('category_id','=',$projectId)->orderBy('id','desc')->select('id','itemType','measurenment','quantity','withPurchase','resetImage',
        'fromStore','adminOneApproval','adminTwoApproval','approved','purchasedCompany','bought','delivered','undelivered','orderReason','urgent','status','category_id','requestUserId','requestUserName','undeliveredReason','deliveredTime','created_at');
      // $users= $users->where(DB::raw('lower(fullName)'), "LIKE", "%".strtolower($str)."%");

        //    ->orwhere(DB::raw(str::lower(strstr("email","@",true))), "LIKE", "%".strtolower($str)."%");
        if($user->role_id == 2){
        $inventory->Where('withPurchase', '=', 'true')->when($str != '', function($q) use($str,$projectId){
            $q->where('itemType', "ilike", "%".$str."%")
            ->orWhere('measurenment', "ilike", "%".$str."%")
            ->orWhere('quantity', "ilike", "%".$str."%")
            ->orWhere('purchasedCompany', "ilike", "%".$str."%");
            $q->where('category_id', "=", $projectId);
         });}else if($user->role_id == 3){
            $inventory->where('approved','=','approved')->when($str != '', function($q) use($str,$projectId){
                $q->where('itemType', "ilike", "%".$str."%")
                ->orWhere('measurenment', "ilike", "%".$str."%")
                ->orWhere('quantity', "ilike", "%".$str."%");
                $q->where('category_id', "=", $projectId);
             });    
         }else if($user->role_id == 5){
            $inventory = InventoryData::where(function($query) {
                $query->orWhere('fromStore','=','true')
                    ->orWhere('bought','=','true');
            })->where('category_id','=',$projectId)->orderBy('id','desc')->select('id','itemType','measurenment','quantity','withPurchase','resetImage',
            'fromStore','adminOneApproval','adminTwoApproval','approved','purchasedCompany','bought','delivered','undelivered','orderReason','urgent','status','category_id','requestUserId','requestUserName','undeliveredReason','deliveredTime','created_at');
        
        $inventory->when($str != '', function($q) use($str,$projectId){
                $q->where('itemType', "ilike", "%".$str."%")
                ->orWhere('measurenment', "ilike", "%".$str."%")
                ->orWhere('quantity', "ilike", "%".$str."%")
                ->orWhere('purchasedCompany', "ilike", "%".$str."%");
                $q->where('category_id', "=", $projectId);
             });
         }else{
            $inventory->where('category_id', "=", $projectId)->when($str != '', function($q) use($str,$projectId){
                $q->where('itemType', "ilike", "%".$str."%")
                ->orWhere('measurenment', "ilike", "%".$str."%")
                ->orWhere('quantity', "ilike", "%".$str."%")
                ->orWhere('purchasedCompany', "ilike", "%".$str."%");
                $q->where('category_id', "=", $projectId);
             });
         }
         
        
         $inventory = $inventory->paginate($request->total);
        
        
        return $inventory;
       
     }
    public function updateUser(Request $request){
        // validate
        $this->validate($request, [
            'fullName' => 'required',
            'password' => "min:6",
            'email' => "bail|required|email|unique:users,email,$request->id",
            'photo' => 'required',
            'role_id' => 'required',
            'id'=> 'required'
        ]);
        $data = [
            'fullName' => $request -> fullName,
            'email' => $request -> email,
            'photo' => $request -> photo,
            'role_id' => $request -> role_id,
            'category_id' => $request -> category_id
        ];
        if($request->password){
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }

        return User::where('id',$request->id)->update($data);
    }
   
    public function deleteUser(Request $request){
        $this->validate($request, [
            'id'=> 'required'
        ]);
        return User::where('id',$request->id)->delete();
    }
    
    public function adminLogin(Request $request){
        $this->validate($request, [
            'email' => "bail|required|email",
            'password' => "bail|required|min:6",
            
    
        ]);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();
            //return $user->role->roleName;
            // return response()->json([
            //     'msg' => $user->role(),
            
               
            // ],200);
            if($user->role->isAdmin == false){
                Auth::logout();
                return response()->json([
                    'msg' => 'Incorrect login details',
                ],401);
            } 
            return response()->json([
                 'msg' => 'You are logged in',
                 'user' => $user
             ],200);
        }else{
            
            return response()->json([
                'msg' => 'Incorrect login details',
            ],401);
        }
      
        
        }
    public function addRole(Request $request){
            // validate
            $this->validate($request, [
                'roleName' => 'required',
                'isAdmin' => 'required'
            ]);
            return Role::create([
                'roleName' => $request->roleName,
                'isAdmin' => $request->isAdmin
            ]);
        }
    public function updateRole(Request $request){
            // validate
            $this->validate($request, [
                'isAdmin' => 'required',
                'roleName' => 'required',
                'id'=> 'required'
            ]);
            return Role::where('id',$request->id)->update([
                'roleName' => $request -> roleName,
                'isAdmin' => $request -> isAdmin
            ]);
        }
    public function deleteRole(Request $request){
            $this->validate($request, [
                'id'=> 'required'
            ]);
            return Role::where('id',$request->id)->delete();
        }
    public function getRole(Request $request){
        return Role::orderBy('id','desc')->paginate($request->total);
    }
    public function assignRoles(Request $request){
        // validate
        $this->validate($request, [
            'permission' => 'required',
            'id' => 'required',
        ]);
        return Role::where('id',$request->id)->update([
            'permission' => $request->permission
        ]);
    }
    public function upload(Request $request){
        $routePath = $request->path();
        $this->validate($request, [
            'file'=> 'required|mimes:jpeg,jpg,png'
        ]);
        $picName =time().'.'.$request->file->extension();
        if($routePath=='app/upload/user/photo'){
            $request->file->move(public_path('uploads/User photos'),$picName);
        }else if($routePath=='app/upload/blog/feature/photo'){
            $request->file->move(public_path('uploads/BlogFeatureImage'),$picName);
        }else if($routePath=='app/upload/project/image'){
            $request->file->move(public_path('uploads/Project Images'),$picName);
        }else if($routePath=='app/upload/reset/photo'){
            $request->file->move(public_path('uploads/Reset photos'),$picName);
        }else{
            $request->file->move(public_path('uploads'),$picName);
        }
        
        //$path=public_path()."/uploads/".$picName;
        return $picName;
    }
    public function deleteImage(Request $request){
        if($request->photo){
          $fileName = $request->photo;
          $fileName = 'User photos/'.$fileName;
          $this->deleteFileFromServer($fileName, false);
       }else if($request->featuredImage){
        $fileName = $request->featuredImage;
        $fileName = 'BlogFeaturePhoto/'.$fileName;
        $this->deleteFileFromServer($fileName, false);
       }else if($request->iconImage){
        $fileName = $request->iconImage;
        $fileName = 'Project Images/'.$fileName;
        $this->deleteFileFromServer($fileName, false);
       }else if($request->resetImage){
        $fileName = $request->resetImage;
        $fileName = 'Reset photos/'.$fileName;
        $this->deleteFileFromServer($fileName, false);
       }
       
       else{
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName, false);
    }
        
        return 'Done';
    }
    public function deleteFileFromServer($fileName,$hasFullPath = false){
        if(!$hasFullPath){
            $filePath = public_path().'/uploads/'.$fileName;
            
        }
        
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }
    public function addInventoryData(Request $request){
        // validate
        $user = Auth::user();
        if($user->id == 4){
            $this->validate($request, [
            'itemType' => 'required',
            'requestUserName' => 'required',
            'orderReason' => 'required',
            'measurenment' => 'required',
            'quantity' => 'required',
            'requestUserId' => 'required'
        ]);
        }
       
       Inventorydata::create([
            'itemType' => $request->itemType,
            'quantity' => $request->quantity,
            'measurenment' => $request->measurenment,
            'category_id' => $request->category_id,
            'requestUserId' => $request->requestUserId,
            'requestUserName' => $request->requestUserName,
            'orderReason' => $request->orderReason,
            'withPurchase' => $request->withPurchase,
            'bought' => $request->bought,
            'resetImage' => $request->resetImage,
            'purchasedCompany' => $request->purchasedCompany,
            'delivered' => $request->delivered,
            'undelivered' => $request->undelivered,
            'undeliveredReason' => $request->undeliveredReason,
            'fromStore' => $request->fromStore,
            'status' => $request->status,
            'urgent' => $request->urgent,
            'adminOneApproval' => $request -> adminOneApproval,
            'adminTwoApproval' => $request -> adminTwoApproval,
            'approved' => $request -> approved,
            'deliveredTime' => $request -> deliveredTime
        ]);
        // event(new ItemAdded());
        $inventory = InventoryData::orderBy('id','desc')->paginate($request->total);
        event(new ItemAdded($inventory));
    }
    public function createNotification(Request $request){

        // validate
        $user = Auth::user();
       
        $this->validate($request, [
            'message' => 'required',
            'status' => 'required',
            'route' => 'required',
            'project_id' =>'required',
        ]);
        
    
      Notification::create([
            'message' => $request->message,
            'requestUserId' =>$user->id,
            'toUserId' => $request->toUserId,
            'status' => $request->status,
            'route' => $request->route,
            'project_id' => $request->project_id,
            'role_id' => $request->role_id
        ]);
        if($request->toUserId){
            $pp = Notification::Where([
                ['toUserId','=',$request->toUserId],
                ['status', '=', 'Pending']])->orderBy('id','desc')->get();
            $pr = response()->json([
                'userId' => $request->toUserId,
                'notification' => $pp
            ]);
            event(new NotificationPend($pr));
            $this->getNotificationData($request->toUserId);
            $this->getRoleNotificationData($request->role_id);

        }else{
            $notifrle = Notification::Where([
                ['role_id','=',$request->role_id],
                ['status', '=', 'Pending']])->orderBy('id','desc')->get();
            $rle = response()->json([
                'role_id' => $request->role_id,
                'notification' => $notifrle
            ]);
            event(new NotifRle($rle));
            $this->getRoleNotificationData($request->role_id);
        }
        
        
        // $nf=Notification::where('id',$nn->id)->first();
       
        
        // $this->getNotificationByRole($request->role_id);
        // $this->getNotification();
        $this->getNotifPending();
        // $this->getNotificationByRole();
        $notif = Notification::Where([
            ['toUserId','=', $request->toUserId],
            ['status', '=', 'Pending']])->orderBy('id','desc')->get();
        return response()->json([
                'notification' => $notif,
            ]);
    }
    public function getNotification(){
        $user = Auth::user();
        $id = $user -> id;
        $pp = Notification::Where([
            ['toUserId','=',$id],
            ['status', '=', 'Pending']])->orderBy('id','desc')->get();
        $pr = response()->json([
            'userId' => $id,
            'notification' => $pp
        ]);
            event(new NotificationPend($pr));
            return $pp;
    }
    public function getNotificationByRole($id){
        // $user = Auth::user();
        // $id = $user -> role_id;
        $pp = Notification::Where([
            ['role_id','=',$id],
            ['status', '=', 'Pending']])->orderBy('id','desc')->get();
        $pr = response()->json([
            'role_id' => $id,
            'notification' => $pp
        ]);
        event(new NotifRle($pr));
            // event(new NotificationByRole($pr));
        return $pp;
    }
    public function getNotifPending(){
        $pp = Notification::Where('status', '=', 'Pending')->get();
        event(new NotificationProjectPend($pp));
        return $pp;
    }
    
    public function getNotifByIdPending($id){
       $nt = Notification::Where([
            ['project_id','=',$id],
            ['status', '=', 'Pending']])->count();
            return response()->json([
                'project_id' => $id,
                'count' => $nt,
            ]);
    
    }
    public function setSeenNotifPendById($id){

        $notif= Notification::Where([
            ['project_id','=',$id],
            ['role_id','!=', 3],
            ['status', '=', 'Pending']])->get();
            foreach($notif as $n){
                Notification::where('id',$n->id)->update([
                  'status' =>"seen"
                ]);
                $this->getNotificationData($n->toUserId);
                $this->getNotification();
                $this->getNotifPending();
            }
       
        
        
    }
    public function setSeenRoleNotifPendById(){
        $user = Auth::user();
        $notif= Notification::Where([
            ['role_id','=',$user->role_id],
            ['status', '=', 'Pending']])->get();
            foreach($notif as $n){
                Notification::where('id',$n->id)->update([
                  'status' =>"seen"
                ]);
                $this->getRoleNotificationData($n->role_id);
                $this->getNotificationByRole($n->role_id);
                $this->getNotifPending();
                // $this->getRoleNotification();
                // $this->getNotifPending();
            }
       
        
        
    }
    public function getRoleNotificationData($id){
        // $user = Auth::user();
        $pp = Notification::Where([
            ['role_id','=',$id]])->orderBy('id','desc')->get();
            event(new NotifRleData($pp));
        return $pp;
        
    }
    public function getNotificationData($id){
        $pp = Notification::Where([
            ['toUserId','=',$id]])->orderBy('id','desc')->get();
            event(new NotificationData($pp));
        return $pp;
        
    }
    public function seenNotification($id){

        $notif= Notification::Where([
            ['toUserId','=',$id],
            ['status', '=', 'Pending']])->get();
            foreach($notif as $n){
                Notification::where('id',$n->id)->update([
                  'status' =>"seen"
                ]);
            }
            $this->getNotificationData($id);
            $this->getNotification($id);
            $this->getNotifPending();
        
    }
    public function getInventoryData(Request $request){
        return InventoryData::orderBy('id','desc')->paginate($request->total);
    }
    public function inventoryData(){
        return InventoryData::get();
    }
    public function getApprovedInventoryData(Request $request,$id){
       $pp = InventoryData::Where([
            ['category_id','=',$id],
            ['approved', '=', 'approved']])->orderBy('id','desc')->paginate($request->total);
        event(new MainStore($pp));
        return $pp;

            
    }
    public function getPaginateApprovedInventoryData(Request $request,$id){
        $pp = InventoryData::Where([
             ['category_id','=',$id],
             ['approved', '=', 'approved']])->orderBy('id','desc')->paginate($request->total);
         return $pp;
 
             
     }
    public function getWithPurchaseInventoryData(Request $request,$id){
        $pp = InventoryData::Where([
            ['category_id','=',$id],
            ['withPurchase', '=', 'true']])->orderBy('id','desc')->paginate($request->total);
            event(new WithPurchase($pp));
            return $pp;   
    }
    public function getPaginateWithPurchaseInventoryData(Request $request,$id){
        $pp = InventoryData::Where([
            ['category_id','=',$id],
            ['withPurchase', '=', 'true']])->orderBy('id','desc')->paginate($request->total);
            return $pp;   
    }
    public function getStoreKeeper2InventoryData(Request $request,$id){
            $pp = InventoryData::where(function($query) use($id) {
                    $query->orWhere('fromStore','=','true')
                        ->orWhere('bought','=','true');
            })->where('category_id','=',$id)->orderBy('id','desc')->paginate($request->total);
            event(new StoreTwo($pp));
            return $pp;
    }
    public function getPaginateStoreKeeper2InventoryData(Request $request,$id){
        $pp = InventoryData::where(function($query) use($id) {
                $query->orWhere('fromStore','=','true')
                    ->orWhere('bought','=','true');
        })->where('category_id','=',$id)->orderBy('id','desc')->paginate($request->total);
        return $pp;
}
    public function updateInventoryData(Request $request){
        // validate
        $this->validate($request, [
            'itemType' => 'required',
            'requestUserId' => 'required',
            'orderReason' => 'required',
            'measurenment' => 'required',
            'quantity' => 'required',
        ]);
        if($request->deliveredTime){
           $dlvrTime = Carbon::now()->toDateTimeString();
         }else{
            $dlvrTime = $request -> deliveredTime;
         }
        InventoryData::where('id',$request->id)->update([
            'itemType' => $request->itemType,
            'quantity' => $request->quantity,
            'measurenment' => $request->measurenment,
            'category_id' => $request->category_id,
            'requestUserId' => $request->requestUserId,
            'orderReason' => $request->orderReason,
            'withPurchase' => $request->withPurchase,
            'bought' => $request->bought,
            'resetImage' => $request->resetImage,
            'purchasedCompany' => $request->purchasedCompany,
            'delivered' => $request->delivered,
            'deliveredTime' => $dlvrTime,
            'undelivered' => $request->undelivered,
            'undeliveredReason' => $request->undeliveredReason,
            'fromStore' => $request->fromStore,
            'status' => $request->status,
            'urgent' => $request->urgent,
            'adminOneApproval' => $request -> adminOneApproval,
            'adminTwoApproval' => $request -> adminTwoApproval,
            'approved' => $request -> approved,
        ]);
        // $inventory = InventoryData::orderBy('id','desc')->paginate($request->total);
        // event(new ItemAdded($inventory));
        $this->getInventoryById($request, $request->category_id);
        $this->getApprovedInventoryData($request,$request->category_id);
        $this->getWithPurchaseInventoryData($request,$request->category_id);
        $this->getStoreKeeper2InventoryData($request,$request->category_id);
    }
    public function deleteInventoryData(Request $request){

        $this->validate($request, [
            'id'=> 'required'
        ]);
        return Inventorydata::where('id',$request->id)->delete();
    }
}
