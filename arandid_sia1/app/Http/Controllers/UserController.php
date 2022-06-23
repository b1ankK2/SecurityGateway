<?php
namespace App\Http\Controllers;

use App\Models\UserJob;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Models\User;

Class UserController extends Controller {
    use ApiResponser;

    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function getUsers(){
        $users = User::all();
        return response()->json($users, 200);
    }

    public function index(){
        $users = User::all();
        return $this->successResponse($users);
    }

    public function add(Request $request){
        $rules = [
            'user' => 'required|max:20',
            'password' => 'required|max:20',
            'jobid' => 'required|numeric|min:1|not_in:0'
        ];
        $this->validate($request,$rules);
        $userjob = UserJob::findOrFail($request->jobid);
        $user = User::create($request->all());
        return $this->successResponse($user, Response::HTTP_CREATED);
        }

    public function show ($id){
        $user = User::findOrFail($id);
        return $this->successResponse($user);
    }

    public function update(Request $request,$id) {
        $rules = [
            'user' => 'max:20',
            'password' => 'max:20',
            'jobid' => 'required|numeric|min:1|not_in:0'
        ];
        $this->validate($request, $rules);
        $userjob = UserJob::findOrFail($request->jobid);
        $user = User::findOrFail($id);

        $user->fill($request->all());
        if ($user->isClean()) {
            return $this->errorResponse('At least one value must
            change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();
        return $this->successResponse($user);
    }

    public function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return $this->successResponse($user);
    }
}