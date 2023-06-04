<?php
namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Passwords;

class RegisterController extends BaseController
{
    public function jwtRegister(){
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $password_confirm = $this->request->getPost('password_confirm');

        $users = auth()->getProvider();

        $user = new User([
            'username' => $username,
            'email'    => $email,
            'password' => $password,
        ]);

        // Validate the user
        $rules = $this->getValidationRules();
        
        try{
            if (! $this->validateData($this->request->getPost(), $rules)) {
                return $this->response->setJSON(['errors' => $this->validator->getErrors()])
                    ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }
        }
        catch(\Exception $e){
            return $this->response->setJSON(['errors' => "Something went wrong"])
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
            'username' => [
                'rules' => 'required|min_length[3]|max_length[255]|is_unique[users.username]',
                'errors' => [
                    'is_unique' => 'Username Sudah Digunakan',
                    'required' => 'Username Harus Diisi',
                    'min_length' => 'Username Minimal 3 Karakter',
                    'max_length' => 'Username Maksimal 255 Karakter',
                ],
            ],
            'email'    => [
                'rules' => 'required|min_length[3]|max_length[255]|valid_email|is_unique[auth_identities.secret]',
                'errors' => [
                    'is_unique' => 'Email Sudah Digunakan',
                    'required' => 'Email Harus Diisi',
                    'min_length' => 'Email Minimal 3 Karakter',
                    'max_length' => 'Email Maksimal 255 Karakter',
                    'valid_email' => 'Email Tidak Valid',
                ],
            ],
            'password' => [
                'rules' => 'required|min_length[8]|' . Passwords::getMaxLenghtRule() . '|strong_password',
                'errors' => [
                    'required' => 'Password Harus Diisi',
                    'min_length' => 'Password Minimal 8 Karakter',
                    'max_length' => 'Password Maksimal 255 Karakter',
                    'strong_password' => 'Password Harus Mengandung Huruf Besar, Huruf Kecil, Angka, dan Simbol',
                ],
            ],
            'password_confirm' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi Password Harus Diisi',
                    'matches' => 'Konfirmasi Password Tidak Sama Dengan Password'
                ]
            ],
        ];
    }
}