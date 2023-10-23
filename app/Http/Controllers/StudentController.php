<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use Illuminate\Http\Request;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Student::latest()->paginate(5);
        return view('index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 5);
      }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)


    {

        $request->validate([
            'student_name'          =>  'required',
            'password'          =>  'required',

            'student_email'         =>  'required|email|unique:students',
            'student_image'         =>  'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
        ]);

        $file_name = time() . '.' . request()->student_image->getClientOriginalExtension();

        request()->student_image->move(public_path('images'), $file_name);

        $student = new Student;

        $student->student_name = $request->student_name;
        $student->student_email = $request->student_email;
        $student->password = Hash::make($request->password);
        $student->student_image = $file_name;

        $student->save();

        return redirect()->route('students.index')->with('message', 'Student Added successfully.');
     }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('show', compact('student'));    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('edit', compact('student'));    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_name' => 'required',
            'student_email' => 'required|email',
            'student_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
            'old_password' => 'required',
            'password' => 'nullable|confirmed|min:6',
        ]);
    
        if (!Hash::check($request->old_password, $student->password)) {
            return redirect()->back()->with('error', 'The old password is incorrect.');
        }
    
        if ($request->hasFile('student_image')) {
            $student_image = time() . '.' . $request->student_image->getClientOriginalExtension();
            $request->student_image->move(public_path('images'), $student_image);
        } else {
            $student_image = $student->student_image;
        }
    
        $student->student_name = $request->student_name;
        $student->student_email = $request->student_email;
        $student->student_image = $student_image;
    
        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }
    
        $student->save();
    
        return redirect()->route('students.index')->with('message', 'Student Data has been updated successfully');
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('info', 'Student Data deleted successfully');
    }
}
