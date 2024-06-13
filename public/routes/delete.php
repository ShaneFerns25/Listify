<?php
require_once 'includes/config.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
function deleteProduct($app) {
    $conn = getDbConnection();

    $app->post('/delete-product', function (Request $request, Response $response) use ($conn)  {
        $data = $request->getParsedBody();
        $pid = $data['Product_ID'] ?? '';

        $sql = "DELETE FROM products WHERE ProductID=:pid";
        $query = $conn->prepare($sql);
        $query-> bindParam(':pid', $pid, PDO::PARAM_STR);
        $query->execute();
        $deleted = ($query->rowCount() > 0) ? true : false;

        $response->getBody()->write(json_encode([
            'status' => $deleted ? 'success' : 'error',
            'message' => $deleted ? 'Product has been successfully deleted.' : 'An error has occured. Product was not deleted.'
        ]));

        return $response;
    });
}