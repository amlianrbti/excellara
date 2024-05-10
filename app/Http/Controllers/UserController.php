<?php
    
namespace App\Http\Controllers;
    
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
    
class UserController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function index()
    {
        $users = User::get();
  
        return view('users', compact('users'));
    }
          
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
         
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request) 
    {
        // Validate incoming request data
        $request->validate([
            'file' => 'required|max:2048',
        ]);
  
        Excel::import(new UsersImport, $request->file('file'));
                 
        return back()->with('success', 'Users imported successfully.');
    }

  /**
   * Summary of destroy
   * @param \App\Models\User $user
   * @return \Illuminate\Http\RedirectResponse
   */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('message', 'User telah dihapus');
    }
    

}