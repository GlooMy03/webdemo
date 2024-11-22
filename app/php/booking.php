<?php
    //header hasil berbentuk json
    header("Content-Type:application/json");
    header('Access-Control-Allow-Origin: *'); // Membolehkan akses dari semua origin

    //tangkap metode akses
    $method = $_SERVER['REQUEST_METHOD'];

    //variable hasil
    $result = array();

    //koneksi database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mellanova_hotel";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        $result['status'] = [
            "code" => 500,
            "description" => 'Database Connection Failed'
        ];
        echo json_encode($result);
        exit();
    }

// Handle GET
if ($method == 'GET') {
    $result['status'] = [
        "code" => 200,
        "description" => 'Request Valid'
    ];

    // Cek apakah ada ID yang diberikan
    if (isset($_GET['id_booking'])) {
        $id_booking = intval($_GET['id_booking']); // Pastikan ID aman
        // Buat query untuk ID tertentu
        $sql = "SELECT * FROM booking WHERE id_booking = $id_booking";
        $hasil_query = $conn->query($sql);

        if ($hasil_query->num_rows > 0) {
            $result['results'] = $hasil_query->fetch_assoc(); // Hanya satu data
        } else {
            $result['status'] = [
                "code" => 404,
                "description" => "Data not found"
            ];
        }
    } else {
        // Jika tidak ada ID, ambil semua data
        $sql = "SELECT * FROM booking";
        $hasil_query = $conn->query($sql);
        $result['results'] = $hasil_query->fetch_all(MYSQLI_ASSOC); // Semua data
    }
}


    // Handle POST
    elseif ($method == 'POST') {
        // Untuk form-data, gunakan $_POST untuk mengambil data
        if (isset($_POST['full_name'], $_POST['email'], $_POST['room_type'], $_POST['check_in'], $_POST['check_out'], $_POST['phone_number'], $_POST['total_rooms'], $_POST['payment_method'])) {
            $full_name = $conn->real_escape_string($_POST['full_name']);
            $email = $conn->real_escape_string($_POST['email']);
            $room_type = $conn->real_escape_string($_POST['room_type']);
            $check_in = $conn->real_escape_string($_POST['check_in']);
            $check_out = $conn->real_escape_string($_POST['check_out']);
            $phone_number = $conn->real_escape_string($_POST['phone_number']);
            $total_rooms = (int)$_POST['total_rooms'];
            $payment_method = $conn->real_escape_string($_POST['payment_method']);

            $sql = "INSERT INTO booking (full_name, email, room_type, check_in, check_out, phone_number, total_rooms, payment_method) 
                    VALUES ('$full_name', '$email', '$room_type', '$check_in', '$check_out', '$phone_number', $total_rooms, '$payment_method')";
            
            if ($conn->query($sql) === TRUE) {
                $result['status'] = [
                    "code" => 201,
                    "description" => 'Data Created Successfully'
                ];
            } else {
                $result['status'] = [
                    "code" => 500,
                    "description" => 'Failed to Create Data'
                ];
            }
        } else {
            $result['status'] = [
                "code" => 400,
                "description" => 'Invalid Input'
            ];
        }

    }

    // Handle PUT
    elseif ($method == 'PUT') {
        // Untuk form-data, gunakan $_POST untuk mengambil data
        $data = json_decode(file_get_contents("php://input"), true); // Parse the raw POST data
        if (isset($data['id_booking'], $data['full_name'], $data['email'], $data['room_type'], $data['check_in'], $data['check_out'], $data['phone_number'], $data['total_rooms'], $data['payment_method'])) {
            // Mengamankan data input dari SQL Injection
            $id_booking = (int)$data['id_booking'];  // Pastikan id_booking adalah integer
            $full_name = $conn->real_escape_string($data['full_name']);
            $email = $conn->real_escape_string($data['email']);
            $room_type = $conn->real_escape_string($data['room_type']);
            $check_in = $conn->real_escape_string($data['check_in']);
            $check_out = $conn->real_escape_string($data['check_out']);
            $phone_number = $conn->real_escape_string($data['phone_number']);
            $total_rooms = (int)$data['total_rooms'];
            $payment_method = $conn->real_escape_string($data['payment_method']);

            // Query untuk memperbarui data
            $sql = "UPDATE booking SET full_name='$full_name', email='$email', room_type='$room_type', check_in='$check_in', check_out='$check_out', phone_number='$phone_number', total_rooms=$total_rooms, payment_method='$payment_method' WHERE id_booking=$id_booking";

            // Mengeksekusi query
            if ($conn->query($sql) === TRUE) {
                $result['status'] = [
                    "code" => 200,
                    "description" => 'Data Updated Successfully'
                ];
            } else {
                $result['status'] = [
                    "code" => 500,
                    "description" => 'Failed to Update Data'
                ];
            }
        } else {
            $result['status'] = [
                "code" => 400,
                "description" => 'Invalid Input'
            ];
        }
    }

    // Handle DELETE
    elseif ($method == 'DELETE') {
        // Untuk form-data, gunakan $_POST untuk mengambil data
        $data = json_decode(file_get_contents("php://input"), true); // Parse the raw POST data
        if (isset($data['id_booking'])) {
            $id_booking = (int)$data['id_booking'];

            $sql = "DELETE FROM booking WHERE id_booking=$id_booking";

            if ($conn->query($sql) === TRUE) {
                $result['status'] = [
                    "code" => 200,
                    "description" => 'Data Deleted Successfully'
                ];
            } else {
                $result['status'] = [
                    "code" => 500,
                    "description" => 'Failed to Delete Data'
                ];
            }
        } else {
            $result['status'] = [
                "code" => 400,
                "description" => 'Invalid Input'
            ];
        }
    }

    // Handle Invalid Method
    else {
        $result['status'] = [
            "code" => 405,
            "description" => 'Method Not Allowed'
        ];
    }

    echo json_encode($result);
    $conn->close();
?>
