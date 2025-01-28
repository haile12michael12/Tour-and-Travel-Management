<?php
// app/controllers/AdminController.php
class AdminController extends Controller
{
    public function register()
    {
        $this->view('admins/register');
    }

    public function store(Request $request)
    {
        $admin = (new Admin())->createAdmin($request->all());
        redirect('/admin/login');
    }

    public function login()
    {
        $this->view('admins/login');
    }

    public function authenticate(Request $request)
    {
        $admin = (new Admin())->authenticate($request->email, $request->password);
        if ($admin) {
            Auth::login($admin);
            redirect('/admin/dashboard');
        } else {
            $this->view('admins/login', ['error' => 'Invalid email or password']);
        }
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        $this->view('admins/edit', compact('admin'));
    }

    public function update($id, Request $request)
    {
        $admin = (new Admin())->updateAdmin($id, $request->all());
        redirect('/admin/' . $id . '/edit');
    }

    public function destroy($id)
    {
        (new Admin())->deleteAdmin($id);
        redirect('/admins');
    }

    public function index()
    {
        $admins = (new Admin())->getAllAdmins();
        $this->view('admins/index', compact('admins'));
    }
}