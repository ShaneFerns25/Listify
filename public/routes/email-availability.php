<?php
require_once 'includes/config.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
function checkEmailAvailability($app) {
    $conn = getDbConnection();

    $app->post('/email-availability', function (Request $request, Response $response) use ($conn)  {
        $data = $request->getParsedBody();
        $email = $data['Email'] ?? '';

        $sql = "SELECT Email FROM users WHERE Email=:email";
        $query = $conn->prepare($sql);
        $query-> bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $isEmailAvailable = ($query->rowCount() == 0) ? true : false;

        $response->getBody()->write(json_encode([
            'status' => $isEmailAvailable ? 'success' : 'error',
            'message' => $isEmailAvailable ? 'Email is available.' : 'Email is already taken.'
        ]));

        return $response;
    });
}