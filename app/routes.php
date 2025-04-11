<?php
// routes.php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\PhpRenderer;

require 'helpers.php';

$view = $app->getContainer()->get('renderer');

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        // Check if the user is already logged in
        if (isset($_SESSION['user_id'])) {
            return $response->withHeader('Location', '/dashboard')->withStatus(302);
        }

        // Check if there is an alert message in the session
        $alert = getAlert();

        // Render the login page

        $content = $this->view->fetch('login.php'); // inner page content
        return $this->view->render($response, 'auth_layout.php', [
            'title' => 'Login',
            'content' => $content,
            'alert' => $alert
        ]);
    });

    $app->get('/dashboard', function (Request $request, Response $response) {
        // Retrieve $view from the container
        $view = $this->get('renderer');

        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['alert'] = [
                'title' => 'Access Denied!',
                'text' => 'You must be logged in to access the dashboard.',
                'icon' => 'error'
            ];
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        // Check if there is an alert message in the session
        $alert = getAlert();

        $content = $view->fetch('dashboard.php'); // inner page content
        return $view->render($response, 'layout.php', [
            'title' => 'Dashboard',
            'content' => $content,
            'alert' => $alert
        ]);
    });

    $app->get('/logout', function (Request $request, Response $response) {
        // Destroy the session and redirect to login
        session_destroy();
        return $response->withHeader('Location', '/')->withStatus(302);
    });

    $app->post('/', function (Request $request, Response $response) use ($app) {
        $data = (array) $request->getParsedBody();
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        // Query the database to check for user credentials
        try {
            $pdo = $app->getContainer()->get('db'); // Assuming 'db' is the PDO instance in the container
            $stmt = $pdo->prepare('SELECT * FROM user WHERE username = :username');
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch();

            // Check if the user exists and verify the password
            if ($user && password_verify($password, $user['password'])) {
                // Set session or token for authenticated user
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['alert'] = [
                    'title' => 'Success!',
                    'text' => 'Login successful!',
                    'icon' => 'success'
                ];
                return $response->withHeader('Location', '/dashboard')->withStatus(302);
            }
        } catch (PDOException $e) {


            // If login fails, set alert and redirect back to login
            error_log($e->getMessage());
            $_SESSION['alert'] = [
                'title' => 'Error!',
                'text' => 'An error occurred. Please try again later.',
                'icon' => 'error'
            ];
            return $response->withHeader('Location', '/')->withStatus(302);
        }
    });

    // $app->group('/users', function (Group $group) {
    //     $group->get('', ListUsersAction::class);
    //     $group->get('/{id}', ViewUserAction::class);
    // });
};
