<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'edu_id' => 'required|string|unique:students|regex:/^7\d{10}$/',
        ], [
            'edu_id.regex' => __('messages.edu_id_format')
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student = Student::create([
            'name' => $request->name,
            'edu_id' => $request->edu_id,
            'status' => 'active',
        ]);

        return response()->json(['message' => __('messages.student_created'), 'student' => $student], 201);
    }

    public function show(Request $request)
    {
        $id = $request->input('id');
        $student = Student::find($id);
        
        if (!$student) {
            return response()->json(['message' => __('messages.student_not_found')], 404);
        }
        
        return response()->json($student);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $student = Student::find($id);
        
        if (!$student) {
            return response()->json(['message' => __('messages.student_not_found')], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'edu_id' => 'sometimes|string|unique:students|regex:/^7\d{10}$/',
        ], [
            'edu_id.regex' => __('messages.edu_id_format')
        ]);

        $student->update([
            'name' => $request->name ?? $student->name,
            'edu_id' => $request->edu_id ?? $student->edu_id,
        ]);

        return response()->json($student);
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $student = Student::find($id);
        
        if (!$student) {
            return response()->json(['message' => __('messages.student_not_found')], 404);
        }

        $request->validate([
            'status' => 'required|in:active,inactive',
        ], [
            'status.in' => __('messages.invalid_status')
        ]);

        $student->status = $request->status;
        $student->save();

        return response()->json([
            'message' => __('messages.student_status_updated'),
            'student' => $student
        ]);
    }
}
