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

        if ($students->isEmpty()) {
            $data = [
                "message" => "There are no students",
                "status" => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            "students" => $students,
            "status" => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|max:255",
            "email" => "required|email|unique:student",
            "phone" => "required|digits:10",
            "language" => "required|in:English,Spanish"
        ]);

        if ($validator->fails()) {
            $data = [
                "message" => "Error on data validation",
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json($data, 400);
        }

        $student = Student::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "language" => $request->language
        ]);

        if (!$student) {
            $data = [
                "message" => "Error while creating student",
                "status" => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            "message" => "Student created correctly",
            "student" => $student,
            "status" => 201
        ];
        return response()->json($data, 201);
    }

    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                "message" => "Student not found",
                "status" => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            "student" => $student,
            "status" => 404
        ];
        return response()->json($data, 200);
    }

    public function destroy(int $id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                "message" => "Student not found",
                "status" => 404
            ];
            return response()->json($data, 404);
        }

        $student->delete();

        $data = [
            "message" => "Student deleted successfully",
            "status" => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, int $id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                "message" => "Student not found",
                "status" => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            "name" => "required|max:255",
            "email" => "required|email|unique:student",
            "phone" => "required|digits:10",
            "language" => "required|in:English,Spanish"
        ]);

        if ($validator->fails()) {
            $data = [
                "message" => "Error on data validation",
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json($data, 400);
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;

        $student->save();

        $data = [
            "message" => "Student updated correctly",
            "student" => $student,
            "status" => 200
        ];
        return response()->json($data, 200);
    }

    public function updateParcial(Request $request, int $id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                "message" => "Student not found",
                "status" => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            "name" => "max:255",
            "email" => "email|unique:student",
            "phone" => "digits:10",
            "language" => "in:English,Spanish"
        ]);

        if ($validator->fails()) {
            $data = [
                "message" => "Error on data validation",
                "errors" => $validator->errors(),
                "status" => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has("name")) {
            $student->name = $request->name;
        }

        if ($request->has("email")) {
            $student->email = $request->email;
        }

        if ($request->has("phone")) {
            $student->phone = $request->phone;
        }

        if ($request->has("language")) {
            $student->language = $request->language;
        }

        $student->save();

        $data = [
            "message" => "Student partially updated correctly",
            "student" => $student,
            "status" => 200
        ];
        return response()->json($data, 200);
    }
}
