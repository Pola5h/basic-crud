
@extends('master')

@section('content')

<div class="card">
	<div class="card-header">Edit Student</div>
	<div class="card-body">
        <form method="post" action="{{ route('students.update', $student->id) }}" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <label class="col-sm-2 col-label-form">Student Name</label>
                <div class="col-sm-10">
                    <input type="text" name="student_name" class="form-control" value="{{ $student->student_name }}" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-label-form">Student Email</label>
                <div class="col-sm-10">
                    <input type="text" name="student_email" class="form-control" value="{{ $student->student_email }}" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-label-form">Old Password</label>
                <div class="col-sm-10">
                    <input type="password" name="old_password" class="form-control" required />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-label-form">New Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" />
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-label-form">Confirm Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password_confirmation" class="form-control" />
                </div>
            </div>
            <div class="row mb-4">
                <label class="col-sm-2 col-label-form">Student Image</label>
                <div class="col-sm-10">
                    <input type="file" name="student_image" />
                    <br />
                    <img src="{{ asset('images/' . $student->student_image) }}" width="100" class="img-thumbnail" />
                    <input type="hidden" name="hidden_student_image" value="{{ $student->student_image }}" />
                </div>
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-primary" style="float: right;" value="Edit" />
            </div>
        </form>
        
	</div>
</div><script>
    function validateForm() {
        var newPassword = document.getElementsByName("password")[0].value;
        var confirmPassword = document.getElementsByName("password_confirmation")[0].value;
    
        if (newPassword !== confirmPassword) {
            alert("New Password and Confirm Password must match.");
            return false; // Prevent form submission
        }
    
        return true; // Allow form submission if passwords match
    }
    </script>
    

@endsection('content')