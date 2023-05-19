<?php
namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Passwords;

class RegisterController extends BaseController
{
    public function jwtRegister(){
        $username = $this->request->getVar('username');
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $confirmPassword = $this->request->getVar('confirmPassword');

        $users = auth()->getProvider();

        $user = new User([
            'username' => $username,
            'email'    => $email,
            'password' => $password,
        ]);

        // Validate the user
        $rules = $this->getValidationRules();

        if (! $this->validateData([
            'username' => $username,
            'email'    => $email,
            'password' => $password,
            'confirm_password' => $confirmPassword,
        ], $rules)) {
            return $this->response->setJSON(['errors' => $this->validator->getErrors()])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        if(! $users->save($user)){
            return $this->response->setJSON(['errors' => $users->errors()])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        // Add to default group
        $users->addToDefaultGroup($user);

        /** @var JWTManager $manager */
        $manager = service('jwtmanager');

        $claims = [
            'role' => $user->getGroups()[0],
        ];

        // Generate JWT and return to client
        $jwt = $manager->generateToken($user, $claims);

        return $this->response->setJSON(['access_token' => $jwt])
            ->setStatusCode(ResponseInterface::HTTP_CREATED);
    }

    /**
     * Get the validation rules.
     *
     * @return array
     */
    protected function getValidationRules(): array
    {
        return [
            'username' => 'required|min_length[3]|max_length[255]|is_unique[users.username]',
            'email'    => 'required|min_length[3]|max_length[255]|valid_email|is_unique[auth_identities.secret]',
            'password' => 'required|min_length[8]|' . Passwords::getMaxLenghtRule() . '|strong_password',
            'confirm_password' => 'required|matches[password]',
        ];
    }
}