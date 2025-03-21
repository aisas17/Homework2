<?php
// Simple file-based storage
$fileName = 'students.json';

// Create empty file if it doesn't exist
if (!file_exists($fileName)) {
    file_put_contents($fileName, json_encode([]));
}

// Get current students
function getStudents() {
    global $fileName;
    $data = file_get_contents($fileName);
    return json_decode($data, true) ?? [];
}

// Save students
function saveStudents($students) {
    global $fileName;
    file_put_contents($fileName, json_encode($students));
    return $students;
}

// Get action from request
$action = $_GET['action'] ?? 'get';

// Handle different actions
switch ($action) {
    case 'add':
        $students = getStudents();
        $input = json_decode(file_get_contents('php://input'), true);
        $students[] = $input;
        echo json_encode(saveStudents($students));
        break;
        
    case 'edit':
        $students = getStudents();
        $id = (int)$_GET['id'];
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (isset($students[$id])) {
            $students[$id] = $input;
            echo json_encode(saveStudents($students));
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Student not found']);
        }
        break;
        
    case 'delete':
        $students = getStudents();
        $id = (int)$_GET['id'];
        
        if (isset($students[$id])) {
            array_splice($students, $id, 1);
            echo json_encode(saveStudents($students));
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Student not found']);
        }
        break;
        
    default:
        // Just return all students
        echo json_encode(getStudents());
}