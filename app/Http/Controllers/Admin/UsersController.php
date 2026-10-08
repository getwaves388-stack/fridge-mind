<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(){
        $all_users = $this->user->withTrashed()->latest()->paginate(2);
        // withTrashed() - include the soft deleted records in the result

        return view('admin.users.index')->with('all_users',$all_users);
    }

    public function deactivate($id){
        $this->user->destroy($id);
        return redirect()->back();
    }

    public function activate($id){
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        // onlyTrashed() - retrieves soft deleted records only.
        // restore() - this will "un-delete" a soft deleted model. This will set the "deleted_at" column to NULL.
        return redirect()->back();
    }
}
