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
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        // Get the validation rules
        $rules = $this->getValidationRules();

        // Validate credentials
        try{
            if (! $this->validateData([
                'email'    => $email,
                'password' => $password,
            ], $rules)) {
    
                return $this->response->setJSON(['errors' => $this->validator->getErrors()])
                    ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }
        }
        catch(\Exception $e){
            return $this->response->setJSON(['errors' => "Something went wrong"])
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

        auth()->login($user);

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
        return [
            'email' => [
                'label' => 'Auth.email',
                'rules' => config(AuthSession::class)->emailValidationRules,
                'errors' => [
                    'valid_email' => 'Email Tidak Valid',
                    'required'    => 'Email Harus Diisi',
                    'is_unique'   => 'Email Sudah Terdaftar',
                    'max_length'  => 'Email Terlalu Panjang',
                    'min_length'  => 'Email Terlalu Pendek',
                ],
            ],
            'password' => [
                'label'  => 'Auth.password',
                'rules'  => 'required|' . Passwords::getMaxLenghtRule(),
                'errors' => [
                    'required' => 'Password Harus Diisi',
                    'max_length' => 'Password Terlalu Panjang',
                    'min_length' => 'Password Terlalu Pendek',
                ],
            ],
        ];
    }
}