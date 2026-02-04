<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || $user->department !== 'Management') {
            abort(403, 'Toegang geweigerd. Alleen Management heeft toegang tot gebruikersbeheer.');
        }

        $query = User::query();

        // Zoekterm filter (naam of email)
        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Rol filter
        if (request()->filled('role')) {
            $query->where('department', request('role'));
        }

        // Status filter
        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)->appends(request()->query());

        return view('management.users.index', compact('users'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user || $user->department !== 'Management') {
            abort(403, 'Toegang geweigerd. Alleen Management heeft toegang tot gebruikersbeheer.');
        }

        return view('management.users.form');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->department !== 'Management') {
            abort(403, 'Toegang geweigerd. Alleen Management heeft toegang tot gebruikersbeheer.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_num' => 'nullable|string|max:20',
            'department' => 'required|in:Sales,Purchasing,Finance,Technician,Planner,Management',
            'status' => 'required|in:active,inactive,vacation',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Set last_active to now for new users
        $validated['last_active'] = now();

        $newUser = User::create($validated);

        // TODO: Send welcome email if checkbox is checked
        if ($request->has('send_welcome_email')) {
            // Mail::to($newUser->email)->send(new WelcomeEmail($newUser));
        }

        return redirect()->route('management.users.index')
            ->with('success', 'Werknemer succesvol aangemaakt!');
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user || $user->department !== 'Management') {
            abort(403, 'Toegang geweigerd. Alleen Management heeft toegang tot gebruikersbeheer.');
        }

        $user = User::findOrFail($id);

        return view('management.users.form', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $authUser = Auth::user();
        if (!$authUser || $authUser->department !== 'Management') {
            abort(403, 'Toegang geweigerd. Alleen Management heeft toegang tot gebruikersbeheer.');
        }

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone_num' => 'nullable|string|max:20',
            'department' => 'required|in:Sales,Purchasing,Finance,Technician,Planner,Management',
            'status' => 'required|in:active,inactive,vacation',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Handle password update (only if provided)
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('management.users.index')
            ->with('success', 'Werknemer succesvol bijgewerkt!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user || $user->department !== 'Management') {
            abort(403, 'Toegang geweigerd. Alleen Management heeft toegang tot gebruikersbeheer.');
        }

        $userToDelete = User::findOrFail($id);

        // Prevent self-deletion
        if ($userToDelete->id === $user->id) {
            return redirect()->route('management.users.index')
                ->with('error', 'Je kunt je eigen account niet verwijderen!');
        }

        $userToDelete->delete();

        return redirect()->route('management.users.index')
            ->with('success', 'Werknemer succesvol verwijderd!');
    }

    public function export()
    {
        $user = Auth::user();
        if (!$user || $user->department !== 'Management') {
            abort(403, 'Toegang geweigerd.');
        }

        $users = User::all();
        $filename = "werknemers_export_" . date('Y-m-d') . ".csv";

        $handle = fopen('php://output', 'w');
        
        // Add BOM for Excel compatibility
        fputs($handle, "\xEF\xBB\xBF");

        // Headers
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // CSV Header Row
        fputcsv($handle, ['ID', 'Naam', 'Email', 'Telefoon', 'Afdeling', 'Status', 'Gemaakt op'], ';');

        foreach ($users as $u) {
            fputcsv($handle, [
                $u->id,
                $u->name,
                $u->email,
                $u->phone_num,
                $u->department, // or function to get Dutch name
                $u->status,
                $u->created_at->format('Y-m-d H:i')
            ], ';');
        }

        fclose($handle);
        exit();
    }

    public function import(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->department !== 'Management') {
            abort(403, 'Toegang geweigerd.');
        }

        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        
        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            // Read header row
            $header = fgetcsv($handle, 1000, ';'); // Assuming semicolon separator
            
            // Basic validation of header structure could go here
            // Expected: ID, Naam, Email, Telefoon, Afdeling, Status, ...

            $count = 0;
            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                // Skip empty rows
                if (count($data) < 3) continue;

                // $data indices map to the export column order
                // 0: ID, 1: Name, 2: Email, 3: Phone, 4: Department, 5: Status
                
                $email = $data[2];
                $name = $data[1];
                
                if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) continue;

                User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'phone_num' => $data[3] ?? null,
                        'department' => $this->validateDepartment($data[4] ?? 'Sales'),
                        'status' => $this->validateStatus($data[5] ?? 'active'),
                        'password' => Hash::make('Welkom01!'), // Default password for new imports
                    ]
                );
                $count++;
            }
            fclose($handle);

            return redirect()->route('management.users.index')->with('success', "$count gebruikers geïmporteerd/bijgewerkt.");
        }

        return redirect()->route('management.users.index')->with('error', 'Kon bestand niet lezen.');
    }

    private function validateDepartment($dept)
    {
        $valid = ['Sales', 'Purchasing', 'Finance', 'Technician', 'Planner', 'Management'];
        return in_array($dept, $valid) ? $dept : 'Sales';
    }

    private function validateStatus($status)
    {
        $valid = ['active', 'inactive', 'vacation'];
        return in_array($status, $valid) ? $status : 'active';
    }
}
