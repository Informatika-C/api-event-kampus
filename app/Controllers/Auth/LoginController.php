<?php
declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\JWTManager;
use CodeIgniter\Shield\Authentication\Passwords;
use CodeIgniter\Shield\Config\AuthSession;

class LoginController extends BaseController
{
    /**
     * Authenticate Existing User and Issue JWT.
     */
    public function jwtLogin()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        // Get the validation rules
        $rules = $this->getValidationRules();

        // Validate credentials
        if (! $this->validateData([
            'email'    => $email,
            'password' => $password,
        ], $rules)) {

            return $this->response->setJSON(['errors' => $this->validator->getErrors()])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Get the credentials for login
        $credentials             = ['email' => $email];
        $credentials             = array_filter($credentials);
        $credentials['password'] = $password;

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // Check the credentials
        $result = $authenticator->check($credentials);

        // Credentials mismatch.
        if (! $result->isOK()) {
            return $this->response->setJSON(['errors' => $result->reason()])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Credentials match.
        // @TODO Record a successful login attempt

        $user = $result->extraInfo();

        /** @var JWTManager $manager */
        $manager = service('jwtmanager');

        $claims = [
            'role' => $user->getGroups()[0],
        ];

        // Generate JWT and return to client
        $jwt = $manager->generateToken($user, $claims);

        return $this->response->setJSON(['access_token' => $jwt]);
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return array<string, array<string, array<string>|string>>
     * @phpstan-return array<string, array<string, string|list<string>>>
     */
    protected function getValidationRules(): array
    {
        return setting('Validation.login') ?? [
            'email' => [
                'label' => 'Auth.email',
                'rules' => config(AuthSession::class)->emailValidationRules,
            ],
            'password' => [
                'label'  => 'Auth.password',
                'rules'  => 'required|' . Passwords::getMaxLenghtRule(),
                'errors' => [
                    'max_byte' => 'Auth.errorPasswordTooLongBytes',
                ],
            ],
        ];
    }
}