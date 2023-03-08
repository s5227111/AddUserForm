<?php
// database connection information
$dsn = 'mysql:host=localhost;dbname=form';
$username = 'root';
$password = '';

// verify if required fields are empty
if (empty($_POST['title']) || 
    empty($_POST['first_name']) || 
    empty($_POST['surname']) || 
    empty($_POST['address']) || 
    empty($_POST['postcode']) || 
    empty($_POST['gender'])) {
    echo json_encode(
        array(
            'message' => 'Please fill all required fields.',
            'error' => true
        ));
    exit;
}


try {
    // creates a new instance of the PDO object
    $pdo = new PDO($dsn, $username, $password);

    // sets the error mode for exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare insert SQL with parameters
    $stmt = $pdo->prepare('INSERT INTO colleagues (
        title,
        first_name,
        surname,
        informal_name,
        address,
        town,
        postcode,
        ni_number,
        dob,
        mobile_tel,
        home_tel,
        other_tel,
        personal_email,
        gender,
        initials,
        emergency_contact
        ) 
        VALUES (
            :title,
            :first_name,
            :surname,
            :informal_name,
            :address,
            :town,
            :postcode,
            :ni_number,
            :dob,
            :mobile_tel,
            :home_tel,
            :other_tel,
            :personal_email,
            :gender,
            :initials,
            :emergency_contact)');

    $dob = (empty($_POST['dob']) ? null : $_POST['dob']);

    // associates parameter values
    $stmt->bindParam(':title', $_POST['title']);
    $stmt->bindParam(':first_name', $_POST['first_name']);
    $stmt->bindParam(':surname', $_POST['surname']);
    $stmt->bindParam(':informal_name', $_POST['informal_name']);
    $stmt->bindParam(':address', $_POST['address']);
    $stmt->bindParam(':town', $_POST['town']);
    $stmt->bindParam(':postcode', $_POST['postcode']);
    $stmt->bindParam(':ni_number', $_POST['ni_number']);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':mobile_tel', $_POST['mobile_tel']);
    $stmt->bindParam(':home_tel', $_POST['home_tel']);
    $stmt->bindParam(':other_tel', $_POST['other_tel']);
    $stmt->bindParam(':personal_email', $_POST['personal_email']);
    $stmt->bindParam(':gender', $_POST['gender']);
    $stmt->bindParam(':initials', $_POST['initials']);
    $stmt->bindParam(':emergency_contact', $_POST['emergency_contact']);
    
    // executes the prepared statement
    $stmt->execute();

    // checks if a row was inserted successfully
    if ($stmt->rowCount() > 0) {
        echo json_encode(
            array(
                'message' => 'Data was saved successfully.',
                'error' => false
            ));
    } else {
        echo json_encode(
            array(
                'message' => 'Data was not saved.',
                'error' => true
            ));
    }
} catch (PDOException $e) {
    // handle exceptions
    echo json_encode(
        array(
            'message' => 'Error: ' . $e->getMessage(),
            'error' => true
        ));
}
?>